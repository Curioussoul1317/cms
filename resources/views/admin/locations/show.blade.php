@extends('layouts.app')

@section('title', $location->name)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('admin.locations.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Locations
                    </a>
                </div>
                <h2 class="page-title d-flex align-items-center">
                    <span class="avatar avatar-sm me-2" style="background-color: {{ $location->color ?? '#1CEAB9' }};">
                        <i class="ti ti-map-pin text-white"></i>
                    </span>
                    {{ $location->name }}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    @if($location->is_active)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-check me-1"></i>
                            Active
                        </span>
                    @else
                        <span class="badge bg-secondary-lt fs-6">
                            <i class="ti ti-x me-1"></i>
                            Inactive
                        </span>
                    @endif
                    <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-primary">
                        <i class="ti ti-edit me-1"></i>
                        Edit Location
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

        <div class="row">
            {{-- Location Details --}}
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-info-circle me-2 text-primary"></i>
                            Location Details
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">ID</div>
                                <div class="datagrid-content">
                                    <span class="badge bg-secondary-lt">{{ $location->id }}</span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Name</div>
                                <div class="datagrid-content fw-medium">{{ $location->name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Slug</div>
                                <div class="datagrid-content">
                                    <code class="text-primary">{{ $location->slug }}</code>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Map ID</div>
                                <div class="datagrid-content">
                                    @if($location->map_id)
                                        <span class="badge bg-cyan-lt">
                                            <i class="ti ti-map me-1"></i>
                                            {{ $location->map_id }}
                                        </span>
                                    @else
                                        <span class="text-secondary">Not set</span>
                                    @endif
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Color</div>
                                <div class="datagrid-content">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-xs me-2" style="background-color: {{ $location->color ?? '#1CEAB9' }};"></span>
                                        <code>{{ $location->color ?? '#1CEAB9' }}</code>
                                    </div>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Sort Order</div>
                                <div class="datagrid-content">
                                    <span class="badge bg-secondary-lt">{{ $location->sort_order }}</span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Status</div>
                                <div class="datagrid-content">
                                    @if($location->is_active)
                                        <span class="status status-green">
                                            <span class="status-dot"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="status status-secondary">
                                            <span class="status-dot"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Created</div>
                                <div class="datagrid-content">{{ $location->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Last Updated</div>
                                <div class="datagrid-content">{{ $location->updated_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </div>

                        @if($location->description)
                            <hr class="my-3">
                            <h4 class="mb-2">Description</h4>
                            <p class="text-secondary mb-0">{{ $location->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-chart-bar me-2 text-primary"></i>
                            Statistics
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-purple-lt text-purple me-3">
                                        <i class="ti ti-building"></i>
                                    </span>
                                    <div>
                                        <div class="h2 mb-0">{{ $location->places->count() }}</div>
                                        <div class="text-secondary small">Total Places</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-green-lt text-green me-3">
                                        <i class="ti ti-check"></i>
                                    </span>
                                    <div>
                                        <div class="h2 mb-0">{{ $location->places->where('is_active', true)->count() }}</div>
                                        <div class="text-secondary small">Active Places</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Places List --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-building me-2 text-primary"></i>
                            Places in this Location
                        </h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.places.create') }}?location_id={{ $location->id }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus me-1"></i>
                                Add Place
                            </a>
                        </div>
                    </div>

                    @if($location->places->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Place</th>
                                        <th>Contact</th>
                                        <th class="text-center">Status</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($location->places as $place)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-sm bg-primary-lt text-primary me-2">
                                                        <i class="ti ti-building"></i>
                                                    </span>
                                                    <div>
                                                        <div class="fw-medium">{{ $place->name }}</div>
                                                        @if($place->address)
                                                            <div class="text-secondary small text-truncate" style="max-width: 200px;">
                                                                {{ Str::limit($place->address, 30) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    @if($place->phone_number)
                                                        <span class="small">
                                                            <i class="ti ti-phone text-secondary me-1"></i>
                                                            {{ $place->phone_number }}
                                                        </span>
                                                    @endif
                                                    @if($place->email)
                                                        <span class="small">
                                                            <i class="ti ti-mail text-secondary me-1"></i>
                                                            {{ $place->email }}
                                                        </span>
                                                    @endif
                                                    @if(!$place->phone_number && !$place->email)
                                                        <span class="text-secondary">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($place->is_active)
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
                                                    <a href="{{ route('admin.places.edit', $place) }}" 
                                                       class="btn btn-icon btn-ghost-warning" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Place">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-building-off" style="font-size: 3rem;"></i>
                                </div>
                                <p class="empty-title">No places in this location</p>
                                <p class="empty-subtitle text-secondary">
                                    Add places to this location to manage them.
                                </p>
                                <div class="empty-action">
                                    <a href="{{ route('admin.places.create') }}?location_id={{ $location->id }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i>
                                        Add First Place
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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