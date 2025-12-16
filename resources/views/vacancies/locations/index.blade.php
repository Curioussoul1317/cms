@extends('layouts.app')

@section('title', 'Vacancy Locations')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('vacancies.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Vacancies
                    </a>
                </div>
                <h2 class="page-title">Vacancy Locations</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <button type="button" 
                        class="btn btn-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#createLocationModal">
                    <i class="ti ti-plus me-1"></i>
                    Add Location
                </button>
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

        <div class="row row-cards">
            @forelse($locations as $location)
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar bg-primary-lt me-3">
                                    <i class="ti ti-map-pin text-primary"></i>
                                </div>
                                <div class="flex-fill">
                                    <h3 class="card-title mb-1">{{ $location->location_name }}</h3>
                                    <div class="text-secondary">
                                        {{ $location->vacancies_count ?? 0 }} {{ Str::plural('vacancy', $location->vacancies_count ?? 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary flex-fill"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editLocationModal{{ $location->id }}">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </button>
                                <form action="{{ route('vacancylocations.destroy', $location) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure? All vacancies in this location will be affected.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            {{ ($location->vacancies_count ?? 0) > 0 ? 'disabled' : '' }}>
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal modal-blur fade" id="editLocationModal{{ $location->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('vacancylocations.update', $location) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Location</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label required">Location Name</label>
                                        <input type="text" 
                                               name="location_name" 
                                               class="form-control" 
                                               value="{{ $location->location_name }}"
                                               required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy me-1"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-map-pin-off" style="font-size: 3rem;"></i>
                                </div>
                                <p class="empty-title">No locations found</p>
                                <p class="empty-subtitle text-secondary">
                                    Add locations to organize your job vacancies by office or region.
                                </p>
                                <div class="empty-action">
                                    <button type="button" 
                                            class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#createLocationModal">
                                        <i class="ti ti-plus me-1"></i>
                                        Add First Location
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Create Location Modal --}}
<div class="modal modal-blur fade" id="createLocationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('vacancylocations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-map-pin me-2"></i>
                        Add New Location
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Location Name</label>
                        <input type="text" 
                               name="location_name" 
                               class="form-control" 
                               placeholder="e.g., Head Office, Regional Office..."
                               required>
                        <small class="form-hint">Enter a descriptive name for the job location.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection