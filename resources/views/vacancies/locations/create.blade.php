 
@extends('layouts.app')

@section('title', 'Create Vacancy Location')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Create New Vacancy Location</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('vacancylocations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="location_name" class="form-label">Location Name *</label>
                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" 
                                   id="location_name" name="location_name" value="{{ old('location_name') }}" required>
                            @error('location_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Create Location
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