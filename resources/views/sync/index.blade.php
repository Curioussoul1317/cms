@extends('layouts.app')

@section('title', 'Database Sync')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-sync-alt me-2"></i>Database Synchronization
        </h3>
        <a href="{{ route('sync.logs') }}" class="btn btn-outline-secondary">
            <i class="fas fa-history me-1"></i>View Logs
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Sync Results --}}
    @if(session('sync_results'))
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-database me-2"></i>Database Sync Results</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th>Status</th>
                                <th>Records</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('sync_results') as $table => $result)
                                <tr>
                                    <td><code>{{ $table }}</code></td>
                                    <td>
                                        @if($result['success'] ?? false)
                                            <span class="badge bg-success">Success</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $result['records_sent'] ?? 0 }}</td>
                                    <td class="small">{{ $result['error'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- File Sync Results --}}
    @if(session('file_sync_results'))
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-folder me-2"></i>File Sync Results</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-success">{{ session('file_sync_results')['success'] ?? 0 }}</h4>
                        <small>Synced</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger">{{ session('file_sync_results')['failed'] ?? 0 }}</h4>
                        <small>Failed</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-muted">{{ session('file_sync_results')['skipped'] ?? 0 }}</h4>
                        <small>Skipped</small>
                    </div>
                </div>
                @if(!empty(session('file_sync_results')['errors']))
                    <hr>
                    <details>
                        <summary class="text-danger">View Errors</summary>
                        <pre class="mt-2 small">{{ json_encode(session('file_sync_results')['errors'], JSON_PRETTY_PRINT) }}</pre>
                    </details>
                @endif
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Connection Status Card --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header {{ $health['success'] ? 'bg-success' : 'bg-danger' }} text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat me-2"></i>Connection Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-3">
                        @if($health['success'])
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5 class="text-success">Connected</h5>
                            <p class="text-muted mb-0">App Two is reachable</p>
                        @else
                            <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                            <h5 class="text-danger">Disconnected</h5>
                            <p class="text-muted small mb-0">{{ $health['error'] ?? 'Unable to connect' }}</p>
                        @endif
                    </div>
                    <hr>
                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="check-health-btn">
                        <i class="fas fa-sync me-1"></i>Refresh Status
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistics Card --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Sync Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h3 class="mb-0">{{ $stats['total_syncs'] }}</h3>
                            <small class="text-muted">Total Syncs</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h3 class="mb-0 text-success">{{ $stats['successful_syncs'] }}</h3>
                            <small class="text-muted">Successful</small>
                        </div>
                        <div class="col-6">
                            <h3 class="mb-0 text-danger">{{ $stats['failed_syncs'] }}</h3>
                            <small class="text-muted">Failed</small>
                        </div>
                        <div class="col-6">
                            <h3 class="mb-0">{{ count($tables) }}</h3>
                            <small class="text-muted">Tables</small>
                        </div>
                    </div>
                    <hr>
                    <div class="small">
                        <strong>Last Sync:</strong><br>
                        @if($stats['last_sync'])
                            {{ $stats['last_sync']->created_at->diffForHumans() }}
                            <span class="badge bg-{{ $stats['last_sync']->status_color }}">
                                {{ $stats['last_sync']->status }}
                            </span>
                        @else
                            <span class="text-muted">Never</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions Card --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sync.modified') }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" {{ !$health['success'] ? 'disabled' : '' }}>
                            <i class="fas fa-clock me-2"></i>Sync Modified Only
                        </button>
                        <small class="text-muted d-block mt-1">Only sync records changed since last sync</small>
                    </form>

                    <form action="{{ route('sync.all') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="incremental">
                        <button type="submit" class="btn btn-primary w-100" {{ !$health['success'] ? 'disabled' : '' }}>
                            <i class="fas fa-sync me-2"></i>Incremental Sync All
                        </button>
                        <small class="text-muted d-block mt-1">Update/insert all records without truncating</small>
                    </form>

                    <form action="{{ route('sync.all') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="full">
                        <button type="submit" class="btn btn-warning w-100" {{ !$health['success'] ? 'disabled' : '' }}
                                onclick="return confirm('WARNING: This will REPLACE all data in App Two. Are you sure?')">
                            <i class="fas fa-database me-2"></i>Full Sync (Replace All)
                        </button>
                        <small class="text-muted d-block mt-1">Truncate and replace all data</small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- File Sync & Complete Sync Row --}}
    <div class="row">
        {{-- File Sync Card --}}
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-folder me-2"></i>File Sync</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h4 class="mb-0">{{ $fileStats['total_files'] ?? 0 }}</h4>
                            <small class="text-muted">Total Files</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0">{{ $fileStats['total_size_formatted'] ?? '0 B' }}</h4>
                            <small class="text-muted">Total Size</small>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('sync.files.modified') }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-info w-100" {{ !$health['success'] ? 'disabled' : '' }}>
                            <i class="fas fa-clock me-2"></i>Sync Modified Files
                        </button>
                        <small class="text-muted d-block mt-1">Only sync files changed since last sync</small>
                    </form>

                    <form action="{{ route('sync.files') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-info w-100" {{ !$health['success'] ? 'disabled' : '' }}
                                onclick="return confirm('Sync all {{ $fileStats['total_files'] ?? 0 }} files to App Two?')">
                            <i class="fas fa-folder-open me-2"></i>Sync All Files
                        </button>
                        <small class="text-muted d-block mt-1">Sync all files in storage/app/public</small>
                    </form>
                </div>
            </div>
        </div>

        {{-- Complete Sync Card --}}
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>Complete Sync</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <p class="text-muted text-center mb-4">
                        Sync <strong>all database tables</strong> and <strong>all files</strong> in one click.
                    </p>
                    <form action="{{ route('sync.everything') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg btn-primary w-100" {{ !$health['success'] ? 'disabled' : '' }}
                                onclick="return confirm('This will sync all database tables and all files. This may take a while. Continue?')">
                            <i class="fas fa-rocket me-2"></i>Sync Everything
                        </button>
                    </form>
                    <small class="text-muted text-center d-block mt-2">
                        Database: {{ count($tables) }} tables | Files: {{ $fileStats['total_files'] ?? 0 }} files
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Card --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Sync Individual Table</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Table Name</th>
                            <th>Records</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tables as $table)
                            @php
                                $count = \DB::connection('mysql_cms')->table($table)->count();
                            @endphp
                            <tr>
                                <td><code>{{ $table }}</code></td>
                                <td>{{ number_format($count) }}</td>
                                <td class="text-end">
                                    <form action="{{ route('sync.table') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="table" value="{{ $table }}">
                                        <input type="hidden" name="type" value="incremental">
                                        <button type="submit" class="btn btn-sm btn-outline-primary" {{ !$health['success'] ? 'disabled' : '' }}>
                                            <i class="fas fa-sync"></i> Sync
                                        </button>
                                    </form>
                                    <form action="{{ route('sync.table') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="table" value="{{ $table }}">
                                        <input type="hidden" name="type" value="full">
                                        <button type="submit" class="btn btn-sm btn-outline-warning" {{ !$health['success'] ? 'disabled' : '' }}
                                                onclick="return confirm('Replace all data in {{ $table }} on App Two?')">
                                            <i class="fas fa-database"></i> Full
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Logs Card --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Sync Logs</h5>
            <a href="{{ route('sync.logs') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Table</th>
                            <th>Type</th>
                            <th>Records</th>
                            <th>Status</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->diffForHumans() }}</td>
                                <td><code>{{ $log->table_name }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $log->sync_type === 'full' ? 'warning' : 'info' }}">
                                        {{ $log->sync_type }}
                                    </span>
                                </td>
                                <td>{{ number_format($log->records_synced) }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->status_color }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td>{{ $log->formatted_duration }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No sync logs yet. Start your first sync!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('check-health-btn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Checking...';

    fetch('{{ route('sync.health') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Connection successful! App Two is reachable.');
            } else {
                alert('Connection failed: ' + (data.error || 'Unknown error'));
            }
            location.reload();
        })
        .catch(error => {
            alert('Error checking connection: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync me-1"></i>Refresh Status';
        });
});
</script>
@endpush
@endsection