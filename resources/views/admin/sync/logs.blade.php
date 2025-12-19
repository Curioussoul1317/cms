@extends('layouts.app')

@section('title', 'Sync Logs')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-history me-2"></i>Sync Logs
        </h3>
        <a href="{{ route('admin.sync.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sync.logs') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Table</label>
                    <input type="text" name="table" class="form-control" value="{{ request('table') }}" placeholder="Table name">
                </div>
                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.sync.logs') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date/Time</th>
                            <th>Table</th>
                            <th>Type</th>
                            <th>Records</th>
                            <th>Status</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>
                                    <span title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </td>
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
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#logModal{{ $log->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal for Log Details --}}
                            <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sync Log #{{ $log->id }} Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Table:</strong> <code>{{ $log->table_name }}</code>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Type:</strong>
                                                    <span class="badge bg-{{ $log->sync_type === 'full' ? 'warning' : 'info' }}">
                                                        {{ $log->sync_type }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Status:</strong>
                                                    <span class="badge bg-{{ $log->status_color }}">{{ $log->status }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Records Synced:</strong> {{ number_format($log->records_synced) }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Started:</strong> {{ $log->started_at?->format('Y-m-d H:i:s') ?? 'N/A' }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Completed:</strong> {{ $log->completed_at?->format('Y-m-d H:i:s') ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <strong>Duration:</strong> {{ $log->formatted_duration }}
                                                </div>
                                            </div>

                                            @if($log->error_message)
                                                <div class="alert alert-danger">
                                                    <strong>Error:</strong><br>
                                                    {{ $log->error_message }}
                                                </div>
                                            @endif

                                            @if($log->details)
                                                <div class="mt-3">
                                                    <strong>Details:</strong>
                                                    <pre class="bg-light p-3 rounded mt-2" style="max-height: 300px; overflow-y: auto;">{{ json_encode($log->details, JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No sync logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- Clear Logs --}}
    <div class="card mt-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Clear Old Logs</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sync.clear-logs') }}" method="POST" class="row g-3 align-items-end"
                  onsubmit="return confirm('Are you sure you want to delete old logs?')">
                @csrf
                @method('DELETE')
                <div class="col-md-4">
                    <label class="form-label">Delete logs older than</label>
                    <select name="days" class="form-select">
                        <option value="7">7 days</option>
                        <option value="30" selected>30 days</option>
                        <option value="60">60 days</option>
                        <option value="90">90 days</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Clear Old Logs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection