@extends('layouts.app')

@section('title', 'Create Timeline Item')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('ourtimeline.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Timeline
                    </a>
                </div>
                <h2 class="page-title">Create Timeline Item</h2>
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

        <form action="{{ route('ourtimeline.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-timeline me-2 text-primary"></i>
                                Timeline Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Year</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar-event"></i>
                                        </span>
                                        <input type="number" 
                                               name="year" 
                                               class="form-control @error('year') is-invalid @enderror" 
                                               placeholder="e.g., 2024"
                                               value="{{ old('year', date('Y')) }}"
                                               min="1900" 
                                               max="2100"
                                               required>
                                    </div>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input type="date" 
                                               name="date" 
                                               class="form-control @error('date') is-invalid @enderror" 
                                               value="{{ old('date') }}"
                                               required>
                                    </div>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label required">Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="5"
                                              placeholder="Describe this milestone or event..."
                                              required>{{ old('description') }}</textarea>
                                    <small class="form-hint">Provide details about this timeline event or milestone.</small>
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
                                    <small class="form-hint">For sorting items within the same year (lower = first)</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Image Upload --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-photo me-2 text-primary"></i>
                                Image
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-center mb-3">
                                    <span class="avatar avatar-xl rounded bg-primary-lt text-primary" id="preview-placeholder">
                                        <i class="ti ti-photo" style="font-size: 2rem;"></i>
                                    </span>
                                    <img src="" alt="Preview" id="image-preview" class="avatar avatar-xl rounded d-none" style="object-fit: cover;">
                                </div>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                <small class="form-hint">Optional image for this timeline event</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-bulb me-2 text-yellow"></i>
                                Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-primary-lt text-primary">
                                        <i class="ti ti-calendar"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Accurate Dates</h4> 
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-green-lt text-green">
                                        <i class="ti ti-photo"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Add Images</h4> 
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Create Timeline Item
                                </button>
                                <a href="{{ route('ourtimeline.index') }}" class="btn btn-outline-secondary">
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
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('preview-placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush