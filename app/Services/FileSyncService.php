<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileSyncService
{
    protected ?string $syncUrl;
    protected ?string $syncToken;
    protected int $timeout;

    /**
     * Storage disk to sync from
     */
    protected string $disk = 'public';

    /**
     * Disable SSL verification (set to true only for development!)
     */
    protected bool $skipSslVerification = true;

    /**
     * Max file size to sync (in bytes) - 50MB default
     */
    protected int $maxFileSize = 52428800;

    /**
     * Directories to sync (empty = sync all)
     */
    protected array $directories = [];

    /**
     * Directories to exclude from sync
     */
    protected array $excludedDirectories = [
        '.gitignore',
    ];

    public function __construct()
    {
        $this->syncUrl = config('services.sync.url') ?? '';
        $this->syncToken = config('services.sync.token') ?? '';
        $this->timeout = (int) config('services.sync.timeout', 300);
    }

    /**
     * Check if service is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->syncUrl) && !empty($this->syncToken);
    }

    /**
     * Get storage statistics
     */
    public function getStorageStats(): array
    {
        $files = Storage::disk($this->disk)->allFiles();
        $totalSize = 0;

        foreach ($files as $file) {
            try {
                $totalSize += Storage::disk($this->disk)->size($file);
            } catch (\Exception $e) {
                continue;
            }
        }

        return [
            'total_files' => count($files),
            'total_size' => $totalSize,
            'total_size_formatted' => $this->formatBytes($totalSize),
        ];
    }

    /**
     * Sync all files in storage
     */
    public function syncAllFiles(string $directory = ''): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'Sync service not configured'];
        }

        $files = Storage::disk($this->disk)->allFiles($directory);
        $results = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'errors' => []
        ];

        foreach ($files as $file) {
            // Skip excluded directories
            if ($this->isExcluded($file)) {
                $results['skipped']++;
                continue;
            }

            $result = $this->syncFile($file);

            if ($result['success']) {
                $results['success']++;
            } elseif ($result['skipped'] ?? false) {
                $results['skipped']++;
            } else {
                $results['failed']++;
                $results['errors'][$file] = $result['error'] ?? 'Unknown error';
            }
        }

        Log::info('File sync completed', $results);

        return $results;
    }

    /**
     * Sync a single file
     */
    public function syncFile(string $relativePath): array
    {
        try {
            if (!Storage::disk($this->disk)->exists($relativePath)) {
                return ['success' => false, 'error' => 'File not found'];
            }

            $fileSize = Storage::disk($this->disk)->size($relativePath);

            // Skip files that are too large
            if ($fileSize > $this->maxFileSize) {
                return [
                    'success' => false,
                    'skipped' => true,
                    'error' => 'File too large: ' . $this->formatBytes($fileSize)
                ];
            }

            $fileContent = Storage::disk($this->disk)->get($relativePath);
            $mimeType = Storage::disk($this->disk)->mimeType($relativePath);

            $http = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout);

            if ($this->skipSslVerification) {
                $http = $http->withoutVerifying();
            }

            $response = $http->post($this->syncUrl . '/file', [
                'path' => $relativePath,
                'content' => base64_encode($fileContent),
                'mime_type' => $mimeType,
                'size' => $fileSize,
            ]);

            if ($response->successful()) {
                return ['success' => true, 'response' => $response->json()];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error("File sync failed: {$relativePath}", ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Sync files in batches (more efficient for many small files)
     */
    public function syncFilesBatch(array $files = [], int $batchSize = 10): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'Sync service not configured'];
        }

        if (empty($files)) {
            $files = Storage::disk($this->disk)->allFiles();
        }

        $results = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'errors' => []
        ];

        $chunks = array_chunk($files, $batchSize);

        foreach ($chunks as $chunk) {
            $batchData = [];

            foreach ($chunk as $relativePath) {
                if ($this->isExcluded($relativePath)) {
                    $results['skipped']++;
                    continue;
                }

                try {
                    if (!Storage::disk($this->disk)->exists($relativePath)) {
                        continue;
                    }

                    $fileSize = Storage::disk($this->disk)->size($relativePath);

                    // Skip files larger than 5MB for batch sync
                    if ($fileSize > 5 * 1024 * 1024) {
                        // Sync large files individually
                        $singleResult = $this->syncFile($relativePath);
                        if ($singleResult['success']) {
                            $results['success']++;
                        } else {
                            $results['failed']++;
                            $results['errors'][$relativePath] = $singleResult['error'] ?? 'Unknown error';
                        }
                        continue;
                    }

                    $batchData[] = [
                        'path' => $relativePath,
                        'content' => base64_encode(Storage::disk($this->disk)->get($relativePath)),
                        'mime_type' => Storage::disk($this->disk)->mimeType($relativePath),
                        'size' => $fileSize,
                    ];
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][$relativePath] = $e->getMessage();
                }
            }

            if (!empty($batchData)) {
                try {
                    $http = Http::withHeaders($this->getHeaders())
                        ->timeout($this->timeout);

                    if ($this->skipSslVerification) {
                        $http = $http->withoutVerifying();
                    }

                    $response = $http->post($this->syncUrl . '/files-batch', [
                        'files' => $batchData
                    ]);

                    if ($response->successful()) {
                        $responseData = $response->json();
                        $results['success'] += $responseData['synced'] ?? count($batchData);
                    } else {
                        $results['failed'] += count($batchData);
                        $results['errors']['batch'] = $response->body();
                    }
                } catch (\Exception $e) {
                    $results['failed'] += count($batchData);
                    $results['errors']['batch'] = $e->getMessage();
                }
            }
        }

        return $results;
    }

    /**
     * Sync only modified files since a given time
     */
    public function syncModifiedFiles(?string $since = null): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'Sync service not configured'];
        }

        $sinceTimestamp = $since ? strtotime($since) : 0;
        $files = Storage::disk($this->disk)->allFiles();
        $modifiedFiles = [];

        foreach ($files as $file) {
            if ($this->isExcluded($file)) {
                continue;
            }

            try {
                $lastModified = Storage::disk($this->disk)->lastModified($file);
                if ($lastModified > $sinceTimestamp) {
                    $modifiedFiles[] = $file;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        if (empty($modifiedFiles)) {
            return [
                'success' => 0,
                'failed' => 0,
                'skipped' => 0,
                'message' => 'No modified files to sync'
            ];
        }

        return $this->syncFilesBatch($modifiedFiles);
    }

    /**
     * Delete a file on remote
     */
    public function deleteRemoteFile(string $relativePath): array
    {
        try {
            $http = Http::withHeaders($this->getHeaders())
                ->timeout($this->timeout);

            if ($this->skipSslVerification) {
                $http = $http->withoutVerifying();
            }

            $response = $http->delete($this->syncUrl . '/file', [
                'path' => $relativePath
            ]);

            return [
                'success' => $response->successful(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Check if file should be excluded
     */
    protected function isExcluded(string $path): bool
    {
        foreach ($this->excludedDirectories as $excluded) {
            if (str_contains($path, $excluded)) {
                return true;
            }
        }
        return false;
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

    /**
     * Format bytes to human readable
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}