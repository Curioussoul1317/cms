<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\SyncLog;

class DatabaseSyncService
{
    protected ?string $syncUrl;
    protected ?string $syncToken;
    protected int $timeout;
    protected int $chunkSize;

    /**
     * Database connection to use for syncing
     * Change this to match your connection name in config/database.php
     */
    protected string $connection = 'mysql_cms';

    /**
     * Tables to sync with their primary keys
     * Format: 'table_name' => 'primary_key'
     */
    protected array $tables = [
        'main_categories' => 'id',
        'pages' => 'id',
        'page_contents' => 'id',
        'corprofile_pages' => 'id',
        'corprofile_objectives' => 'id',
        'corprofile_strategies' => 'id',
        'corprofile_values' => 'id',
        'corprofile_principles' => 'id',
        'bod_directors' => 'id',
        'ourtimeline_items' => 'id',
        'ourpartners' => 'id',
        'mediacategories' => 'id',
        'mediafiles' => 'id',
        'downloadcategories' => 'id',
        'downloadfiles' => 'id',
        'vacancylocations' => 'id',
        'vacancies' => 'id',
        'hero_sections' => 'id',
        'locations' => 'id',
        'places' => 'id',
        'news' => 'id',
        'news_images' => 'id',
    ];

    /**
     * Tables that have is_published column and should be filtered
     * Only sync rows where is_published = true
     */
    protected array $publishedFilterTables = [
        'main_categories',
        'pages',
        'page_contents',
        'corprofile_pages',
        'corprofile_objectives',
        'corprofile_strategies',
        'corprofile_values',
        'corprofile_principles',
        'bod_directors',
        'ourtimeline_items',
        'ourpartners',
        'mediacategories',
        'mediafiles',
        'downloadcategories',
        'downloadfiles',
        'vacancylocations',
        'vacancies',
        'hero_sections',
        'locations',
        'places',
        'news',
        'news_images',
    ];

    /**
     * Tables to exclude from sync
     */
    protected array $excludedTables = [
        'migrations',
        'password_reset_tokens',
        'personal_access_tokens',
        'failed_jobs',
        'jobs',
        'cache',
        'sessions',
        'sync_logs',
        'users',
    ];

    public function __construct()
    {
        $this->syncUrl = config('services.sync.url') ?? '';
        $this->syncToken = config('services.sync.token') ?? '';
        $this->timeout = (int) config('services.sync.timeout', 120);
        $this->chunkSize = (int) config('services.sync.chunk_size', 500);
    }

