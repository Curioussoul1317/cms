@extends('layouts.app')

@section('title', 'Edit Main Category')

@section('content')
<div class="container-xl">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Main Categories
                </div>
                <h2 class="page-title">
                    Edit Main Category
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('categories.hierarchy') }}" class="btn btn-secondary">
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

      

                <form action="{{ route('main-categories.update', $mainCategory) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cards">
                    <div class="card col-8">  
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" 
                                               name="name" 
                                               id="name" 
                                               value="{{ old('name', $mainCategory->name) }}" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               placeholder="Enter category name"
                                               required>
                                        <small class="form-hint">A descriptive name for this main category</small>
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
                                               value="{{ old('slug', $mainCategory->slug) }}" 
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
                                        <label class="form-label">Description</label>
                                        <textarea name="description" 
                                                  id="description" 
                                                  rows="3" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Enter a brief description of this category">{{ old('description', $mainCategory->description) }}</textarea>
                                        <small class="form-hint">Optional description to help users understand this category</small>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- Approve Button -->

                                        <!-- <label class="form-label">Display Order</label> -->
                                        <input type="hidden" 
                                               name="order" 
                                               id="order" 
                                               value="{{ old('order', $mainCategory->order) }}" 
                                               class="form-control @error('order') is-invalid @enderror" 
                                               placeholder="0">
                                        <!-- <small class="form-hint">Lower numbers appear first (e.g., 1, 2, 3...)</small>
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror -->

                        <div class="card-footer bg-transparent">
                            <div class="d-flex">
                                <a href="{{ route('categories.hierarchy') }}" class="btn btn-link">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="ti ti-device-floppy icon me-1"></i>
                                    Update Main Category
                                </button>
                            </div>
                        </div>

                    </div>
                    </form>





                    <!-- Settings Card -->
                    <div class="card mt-3 col-4">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            @if($mainCategory->id ==1)

                            @else

                                <div class="col-md-12">
                                @if(!$mainCategory->is_approved)
<form action="{{ route('approve', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$mainCategory->is_published)
<form action="{{ route('publish', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif

                                </div> 
                              
                            </div>

                            <div class="card mt-3 border-danger">
                    <div class="card-header bg-danger-lt">
                        <h3 class="card-title text-danger">
                            <i class="ti ti-alert-triangle icon me-2"></i>
                            Delete
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-1">Delete this main category</h3>
                                <div class="text-muted">
                                    Once you delete a main category, there is no going back. 
                                    @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)
                                        <strong class="text-danger">This will also delete all {{ $mainCategory->subCategories->count() }} sub categories and their links.</strong>
                                    @else
                                        Please be certain.
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('main-categories.destroy', $mainCategory) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this main category? @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)This will also delete all {{ $mainCategory->subCategories->count() }} sub categories and their links. @endif This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ti ti-trash icon me-1"></i>
                                        Delete Main Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                        </div>

                        
                    </div>
                    </div>
 
 
  
              
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function(e) {
        const slug = document.getElementById('slug');
        if (!slug.value || slug.value === '') {
            slug.value = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });
</script>
@endsection