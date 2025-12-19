<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SyncLog;

class DatabaseSyncService
{
    protected string $syncUrl;
    protected string $syncToken;
    protected int $timeout;
    protected int $chunkSize;

    /**
     * Tables to sync - customize this list based on your needs
     * Format: 'table_name' => 'primary_key'
     */
    protected array $tables = [
        'users' => 'id',
        'categories' => 'id',
        'posts' => 'id',
        'comments' => 'id',
        // Add your tables here
        // 'customers' => 'id',
        // 'orders' => 'id',
        // 'products' => 'id',
    ];

    /**
     * Tables to exclude from sync (system tables, etc.)
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
    ];

    public function __construct()
    {
        $this->syncUrl = config('services.sync.url');
        $this->syncToken = config('services.sync.token');
        $this->timeout = config('services.sync.timeout', 120);
        $this->chunkSize = config('services.sync.chunk_size', 500);
    }

   
    public function healthCheck(): array
    {
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
        $startTime = now();

        try {
            $query = DB::table($table);

            // For incremental sync, only get recently updated records
            if ($type === 'incremental' && $since) {
                if (\Schema::hasColumn($table, 'updated_at')) {
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
     * Sync large tables in chunks
     */
    protected function syncTableInChunks(
        string $table,
        string $type,
        string $primaryKey,
        ?string $since
    ): array {
        $query = DB::table($table);

        if ($type === 'incremental' && $since) {
            if (\Schema::hasColumn($table, 'updated_at')) {
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
                            'sync_type' => $type === 'full' ? 'incremental' : $type, // Don't truncate on chunks
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
        $lastSync = SyncLog::where('status', 'success')
            ->latest('created_at')
            ->first();

        return $lastSync?->created_at?->toDateTimeString();
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