    /**
     * Check if service is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->syncUrl) && !empty($this->syncToken);
    }

    /**
     * Check if App Two is reachable
     */
    public function healthCheck(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'status' => 'not_configured',
                'error' => 'Sync URL or Token not configured. Check your .env file.'
            ];
        }

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(10)
                ->get($this->syncUrl . '/health');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => 'connected',
                    'response' => $response->json()
                ];
            }

            return [
                'success' => false,
                'status' => 'error',
                'error' => $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 'unreachable',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get list of tables available for sync
     */
    public function getAvailableTables(): array
    {
        return array_keys($this->tables);
    }

    /**
     * Set custom tables to sync
     */
    public function setTables(array $tables): self
    {
        $this->tables = $tables;
        return $this;
    }

    /**
     * Sync all configured tables
     */
    public function syncAll(string $type = 'incremental', ?string $since = null): array
    {
        if (!$this->isConfigured()) {
            return ['error' => 'Sync service not configured'];
        }

        $results = [];
        $startTime = now();

        foreach ($this->tables as $table => $primaryKey) {
            $results[$table] = $this->syncTable($table, $type, $primaryKey, $since);
        }

        // Log the sync operation
        $this->logSync('all', $type, $results, $startTime);

        return $results;
    }

    /**
     * Sync a single table
     */
    public function syncTable(
        string $table,
        string $type = 'incremental',
        string $primaryKey = 'id',
        ?string $since = null
    ): array {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'Sync service not configured'];
        }

        $startTime = now();

        try {
            // Use the specified database connection
            $query = DB::connection($this->connection)->table($table);

            // Apply is_published filter if table has this column
            if ($this->shouldFilterPublished($table)) {
                $query->where('is_published', true);
            }

            // For incremental sync, only get recently updated records
            if ($type === 'incremental' && $since) {
                if (Schema::connection($this->connection)->hasColumn($table, 'updated_at')) {
                    $query->where('updated_at', '>=', $since);
                }
            }

            $totalRecords = $query->count();

            // For large tables, sync in chunks
            if ($totalRecords > $this->chunkSize) {
                return $this->syncTableInChunks($table, $type, $primaryKey, $since);
            }

            $data = $query->get()->map(function ($item) {
                return (array) $item;
            })->toArray();

            $response = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout)
                ->post($this->syncUrl . '/receive', [
                    'table' => $table,
                    'data' => $data,
                    'sync_type' => $type,
                    'primary_key' => $primaryKey,
                ]);

            if ($response->successful()) {
                $result = [
                    'success' => true,
                    'records_sent' => count($data),
                    'response' => $response->json(),
                    'duration' => $startTime->diffInSeconds(now())
                ];

                Log::info("Sync successful for table: {$table}", $result);
                return $result;
            }

            $result = [
                'success' => false,
                'error' => $response->body(),
                'status_code' => $response->status()
            ];

            Log::error("Sync failed for table: {$table}", $result);
            return $result;

        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];

            Log::error("Sync exception for table: {$table}", $result);
            return $result;
        }
    }

    /**
     * Check if table should be filtered by is_published
     */
    protected function shouldFilterPublished(string $table): bool
    {
        // Check if table is in the filter list AND has the column
        if (in_array($table, $this->publishedFilterTables)) {
            return Schema::connection($this->connection)->hasColumn($table, 'is_published');
        }
        return false;
    }

    /**
     * Sync large tables in chunks
     */
    protected function syncTableInChunks(
        string $table,
        string $type,
        string $primaryKey,
        ?string $since
    ): array {
        // Use the specified database connection
        $query = DB::connection($this->connection)->table($table);

        // Apply is_published filter
        if ($this->shouldFilterPublished($table)) {
            $query->where('is_published', true);
        }

        // Apply incremental filter
        if ($type === 'incremental' && $since) {
            if (Schema::connection($this->connection)->hasColumn($table, 'updated_at')) {
                $query->where('updated_at', '>=', $since);
            }
        }

        $totalRecords = 0;
        $totalSynced = 0;
        $errors = [];

        $query->orderBy($primaryKey)
            ->chunk($this->chunkSize, function ($records) use (
                $table,
                $type,
                $primaryKey,
                &$totalRecords,
                &$totalSynced,
                &$errors
            ) {
                $data = $records->map(fn($item) => (array) $item)->toArray();
                $totalRecords += count($data);

                try {
                    $response = Http::withHeaders($this->getHeaders())
                        ->timeout($this->timeout)
                        ->post($this->syncUrl . '/receive', [
                            'table' => $table,
                            'data' => $data,
                            'sync_type' => $type === 'full' ? 'incremental' : $type,
                            'primary_key' => $primaryKey,
                        ]);

                    if ($response->successful()) {
                        $totalSynced += $response->json()['synced'] ?? 0;
                    } else {
                        $errors[] = $response->body();
                    }
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            });

        return [
            'success' => empty($errors),
            'records_sent' => $totalRecords,
            'records_synced' => $totalSynced,
            'errors' => $errors,
            'chunked' => true
        ];
    }

    /**
     * Sync only modified records since last sync
     */
    public function syncModified(?string $since = null): array
    {
        $since = $since ?? $this->getLastSyncTime();
        return $this->syncAll('incremental', $since);
    }

    /**
     * Get the last successful sync time
     */
    public function getLastSyncTime(): ?string
    {
        try {
            $lastSync = SyncLog::where('status', 'success')
                ->latest('created_at')
                ->first();

            return $lastSync?->created_at?->toDateTimeString();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Log sync operation
     */
    protected function logSync(string $table, string $type, array $results, $startTime): void
    {
        try {
            $totalSuccess = collect($results)->filter(fn($r) => $r['success'] ?? false)->count();
            $totalFailed = collect($results)->filter(fn($r) => !($r['success'] ?? false))->count();

            SyncLog::create([
                'table_name' => $table,
                'sync_type' => $type,
                'records_synced' => collect($results)->sum('records_sent'),
                'status' => $totalFailed === 0 ? 'success' : ($totalSuccess > 0 ? 'partial' : 'failed'),
                'details' => json_encode($results),
                'started_at' => $startTime,
                'completed_at' => now(),
                'duration_seconds' => $startTime->diffInSeconds(now()),
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to log sync operation', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Get request headers
     */
    protected function getHeaders(): array
    {
        return [
            'X-Sync-Token' => $this->syncToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}