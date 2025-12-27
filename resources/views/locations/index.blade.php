@extends('layouts.app')

@section('title', 'Locations')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Region Management</div>
                <h2 class="page-title">Locations</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('locations.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Location
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('locations.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Location">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-check me-2"></i></div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-alert-circle me-2"></i></div>
                    <div>{{ session('error') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-map-pin me-2 text-primary"></i>
                    All Locations
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $locations->total() ?? $locations->count() }} {{ Str::plural('location', $locations->total() ?? $locations->count()) }}
                    </span>
                </div>
            </div>

            @if($locations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">Order</th>
                                <th>Location</th>
                                <th>Map Region</th>
                                <th class="text-center">Places</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td class="text-secondary">
                                        <span class="badge bg-secondary-lt">{{ $location->sort_order }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-sm me-2" style="background-color: {{ $location->color ?? '#1CEAB9' }};">
                                                <i class="ti ti-map-pin text-white"></i>
                                            </span>
                                            <div>
                                                <div class="fw-medium">{{ $location->name }}</div>
                                                <code class="text-secondary small">{{ $location->slug }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($location->map_id)
                                            <span class="badge bg-cyan-lt">
                                                <i class="ti ti-map me-1"></i>
                                                {{ $location->map_id }}
                                            </span>
                                        @else
                                            <span class="text-secondary">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-purple-lt">
                                            <i class="ti ti-building me-1"></i>
                                            {{ $location->places_count }} {{ Str::plural('place', $location->places_count) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($location->is_active)
                                            <span class="badge bg-green-lt">
                                                <i class="ti ti-check me-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-lt">
                                                <i class="ti ti-x me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('locations.show', $location) }}" 
                                               class="btn btn-icon btn-ghost-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="View Details">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('locations.edit', $location) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Location">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('locations.destroy', $location) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this location?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Location"
                                                        {{ $location->places_count > 0 ? 'disabled' : '' }}>
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($locations->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $locations->firstItem() }}</span> to <span>{{ $locations->lastItem() }}</span> 
                            of <span>{{ $locations->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $locations->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-map-pin-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No locations found</p>
                        <p class="empty-subtitle text-secondary">
                            Create locations to organize places by region.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('locations.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Location
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush