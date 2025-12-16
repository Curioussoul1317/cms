@extends('layouts.app')

@section('title', 'Edit Vacancy')

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
                <h2 class="page-title">Edit Vacancy</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $vacancy->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $vacancy->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $vacancy->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $vacancy->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $vacancy->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $vacancy->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($vacancy->is_expired)
                        <span class="badge bg-red-lt fs-6">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Expired
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

        {{-- Publishing Controls Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-1">
                            <i class="ti ti-settings me-2 text-primary"></i>
                            Publishing Controls
                        </h3>
                        <p class="text-secondary mb-0">Manage approval and publishing status for this vacancy.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- Approval Logic: Only show if NOT published --}}
                            @if(!$vacancy->is_published)
                                @if(!$vacancy->is_approved)
                                    <form action="{{ route('approve', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($vacancy->is_approved)
                                @if(!$vacancy->is_published)
                                    <form action="{{ route('publish', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'vacancy', 'id' => $vacancy->id]) }}" method="POST" class="d-inline">
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
                @if(!$vacancy->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This vacancy needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('vacancies.update', $vacancy) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                                           value="{{ old('title', $vacancy->title) }}"
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
                                               value="{{ old('posted_date', $vacancy->posted_date->format('Y-m-d')) }}"
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
                                               value="{{ old('due_date', $vacancy->due_date->format('Y-m-d')) }}"
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
                                               value="{{ old('salary', $vacancy->salary) }}"
                                               required>
                                    </div>
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Location</label>
                                    <select name="vacancylocation_id" class="form-select @error('vacancylocation_id') is-invalid @enderror" required>
                                        <option value="">Select location...</option>
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
                                               value="{{ old('url', $vacancy->url) }}">
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
                    {{-- Information Card --}}
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
                                    <div class="datagrid-content">{{ $vacancy->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $vacancy->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Days Until Due</div>
                                    <div class="datagrid-content">
                                        @if($vacancy->due_date->isPast())
                                            <span class="text-danger">
                                                <i class="ti ti-alert-triangle me-1"></i>
                                                Expired {{ $vacancy->due_date->diffForHumans() }}
                                            </span>
                                        @elseif($vacancy->due_date->diffInDays(now()) <= 7)
                                            <span class="text-warning">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ $vacancy->due_date->diffInDays(now()) }} days remaining
                                            </span>
                                        @else
                                            <span class="text-success">
                                                <i class="ti ti-check me-1"></i>
                                                {{ $vacancy->due_date->diffInDays(now()) }} days remaining
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $vacancy->is_approved ? 'green' : 'yellow' }}">
                                            {{ $vacancy->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $vacancy->is_published ? 'blue' : 'secondary' }}">
                                            {{ $vacancy->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Vacancy
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
                            Once deleted, this vacancy cannot be recovered.
                        </p>
                        <form action="{{ route('vacancies.destroy', $vacancy) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this vacancy? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i>
                                Delete Vacancy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection