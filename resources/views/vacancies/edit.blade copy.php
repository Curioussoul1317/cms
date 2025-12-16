 
@extends('layouts.app')

@section('title', 'Edit Vacancy')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Vacancy</h3>
                </div>
                <div class="card-body">

                @if(!$vacancy->is_approved)
<form action="{{ route('approve', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$vacancy->is_published)
<form action="{{ route('publish', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif


                    <form action="{{ route('vacancies.update', $vacancy) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $vacancy->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="posted_date" class="form-label">Posted Date *</label>
                                <input type="date" class="form-control @error('posted_date') is-invalid @enderror" 
                                       id="posted_date" name="posted_date" 
                                       value="{{ old('posted_date', $vacancy->posted_date->format('Y-m-d')) }}" required>
                                @error('posted_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">Due Date *</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" name="due_date" 
                                       value="{{ old('due_date', $vacancy->due_date->format('Y-m-d')) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary *</label>
                            <input type="text" class="form-control @error('salary') is-invalid @enderror" 
                                   id="salary" name="salary" value="{{ old('salary', $vacancy->salary) }}" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="vacancylocation_id" class="form-label">Location *</label>
                            <select class="form-select @error('vacancylocation_id') is-invalid @enderror" 
                                    id="vacancylocation_id" name="vacancylocation_id" required>
                                <option value="">Select Location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" 
                                            {{ old('vacancylocation_id', $vacancy->vacancylocation_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vacancylocation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Application URL</label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url', $vacancy->url) }}">
                            <small class="text-muted">Link to the application page or job details</small>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Vacancy
                            </button>
                            <a href="{{ route('vacancies.index') }}" class="btn btn-secondary">
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