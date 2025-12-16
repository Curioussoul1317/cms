@extends('layouts.app')

@section('title', 'Upload Media File')

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
                <h2 class="page-title">Upload Media File</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
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

        <form action="{{ route('mediafiles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-upload me-2 text-primary"></i>
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
                                            <option value="{{ $category->id }}" {{ old('mediacategory_id') == $category->id ? 'selected' : '' }}>
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
                                               value="{{ old('date') }}"
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
                                           value="{{ old('title') }}"
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
                                               value="{{ old('reference_number') }}"
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
                    {{-- File Upload --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-type-pdf me-2 text-red"></i>
                                PDF File
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-center mb-3 p-4 bg-light rounded border-2 border-dashed" id="upload-area">
                                    <i class="ti ti-file-type-pdf text-red mb-2" style="font-size: 3rem;"></i>
                                    <p class="text-secondary mb-0" id="file-name">No file selected</p>
                                </div>
                                <input type="file" 
                                       name="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       accept=".pdf"
                                       onchange="updateFileName(this)"
                                       required>
                                <small class="form-hint">Only PDF files allowed (max 10MB)</small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, the file will be available for download in the media center.
                            </small>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-upload me-1"></i>
                                    Upload File
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
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        fileNameDisplay.textContent = input.files[0].name;
        fileNameDisplay.classList.remove('text-secondary');
        fileNameDisplay.classList.add('text-primary', 'fw-medium');
    } else {
        fileNameDisplay.textContent = 'No file selected';
        fileNameDisplay.classList.add('text-secondary');
        fileNameDisplay.classList.remove('text-primary', 'fw-medium');
    }
}
</script>
@endpush