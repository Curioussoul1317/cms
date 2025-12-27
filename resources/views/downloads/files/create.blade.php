@extends('layouts.app')

@section('title', 'Add Download File')

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
                <h2 class="page-title">Add Download File</h2>
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

        <form action="{{ route('downloadfiles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-plus me-2 text-primary"></i>
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
                                            <option value="{{ $category->id }}" {{ old('downloadcategory_id') == $category->id ? 'selected' : '' }}>
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
                                            <input type="file" 
                                                   name="eng_file" 
                                                   class="form-control @error('eng_file') is-invalid @enderror" 
                                                   accept=".pdf"
                                                   onchange="updateFileName(this, 'eng-file-name')">
                                            <small class="form-hint">PDF only, max 10MB</small>
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
                                            <input type="file" 
                                                   name="dhivehi_file" 
                                                   class="form-control @error('dhivehi_file') is-invalid @enderror" 
                                                   accept=".pdf"
                                                   onchange="updateFileName(this, 'dhi-file-name')">
                                            <small class="form-hint">PDF only, max 10MB</small>
                                            <p class="text-primary small mb-0 mt-1" id="dhi-file-name"></p>
                                            @error('dhivehi_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3 mb-0">
                                <div class="d-flex">
                                    <div><i class="ti ti-info-circle me-2"></i></div>
                                    <div>At least one file (English or Dhivehi) should be uploaded for the download to be useful.</div>
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
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, the file will be available for download on the website.
                            </small>
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-bulb me-2 text-yellow"></i>
                                Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-green-lt text-green">
                                        <i class="ti ti-file-type-pdf"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Bilingual Files</h4> 
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-blue-lt text-blue">
                                        <i class="ti ti-file-check"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Descriptive Titles</h4> 
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Add File
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
</script>
@endpush