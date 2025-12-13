@extends('layouts.app')

@section('title', 'Edit Link')

@section('content')
<div class="container-xl">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                  Pages
                </div>
                <h2 class="page-title">
                    Edit Page
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
                <form action="{{ route('links.update', $link) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cards">
                    <div class="card col-8">  
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                             
                                <input type="hidden" name="sub_category_id" value="{{ $link->sub_category_id }}">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label required">Title</label>
                                        <input type="text" 
                                               name="title" 
                                               id="title" 
                                               value="{{ old('title', $link->title) }}" 
                                               class="form-control @error('title') is-invalid @enderror" 
                                               placeholder="Enter Page title"
                                               required>
                                        <small class="form-hint">A descriptive title for this Page</small>
                                        @error('title')
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
                                                  placeholder="Enter a brief description of this Page">{{ old('description', $link->description) }}</textarea>
                                        <small class="form-hint">Optional description to provide more context about this page</small>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Card -->
                    <div class="card mt-3 col-4">
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
                                               value="{{ old('order', $link->order) }}" 
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
                                                       {{ old('is_active', $link->is_active) ? 'checked' : '' }} 
                                                       class="form-check-input">
                                                <span class="form-check-label">Active</span>
                                            </label>
                                            <small class="form-hint d-block mt-1">
                                                When inactive, this page will be hidden from public view
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($link->url)
                                <div class="alert alert-info mb-0 mt-3">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <i class="ti ti-info-circle icon alert-icon"></i>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Current URL</h4>
                                            <div class="text-muted">
                                                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="alert-link">
                                                    {{ $link->url }}
                                                    <i class="ti ti-external-link icon ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex">
                                <a href="{{ route('categories.hierarchy') }}" class="btn btn-link">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="ti ti-device-floppy icon me-1"></i>
                                    Update Page
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>

                <!-- Content Blocks Card -->
                <!-- @if($link->contents && $link->contents->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-layout-grid icon me-2"></i>
                                Content Blocks
                            </h3>
                            <div class="card-actions">
                                <a href="{{ route('link-contents.index', ['type' => 'link', 'id' => $link->id]) }}" class="btn btn-primary btn-sm">
                                    Manage Content
                                </a>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($link->contents->take(5) as $content)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar bg-indigo-lt text-indigo">
                                                <i class="ti ti-file-text icon"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold">{{ $content->template->name ?? 'Content Block' }}</div>
                                            <div class="text-muted small">
                                                Order: {{ $content->order }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge {{ $content->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $content->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($link->contents->count() > 5)
                                <div class="list-group-item text-center">
                                    <a href="{{ route('link-contents.index', ['type' => 'link', 'id' => $link->id]) }}" class="text-muted">
                                        View all {{ $link->contents->count() }} content blocks
                                        <i class="ti ti-arrow-right icon ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-layout-grid icon me-2"></i>
                                Content Blocks
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-layout-grid icon"></i>
                                </div>
                                <p class="empty-title">No content blocks yet</p>
                                <p class="empty-subtitle text-muted">
                                    Add content blocks to enhance this link's page
                                </p>
                                <div class="empty-action">
                                    <a href="{{ route('link-contents.create', ['type' => 'link', 'id' => $link->id]) }}" class="btn btn-primary">
                                        <i class="ti ti-plus icon"></i>
                                        Add Content Block
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif -->

                <!-- Danger Zone Card -->
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
                                <h3 class="mb-1">Delete this Page</h3>
                                <div class="text-muted">
                                    Once you delete a Page,  Please be certain.
                                </div>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('links.destroy', $link) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this link? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ti ti-trash icon me-1"></i>
                                        Delete Page
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

@push('scripts')
<script>
    // Validate URL format
    document.getElementById('url').addEventListener('blur', function(e) {
        const url = e.target.value;
        if (url && !url.match(/^https?:\/\//)) {
            e.target.value = 'https://' + url;
        }
    });
</script>
@endpush
@endsection