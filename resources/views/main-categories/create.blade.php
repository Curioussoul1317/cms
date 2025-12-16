@extends('layouts.app')

@section('title', 'Create Main Category')

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
                <h2 class="page-title">Create Main Category</h2>
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

        <form action="{{ route('main-categories.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    {{-- Basic Details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-folder me-2 text-primary"></i>
                                Category Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter category name..."
                                           value="{{ old('name') }}"
                                           required>
                                    <small class="form-hint">A descriptive name for this main category</small>
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
                                    <label class="form-label">Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="3"
                                              placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                                    <small class="form-hint">Optional description to help users understand this category</small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
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
                                    <small class="form-hint">Lower numbers appear first (e.g., 1, 2, 3...)</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Tips --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-bulb me-2 text-yellow"></i>
                                Category Hierarchy
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-blue-lt text-blue">
                                        <i class="ti ti-folder"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Main Categories</h4>
                                    <p class="text-secondary small mb-0">Top-level categories that group related sub-categories together.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-green-lt text-green">
                                        <i class="ti ti-folders"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Sub Categories</h4>
                                    <p class="text-secondary small mb-0">Specific categories that belong to a main category.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-purple-lt text-purple">
                                        <i class="ti ti-link"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Pages</h4>
                                    <p class="text-secondary small mb-0">Individual pages with  that contain content.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-plus me-1"></i>
                                    Create Main Category
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
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = document.getElementById('slug');
            if (!slug.value || slug.dataset.edited !== 'true') {
                slug.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
 
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.edited = 'true';
        });
    });
</script>
@endpush