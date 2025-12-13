@extends('layouts.app')

@section('title', 'Create Sub Category')

@section('content')

<div class="container-xl">
    <div class="page-header d-print-none ">
        <div class="row g-2 align-items-center">
            <div class="col">
                @if($requesttype=="Page")
                <h2 class="page-title">New Page Creation</h2>
                <div class="text-muted mt-1">Creating new page under: <strong>{{ $selectedMainCategory->name }}</strong></div>
                @else
                <h2 class="page-title">New Sub Category Creation</h2>
                <div class="text-muted mt-1">Creating new Sub Category under: <strong>{{ $selectedMainCategory->name }}</strong></div>
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

 

    <!-- Page body -->
    <div class="page-body">
        <div class="row row-cards">
            <div class="col-lg-12 mx-auto">
                <form action="{{ route('sub-categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-cards">
                    <div class="card col-8">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <input type="hidden" name="main_category_id" value="{{ request('main_category') ?? $mainCategory->id ?? '' }}">
                            <input type="hidden" name="subtype" value="{{$requesttype}}">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" 
                                               name="name" 
                                               id="name" 
                                               value="{{ old('name') }}" 
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
                                               value="{{ old('slug') }}" 
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
                                               value="{{ old('heading') }}" 
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
                                                  placeholder="Enter a brief description of this sub category">{{ old('description') }}</textarea>
                                        <small class="form-hint">A short description to help users understand this category</small>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SVG Icon Card -->
                    <div class="card mt-3 col-4">
                        <div class="card-header">
                            <h3 class="card-title">Icon (SVG)</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">SVG Icon</label>
                                <input type="file" 
                                    name="svg" 
                                    id="svg" 
                                    class="form-control @error('svg') is-invalid @enderror" 
                                    accept=".svg,image/svg+xml">
                                <small class="form-hint">Upload an SVG file. Maximum size: 2MB.</small>
                                @error('svg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        <!-- Preview Area (Optional) -->
                        <div id="svg-preview" class="mb-3" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div class="border rounded p-3 text-center">
                                <img id="preview-image" src="" alt="SVG Preview" style="max-width: 100px; max-height: 100px;">
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


 

                    <!-- Settings Card -->
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
                                               value="{{ old('order', 0) }}" 
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
                                                       {{ old('is_active', true) ? 'checked' : '' }} 
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
                                    <i class="ti ti-plus icon me-1"></i>
                                    Create Sub Category
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

 
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
        if (!slug.value || slug.value === '') {
            slug.value = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

 
    document.getElementById('name').addEventListener('blur', function(e) {
        const heading = document.getElementById('heading');
        if (!heading.value || heading.value === '') {
            heading.value = e.target.value;
        }
    });
</script> 
@endsection