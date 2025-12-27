<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DatabaseSyncService;
use App\Models\SyncLog;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    protected DatabaseSyncService $syncService;

    public function __construct(DatabaseSyncService $syncService)
    {
        $this->syncService = $syncService;
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
        $tables = $this->syncService->getAvailableTables();

        // Check connection health
        $health = $this->syncService->healthCheck();

        return view('sync.index', compact('stats', 'recentLogs', 'tables', 'health'));
    }

    /**
     * Check connection health
     */
    public function checkHealth()
    {
        $health = $this->syncService->healthCheck();

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
            $results = $this->syncService->syncAll($type);

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
            $result = $this->syncService->syncTable($table, $type);

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
            $results = $this->syncService->syncModified($since);

            $successCount = collect($results)->filter(fn($r) => $r['success'] ?? false)->count();
            $totalRecords = collect($results)->sum('records_sent');

            return back()->with('success', "Incremental sync completed: {$totalRecords} records across {$successCount} tables.");
        } catch (\Exception $e) {
            return back()->with('error', 'Incremental sync failed: ' . $e->getMessage());
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