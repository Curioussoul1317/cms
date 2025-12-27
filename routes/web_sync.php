<?php

use App\Http\Controllers\Admin\SyncController;
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

Route::middleware(['auth'])->group(function () {

    // Sync Dashboard
    Route::get('/sync', [SyncController::class, 'index'])->name('sync.index');

    // Health Check (AJAX)
    Route::get('/sync/health', [SyncController::class, 'checkHealth'])->name('sync.health');

    // Database Sync
    Route::post('/sync/all', [SyncController::class, 'syncAll'])->name('sync.all');
    Route::post('/sync/table', [SyncController::class, 'syncTable'])->name('sync.table');
    Route::post('/sync/modified', [SyncController::class, 'syncModified'])->name('sync.modified');

    // File Sync
    Route::post('/sync/files', [SyncController::class, 'syncFiles'])->name('sync.files');
    Route::post('/sync/files/modified', [SyncController::class, 'syncModifiedFiles'])->name('sync.files.modified');

    // Sync Everything (Database + Files)
    Route::post('/sync/everything', [SyncController::class, 'syncEverything'])->name('sync.everything');

    // Sync Logs
    Route::get('/sync/logs', [SyncController::class, 'logs'])->name('sync.logs');
    Route::get('/sync/logs/{log}', [SyncController::class, 'logDetails'])->name('sync.log-details');
    Route::delete('/sync/logs/clear', [SyncController::class, 'clearLogs'])->name('sync.clear-logs');
});