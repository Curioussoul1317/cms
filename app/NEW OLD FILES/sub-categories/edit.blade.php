@extends('layouts.app')

@section('title', 'Edit Sub Category')

@section('content')
<div class="container-xl"> 
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col">
                @if($subCategory->subtype == "Page")
                <h2 class="page-title">Edit Page</h2>
                <div class="text-muted mt-1">Editing page under: <strong>{{ $subCategory->mainCategory->name }}</strong></div>
                @else
                <h2 class="page-title">Edit Sub Category</h2>
                <div class="text-muted mt-1">Editing sub category under: <strong>{{ $subCategory->mainCategory->name }}</strong></div>
                @endif
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('categories.hierarchy') }}" class="btn btn-secondary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Back 
                    </a>
                </div>
            </div>
        </div>
    </div>
 
    <div class="page-body">
        <div class="row row-cards">
            <div class="col-lg-12 mx-auto">
                <form action="{{ route('sub-categories.update', $subCategory) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-cards">
                        <div class="card col-8">
                            <div class="card-header">
                                <h3 class="card-title">Basic Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                     <input type="text" name="main_category_id" value="{{ $subCategory->main_category_id }}">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   value="{{ old('name', $subCategory->name) }}" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   placeholder="Enter sub category name"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" 
                                                   name="slug" 
                                                   id="slug" 
                                                   value="{{ old('slug', $subCategory->slug) }}" 
                                                   class="form-control @error('slug') is-invalid @enderror" 
                                                   placeholder="auto-generated-slug">
                                            <small class="form-hint">Leave empty to auto-generate from name</small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label required">Heading</label>
                                            <input type="text" 
                                                   name="heading" 
                                                   id="heading" 
                                                   value="{{ old('heading', $subCategory->heading) }}" 
                                                   class="form-control @error('heading') is-invalid @enderror" 
                                                   placeholder="Enter page heading"
                                                   required>
                                            <small class="form-hint">This will be displayed as the main heading on the page</small>
                                            @error('heading')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" 
                                                      id="description" 
                                                      rows="4" 
                                                      class="form-control @error('description') is-invalid @enderror" 
                                                      placeholder="Enter a brief description of this sub category">{{ old('description', $subCategory->description) }}</textarea>
                                            <small class="form-hint">A short description to help users understand this category</small>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="card mt-3 col-4">
                            <div class="card-header">
                                <h3 class="card-title">Icon (SVG)</h3>
                            </div>
                            <div class="card-body">
                                @if($subCategory->svg)
                                    <div class="mb-3">
                                        <label class="form-label">Current Icon:</label>
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="svg-icon-container" style="width: 64px; height: 64px; margin: 0 auto; overflow: hidden;">
                                                {!! $subCategory->svg !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">{{ $subCategory->svg ? 'Replace SVG Icon' : 'Upload SVG Icon' }}</label>
                                    <input type="file" 
                                        name="svg" 
                                        id="svg" 
                                        class="form-control @error('svg') is-invalid @enderror" 
                                        accept=".svg,image/svg+xml">
                                    <small class="form-hint">Upload an SVG file to {{ $subCategory->svg ? 'replace the current icon' : 'add an icon' }}. Maximum size: 2MB.</small>
                                    @error('svg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
 
                                <div id="svg-preview" class="mb-3" style="display: none;">
                                    <label class="form-label">New Preview:</label>
                                    <div class="border rounded p-3 text-center">
                                        <div class="svg-icon-container" style="width: 100px; height: 100px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                            <img id="preview-image" src="" alt="SVG Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mb-0">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <i class="ti ti-info-circle icon alert-icon"></i>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">SVG Tips</h4>
                                            <div class="text-muted">
                                                Upload simple, scalable SVG icons. Recommended size is 64x64px or similar square dimensions.  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Settings</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Display Order</label>
                                            <input type="number" 
                                                   name="order" 
                                                   id="order" 
                                                   value="{{ old('order', $subCategory->order) }}" 
                                                   class="form-control @error('order') is-invalid @enderror" 
                                                   placeholder="0">
                                            <small class="form-hint">Lower numbers appear first (e.g., 1, 2, 3...)</small>
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <div>
                                                <label class="form-check form-switch">
                                                    <input type="checkbox" 
                                                           name="is_active" 
                                                           value="1" 
                                                           {{ old('is_active', $subCategory->is_active) ? 'checked' : '' }} 
                                                           class="form-check-input">
                                                    <span class="form-check-label">Active</span>
                                                </label>
                                                <small class="form-hint d-block mt-1">
                                                    When inactive, this sub category will be hidden from public view
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="d-flex">
                                    <a href="{{ route('categories.hierarchy') }}" class="btn btn-link">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        <i class="ti ti-device-floppy icon me-1"></i>
                                        Update Sub Category
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
                <div class="card mt-3 border-danger">
                    <div class="card-header bg-danger-lt">
                        <h3 class="card-title text-danger">
                            <i class="ti ti-alert-triangle icon me-2"></i>
                            Danger Zone
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1">Delete this sub category</h3>
                                <div class="text-muted">
                                    Once you delete a sub category, there is no going back. Please be certain.
                                </div>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('sub-categories.destroy', $subCategory) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this sub category? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ti ti-trash icon me-1"></i>
                                        Delete Sub Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style> 
.svg-icon-container svg {
    width: 100% !important;
    height: 100% !important;
    max-width: 64px !important;
    max-height: 64px !important;
    display: block;
}
</style>

<script> 
document.getElementById('svg').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('svg-preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
 
document.getElementById('name').addEventListener('input', function(e) {
    const slug = document.getElementById('slug'); 
    slug.value = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
});
</script>
@endsection