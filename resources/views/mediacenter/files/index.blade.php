@extends('layouts.app')

@section('title', 'Media Files')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Media Center</div>
                <h2 class="page-title">Media Files</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('mediacenter.index') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Media Center
                    </a>
                    <a href="{{ route('mediacategories.index') }}" class="btn btn-outline-primary d-none d-sm-inline-block">
                        <i class="ti ti-folder me-1"></i>
                        Manage Categories
                    </a>
                    <a href="{{ route('mediafiles.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-upload me-1"></i>
                        Upload File
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('mediafiles.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Upload File">
                        <i class="ti ti-upload"></i>
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
                    <i class="ti ti-file-description me-2 text-primary"></i>
                    All Files
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
                                <th>File</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Reference #</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-sm bg-red-lt text-red me-2">
                                                <i class="ti ti-file-type-pdf"></i>
                                            </span>
                                            <div>
                                                <div class="fw-medium text-truncate" style="max-width: 250px;">
                                                    {{ $file->title }}
                                                </div>
                                                <div class="text-secondary small">{{ $file->file_name ?? 'N/A' }}</div>
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
                                    <td>
                                        <code class="text-secondary">{{ $file->reference_number }}</code>
                                    </td>
                                    <td class="text-center text-secondary">
                                        <small>{{ $file->file_size_formatted }}</small>
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
                                            <a href="{{ route('mediafiles.download', $file) }}" 
                                               class="btn btn-icon btn-ghost-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="Download"
                                               target="_blank">
                                                <i class="ti ti-download"></i>
                                            </a>
                                            <a href="{{ route('mediafiles.edit', $file) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit File">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('mediafiles.destroy', $file) }}" 
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
                            Upload PDF files to share in the media page.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('mediafiles.create') }}" class="btn btn-primary">
                                <i class="ti ti-upload me-1"></i>
                                Upload First File
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