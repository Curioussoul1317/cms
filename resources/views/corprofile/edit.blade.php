@extends('layouts.app')

@section('title', 'Edit Corporate Profile')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('corprofile.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to List
                    </a>
                </div>
                <h2 class="page-title">Edit Corporate Profile</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $corprofile->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6 me-2">
                        <i class="ti ti-{{ $corprofile->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $corprofile->is_approved ? 'Approved' : 'Pending Approval' }}
                    </span>
                    <span class="badge {{ $corprofile->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $corprofile->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $corprofile->is_published ? 'Published' : 'Draft' }}
                    </span>
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

        {{-- Approval & Publishing Actions Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-1">
                            <i class="ti ti-settings me-2 text-primary"></i>
                            Publishing Controls
                        </h3>
                        <p class="text-secondary mb-0">Manage approval and publishing status for this content.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- Approval Logic: Only show if NOT published --}}
                            @if(!$corprofile->is_published)
                                @if(!$corprofile->is_approved)
                                    <form action="{{ route('approve', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($corprofile->is_approved)
                                @if(!$corprofile->is_published)
                                    <form action="{{ route('publish', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
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
                @if(!$corprofile->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This content needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Basic Information --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-info-circle me-2 text-primary"></i>
                            Basic Information
                        </h3>
                        @if($corprofile->video || $corprofile->description)
                            <div class="card-actions">
                                <span class="badge bg-green-lt">
                                    <i class="ti ti-check me-1"></i> Saved
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.basic', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Video</label>
                                @if($corprofile->video)
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <video width="100%" style="max-width: 400px;" controls class="rounded">
                                            <source src="{{ Storage::url($corprofile->video) }}" type="video/mp4">
                                        </video>
                                        <p class="text-secondary small mb-0 mt-2">
                                            <i class="ti ti-video me-1"></i> Current video uploaded
                                        </p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('video') is-invalid @enderror" 
                                       name="video" accept="video/*">
                                <small class="form-hint">Upload a new video to replace the existing one (MP4 recommended)</small>
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="5" 
                                          placeholder="Enter company description...">{{ old('description', $corprofile->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Save Basic Info
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Vision Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-eye me-2 text-green"></i>
                            Vision
                        </h3>
                        @if($corprofile->vision_image || $corprofile->vision_text)
                            <div class="card-actions">
                                <span class="badge bg-green-lt">
                                    <i class="ti ti-check me-1"></i> Saved
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.vision', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Vision Image</label>
                                @if($corprofile->vision_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->vision_image) }}" 
                                             alt="Vision" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('vision_image') is-invalid @enderror" 
                                       name="vision_image" accept="image/*">
                                @error('vision_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Vision Text</label>
                                <textarea class="form-control @error('vision_text') is-invalid @enderror" 
                                          name="vision_text" rows="3" 
                                          placeholder="Enter vision statement...">{{ old('vision_text', $corprofile->vision_text) }}</textarea>
                                @error('vision_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-green">
                                <i class="ti ti-device-floppy me-1"></i> Save Vision
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mission Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-target me-2 text-cyan"></i>
                            Mission
                        </h3>
                        @if($corprofile->mission_image || $corprofile->mission_text)
                            <div class="card-actions">
                                <span class="badge bg-green-lt">
                                    <i class="ti ti-check me-1"></i> Saved
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.mission', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Mission Image</label>
                                @if($corprofile->mission_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->mission_image) }}" 
                                             alt="Mission" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('mission_image') is-invalid @enderror" 
                                       name="mission_image" accept="image/*">
                                @error('mission_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Mission Text</label>
                                <textarea class="form-control @error('mission_text') is-invalid @enderror" 
                                          name="mission_text" rows="3" 
                                          placeholder="Enter mission statement...">{{ old('mission_text', $corprofile->mission_text) }}</textarea>
                                @error('mission_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-cyan">
                                <i class="ti ti-device-floppy me-1"></i> Save Mission
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Objectives Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-list-check me-2 text-yellow"></i>
                            Objectives
                        </h3>
                        @if($corprofile->objectives->count() > 0)
                            <div class="card-actions">
                                <span class="badge bg-yellow-lt">
                                    {{ $corprofile->objectives->count() }} {{ Str::plural('item', $corprofile->objectives->count()) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.objectives', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Objectives Image</label>
                                @if($corprofile->objectives_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->objectives_image) }}" 
                                             alt="Objectives" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('objectives_image') is-invalid @enderror" 
                                       name="objectives_image" accept="image/*">
                                @error('objectives_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="objectives-container">
                                @forelse($corprofile->objectives as $index => $objective)
                                    <div class="objective-item card card-body bg-light mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="badge bg-yellow">Objective {{ $index + 1 }}</span>
                                            <button type="button" class="btn btn-icon btn-ghost-danger btn-sm" onclick="removeItem(this.closest('.objective-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="objectives[{{ $index }}][title]" 
                                                   value="{{ $objective->title }}" placeholder="Objective title" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="objectives[{{ $index }}][description]" 
                                                      rows="2" placeholder="Objective description">{{ $objective->description }}</textarea>
                                        </div>
                                    </div>
                                @empty
                                    <div class="objective-item card card-body bg-light mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="badge bg-yellow">Objective 1</span>
                                            <button type="button" class="btn btn-icon btn-ghost-danger btn-sm" onclick="removeItem(this.closest('.objective-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="objectives[0][title]" 
                                                   placeholder="Objective title" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="objectives[0][description]" 
                                                      rows="2" placeholder="Objective description"></textarea>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="addObjective()">
                                    <i class="ti ti-plus me-1"></i> Add Objective
                                </button>
                                <button type="submit" class="btn btn-yellow">
                                    <i class="ti ti-device-floppy me-1"></i> Save Objectives
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Strategies Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-chart-arrows me-2 text-red"></i>
                            Strategies
                        </h3>
                        @if($corprofile->strategies->count() > 0)
                            <div class="card-actions">
                                <span class="badge bg-red-lt">
                                    {{ $corprofile->strategies->count() }} {{ Str::plural('item', $corprofile->strategies->count()) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.strategies', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Strategies Image</label>
                                @if($corprofile->strategies_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->strategies_image) }}" 
                                             alt="Strategies" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('strategies_image') is-invalid @enderror" 
                                       name="strategies_image" accept="image/*">
                                @error('strategies_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="strategies-container" class="mb-3">
                                @forelse($corprofile->strategies as $strategy)
                                    <div class="strategy-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-red-lt text-red">
                                                <i class="ti ti-arrow-right"></i>
                                            </span>
                                            <input type="text" class="form-control" name="strategies[]" 
                                                   value="{{ $strategy->text }}" placeholder="Strategy text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.strategy-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="strategy-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-red-lt text-red">
                                                <i class="ti ti-arrow-right"></i>
                                            </span>
                                            <input type="text" class="form-control" name="strategies[]" 
                                                   placeholder="Strategy text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.strategy-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="addStrategy()">
                                    <i class="ti ti-plus me-1"></i> Add Strategy
                                </button>
                                <button type="submit" class="btn btn-red">
                                    <i class="ti ti-device-floppy me-1"></i> Save Strategies
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Values Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-heart me-2 text-purple"></i>
                            Values
                        </h3>
                        @if($corprofile->values->count() > 0)
                            <div class="card-actions">
                                <span class="badge bg-purple-lt">
                                    {{ $corprofile->values->count() }} {{ Str::plural('item', $corprofile->values->count()) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.values', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Values Image</label>
                                @if($corprofile->values_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->values_image) }}" 
                                             alt="Values" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('values_image') is-invalid @enderror" 
                                       name="values_image" accept="image/*">
                                @error('values_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="values-container" class="mb-3">
                                @forelse($corprofile->values as $value)
                                    <div class="value-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-purple-lt text-purple">
                                                <i class="ti ti-star"></i>
                                            </span>
                                            <input type="text" class="form-control" name="values[]" 
                                                   value="{{ $value->text }}" placeholder="Value text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.value-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="value-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-purple-lt text-purple">
                                                <i class="ti ti-star"></i>
                                            </span>
                                            <input type="text" class="form-control" name="values[]" 
                                                   placeholder="Value text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.value-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="addValue()">
                                    <i class="ti ti-plus me-1"></i> Add Value
                                </button>
                                <button type="submit" class="btn btn-purple">
                                    <i class="ti ti-device-floppy me-1"></i> Save Values
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Principles Section --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-compass me-2 text-dark"></i>
                            Guiding Principles
                        </h3>
                        @if($corprofile->principles->count() > 0)
                            <div class="card-actions">
                                <span class="badge bg-secondary-lt">
                                    {{ $corprofile->principles->count() }} {{ Str::plural('item', $corprofile->principles->count()) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corprofile.update.principles', $corprofile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="form-label">Principles Image</label>
                                @if($corprofile->principles_image)
                                    <div class="mb-3">
                                        <img src="{{ Storage::url($corprofile->principles_image) }}" 
                                             alt="Principles" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('principles_image') is-invalid @enderror" 
                                       name="principles_image" accept="image/*">
                                @error('principles_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="principles-container" class="mb-3">
                                @forelse($corprofile->principles as $principle)
                                    <div class="principle-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="ti ti-point"></i>
                                            </span>
                                            <input type="text" class="form-control" name="principles[]" 
                                                   value="{{ $principle->text }}" placeholder="Principle text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.principle-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="principle-item mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="ti ti-point"></i>
                                            </span>
                                            <input type="text" class="form-control" name="principles[]" 
                                                   placeholder="Principle text" required>
                                            <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.principle-item'))">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="addPrinciple()">
                                    <i class="ti ti-plus me-1"></i> Add Principle
                                </button>
                                <button type="submit" class="btn btn-dark">
                                    <i class="ti ti-device-floppy me-1"></i> Save Principles
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Quick Navigation --}}
                <div class="card mb-4 sticky-top" style="top: 1rem; z-index: 100;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-list me-2"></i>
                            Quick Navigation
                        </h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-primary-lt text-primary me-3">
                                <i class="ti ti-info-circle"></i>
                            </span>
                            Basic Information
                            @if($corprofile->video || $corprofile->description)
                                <i class="ti ti-check text-success ms-auto"></i>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-green-lt text-green me-3">
                                <i class="ti ti-eye"></i>
                            </span>
                            Vision
                            @if($corprofile->vision_image || $corprofile->vision_text)
                                <i class="ti ti-check text-success ms-auto"></i>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-cyan-lt text-cyan me-3">
                                <i class="ti ti-target"></i>
                            </span>
                            Mission
                            @if($corprofile->mission_image || $corprofile->mission_text)
                                <i class="ti ti-check text-success ms-auto"></i>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-yellow-lt text-yellow me-3">
                                <i class="ti ti-list-check"></i>
                            </span>
                            Objectives
                            @if($corprofile->objectives->count() > 0)
                                <span class="badge bg-yellow-lt ms-auto">{{ $corprofile->objectives->count() }}</span>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-red-lt text-red me-3">
                                <i class="ti ti-chart-arrows"></i>
                            </span>
                            Strategies
                            @if($corprofile->strategies->count() > 0)
                                <span class="badge bg-red-lt ms-auto">{{ $corprofile->strategies->count() }}</span>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-purple-lt text-purple me-3">
                                <i class="ti ti-heart"></i>
                            </span>
                            Values
                            @if($corprofile->values->count() > 0)
                                <span class="badge bg-purple-lt ms-auto">{{ $corprofile->values->count() }}</span>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <span class="avatar avatar-xs bg-dark text-white me-3">
                                <i class="ti ti-compass"></i>
                            </span>
                            Guiding Principles
                            @if($corprofile->principles->count() > 0)
                                <span class="badge bg-secondary-lt ms-auto">{{ $corprofile->principles->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Completion Status --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-chart-pie me-2"></i>
                            Completion Status
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $sections = [
                                'basic' => $corprofile->video || $corprofile->description,
                                'vision' => $corprofile->vision_image || $corprofile->vision_text,
                                'mission' => $corprofile->mission_image || $corprofile->mission_text,
                                'objectives' => $corprofile->objectives->count() > 0,
                                'strategies' => $corprofile->strategies->count() > 0,
                                'values' => $corprofile->values->count() > 0,
                                'principles' => $corprofile->principles->count() > 0,
                            ];
                            $completed = collect($sections)->filter()->count();
                            $total = count($sections);
                            $percentage = round(($completed / $total) * 100);
                        @endphp
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-fill">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $percentage == 100 ? 'success' : ($percentage >= 50 ? 'primary' : 'warning') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            <span class="ms-3 fw-bold">{{ $percentage }}%</span>
                        </div>
                        
                        <div class="text-secondary">
                            {{ $completed }} of {{ $total }} sections completed
                        </div>
                    </div>
                </div>

                {{-- Information Card --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-info-circle me-2"></i>
                            Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Created</div>
                                <div class="datagrid-content">{{ $corprofile->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Last Updated</div>
                                <div class="datagrid-content">{{ $corprofile->updated_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Approval Status</div>
                                <div class="datagrid-content">
                                    <span class="status status-{{ $corprofile->is_approved ? 'green' : 'yellow' }}">
                                        {{ $corprofile->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Publication Status</div>
                                <div class="datagrid-content">
                                    <span class="status status-{{ $corprofile->is_published ? 'blue' : 'secondary' }}">
                                        {{ $corprofile->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let objectiveCount = {{ $corprofile->objectives->count() ?: 1 }};

function addObjective() {
    const container = document.getElementById('objectives-container');
    const count = container.querySelectorAll('.objective-item').length;
    const newObjective = `
        <div class="objective-item card card-body bg-light mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="badge bg-yellow">Objective ${count + 1}</span>
                <button type="button" class="btn btn-icon btn-ghost-danger btn-sm" onclick="removeItem(this.closest('.objective-item'))">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="objectives[${objectiveCount}][title]" placeholder="Objective title" required>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea class="form-control" name="objectives[${objectiveCount}][description]" rows="2" placeholder="Objective description"></textarea>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newObjective);
    objectiveCount++;
}

function addStrategy() {
    const container = document.getElementById('strategies-container');
    const newStrategy = `
        <div class="strategy-item mb-2">
            <div class="input-group">
                <span class="input-group-text bg-red-lt text-red">
                    <i class="ti ti-arrow-right"></i>
                </span>
                <input type="text" class="form-control" name="strategies[]" placeholder="Strategy text" required>
                <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.strategy-item'))">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newStrategy);
}

function addValue() {
    const container = document.getElementById('values-container');
    const newValue = `
        <div class="value-item mb-2">
            <div class="input-group">
                <span class="input-group-text bg-purple-lt text-purple">
                    <i class="ti ti-star"></i>
                </span>
                <input type="text" class="form-control" name="values[]" placeholder="Value text" required>
                <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.value-item'))">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newValue);
}

function addPrinciple() {
    const container = document.getElementById('principles-container');
    const newPrinciple = `
        <div class="principle-item mb-2">
            <div class="input-group">
                <span class="input-group-text bg-dark text-white">
                    <i class="ti ti-point"></i>
                </span>
                <input type="text" class="form-control" name="principles[]" placeholder="Principle text" required>
                <button type="button" class="btn btn-icon btn-outline-danger" onclick="removeItem(this.closest('.principle-item'))">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newPrinciple);
}

function removeItem(element) {
    element.remove();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush