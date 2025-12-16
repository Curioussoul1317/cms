@extends('layouts.app')

@section('title', 'Vacancies Management')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Administration</div>
                <h2 class="page-title">Vacancies Management</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('vacancies.show') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Public Page
                    </a>
                    <a href="{{ route('vacancylocations.index') }}" class="btn btn-outline-primary d-none d-sm-inline-block">
                        <i class="ti ti-map-pin me-1"></i>
                        Manage Locations
                    </a>
                    <a href="{{ route('vacancies.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add New Vacancy
                    </a>
                    {{-- Mobile buttons --}}
                    <a href="{{ route('vacancies.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add New Vacancy">
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
                    <div>
                        <i class="ti ti-check me-2"></i>
                    </div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div>
                        <i class="ti ti-alert-circle me-2"></i>
                    </div>
                    <div>{{ session('error') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-briefcase me-2 text-primary"></i>
                    All Vacancies
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $vacancies->total() }} {{ Str::plural('vacancy', $vacancies->total()) }}
                    </span>
                </div>
            </div>

            @if($vacancies->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Posted</th>
                                <th>Due Date</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacancies as $vacancy)
                                <tr>
                                    <td class="text-secondary">{{ $vacancy->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ Str::limit($vacancy->title, 40) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-cyan-lt">
                                            <i class="ti ti-map-pin me-1"></i>
                                            {{ $vacancy->location->location_name }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">{{ $vacancy->salary }}</td>
                                    <td class="text-secondary">
                                        <span data-bs-toggle="tooltip" title="{{ $vacancy->posted_date->format('d M Y, h:i A') }}">
                                            {{ $vacancy->posted_date->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($vacancy->due_date->isPast())
                                            <span class="text-danger">
                                                <i class="ti ti-alert-triangle me-1"></i>
                                                {{ $vacancy->due_date->format('d M Y') }}
                                            </span>
                                        @elseif($vacancy->due_date->diffInDays(now()) <= 7)
                                            <span class="text-warning">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ $vacancy->due_date->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-secondary">{{ $vacancy->due_date->format('d M Y') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($vacancy->is_expired)
                                            <span class="badge bg-red-lt">
                                                <i class="ti ti-x me-1"></i> Expired
                                            </span>
                                        @else
                                            <span class="badge bg-green-lt">
                                                <i class="ti ti-check me-1"></i> Active
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('vacancies.edit', $vacancy) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Vacancy">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('vacancies.destroy', $vacancy) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this vacancy?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Vacancy">
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

                @if($vacancies->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $vacancies->firstItem() }}</span> to <span>{{ $vacancies->lastItem() }}</span> 
                            of <span>{{ $vacancies->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $vacancies->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-briefcase-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No vacancies found</p>
                        <p class="empty-subtitle text-secondary">
                            There are no job vacancies in the system yet. Start by creating your first vacancy posting.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('vacancies.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Vacancy
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
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush