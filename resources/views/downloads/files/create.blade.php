 
@extends('layouts.app')

@section('title', 'Add Download File')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Download File</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('downloadfiles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="downloadcategory_id" class="form-label">Category *</label>
                            <select class="form-select @error('downloadcategory_id') is-invalid @enderror" 
                                    id="downloadcategory_id" name="downloadcategory_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('downloadcategory_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('downloadcategory_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="eng_file" class="form-label">English PDF File</label>
                            <input type="file" class="form-control @error('eng_file') is-invalid @enderror" 
                                   id="eng_file" name="eng_file" accept=".pdf">
                            <small class="text-muted">PDF only, max 10MB</small>
                            @error('eng_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dhivehi_file" class="form-label">Dhivehi PDF File</label>
                            <input type="file" class="form-control @error('dhivehi_file') is-invalid @enderror" 
                                   id="dhivehi_file" name="dhivehi_file" accept=".pdf">
                            <small class="text-muted">PDF only, max 10MB</small>
                            @error('dhivehi_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (Show on website)
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Add File
                            </button>
                            <a href="{{ route('downloadfiles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection