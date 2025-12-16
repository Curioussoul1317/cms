@extends('layouts.app')

@section('title', 'Download Files')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Downloads</div>
                <h2 class="page-title">Download Files</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('downloads.index') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Downloads Page
                    </a>
                    <a href="{{ route('downloadcategories.index') }}" class="btn btn-outline-primary d-none d-sm-inline-block">
                        <i class="ti ti-folder me-1"></i>
                        Manage Categories
                    </a>
                    <a href="{{ route('downloadfiles.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add File
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('downloadfiles.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add File">
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
                    <i class="ti ti-download me-2 text-primary"></i>
                    All Download Files
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $files->total() }} {{ Str::plural('file', $files->total()) }}
                    </span>
                </div>
            </div>

            @if($files->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th class="text-center">Files Available</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-sm bg-primary-lt text-primary me-2">
                                                <i class="ti ti-file-download"></i>
                                            </span>
                                            <div>
                                                <div class="fw-medium text-truncate" style="max-width: 250px;">
                                                    {{ $file->title }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-cyan-lt">
                                            <i class="ti ti-folder me-1"></i>
                                            {{ $file->category->name }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">
                                        <i class="ti ti-calendar me-1"></i>
                                        {{ $file->date->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-list justify-content-center">
                                            @if($file->eng_file)
                                                <span class="badge bg-green-lt" data-bs-toggle="tooltip" title="English PDF available">
                                                    <i class="ti ti-file-type-pdf me-1"></i> ENG
                                                </span>
                                            @endif
                                            @if($file->dhivehi_file)
                                                <span class="badge bg-blue-lt" data-bs-toggle="tooltip" title="Dhivehi PDF available">
                                                    <i class="ti ti-file-type-pdf me-1"></i> DHI
                                                </span>
                                            @endif
                                            @if(!$file->eng_file && !$file->dhivehi_file)
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-file-off me-1"></i> None
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($file->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($file->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('downloadfiles.edit', $file) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit File">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('downloadfiles.destroy', $file) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this file?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete File">
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

                @if($files->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <span>{{ $files->firstItem() }}</span> to <span>{{ $files->lastItem() }}</span> 
                            of <span>{{ $files->total() }}</span> entries
                        </p>
                        <div class="ms-auto">
                            {{ $files->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-file-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No files found</p>
                        <p class="empty-subtitle text-secondary">
                            Add downloadable files for users to access.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('downloadfiles.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First File
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