@extends('layouts.app')

@section('title', 'Create Page')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('categories.hierarchy') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Categories
                    </a>
                </div>
                <h2 class="page-title">Create New Page</h2>
                @if($selectedMainCategory || $selectedParentPage)
                    <div class="text-secondary mt-1">
                        @if($selectedMainCategory)
                            Category: <strong>{{ $selectedMainCategory->name }}</strong>
                        @endif
                        @if($selectedParentPage)
                            <span class="mx-2">•</span> Parent: <strong>{{ $selectedParentPage->name }}</strong>
                        @endif
                    </div>
                @endif
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

        <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Hidden fields for pre-selected values --}}
            @if($selectedMainCategory)
                <input type="hidden" name="main_category_id" value="{{ $selectedMainCategory->id }}">
            @endif
            @if(request('parent_id'))
                <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
            @endif
            @if($requesttype ?? null)
                <input type="hidden" name="subtype" value="{{ $requesttype }}">
            @endif
            
            <div class="row">
                <div class="col-lg-8">
                    {{-- Basic Details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-file-text me-2 text-primary"></i>
                                Page Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                {{-- Main Category Selection (if not pre-selected) --}}
                                @if(!$selectedMainCategory)
                                    <div class="col-12">
                                        <label class="form-label required">Main Category</label>
                                        <select name="main_category_id" 
                                                class="form-select @error('main_category_id') is-invalid @enderror" 
                                                required>
                                            <option value="">Select Main Category...</option>
                                            @foreach($mainCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('main_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                {{-- Parent Page Selection (if not pre-selected) --}}
                                @if(!request('parent_id'))
                                    <div class="col-12">
                                        <label class="form-label">Parent Page</label>
                                        <select name="parent_id" 
                                                id="parent_id"
                                                class="form-select @error('parent_id') is-invalid @enderror">
                                            <option value="">None (Top-level page)</option>
                                            @foreach($parentPages as $page)
                                                <option value="{{ $page->id }}" {{ old('parent_id') == $page->id ? 'selected' : '' }}>
                                                    {{ $page->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">Select a parent page if this is a child page</small>
                                        @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label required">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter page name..."
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Slug</label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug"
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           placeholder="auto-generated-slug"
                                           value="{{ old('slug') }}">
                                    <small class="form-hint">Leave empty to auto-generate from name</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Heading</label>
                                    <input type="text" 
                                           name="heading" 
                                           id="heading"
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           placeholder="Page heading displayed on the page..."
                                           value="{{ old('heading') }}">
                                    <small class="form-hint">This will be displayed as the main heading on the page</small>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="4"
                                              placeholder="Brief description of this page...">{{ old('description') }}</textarea>
                                    <small class="form-hint">A short description to help users understand this page</small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- SVG Icon --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-icons me-2 text-primary"></i>
                                Icon (SVG)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Upload SVG Icon</label>
                                <input type="file" 
                                       name="svg" 
                                       id="svg"
                                       class="form-control @error('svg') is-invalid @enderror" 
                                       accept=".svg,image/svg+xml">
                                <small class="form-hint">Maximum size: 2MB. Recommended: 64x64px</small>
                                @error('svg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview Area --}}
                            <div id="svg-preview" class="mb-3" style="display: none;">
                                <label class="form-label">Preview</label>
                                <div class="border rounded p-3 text-center bg-light">
                                    <img id="preview-image" src="" alt="SVG Preview" style="max-width: 80px; max-height: 80px;">
                                </div>
                            </div>

                            <div class="alert alert-info mb-0">
                                <div class="d-flex">
                                    <div><i class="ti ti-info-circle me-2"></i></div>
                                    <div>
                                        <div class="fw-medium">SVG Tips</div>
                                        <div class="small text-secondary">Upload simple, scalable SVG icons with square dimensions.</div>
                                    </div>
                                </div>
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
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-sort-ascending-numbers"></i>
                                    </span>
                                    <input type="number" 
                                           name="order" 
                                           class="form-control @error('order') is-invalid @enderror" 
                                           value="{{ old('order', 0) }}"
                                           min="0">
                                </div>
                                <small class="form-hint">Lower numbers appear first</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="form-check form-switch">
                                <input type="checkbox" 
                                       name="has_children" 
                                       value="1" 
                                       class="form-check-input"
                                       {{ old('has_children') ? 'checked' : '' }}>
                                <span class="form-check-label">Allow Child Pages</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                Enable to allow creating multiple pages under this page.
                            </small>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-plus me-1"></i>
                                    Create Page
                                </button>
                                <a href="{{ route('categories.hierarchy') }}" class="btn btn-outline-secondary">
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
    document.addEventListener('DOMContentLoaded', function() {
        // SVG Preview
        document.getElementById('svg').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('svg-preview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('svg-preview').style.display = 'none';
            }
        });

        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = document.getElementById('slug');
            if (!slug.dataset.edited) {
                slug.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        // Track manual slug edits
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.edited = 'true';
        });

        // Auto-fill heading from name
        document.getElementById('name').addEventListener('blur', function(e) {
            const heading = document.getElementById('heading');
            if (!heading.value) {
                heading.value = e.target.value;
            }
        });
    });
</script>
@endpush