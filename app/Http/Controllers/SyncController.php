<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DatabaseSyncService;
use App\Services\FileSyncService;
use App\Models\SyncLog;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    protected DatabaseSyncService $dbSyncService;
    protected FileSyncService $fileSyncService;

    public function __construct(DatabaseSyncService $dbSyncService, FileSyncService $fileSyncService)
    {
        $this->dbSyncService = $dbSyncService;
        $this->fileSyncService = $fileSyncService;
    }

    /**
     * Display sync dashboard
     */
    public function index()
    {
        // Get sync statistics
        $stats = [
            'total_syncs' => SyncLog::count(),
            'successful_syncs' => SyncLog::successful()->count(),
            'failed_syncs' => SyncLog::failed()->count(),
            'last_sync' => SyncLog::latest()->first(),
            'last_successful_sync' => SyncLog::successful()->latest()->first(),
        ];

        // Get recent sync logs
        $recentLogs = SyncLog::latest()
            ->take(10)
            ->get();

        // Get available tables
        $tables = $this->dbSyncService->getAvailableTables();

        // Check connection health
        $health = $this->dbSyncService->healthCheck();

        // Get file storage stats
        $fileStats = $this->fileSyncService->getStorageStats();

        return view('sync.index', compact('stats', 'recentLogs', 'tables', 'health', 'fileStats'));
    }

    /**
     * Check connection health
     */
    public function checkHealth()
    {
        $health = $this->dbSyncService->healthCheck();

        return response()->json($health);
    }

    /**
     * Sync all tables
     */
    public function syncAll(Request $request)
    {
        $request->validate([
            'type' => 'required|in:full,incremental',
        ]);

        $type = $request->input('type');

        try {
            $results = $this->dbSyncService->syncAll($type);

            $successCount = collect($results)->filter(fn($r) => $r['success'] ?? false)->count();
            $failedCount = collect($results)->filter(fn($r) => !($r['success'] ?? false))->count();

            if ($failedCount === 0) {
                return back()->with('success', "Successfully synced all {$successCount} tables!");
            } elseif ($successCount > 0) {
                return back()->with('warning', "Partially synced: {$successCount} successful, {$failedCount} failed.")
                    ->with('sync_results', $results);
            } else {
                return back()->with('error', 'All sync operations failed.')
                    ->with('sync_results', $results);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync a single table
     */
    public function syncTable(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'type' => 'required|in:full,incremental',
        ]);

        $table = $request->input('table');
        $type = $request->input('type');

        try {
            $result = $this->dbSyncService->syncTable($table, $type);

            if ($result['success']) {
                $count = $result['records_sent'] ?? 0;
                return back()->with('success', "Successfully synced '{$table}' table ({$count} records)!");
            } else {
                return back()->with('error', "Failed to sync '{$table}': " . ($result['error'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync only modified records
     */
    public function syncModified(Request $request)
    {
        $since = $request->input('since');

        try {
            $results = $this->dbSyncService->syncModified($since);

            $successCount = collect($results)->filter(fn($r) => $r['success'] ?? false)->count();
            $totalRecords = collect($results)->sum('records_sent');

            return back()->with('success', "Incremental sync completed: {$totalRecords} records across {$successCount} tables.");
        } catch (\Exception $e) {
            return back()->with('error', 'Incremental sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync all files
     */
    public function syncFiles(Request $request)
    {
        try {
            $results = $this->fileSyncService->syncAllFiles();

            $message = "File sync completed: {$results['success']} synced, {$results['failed']} failed, {$results['skipped']} skipped.";

            if ($results['failed'] > 0) {
                return back()->with('warning', $message)->with('file_sync_results', $results);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'File sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync modified files only
     */
    public function syncModifiedFiles(Request $request)
    {
        $since = $request->input('since', cache('last_file_sync_time'));

        try {
            $results = $this->fileSyncService->syncModifiedFiles($since);

            cache(['last_file_sync_time' => now()->toDateTimeString()], now()->addYear());

            $message = "Modified files sync completed: {$results['success']} synced, {$results['failed']} failed.";

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'File sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync everything (database + files)
     */
    public function syncEverything(Request $request)
    {
        $dbResults = [];
        $fileResults = [];

        try {
            // Sync database
            $dbResults = $this->dbSyncService->syncAll('incremental');
            $dbSuccess = collect($dbResults)->filter(fn($r) => $r['success'] ?? false)->count();

            // Sync files
            $fileResults = $this->fileSyncService->syncAllFiles();

            cache(['last_sync_time' => now()], now()->addYear());

            $message = "Complete sync finished. Database: {$dbSuccess} tables. Files: {$fileResults['success']} synced, {$fileResults['failed']} failed.";

            return back()
                ->with('success', $message)
                ->with('sync_results', $dbResults)
                ->with('file_sync_results', $fileResults);

        } catch (\Exception $e) {
            return back()->with('error', 'Complete sync failed: ' . $e->getMessage());
        }
    }

    /**
     * View sync logs
     */
    public function logs(Request $request)
    {
        $query = SyncLog::latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by table
        if ($request->filled('table')) {
            $query->where('table_name', $request->table);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('created_at', '<=', $request->to);
        }

        $logs = $query->paginate(20);

        return view('sync.logs', compact('logs'));
    }

    /**
     * View single log details
     */
    public function logDetails(SyncLog $log)
    {
        return view('sync.log-details', compact('log'));
    }

    /**
     * Clear old sync logs
     */
    public function clearLogs(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $days = $request->input('days');
        $deleted = SyncLog::where('created_at', '<', now()->subDays($days))->delete();

        return back()->with('success', "Deleted {$deleted} sync logs older than {$days} days.");
    }
}