<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sync Routes (Add to routes/web.php)
|--------------------------------------------------------------------------
|
| These routes handle the sync dashboard and operations.
| Adjust the middleware as needed for your authentication setup.
|
*/
 

    // Sync Dashboard
    Route::get('/sync', [SyncController::class, 'index'])->name('sync.index');

    // Health Check (AJAX)
    Route::get('/sync/health', [SyncController::class, 'checkHealth'])->name('sync.health');

    // Sync All Tables
    Route::post('/sync/all', [SyncController::class, 'syncAll'])->name('sync.all');

    // Sync Single Table
    Route::post('/sync/table', [SyncController::class, 'syncTable'])->name('sync.table');

    // Sync Modified Only
    Route::post('/sync/modified', [SyncController::class, 'syncModified'])->name('sync.modified');

    // Sync Logs
    Route::get('/sync/logs', [SyncController::class, 'logs'])->name('sync.logs');
    Route::get('/sync/logs/{log}', [SyncController::class, 'logDetails'])->name('sync.log-details');
    Route::delete('/sync/logs/clear', [SyncController::class, 'clearLogs'])->name('sync.clear-logs');
 