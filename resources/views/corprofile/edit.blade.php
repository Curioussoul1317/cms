@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Corporate Profile</h2>
                <a href="{{ route('corprofile.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




    @if(!$corprofile->is_approved)
<form action="{{ route('approve', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$corprofile->is_published)
<form action="{{ route('publish', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'corprofile-page', 'id' => $corprofile->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif


 

    <!-- Basic Information -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Basic Information</h5>
            @if($corprofile->video || $corprofile->description)
                <span class="badge bg-success">Saved</span>
            @endif




        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.basic', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="video" class="form-label">Video</label>
                    @if($corprofile->video)
                        <div class="mb-2">
                            <video width="300" controls>
                                <source src="{{ Storage::url($corprofile->video) }}" type="video/mp4">
                            </video>
                            <p class="text-muted small">Current video uploaded</p>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('video') is-invalid @enderror" 
                           id="video" name="video" accept="video/*">
                    @error('video')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4">{{ old('description', $corprofile->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Basic Info
                </button>
            </form>
        </div>
    </div>

    <!-- Vision Section -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Vision</h5>
            @if($corprofile->vision_image || $corprofile->vision_text)
                <span class="badge bg-light text-dark">Saved</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.vision', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="vision_image" class="form-label">Vision Image</label>
                    @if($corprofile->vision_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->vision_image) }}" alt="Vision" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('vision_image') is-invalid @enderror" 
                           id="vision_image" name="vision_image" accept="image/*">
                    @error('vision_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="vision_text" class="form-label">Vision Text</label>
                    <textarea class="form-control @error('vision_text') is-invalid @enderror" 
                              id="vision_text" name="vision_text" rows="3">{{ old('vision_text', $corprofile->vision_text) }}</textarea>
                    @error('vision_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Vision
                </button>
            </form>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="card mb-3">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Mission</h5>
            @if($corprofile->mission_image || $corprofile->mission_text)
                <span class="badge bg-light text-dark">Saved</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.mission', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="mission_image" class="form-label">Mission Image</label>
                    @if($corprofile->mission_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->mission_image) }}" alt="Mission" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('mission_image') is-invalid @enderror" 
                           id="mission_image" name="mission_image" accept="image/*">
                    @error('mission_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mission_text" class="form-label">Mission Text</label>
                    <textarea class="form-control @error('mission_text') is-invalid @enderror" 
                              id="mission_text" name="mission_text" rows="3">{{ old('mission_text', $corprofile->mission_text) }}</textarea>
                    @error('mission_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Save Mission
                </button>
            </form>
        </div>
    </div>

    <!-- Objectives Section -->
    <div class="card mb-3"> 
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Objectives</h5>
            @if($corprofile->objectives->count() > 0)
                <span class="badge bg-dark">{{ $corprofile->objectives->count() }} items</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.objectives', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="objectives_image" class="form-label">Objectives Image</label>
                    @if($corprofile->objectives_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->objectives_image) }}" alt="Objectives" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('objectives_image') is-invalid @enderror" 
                           id="objectives_image" name="objectives_image" accept="image/*">
                    @error('objectives_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="objectives-container">
                    @forelse($corprofile->objectives as $index => $objective)
                        <div class="objective-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this.closest('.objective-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="objectives[{{ $index }}][title]" value="{{ $objective->title }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="objectives[{{ $index }}][description]" rows="2">{{ $objective->description }}</textarea>
                            </div>
                        </div>
                    @empty
                        <div class="objective-item mb-3 p-3 border rounded">
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="objectives[0][title]" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="objectives[0][description]" rows="2"></textarea>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addObjective()">
                    <i class="fas fa-plus"></i> Add Objective
                </button>

                <div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Save Objectives
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Strategies Section -->
    <div class="card mb-3">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Strategies</h5>
            @if($corprofile->strategies->count() > 0)
                <span class="badge bg-light text-dark">{{ $corprofile->strategies->count() }} items</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.strategies', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="strategies_image" class="form-label">Strategies Image</label>
                    @if($corprofile->strategies_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->strategies_image) }}" alt="Strategies" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('strategies_image') is-invalid @enderror" 
                           id="strategies_image" name="strategies_image" accept="image/*">
                    @error('strategies_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="strategies-container">
                    @forelse($corprofile->strategies as $strategy)
                        <div class="strategy-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="strategies[]" value="{{ $strategy->text }}" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.strategy-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="strategy-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="strategies[]" placeholder="Strategy text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.strategy-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addStrategy()">
                    <i class="fas fa-plus"></i> Add Strategy
                </button>

                <div>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save"></i> Save Strategies
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Values Section -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Values</h5>
            @if($corprofile->values->count() > 0)
                <span class="badge bg-light text-dark">{{ $corprofile->values->count() }} items</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.values', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="values_image" class="form-label">Values Image</label>
                    @if($corprofile->values_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->values_image) }}" alt="Values" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('values_image') is-invalid @enderror" 
                           id="values_image" name="values_image" accept="image/*">
                    @error('values_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="values-container">
                    @forelse($corprofile->values as $value)
                        <div class="value-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="values[]" value="{{ $value->text }}" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.value-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="value-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="values[]" placeholder="Value text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.value-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addValue()">
                    <i class="fas fa-plus"></i> Add Value
                </button>

                <div>
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-save"></i> Save Values
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Principles Section -->
    <div class="card mb-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Guiding Principles</h5>
            @if($corprofile->principles->count() > 0)
                <span class="badge bg-light text-dark">{{ $corprofile->principles->count() }} items</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('corprofile.update.principles', $corprofile) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="principles_image" class="form-label">Principles Image</label>
                    @if($corprofile->principles_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($corprofile->principles_image) }}" alt="Principles" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('principles_image') is-invalid @enderror" 
                           id="principles_image" name="principles_image" accept="image/*">
                    @error('principles_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="principles-container">
                    @forelse($corprofile->principles as $principle)
                        <div class="principle-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="principles[]" value="{{ $principle->text }}" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.principle-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="principle-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="principles[]" placeholder="Principle text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.principle-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addPrinciple()">
                    <i class="fas fa-plus"></i> Add Principle
                </button>

                <div>
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save"></i> Save Principles
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
let objectiveCount = {{ $corprofile->objectives->count() ?: 1 }};

function addObjective() {
    const container = document.getElementById('objectives-container');
    const newObjective = `
        <div class="objective-item mb-3 p-3 border rounded">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this.closest('.objective-item'))">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-2">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="objectives[${objectiveCount}][title]" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="objectives[${objectiveCount}][description]" rows="2"></textarea>
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
                <input type="text" class="form-control" name="strategies[]" placeholder="Strategy text" required>
                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.strategy-item'))">
                    <i class="fas fa-times"></i>
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
                <input type="text" class="form-control" name="values[]" placeholder="Value text" required>
                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.value-item'))">
                    <i class="fas fa-times"></i>
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
                <input type="text" class="form-control" name="principles[]" placeholder="Principle text" required>
                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.principle-item'))">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newPrinciple);
}

function removeItem(element) {
    element.remove();
}
</script>
@endsection