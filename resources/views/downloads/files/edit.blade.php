 
@extends('layouts.app')

@section('title', 'Edit Download File')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Download File</h3>
                </div>
                <div class="card-body">

                
                @if(!$downloadfile->is_approved)
<form action="{{ route('approve', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$downloadfile->is_published)
<form action="{{ route('publish', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'download-file', 'id' => $downloadfile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif

                    <form action="{{ route('downloadfiles.update', $downloadfile) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="downloadcategory_id" class="form-label">Category *</label>
                            <select class="form-select @error('downloadcategory_id') is-invalid @enderror" 
                                    id="downloadcategory_id" name="downloadcategory_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('downloadcategory_id', $downloadfile->downloadcategory_id) == $category->id ? 'selected' : '' }}>
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
                                   id="title" name="title" value="{{ old('title', $downloadfile->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $downloadfile->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="eng_file" class="form-label">English PDF File</label>
                            @if($downloadfile->eng_file)
                                <div class="mb-2">
                                    <a href="{{ route('downloadfiles.download-english', $downloadfile) }}" 
                                       class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Current English File
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('eng_file') is-invalid @enderror" 
                                   id="eng_file" name="eng_file" accept=".pdf">
                            <small class="text-muted">Leave empty to keep current file. PDF only, max 10MB</small>
                            @error('eng_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dhivehi_file" class="form-label">Dhivehi PDF File</label>
                            @if($downloadfile->dhivehi_file)
                                <div class="mb-2">
                                    <a href="{{ route('downloadfiles.download-dhivehi', $downloadfile) }}" 
                                       class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Current Dhivehi File
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('dhivehi_file') is-invalid @enderror" 
                                   id="dhivehi_file" name="dhivehi_file" accept=".pdf">
                            <small class="text-muted">Leave empty to keep current file. PDF only, max 10MB</small>
                            @error('dhivehi_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', $downloadfile->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (Show on website)
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update File
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