@extends('layouts.app')

@section('title', 'Edit Media File')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('mediafiles.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Files
                    </a>
                </div>
                <h2 class="page-title">Edit Media File</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $mediafile->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $mediafile->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $mediafile->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $mediafile->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $mediafile->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $mediafile->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($mediafile->is_active)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-eye me-1"></i>
                            Active
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Alerts --}}
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

        @if($errors->any())
            <div class="alert alert-danger">
                <div class="d-flex">
                    <div><i class="ti ti-alert-triangle me-2"></i></div>
                    <div>
                        <h4 class="alert-title">Please fix the following errors:</h4>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Publishing Controls Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-1">
                            <i class="ti ti-settings me-2 text-primary"></i>
                            Publishing Controls
                        </h3>
                        <p class="text-secondary mb-0">Manage approval and publishing status for this file.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- Approval Logic: Only show if NOT published --}}
                            @if(!$mediafile->is_published)
                                @if(!$mediafile->is_approved)
                                    <form action="{{ route('approve', ['model' => 'media-file', 'id' => $mediafile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'media-file', 'id' => $mediafile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($mediafile->is_approved)
                                @if(!$mediafile->is_published)
                                    <form action="{{ route('publish', ['model' => 'media-file', 'id' => $mediafile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'media-file', 'id' => $mediafile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="ti ti-download me-1"></i> Unpublish
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Status Flow Indicator --}}
                @if(!$mediafile->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This file needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('mediafiles.update', $mediafile) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-description me-2 text-primary"></i>
                                File Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Category</label>
                                    <select name="mediacategory_id" class="form-select @error('mediacategory_id') is-invalid @enderror" required>
                                        <option value="">Select category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('mediacategory_id', $mediafile->mediacategory_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mediacategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input type="date" 
                                               name="date" 
                                               class="form-control @error('date') is-invalid @enderror" 
                                               value="{{ old('date', $mediafile->date->format('Y-m-d')) }}"
                                               required>
                                    </div>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label required">Title</label>
                                    <input type="text" 
                                           name="title" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           placeholder="Enter file title..."
                                           value="{{ old('title', $mediafile->title) }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Reference Number</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-hash"></i>
                                        </span>
                                        <input type="text" 
                                               name="reference_number" 
                                               class="form-control @error('reference_number') is-invalid @enderror" 
                                               placeholder="e.g., DOC-2024-001"
                                               value="{{ old('reference_number', $mediafile->reference_number) }}"
                                               required>
                                    </div>
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Current File --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-type-pdf me-2 text-red"></i>
                                Current File
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($mediafile->file_path)
                                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                    <span class="avatar bg-red-lt text-red me-3">
                                        <i class="ti ti-file-type-pdf"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-medium text-truncate" style="max-width: 180px;">
                                            {{ $mediafile->file_name }}
                                        </div>
                                        <div class="text-secondary small">{{ $mediafile->file_size_formatted }}</div>
                                    </div>
                                    <a href="{{ route('mediafiles.download', $mediafile) }}" 
                                       class="btn btn-icon btn-primary" 
                                       target="_blank"
                                       data-bs-toggle="tooltip"
                                       title="Download">
                                        <i class="ti ti-download"></i>
                                    </a>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="form-label">Replace File</label>
                                <input type="file" 
                                       name="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       accept=".pdf"
                                       onchange="updateFileName(this)">
                                <small class="form-hint">Leave empty to keep current file (max 10MB)</small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <p class="text-secondary small mb-0" id="new-file-name"></p>
                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-settings me-2 text-primary"></i>
                                Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $mediafile->is_active) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, the file will be available for download in the media center.
                            </small>
                        </div>
                    </div>

                    {{-- Information --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-info-circle me-2 text-primary"></i>
                                Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Uploaded</div>
                                    <div class="datagrid-content">{{ $mediafile->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $mediafile->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $mediafile->is_approved ? 'green' : 'yellow' }}">
                                            {{ $mediafile->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $mediafile->is_published ? 'blue' : 'secondary' }}">
                                            {{ $mediafile->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update File
                                </button>
                                <a href="{{ route('mediafiles.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-x me-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Danger Zone - Outside main form --}}
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4">
                <div class="card border-danger">
                    <div class="card-header bg-danger-lt">
                        <h3 class="card-title text-danger">
                            <i class="ti ti-alert-triangle me-2"></i>
                            Danger Zone
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-secondary mb-3">
                            Once deleted, this file cannot be recovered.
                        </p>
                        <form action="{{ route('mediafiles.destroy', $mediafile) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this file? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i>
                                Delete File
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateFileName(input) {
    const fileNameDisplay = document.getElementById('new-file-name');
    if (input.files && input.files[0]) {
        fileNameDisplay.innerHTML = '<i class="ti ti-check text-success me-1"></i> New file: <strong>' + input.files[0].name + '</strong>';
    } else {
        fileNameDisplay.textContent = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush