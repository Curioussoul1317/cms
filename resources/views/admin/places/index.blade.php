@extends('layouts.app')

@section('title', 'Places')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Location Management</div>
                <h2 class="page-title">Places</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-map-pin me-1"></i>
                        Manage Locations
                    </a>
                    <a href="{{ route('admin.places.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Place
                    </a>
                    <a href="{{ route('admin.places.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Place">
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

        {{-- Filter Card --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.places.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Filter by Location</label>
                        <select name="location_id" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-1"></i>
                            Filter
                        </button>
                        @if(request('location_id'))
                            <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-x me-1"></i>
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Places Table --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-building me-2 text-primary"></i>
                    All Places
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $places->total() }} {{ Str::plural('place', $places->total()) }}
                    </span>
                </div>
            </div>

            @if($places->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Place</th>
                                <th>Location</th>
                                <th>Contact</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($places as $place)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($place->image)
                                                <span class="avatar avatar-sm me-2" style="background-image: url('{{ Storage::url($place->image) }}')"></span>
                                            @else
                                                <span class="avatar avatar-sm bg-primary-lt text-primary me-2">
                                                    <i class="ti ti-building"></i>
                                                </span>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $place->name }}</div>
                                                @if($place->address)
                                                    <div class="text-secondary small text-truncate" style="max-width: 180px;">
                                                        {{ Str::limit($place->address, 25) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.locations.show', $place->location) }}" class="text-decoration-none">
                                            <span class="badge bg-cyan-lt">
                                                <i class="ti ti-map-pin me-1"></i>
                                                {{ $place->location->name }}
                                            </span>
                                        </a>
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
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($place->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($place->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('admin.places.show', $place) }}" 
                                               class="btn btn-icon btn-ghost-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="View Details">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.places.edit', $place) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Place">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.places.destroy', $place) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this place?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Place">
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

                @if($places->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $places->firstItem() }}</span> to <span>{{ $places->lastItem() }}</span> 
                            of <span>{{ $places->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $places->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-building-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No places found</p>
                        <p class="empty-subtitle text-secondary">
                            @if(request('location_id'))
                                No places in this location. Try a different filter or add a new place.
                            @else
                                Create places to associate with locations.
                            @endif
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('admin.places.create') }}" class="btn btn-primary">
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