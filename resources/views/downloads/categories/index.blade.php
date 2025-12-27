@extends('layouts.app')

@section('title', 'Download Categories')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Downloads</div>
                <h2 class="page-title">Download Categories</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('downloads.index') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Downloads Page
                    </a>
                    <a href="{{ route('downloadfiles.index') }}" class="btn btn-outline-primary d-none d-sm-inline-block">
                        <i class="ti ti-files me-1"></i>
                        Manage Files
                    </a>
                    <a href="{{ route('downloadcategories.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Category
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('downloadcategories.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Category">
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
                    <i class="ti ti-folder-down me-2 text-primary"></i>
                    All Categories
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}
                    </span>
                </div>
            </div>

            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">Order</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th class="text-center">Files</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="text-secondary">
                                        <span class="badge bg-secondary-lt">{{ $category->order }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-sm bg-primary-lt text-primary me-2">
                                                <i class="ti ti-folder-down"></i>
                                            </span>
                                            <div class="fw-medium">{{ $category->name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="text-secondary">{{ $category->slug }}</code>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-cyan-lt">
                                            <i class="ti ti-file me-1"></i>
                                            {{ $category->download_files_count }} {{ Str::plural('file', $category->download_files_count) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($category->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($category->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('downloadcategories.edit', $category) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Category">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('downloadcategories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure? This will delete all files in this category!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Category"
                                                        {{ $category->download_files_count > 0 ? 'disabled' : '' }}>
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

             
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-folder-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No categories found</p>
                        <p class="empty-subtitle text-secondary">
                            Create categories to organize  downloadable files.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('downloadcategories.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Category
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