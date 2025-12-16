@extends('layouts.app')

@section('title', 'Edit Page')

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
                <h2 class="page-title">Edit Page</h2>
                <div class="text-secondary mt-1">
                    Editing: <strong>{{ $page->name }}</strong>
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $page->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $page->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $page->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $page->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $page->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $page->is_published ? 'Published' : 'Draft' }}
                    </span>
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

        {{-- Publishing Controls Card (only show if not ID 1) --}}
        @if($page->id != 1)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-1">
                                <i class="ti ti-settings me-2 text-primary"></i>
                                Publishing Controls
                            </h3>
                            <p class="text-secondary mb-0">Manage approval and publishing status for this page.</p>
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
                                @if(!$page->is_published)
                                    @if(!$page->is_approved)
                                        {{-- Not approved yet - show Approve button --}}
                                        <form action="{{ route('approve', ['model' => 'page', 'id' => $page->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">
                                                <i class="ti ti-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @else
                                        {{-- Already approved but not published - show Unapprove button --}}
                                        <form action="{{ route('unapprove', ['model' => 'page', 'id' => $page->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning">
                                                <i class="ti ti-x me-1"></i> Unapprove
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Publish Buttons: Only show if approved --}}
                                @if($page->is_approved)
                                    @if(!$page->is_published)
                                        {{-- Approved but not published - show Publish button --}}
                                        <form action="{{ route('publish', ['model' => 'page', 'id' => $page->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-upload me-1"></i> Publish
                                            </button>
                                        </form>
                                    @else
                                        {{-- Already published - show Unpublish button --}}
                                        <form action="{{ route('unpublish', ['model' => 'page', 'id' => $page->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <i class="ti ti-download me-1"></i> Unpublish
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Status Flow Indicator --}}
                    @if(!$page->is_approved)
                        <div class="alert alert-info mt-3 mb-0">
                            <div class="d-flex">
                                <div><i class="ti ti-info-circle me-2"></i></div>
                                <div>This page needs to be <strong>approved</strong> before it can be published.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <form action="{{ route('pages.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                                {{-- Only show category/parent selection if not page ID 1 --}}
                                @if($page->id != 1)
                                    <div class="col-12">
                                        <label class="form-label required">Main Category</label>
                                        <select name="main_category_id" 
                                                class="form-select @error('main_category_id') is-invalid @enderror" 
                                                required>
                                            <option value="">Select Main Category...</option>
                                            @foreach($mainCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('main_category_id', $page->main_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('main_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Parent Page</label>
                                        <select name="parent_id" 
                                                id="parent_id"
                                                class="form-select @error('parent_id') is-invalid @enderror">
                                            <option value="">None (Top-level page)</option>
                                            @foreach($parentPages as $parentPage)
                                                <option value="{{ $parentPage->id }}" {{ old('parent_id', $page->parent_id) == $parentPage->id ? 'selected' : '' }}>
                                                    {{ $parentPage->name }}
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
                                           value="{{ old('name', $page->name) }}"
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
                                           value="{{ old('slug', $page->slug) }}">
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
                                           value="{{ old('heading', $page->heading) }}">
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
                                              placeholder="Brief description of this page...">{{ old('description', $page->description) }}</textarea>
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
                    {{-- SVG Icon (only show if not page ID 1) --}}
                    @if($page->id != 1)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-icons me-2 text-primary"></i>
                                    Icon (SVG)
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($page->svg)
                                    <div class="mb-3">
                                        <label class="form-label">Current Icon</label>
                                        <div class="border rounded p-3 text-center bg-light">
                                            <img src="{{ asset('storage/' . $page->svg) }}" 
                                                 alt="Current SVG" 
                                                 style="max-width: 80px; max-height: 80px;"
                                                 id="current-svg">
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">{{ $page->svg ? 'Replace Icon' : 'Upload Icon' }}</label>
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
                                    <label class="form-label">New Preview</label>
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
                                               value="{{ old('order', $page->order) }}"
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
                                           {{ old('has_children', $page->has_children) ? 'checked' : '' }}>
                                    <span class="form-check-label">Allow Child Pages</span>
                                </label>
                                <small class="form-hint d-block mt-2">
                                    Enable to allow creating multiple pages under this page.
                                </small>

                                @if($page->children()->count() > 0)
                                    <div class="alert alert-warning mt-3 mb-0">
                                        <div class="d-flex">
                                            <div><i class="ti ti-alert-triangle me-2"></i></div>
                                            <div>
                                                <div class="fw-medium">{{ $page->children()->count() }} Child Page(s)</div>
                                                <div class="small">Keep "Allow Child Pages" enabled or move children first.</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Statistics --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-chart-bar me-2 text-primary"></i>
                                Statistics
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="avatar bg-purple-lt text-purple me-3">
                                    <i class="ti ti-file-text"></i>
                                </span>
                                <div>
                                    <div class="fw-bold">{{ $page->children()->count() }}</div>
                                    <div class="text-secondary small">Child Pages</div>
                                </div>
                            </div>
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
                                    <div class="datagrid-content">{{ $page->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $page->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $page->is_approved ? 'green' : 'yellow' }}">
                                            <span class="status-dot"></span>
                                            {{ $page->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $page->is_published ? 'blue' : 'secondary' }}">
                                            <span class="status-dot"></span>
                                            {{ $page->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                                @if($page->approved_by)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Approved By</div>
                                        <div class="datagrid-content">{{ $page->approver->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                                @if($page->approved_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Approved At</div>
                                        <div class="datagrid-content">{{ $page->approved_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @endif
                                @if($page->published_by)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Published By</div>
                                        <div class="datagrid-content">{{ $page->publisher->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                                @if($page->published_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Published At</div>
                                        <div class="datagrid-content">{{ $page->published_at->format('d M Y, h:i A') }}</div>
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
                                    Update Page
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

        {{-- Danger Zone - Outside main form (only show if not ID 1) --}}
        @if($page->id != 1)
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
                                @if($page->children()->count() > 0)
                                    <strong class="text-danger">Warning:</strong> This page has {{ $page->children()->count() }} child page(s). They will also be deleted.
                                @else
                                    Once deleted, this page cannot be recovered.
                                @endif
                            </p>
                            <form action="{{ route('pages.destroy', $page) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this page? @if($page->children()->count() > 0)This will also delete all {{ $page->children()->count() }} child page(s). @endif This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="ti ti-trash me-1"></i>
                                    Delete Page
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SVG Preview
        const svgInput = document.getElementById('svg');
        if (svgInput) {
            svgInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-image').src = e.target.result;
                        document.getElementById('svg-preview').style.display = 'block';
                        
                        // Also update current image preview if exists
                        const currentSvg = document.getElementById('current-svg');
                        if (currentSvg) {
                            currentSvg.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('svg-preview').style.display = 'none';
                }
            });
        }

        // Auto-generate slug from name (only if not manually edited)
        document.getElementById('name').addEventListener('input', function(e) {
            const slug = document.getElementById('slug');
            if (!slug.dataset.userModified) {
                slug.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        // Track manual slug edits
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.userModified = 'true';
        });

        // Auto-fill heading from name if empty
        document.getElementById('name').addEventListener('blur', function(e) {
            const heading = document.getElementById('heading');
            if (!heading.value) {
                heading.value = e.target.value;
            }
        });
    });
</script>
@endpush