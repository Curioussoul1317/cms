@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Board Member</h2>
                <a href="{{ route('bod.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
    @endif

    <div class="card">
        <div class="card-body">

        @if(!$bod->is_approved)
<form action="{{ route('approve', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$bod->is_published)
<form action="{{ route('publish', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'bod-director', 'id' => $bod->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif


            <form action="{{ route('bod.update', $bod) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $bod->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title/Position <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $bod->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($bod->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' . $bod->image) }}" 
                                 alt="{{ $bod->name }}" 
                                 style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="image" class="form-label">Image {{ $bod->image ? '(Upload new to replace)' : '' }}</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Recommended: Square image for best circular display</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="6">{{ old('description', $bod->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">This will appear on hover over the image</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                           id="order" name="order" value="{{ old('order', $bod->order) }}" min="0">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" 
                               name="is_active" value="1" {{ old('is_active', $bod->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (Display on public page)
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bod.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Director</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection