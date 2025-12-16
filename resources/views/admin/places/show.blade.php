@extends('layouts.app')

@section('title', $place->name)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('admin.places.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Places
                    </a>
                </div>
                <h2 class="page-title d-flex align-items-center">
                    @if($place->image)
                        <span class="avatar avatar-sm me-2" style="background-image: url('{{ Storage::url($place->image) }}')"></span>
                    @else
                        <span class="avatar avatar-sm bg-primary-lt text-primary me-2">
                            <i class="ti ti-building"></i>
                        </span>
                    @endif
                    {{ $place->name }}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    @if($place->is_approved)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-check me-1"></i>
                            Approved
                        </span>
                    @else
                        <span class="badge bg-yellow-lt fs-6">
                            <i class="ti ti-clock me-1"></i>
                            Pending
                        </span>
                    @endif
                    @if($place->is_published)
                        <span class="badge bg-blue-lt fs-6">
                            <i class="ti ti-world me-1"></i>
                            Published
                        </span>
                    @endif
                    @if($place->is_active)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-eye me-1"></i>
                            Active
                        </span>
                    @else
                        <span class="badge bg-secondary-lt fs-6">
                            <i class="ti ti-eye-off me-1"></i>
                            Inactive
                        </span>
                    @endif
                    <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-primary">
                        <i class="ti ti-edit me-1"></i>
                        Edit Place
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
            {{-- Place Details --}}
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-info-circle me-2 text-primary"></i>
                            Place Details
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">ID</div>
                                <div class="datagrid-content">
                                    <span class="badge bg-secondary-lt">{{ $place->id }}</span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Name</div>
                                <div class="datagrid-content fw-medium">{{ $place->name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Slug</div>
                                <div class="datagrid-content">
                                    <code class="text-primary">{{ $place->slug }}</code>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Location</div>
                                <div class="datagrid-content">
                                    <a href="{{ route('admin.locations.show', $place->location) }}" class="text-decoration-none">
                                        <span class="badge bg-cyan-lt">
                                            <i class="ti ti-map-pin me-1"></i>
                                            {{ $place->location->name }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Phone</div>
                                <div class="datagrid-content">
                                    @if($place->phone_number)
                                        <a href="tel:{{ $place->phone_number }}" class="text-decoration-none">
                                            <i class="ti ti-phone me-1 text-secondary"></i>
                                            {{ $place->phone_number }}
                                        </a>
                                    @else
                                        <span class="text-secondary">Not set</span>
                                    @endif
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Email</div>
                                <div class="datagrid-content">
                                    @if($place->email)
                                        <a href="mailto:{{ $place->email }}" class="text-decoration-none">
                                            <i class="ti ti-mail me-1 text-secondary"></i>
                                            {{ $place->email }}
                                        </a>
                                    @else
                                        <span class="text-secondary">Not set</span>
                                    @endif
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Sort Order</div>
                                <div class="datagrid-content">
                                    <span class="badge bg-secondary-lt">{{ $place->sort_order }}</span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Status</div>
                                <div class="datagrid-content">
                                    @if($place->is_active)
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
                                <div class="datagrid-content">{{ $place->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Last Updated</div>
                                <div class="datagrid-content">{{ $place->updated_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </div>

                        @if($place->address)
                            <hr class="my-3">
                            <h4 class="mb-2">
                                <i class="ti ti-map-pin me-1 text-secondary"></i>
                                Address
                            </h4>
                            <p class="text-secondary mb-0">{{ $place->address }}</p>
                        @endif

                        @if($place->description)
                            <hr class="my-3">
                            <h4 class="mb-2">
                                <i class="ti ti-file-description me-1 text-secondary"></i>
                                Description
                            </h4>
                            <p class="text-secondary mb-0">{{ $place->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Publishing Status --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-world me-2 text-primary"></i>
                            Publishing Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Approval Status</div>
                                <div class="datagrid-content">
                                    <span class="status status-{{ $place->is_approved ? 'green' : 'yellow' }}">
                                        <span class="status-dot"></span>
                                        {{ $place->is_approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Publication Status</div>
                                <div class="datagrid-content">
                                    <span class="status status-{{ $place->is_published ? 'blue' : 'secondary' }}">
                                        <span class="status-dot"></span>
                                        {{ $place->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                            @if($place->approved_by)
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approved By</div>
                                    <div class="datagrid-content">{{ $place->approver->name ?? 'N/A' }}</div>
                                </div>
                            @endif
                            @if($place->published_by)
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Published By</div>
                                    <div class="datagrid-content">{{ $place->publisher->name ?? 'N/A' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-6">
                {{-- Opening Hours --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-clock me-2 text-primary"></i>
                            Opening Hours
                        </h3>
                    </div>
                    @if($place->opening_hours && count($place->opening_hours) > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Days</th>
                                        <th>Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($place->opening_hours as $schedule)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($schedule['days'] ?? [] as $day)
                                                        <span class="badge bg-secondary-lt">{{ $day }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                @if(isset($schedule['closed']) && $schedule['closed'])
                                                    <span class="badge bg-red-lt">
                                                        <i class="ti ti-x me-1"></i>
                                                        Closed
                                                    </span>
                                                @else
                                                    <span class="badge bg-green-lt">
                                                        <i class="ti ti-clock me-1"></i>
                                                        {{ $schedule['open'] ?? '—' }} - {{ $schedule['close'] ?? '—' }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="empty py-4">
                                <div class="empty-icon">
                                    <i class="ti ti-clock-off" style="font-size: 2rem;"></i>
                                </div>
                                <p class="empty-title">No opening hours set</p>
                                <p class="empty-subtitle text-secondary">
                                    Add opening hours in the edit page.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Image --}}
                @if($place->image)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-photo me-2 text-primary"></i>
                                Image
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="ratio ratio-16x9 bg-light rounded overflow-hidden">
                                <img src="{{ Storage::url($place->image) }}" 
                                     alt="{{ $place->name }}" 
                                     class="object-cover">
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Quick Actions --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-bolt me-2 text-primary"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit Place
                            </a>
                            <a href="{{ route('admin.locations.show', $place->location) }}" class="btn btn-outline-primary">
                                <i class="ti ti-map-pin me-1"></i>
                                View Location
                            </a>
                            <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-list me-1"></i>
                                All Places
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .object-cover {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>
@endsection