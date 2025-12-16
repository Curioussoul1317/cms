@extends('layouts.app')

@section('title', 'Edit Main Category')

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
                <h2 class="page-title">Edit Main Category</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $mainCategory->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $mainCategory->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $mainCategory->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $mainCategory->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $mainCategory->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $mainCategory->is_published ? 'Published' : 'Draft' }}
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
        @if($mainCategory->id != 1)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-1">
                                <i class="ti ti-settings me-2 text-primary"></i>
                                Publishing Controls
                            </h3>
                            <p class="text-secondary mb-0">Manage approval and publishing status for this category.</p>
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
                                @if(!$mainCategory->is_published)
                                    @if(!$mainCategory->is_approved)
                                        {{-- Not approved yet - show Approve button --}}
                                        <form action="{{ route('approve', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">
                                                <i class="ti ti-check me-1"></i> Approve
                                            </button>
                                        </form>
                                    @else
                                        {{-- Already approved but not published - show Unapprove button --}}
                                        <form action="{{ route('unapprove', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning">
                                                <i class="ti ti-x me-1"></i> Unapprove
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Publish Buttons: Only show if approved --}}
                                @if($mainCategory->is_approved)
                                    @if(!$mainCategory->is_published)
                                        {{-- Approved but not published - show Publish button --}}
                                        <form action="{{ route('publish', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-upload me-1"></i> Publish
                                            </button>
                                        </form>
                                    @else
                                        {{-- Already published - show Unpublish button --}}
                                        <form action="{{ route('unpublish', ['model' => 'main-category', 'id' => $mainCategory->id]) }}" method="POST" class="d-inline">
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
                    @if(!$mainCategory->is_approved)
                        <div class="alert alert-info mt-3 mb-0">
                            <div class="d-flex">
                                <div><i class="ti ti-info-circle me-2"></i></div>
                                <div>This category needs to be <strong>approved</strong> before it can be published.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <form action="{{ route('main-categories.update', $mainCategory) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                                           value="{{ old('name', $mainCategory->name) }}"
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
                                           value="{{ old('slug', $mainCategory->slug) }}">
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
                                              placeholder="Brief description of this category...">{{ old('description', $mainCategory->description) }}</textarea>
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
                                               value="{{ old('order', $mainCategory->order) }}"
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
                                <span class="avatar bg-green-lt text-green me-3">
                                    <i class="ti ti-folders"></i>
                                </span>
                                <div>
                                    <div class="fw-bold">{{ $mainCategory->subCategories ? $mainCategory->subCategories->count() : 0 }}</div>
                                    <div class="text-secondary small">Sub Categories</div>
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
                                    <div class="datagrid-content">{{ $mainCategory->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $mainCategory->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $mainCategory->is_approved ? 'green' : 'yellow' }}">
                                            <span class="status-dot"></span>
                                            {{ $mainCategory->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $mainCategory->is_published ? 'blue' : 'secondary' }}">
                                            <span class="status-dot"></span>
                                            {{ $mainCategory->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                                @if($mainCategory->approved_by)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Approved By</div>
                                        <div class="datagrid-content">{{ $mainCategory->approver->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                                @if($mainCategory->approved_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Approved At</div>
                                        <div class="datagrid-content">{{ $mainCategory->approved_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @endif
                                @if($mainCategory->published_by)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Published By</div>
                                        <div class="datagrid-content">{{ $mainCategory->publisher->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                                @if($mainCategory->published_at)
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Published At</div>
                                        <div class="datagrid-content">{{ $mainCategory->published_at->format('d M Y, h:i A') }}</div>
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
                                    Update Main Category
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
        @if($mainCategory->id != 1)
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
                                @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)
                                    <strong class="text-danger">Warning:</strong> This will also delete all {{ $mainCategory->subCategories->count() }} sub categories and their links.
                                @else
                                    Once deleted, this category cannot be recovered.
                                @endif
                            </p>
                            <form action="{{ route('main-categories.destroy', $mainCategory) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this main category? @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)This will also delete all {{ $mainCategory->subCategories->count() }} sub categories and their links. @endif This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="ti ti-trash me-1"></i>
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
@endsection