 
@extends('layouts.app')

@section('title', 'Edit Vacancy Location')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Vacancy Location</h3>
                </div>
                <div class="card-body">
                    
                @if(!$vacancylocation->is_approved)
<form action="{{ route('approve', ['model' => 'vacancy-location', 'id' => $vacancylocation->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'vacancy-location', 'id' => $vacancylocation->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$vacancylocation->is_published)
<form action="{{ route('publish', ['model' => 'vacancy-location', 'id' => $vacancylocation->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'vacancy-location', 'id' => $vacancylocation->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif
                    <form action="{{ route('vacancylocations.update', $vacancylocation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="location_name" class="form-label">Location Name *</label>
                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" 
                                   id="location_name" name="location_name" 
                                   value="{{ old('location_name', $vacancylocation->location_name) }}" required>
                            @error('location_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   name="is_active" value="1" 
                                   {{ old('is_active', $vacancylocation->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Location
                            </button>
                            <a href="{{ route('vacancylocations.index') }}" class="btn btn-secondary">
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