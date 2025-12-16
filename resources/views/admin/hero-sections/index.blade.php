@extends('layouts.app')

@section('title', 'Hero Sections')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Website Management</div>
                <h2 class="page-title">Hero Sections</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Hero Section
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Hero Section">
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
                    <i class="ti ti-layout-navbar me-2 text-primary"></i>
                    All Hero Sections
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $heroSections->total() }} {{ Str::plural('section', $heroSections->total()) }}
                    </span>
                </div>
            </div>

            @if($heroSections->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Route / Page</th>
                                <th>Title</th>
                                <th class="w-1">Preview</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($heroSections as $hero)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-sm me-2" style="background-color: {{ $hero->background_color }};">
                                                <i class="ti ti-layout-navbar text-white"></i>
                                            </span>
                                            <div>
                                                <code class="text-primary">{{ $hero->route_name }}</code>
                                                @if($hero->section)
                                                    <span class="badge bg-cyan-lt ms-1">{{ $hero->section }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-truncate" style="max-width: 200px;">
                                            {{ $hero->title }}
                                        </div>
                                        @if($hero->subtitle)
                                            <div class="text-secondary small text-truncate" style="max-width: 200px;">
                                                {{ Str::limit($hero->subtitle, 40) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($hero->image)
                                            <span class="avatar rounded" style="background-image: url('{{ asset('storage/' . $hero->image) }}')"></span>
                                        @else
                                            <span class="avatar rounded" style="background-color: {{ $hero->background_color }};">
                                                <i class="ti ti-photo-off text-white"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($hero->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($hero->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('admin.hero-sections.edit', $hero) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Hero">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.hero-sections.destroy', $hero) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this hero section?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Hero">
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

                @if($heroSections->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $heroSections->firstItem() }}</span> to <span>{{ $heroSections->lastItem() }}</span> 
                            of <span>{{ $heroSections->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $heroSections->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-layout-navbar-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No hero sections found</p>
                        <p class="empty-subtitle text-secondary">
                            Create hero sections to display on different pages of your website.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Hero Section
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