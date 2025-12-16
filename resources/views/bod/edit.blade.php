@extends('layouts.app')

@section('title', 'Edit Board Member')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('bod.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Board of Directors
                    </a>
                </div>
                <h2 class="page-title">Edit Board Member</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $bod->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $bod->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $bod->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $bod->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $bod->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $bod->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($bod->is_active)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-eye me-1"></i>
                            Active
                        </span>
                    @endif
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
                        <p class="text-secondary mb-0">Manage approval and publishing status for this board member.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- Approval Logic: Only show if NOT published --}}
                            @if(!$bod->is_published)
                                @if(!$bod->is_approved)
                                    <form action="{{ route('approve', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($bod->is_approved)
                                @if(!$bod->is_published)
                                    <form action="{{ route('publish', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
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
                @if(!$bod->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This board member needs to be <strong>approved</strong> before they can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('bod.update', $bod) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-user-edit me-2 text-primary"></i>
                                Director Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Full name..."
                                           value="{{ old('name', $bod->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Title/Position</label>
                                    <input type="text" 
                                           name="title" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           placeholder="e.g., Chairman, Director..."
                                           value="{{ old('title', $bod->title) }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description / Bio</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="5"
                                              placeholder="Brief biography or description...">{{ old('description', $bod->description) }}</textarea>
                                    <small class="form-hint">This will appear when hovering over the director's image on the public page.</small>
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
                                               value="{{ old('order', $bod->order) }}"
                                               min="0">
                                    </div>
                                    <small class="form-hint">Lower numbers appear first</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Photo Upload --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-photo me-2 text-primary"></i>
                                Photo
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-center mb-3">
                                    @if($bod->image)
                                        <img src="{{ asset('storage/' . $bod->image) }}" 
                                             alt="{{ $bod->name }}" 
                                             id="current-image"
                                             class="avatar avatar-xl rounded-circle" 
                                             style="object-fit: cover;">
                                        <img src="" alt="Preview" id="image-preview" class="avatar avatar-xl rounded-circle d-none" style="object-fit: cover;">
                                    @else
                                        <span class="avatar avatar-xl rounded-circle bg-primary-lt text-primary" id="preview-avatar">
                                            {{ strtoupper(substr($bod->name, 0, 2)) }}
                                        </span>
                                        <img src="" alt="Preview" id="image-preview" class="avatar avatar-xl rounded-circle d-none" style="object-fit: cover;">
                                    @endif
                                </div>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                <small class="form-hint">
                                    {{ $bod->image ? 'Upload new image to replace existing' : 'Recommended: Square image (500x500px)' }}
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $bod->is_active) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, the director will be displayed on the public Board of Directors page.
                            </small>
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
                                    <div class="datagrid-content">{{ $bod->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $bod->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $bod->is_approved ? 'green' : 'yellow' }}">
                                            {{ $bod->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $bod->is_published ? 'blue' : 'secondary' }}">
                                            {{ $bod->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Director
                                </button>
                                <a href="{{ route('bod.index') }}" class="btn btn-outline-secondary">
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
                            Once deleted, this board member cannot be recovered.
                        </p>
                        <form action="{{ route('bod.destroy', $bod) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this director? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i>
                                Delete Director
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
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const currentImage = document.getElementById('current-image');
    const placeholder = document.getElementById('preview-avatar');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (currentImage) currentImage.classList.add('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush