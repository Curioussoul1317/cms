@extends('layouts.app')

@section('title', 'Edit News')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('news.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to News
                    </a>
                </div>
                <h2 class="page-title">Edit News</h2>
                <div class="text-secondary mt-1">
                    Editing: <strong>{{ Str::limit($news->title, 50) }}</strong>
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $news->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $news->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $news->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $news->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $news->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $news->is_published ? 'Published' : 'Draft' }}
                    </span>
                    <span class="badge {{ $news->is_active ? 'bg-green' : 'bg-red' }} fs-6">
                        {{ $news->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <a href="{{ route('news.show', $news) }}" class="btn btn-outline-primary">
                        <i class="ti ti-eye me-1"></i>
                        View
                    </a>
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
                        <p class="text-secondary mb-0">Manage approval and publishing status for this news article.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- 
                                APPROVE/PUBLISH WORKFLOW LOGIC:
                                - NOT approved: Show "Approve" button only
                                - Approved but NOT published: Show "Unapprove" and "Publish" buttons
                                - Published: Show only "Unpublish" button (approval buttons hidden)
                            --}}
                            
                            {{-- Approval Buttons: Only show if NOT published --}}
                            @if(!$news->is_published)
                                @if(!$news->is_approved)
                                    {{-- Not approved yet - show Approve button --}}
                                    <form action="{{ route('news.approve', $news) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    {{-- Already approved but not published - show Unapprove button --}}
                                    <form action="{{ route('news.unapprove', $news) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Buttons: Only show if approved --}}
                            @if($news->is_approved)
                                @if(!$news->is_published)
                                    {{-- Approved but not published - show Publish button --}}
                                    <form action="{{ route('news.publish', $news) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    {{-- Already published - show Unpublish button --}}
                                    <form action="{{ route('news.unpublish', $news) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="ti ti-download me-1"></i> Unpublish
                                        </button>
                                    </form>
                                @endif
                            @endif

                            <div class="vr mx-2"></div>

                            {{-- Toggle Active --}}
                            <form action="{{ route('news.toggle-active', $news) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $news->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    <i class="ti ti-{{ $news->is_active ? 'eye-off' : 'eye' }} me-1"></i>
                                    {{ $news->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Status Flow Indicator --}}
                @if(!$news->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This news article needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                {{-- Main Content --}}
                <div class="col-lg-8">
                    {{-- News Details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-news me-2 text-primary"></i>
                                News Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Title</label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $news->title) }}" 
                                       placeholder="Enter news title..."
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" 
                                       name="slug" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       value="{{ old('slug', $news->slug) }}" 
                                       placeholder="auto-generated-from-title">
                                <small class="form-hint">Leave empty to auto-generate from title</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Excerpt</label>
                                <textarea name="excerpt" 
                                          class="form-control @error('excerpt') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Brief summary of the news (max 500 characters)">{{ old('excerpt', $news->excerpt) }}</textarea>
                                <small class="form-hint">A short summary displayed in news listings</small>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Content</label>
                                <textarea name="content" 
                                          id="content" 
                                          class="form-control @error('content') is-invalid @enderror" 
                                          rows="15" 
                                          placeholder="Enter full news content..."
                                          required>{{ old('content', $news->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Existing Gallery Images --}}
                    @if($news->images->count() > 0)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-photo me-2 text-primary"></i>
                                    Existing Gallery Images
                                </h3>
                                <div class="card-actions">
                                    <span class="badge bg-cyan-lt">{{ $news->images->count() }} images</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3" id="existing-images-container">
                                    @foreach($news->images as $image)
                                        <div class="col-md-6 existing-image-item" id="existing-image-{{ $image->id }}">
                                            <div class="card bg-light">
                                                <div class="row g-0">
                                                    <div class="col-4">
                                                        <img src="{{ $image->image_url }}" 
                                                             class="rounded-start" 
                                                             style="width:100%; height:120px; object-fit:cover;">
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="card-body p-2">
                                                            <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                                            <input type="hidden" name="image_order[{{ $image->id }}]" value="{{ $image->sort_order }}" class="image-order-input">
                                                            
                                                            <div class="mb-2">
                                                                <input type="text" 
                                                                       name="existing_captions[{{ $image->id }}]" 
                                                                       class="form-control form-control-sm" 
                                                                       placeholder="Caption" 
                                                                       value="{{ $image->caption }}">
                                                            </div>
                                                            <div class="mb-2">
                                                                <input type="text" 
                                                                       name="existing_alt_texts[{{ $image->id }}]" 
                                                                       class="form-control form-control-sm" 
                                                                       placeholder="Alt text" 
                                                                       value="{{ $image->alt_text }}">
                                                            </div>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    onclick="removeExistingImage({{ $image->id }})">
                                                                <i class="ti ti-trash me-1"></i>
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Add New Images --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-photo-plus me-2 text-primary"></i>
                                Add New Images
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="image-upload-container">
                                <div class="image-upload-row mb-3" id="image-row-0">
                                    <div class="row g-3 align-items-end">
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
                                            <input type="text" name="alt_texts[]" class="form-control" placeholder="Alt text">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-icon btn-ghost-danger" onclick="removeImageRow(0)" style="display:none;">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-2 image-preview" id="preview-0"></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary" onclick="addImageRow()">
                                <i class="ti ti-plus me-1"></i>
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
                            <h3 class="card-title">
                                <i class="ti ti-photo me-2 text-primary"></i>
                                Featured Image
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($news->featured_image)
                                <div class="mb-3" id="current-featured-image">
                                    <img src="{{ $news->featured_image_url }}" class="img-thumbnail w-100 mb-2" id="featured-preview">
                                    <small class="text-secondary">Current image - upload new to replace</small>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="form-label">{{ $news->featured_image ? 'Replace Image' : 'Upload Image' }}</label>
                                <input type="file" 
                                       name="featured_image" 
                                       class="form-control @error('featured_image') is-invalid @enderror" 
                                       accept="image/*" 
                                       onchange="previewFeaturedImage(this)">
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
                            <h3 class="card-title">
                                <i class="ti ti-settings me-2 text-primary"></i>
                                Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-sort-ascending-numbers"></i>
                                    </span>
                                    <input type="number" 
                                           name="sort_order" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', $news->sort_order) }}" 
                                           min="0">
                                </div>
                                <small class="form-hint">Lower numbers appear first</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       class="form-check-input" 
                                       {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block">Inactive news won't be visible on the website</small>
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
                                    <div class="datagrid-content">
                                        {{ $news->created_at->format('d M Y, h:i A') }}
                                        @if($news->creator)
                                            <br><small class="text-secondary">by {{ $news->creator->name }}</small>
                                        @endif
                                    </div>
                                </div>
                                @if($news->updated_at != $news->created_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Last Updated</div>
                                        <div class="datagrid-content">
                                            {{ $news->updated_at->format('d M Y, h:i A') }}
                                            @if($news->updater)
                                                <br><small class="text-secondary">by {{ $news->updater->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $news->is_approved ? 'green' : 'yellow' }}">
                                            <span class="status-dot"></span>
                                            {{ $news->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $news->is_published ? 'blue' : 'secondary' }}">
                                            <span class="status-dot"></span>
                                            {{ $news->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                                @if($news->approved_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Approved</div>
                                        <div class="datagrid-content">
                                            {{ $news->approved_at->format('d M Y, h:i A') }}
                                            @if($news->approver)
                                                <br><small class="text-secondary">by {{ $news->approver->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if($news->published_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Published</div>
                                        <div class="datagrid-content">
                                            {{ $news->published_at->format('d M Y, h:i A') }}
                                            @if($news->publisher)
                                                <br><small class="text-secondary">by {{ $news->publisher->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update News
                                </button>
                                <a href="{{ route('news.show', $news) }}" class="btn btn-outline-primary">
                                    <i class="ti ti-eye me-1"></i>
                                    View News
                                </a>
                                <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">
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
                            Once deleted, this news article and all its images cannot be recovered.
                        </p>
                        <form action="{{ route('news.destroy', $news) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this news article? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i>
                                Delete News
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
    let imageRowCount = 1;

    function addImageRow() {
        const container = document.getElementById('image-upload-container');
        const rowId = imageRowCount++;
        
        const html = `
            <div class="image-upload-row mb-3" id="image-row-${rowId}">
                <hr class="my-3">
                <div class="row g-3 align-items-end">
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
                        <input type="text" name="alt_texts[]" class="form-control" placeholder="Alt text">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-icon btn-ghost-danger" onclick="removeImageRow(${rowId})">
                            <i class="ti ti-x"></i>
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

    function removeExistingImage(imageId) {
        if (confirm('Are you sure you want to remove this image?')) {
            const item = document.getElementById(`existing-image-${imageId}`);
            if (item) {
                item.remove();
            }
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
        const existingPreview = document.getElementById('featured-preview');
        preview.innerHTML = '';
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (existingPreview) {
                    existingPreview.src = e.target.result;
                } else {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail w-100">`;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush