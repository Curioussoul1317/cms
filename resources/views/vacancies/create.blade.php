@extends('layouts.app')

@section('title', 'Create Vacancy')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('vacancies.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Vacancies
                    </a>
                </div>
                <h2 class="page-title">Create New Vacancy</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="{{ route('vacancies.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-briefcase me-2 text-primary"></i>
                                Vacancy Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label required">Job Title</label>
                                    <input type="text" 
                                           name="title" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           placeholder="Enter job title..."
                                           value="{{ old('title') }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Posted Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input type="date" 
                                               name="posted_date" 
                                               class="form-control @error('posted_date') is-invalid @enderror" 
                                               value="{{ old('posted_date', date('Y-m-d')) }}"
                                               required>
                                    </div>
                                    @error('posted_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Due Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar-due"></i>
                                        </span>
                                        <input type="date" 
                                               name="due_date" 
                                               class="form-control @error('due_date') is-invalid @enderror" 
                                               value="{{ old('due_date') }}"
                                               required>
                                    </div>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">MVR</span>
                                        <input type="text" 
                                               name="salary" 
                                               class="form-control @error('salary') is-invalid @enderror" 
                                               placeholder="e.g., 9,000"
                                               value="{{ old('salary') }}"
                                               required>
                                    </div>
                                    <small class="form-hint">Enter monthly salary amount</small>
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Location</label>
                                    <select name="vacancylocation_id" class="form-select @error('vacancylocation_id') is-invalid @enderror" required>
                                        <option value="">Select location...</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('vacancylocation_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vacancylocation_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Application URL</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-link"></i>
                                        </span>
                                        <input type="url" 
                                               name="url" 
                                               class="form-control @error('url') is-invalid @enderror" 
                                               placeholder="https://example.com/apply"
                                               value="{{ old('url') }}">
                                    </div>
                                    <small class="form-hint">Link to the application page or job details (optional)</small>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Tips Card --}}
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
                                        <i class="ti ti-writing"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Clear Job Title</h4>
                                    <p class="text-secondary small mb-0">Use a descriptive title that candidates will search for.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-green-lt text-green">
                                        <i class="ti ti-calendar"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Set Deadlines</h4>
                                    <p class="text-secondary small mb-0">Give candidates enough time to prepare applications.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-cyan-lt text-cyan">
                                        <i class="ti ti-coin"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Transparent Salary</h4>
                                    <p class="text-secondary small mb-0">Clear salary info attracts more qualified candidates.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Create Vacancy
                                </button>
                                <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary">
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