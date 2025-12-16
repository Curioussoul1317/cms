@extends('layouts.app')

@section('title', 'Edit Download File')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('downloadfiles.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Files
                    </a>
                </div>
                <h2 class="page-title">Edit Download File</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $downloadfile->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $downloadfile->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $downloadfile->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $downloadfile->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $downloadfile->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $downloadfile->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($downloadfile->is_active)
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
                            @if(!$downloadfile->is_published)
                                @if(!$downloadfile->is_approved)
                                    <form action="{{ route('approve', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($downloadfile->is_approved)
                                @if(!$downloadfile->is_published)
                                    <form action="{{ route('publish', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
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
                @if(!$downloadfile->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This file needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('downloadfiles.update', $downloadfile) }}" method="POST" enctype="multipart/form-data">
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
                                    <select name="downloadcategory_id" class="form-select @error('downloadcategory_id') is-invalid @enderror" required>
                                        <option value="">Select category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('downloadcategory_id', $downloadfile->downloadcategory_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('downloadcategory_id')
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
                                               value="{{ old('date', $downloadfile->date->format('Y-m-d')) }}"
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
                                           value="{{ old('title', $downloadfile->title) }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- File Uploads --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-type-pdf me-2 text-red"></i>
                                PDF Files
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                {{-- English File --}}
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="avatar bg-green-lt text-green me-2">
                                                    <i class="ti ti-language"></i>
                                                </span>
                                                <div>
                                                    <h4 class="mb-0">English Version</h4>
                                                    <small class="text-secondary">PDF file in English</small>
                                                </div>
                                            </div>
                                            
                                            @if($downloadfile->eng_file)
                                                <div class="d-flex align-items-center p-2 bg-white rounded mb-3">
                                                    <span class="avatar avatar-sm bg-red-lt text-red me-2">
                                                        <i class="ti ti-file-type-pdf"></i>
                                                    </span>
                                                    <div class="flex-fill">
                                                        <div class="fw-medium small">Current English File</div>
                                                    </div>
                                                    <a href="{{ route('downloadfiles.download-english', $downloadfile) }}" 
                                                       class="btn btn-icon btn-sm btn-primary" 
                                                       target="_blank"
                                                       data-bs-toggle="tooltip"
                                                       title="Download">
                                                        <i class="ti ti-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            <input type="file" 
                                                   name="eng_file" 
                                                   class="form-control @error('eng_file') is-invalid @enderror" 
                                                   accept=".pdf"
                                                   onchange="updateFileName(this, 'eng-file-name')">
                                            <small class="form-hint">{{ $downloadfile->eng_file ? 'Upload new to replace' : 'PDF only, max 10MB' }}</small>
                                            <p class="text-primary small mb-0 mt-1" id="eng-file-name"></p>
                                            @error('eng_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Dhivehi File --}}
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="avatar bg-blue-lt text-blue me-2">
                                                    <i class="ti ti-language"></i>
                                                </span>
                                                <div>
                                                    <h4 class="mb-0">Dhivehi Version</h4>
                                                    <small class="text-secondary">PDF file in Dhivehi</small>
                                                </div>
                                            </div>
                                            
                                            @if($downloadfile->dhivehi_file)
                                                <div class="d-flex align-items-center p-2 bg-white rounded mb-3">
                                                    <span class="avatar avatar-sm bg-red-lt text-red me-2">
                                                        <i class="ti ti-file-type-pdf"></i>
                                                    </span>
                                                    <div class="flex-fill">
                                                        <div class="fw-medium small">Current Dhivehi File</div>
                                                    </div>
                                                    <a href="{{ route('downloadfiles.download-dhivehi', $downloadfile) }}" 
                                                       class="btn btn-icon btn-sm btn-primary" 
                                                       target="_blank"
                                                       data-bs-toggle="tooltip"
                                                       title="Download">
                                                        <i class="ti ti-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            <input type="file" 
                                                   name="dhivehi_file" 
                                                   class="form-control @error('dhivehi_file') is-invalid @enderror" 
                                                   accept=".pdf"
                                                   onchange="updateFileName(this, 'dhi-file-name')">
                                            <small class="form-hint">{{ $downloadfile->dhivehi_file ? 'Upload new to replace' : 'PDF only, max 10MB' }}</small>
                                            <p class="text-primary small mb-0 mt-1" id="dhi-file-name"></p>
                                            @error('dhivehi_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
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
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $downloadfile->is_active) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, the file will be available for download on the website.
                            </small>
                        </div>
                    </div>

                    {{-- Files Summary --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-files me-2 text-primary"></i>
                                Files Summary
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-sm {{ $downloadfile->eng_file ? 'bg-green-lt text-green' : 'bg-secondary-lt text-secondary' }} me-2">
                                    <i class="ti ti-{{ $downloadfile->eng_file ? 'check' : 'x' }}"></i>
                                </span>
                                <div>
                                    <span class="fw-medium">English Version</span>
                                    <span class="badge {{ $downloadfile->eng_file ? 'bg-green-lt' : 'bg-secondary-lt' }} ms-2">
                                        {{ $downloadfile->eng_file ? 'Available' : 'Not uploaded' }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-sm {{ $downloadfile->dhivehi_file ? 'bg-blue-lt text-blue' : 'bg-secondary-lt text-secondary' }} me-2">
                                    <i class="ti ti-{{ $downloadfile->dhivehi_file ? 'check' : 'x' }}"></i>
                                </span>
                                <div>
                                    <span class="fw-medium">Dhivehi Version</span>
                                    <span class="badge {{ $downloadfile->dhivehi_file ? 'bg-blue-lt' : 'bg-secondary-lt' }} ms-2">
                                        {{ $downloadfile->dhivehi_file ? 'Available' : 'Not uploaded' }}
                                    </span>
                                </div>
                            </div>
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
                                    <div class="datagrid-title">Created</div>
                                    <div class="datagrid-content">{{ $downloadfile->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $downloadfile->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $downloadfile->is_approved ? 'green' : 'yellow' }}">
                                            {{ $downloadfile->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $downloadfile->is_published ? 'blue' : 'secondary' }}">
                                            {{ $downloadfile->is_published ? 'Published' : 'Draft' }}
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
                                <a href="{{ route('downloadfiles.index') }}" class="btn btn-outline-secondary">
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
                        <form action="{{ route('downloadfiles.destroy', $downloadfile) }}" 
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
function updateFileName(input, targetId) {
    const fileNameDisplay = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        fileNameDisplay.innerHTML = '<i class="ti ti-check text-success me-1"></i>' + input.files[0].name;
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