@extends('layouts.app')

@section('title', 'Create News')

@section('page-header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="page-pretitle">News Management</div>
        <div class="page-title-wrapper d-flex justify-content-between align-items-center">
            <h2 class="page-title">Create News</h2>
            <a href="{{ route('news.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 14l-4 -4l4 -4"/>
                    <path d="M5 10h11a4 4 0 1 1 0 8h-1"/>
                </svg>
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-xl">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                    <path d="M12 9v4"/>
                    <path d="M12 16v.01"/>
                </svg>
            </div>
            <div>
                <h4 class="alert-title">Please fix the following errors:</h4>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">News Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required placeholder="Enter news title">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                            <small class="form-hint">Leave empty to auto-generate from title</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt</label>
                            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" 
                                      rows="3" placeholder="Brief summary of the news (max 500 characters)">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Content</label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" 
                                      rows="15" required placeholder="Enter full news content">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Gallery Images --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Gallery Images</h3>
                    </div>
                    <div class="card-body">
                        <div id="image-upload-container">
                            <div class="image-upload-row mb-3" id="image-row-0">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="images[]" class="form-control" accept="image/*" onchange="previewImage(this, 0)">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Caption</label>
                                        <input type="text" name="captions[]" class="form-control" placeholder="Image caption">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Alt Text</label>
                                        <input type="text" name="alt_texts[]" class="form-control" placeholder="Alt text for accessibility">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-icon" onclick="removeImageRow(0)" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M18 6l-12 12"/>
                                                <path d="M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2 image-preview" id="preview-0"></div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary" onclick="addImageRow()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14"/>
                                <path d="M5 12l14 0"/>
                            </svg>
                            Add Another Image
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Featured Image --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" 
                                   accept="image/*" onchange="previewFeaturedImage(this)">
                            @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="featured-image-preview"></div>
                    </div>
                </div>

                {{-- Settings --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', 0) }}" min="0">
                            <small class="form-hint">Lower numbers appear first</small>
                            @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block">Inactive news won't be visible on the website</small>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/>
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                    <path d="M14 4l0 4l-6 0l0 -4"/>
                                </svg>
                                Create News
                            </button>
                            <a href="{{ route('news.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let imageRowCount = 1;

function addImageRow() {
    const container = document.getElementById('image-upload-container');
    const rowId = imageRowCount++;
    
    const html = `
        <div class="image-upload-row mb-3" id="image-row-${rowId}">
            <hr class="my-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Image</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" onchange="previewImage(this, ${rowId})">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Caption</label>
                    <input type="text" name="captions[]" class="form-control" placeholder="Image caption">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Alt Text</label>
                    <input type="text" name="alt_texts[]" class="form-control" placeholder="Alt text for accessibility">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-icon" onclick="removeImageRow(${rowId})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 6l-12 12"/>
                            <path d="M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 image-preview" id="preview-${rowId}"></div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

function removeImageRow(rowId) {
    const row = document.getElementById(`image-row-${rowId}`);
    if (row) {
        row.remove();
    }
}

function previewImage(input, rowId) {
    const preview = document.getElementById(`preview-${rowId}`);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewFeaturedImage(input) {
    const preview = document.getElementById('featured-image-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail w-100">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush