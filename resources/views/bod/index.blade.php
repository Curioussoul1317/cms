@extends('layouts.app')

@section('title', 'Board of Directors')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Administration</div>
                <h2 class="page-title">Board of Directors</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('bod.show', 1) }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Public Page
                    </a>
                    <a href="{{ route('bod.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Director
                    </a>
                    {{-- Mobile buttons --}}
                    <a href="{{ route('bod.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Director">
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
                    <i class="ti ti-users me-2 text-primary"></i>
                    All Directors
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $directors->total() }} {{ Str::plural('director', $directors->total()) }}
                    </span>
                </div>
            </div>

            @if($directors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">Order</th>
                                <th class="w-1">Photo</th>
                                <th>Name</th>
                                <th>Title/Position</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($directors as $director)
                                <tr>
                                    <td class="text-secondary">
                                        <span class="badge bg-secondary-lt">{{ $director->order }}</span>
                                    </td>
                                    <td>
                                        @if($director->image)
                                            <span class="avatar avatar-md rounded-circle" 
                                                  style="background-image: url('{{ asset('storage/' . $director->image) }}')">
                                            </span>
                                        @else
                                            <span class="avatar avatar-md rounded-circle bg-primary-lt text-primary">
                                                {{ strtoupper(substr($director->name, 0, 2)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $director->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{ $director->title }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($director->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($director->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('bod.edit', $director) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Director">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('bod.destroy', $director) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this director?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Director">
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

                @if($directors->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $directors->firstItem() }}</span> to <span>{{ $directors->lastItem() }}</span> 
                            of <span>{{ $directors->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $directors->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-users-minus" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No directors found</p>
                        <p class="empty-subtitle text-secondary">
                            Add board members to display them on your public page.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('bod.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Director
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