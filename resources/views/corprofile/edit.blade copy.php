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

    <form action="{{ route('corprofile.update', $corprofile) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                @if($corprofile->video)
                    <div class="mb-3">
                        <label class="form-label">Current Video</label>
                        <div>
                            <video width="320" height="240" controls>
                                <source src="{{ asset('storage/' .$corprofile->video) }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="video" class="form-label">Video {{ $corprofile->video ? '(Upload new to replace)' : '' }}</label>
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
            </div>
        </div>

        <!-- Vision Section -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Vision</h5>
            </div>
            <div class="card-body">
                @if($corprofile->vision_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->vision_image) }}" alt="Vision" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="vision_image" class="form-label">Vision Image {{ $corprofile->vision_image ? '(Upload new to replace)' : '' }}</label>
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
            </div>
        </div>

        <!-- Mission Section -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Mission</h5>
            </div>
            <div class="card-body">
                @if($corprofile->mission_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->mission_image) }}" alt="Mission" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="mission_image" class="form-label">Mission Image {{ $corprofile->mission_image ? '(Upload new to replace)' : '' }}</label>
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
            </div>
        </div>

        <!-- Objectives Section -->
        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Objectives</h5>
            </div>
            <div class="card-body">
                @if($corprofile->objectives_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->objectives_image) }}" alt="Objectives" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="objectives_image" class="form-label">Objectives Image {{ $corprofile->objectives_image ? '(Upload new to replace)' : '' }}</label>
                    <input type="file" class="form-control @error('objectives_image') is-invalid @enderror" 
                           id="objectives_image" name="objectives_image" accept="image/*">
                    @error('objectives_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="objectives-container">
                    @foreach($corprofile->objectives as $index => $objective)
                        <div class="objective-item mb-3 p-3 border rounded">
                            @if($index > 0)
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this.closest('.objective-item'))">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="objectives[{{ $index }}][title]" 
                                       value="{{ old('objectives.'.$index.'.title', $objective->title) }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="objectives[{{ $index }}][description]" 
                                          rows="2">{{ old('objectives.'.$index.'.description', $objective->description) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addObjective()">
                    <i class="fas fa-plus"></i> Add Objective
                </button>
            </div>
        </div>

        <!-- Strategies Section -->
        <div class="card mb-3">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Strategies</h5>
            </div>
            <div class="card-body">
                @if($corprofile->strategies_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->strategies_image) }}" alt="Strategies" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="strategies_image" class="form-label">Strategies Image {{ $corprofile->strategies_image ? '(Upload new to replace)' : '' }}</label>
                    <input type="file" class="form-control @error('strategies_image') is-invalid @enderror" 
                           id="strategies_image" name="strategies_image" accept="image/*">
                    @error('strategies_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="strategies-container">
                    @foreach($corprofile->strategies as $strategy)
                        <div class="strategy-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="strategies[]" 
                                       value="{{ $strategy->text }}" placeholder="Strategy text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.strategy-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addStrategy()">
                    <i class="fas fa-plus"></i> Add Strategy
                </button>
            </div>
        </div>

        <!-- Values Section -->
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Values</h5>
            </div>
            <div class="card-body">
                @if($corprofile->values_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->values_image) }}" alt="Values" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="values_image" class="form-label">Values Image {{ $corprofile->values_image ? '(Upload new to replace)' : '' }}</label>
                    <input type="file" class="form-control @error('values_image') is-invalid @enderror" 
                           id="values_image" name="values_image" accept="image/*">
                    @error('values_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="values-container">
                    @foreach($corprofile->values as $value)
                        <div class="value-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="values[]" 
                                       value="{{ $value->text }}" placeholder="Value text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.value-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addValue()">
                    <i class="fas fa-plus"></i> Add Value
                </button>
            </div>
        </div>

        <!-- Guiding Principles Section -->
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Guiding Principles</h5>
            </div>
            <div class="card-body">
                @if($corprofile->principles_image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' .$corprofile->principles_image) }}" alt="Principles" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="principles_image" class="form-label">Principles Image {{ $corprofile->principles_image ? '(Upload new to replace)' : '' }}</label>
                    <input type="file" class="form-control @error('principles_image') is-invalid @enderror" 
                           id="principles_image" name="principles_image" accept="image/*">
                    @error('principles_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="principles-container">
                    @foreach($corprofile->principles as $principle)
                        <div class="principle-item mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="principles[]" 
                                       value="{{ $principle->text }}" placeholder="Principle text" required>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this.closest('.principle-item'))">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addPrinciple()">
                    <i class="fas fa-plus"></i> Add Principle
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('corprofile.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>

<script>
let objectiveCount = {{ $corprofile->objectives->count() }};

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