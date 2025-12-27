@extends('layouts.app')

@section('title', 'Edit Place')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('places.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Places
                    </a>
                </div>
                <h2 class="page-title">Edit Place</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- Status Badges --}}
                    <span class="badge {{ $place->is_approved ? 'bg-green-lt' : 'bg-yellow-lt' }} fs-6">
                        <i class="ti ti-{{ $place->is_approved ? 'check' : 'clock' }} me-1"></i>
                        {{ $place->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                    <span class="badge {{ $place->is_published ? 'bg-blue-lt' : 'bg-secondary-lt' }} fs-6">
                        <i class="ti ti-{{ $place->is_published ? 'world' : 'world-off' }} me-1"></i>
                        {{ $place->is_published ? 'Published' : 'Draft' }}
                    </span>
                    @if($place->is_active)
                        <span class="badge bg-green-lt fs-6">
                            <i class="ti ti-eye me-1"></i>
                            Active
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

        {{-- Publishing Controls Card --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-1">
                            <i class="ti ti-settings me-2 text-primary"></i>
                            Publishing Controls
                        </h3>
                        <p class="text-secondary mb-0">Manage approval and publishing status for this place.</p>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            {{-- Approval Logic: Only show if NOT published --}}
                            @if(!$place->is_published)
                                @if(!$place->is_approved)
                                    <form action="{{ route('approve', ['model' => 'place', 'id' => $place->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unapprove', ['model' => 'place', 'id' => $place->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="ti ti-x me-1"></i> Unapprove
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Publish Logic: Only show if approved --}}
                            @if($place->is_approved)
                                @if(!$place->is_published)
                                    <form action="{{ route('publish', ['model' => 'place', 'id' => $place->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-upload me-1"></i> Publish
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('unpublish', ['model' => 'place', 'id' => $place->id]) }}" method="POST" class="d-inline">
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
                @if(!$place->is_approved)
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle me-2"></i></div>
                            <div>This place needs to be <strong>approved</strong> before it can be published.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('places.update', $place) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    {{-- Basic Details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-building me-2 text-primary"></i>
                                Place Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Location</label>
                                    <select name="location_id" class="form-select @error('location_id') is-invalid @enderror" required>
                                        <option value="">Select a location...</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id', $place->location_id) == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter place name..."
                                           value="{{ old('name', $place->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" 
                                              class="form-control @error('address') is-invalid @enderror" 
                                              rows="2"
                                              placeholder="Full address...">{{ old('address', $place->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> 
                            </div>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-address-book me-2 text-primary"></i>
                                Contact Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-phone"></i>
                                        </span>
                                        <input type="text" 
                                               name="phone_number" 
                                               class="form-control @error('phone_number') is-invalid @enderror" 
                                               placeholder="+960 XXX XXXX"
                                               value="{{ old('phone_number', $place->phone_number) }}">
                                    </div>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="contact@example.com"
                                               value="{{ old('email', $place->email) }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Opening Hours --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-clock me-2 text-primary"></i>
                                Opening Hours
                            </h3>
                            <div class="card-actions">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-hours">
                                    <i class="ti ti-plus me-1"></i>
                                    Add Schedule
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="opening-hours-container">
                                @php
                                    $openingHours = old('hours', $place->opening_hours ?? []);
                                    if (empty($openingHours)) {
                                        $openingHours = [
                                            ['days' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu'], 'open' => '09:00', 'close' => '16:00'],
                                            ['days' => ['Fri'], 'closed' => true],
                                            ['days' => ['Sat'], 'open' => '09:00', 'close' => '16:00'],
                                        ];
                                    }
                                @endphp

                                @foreach($openingHours as $index => $schedule)
                                    <div class="opening-hours-row card bg-light mb-3">
                                        <div class="card-body">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-4">
                                                    <label class="form-label">Days</label>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                                            <label class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" 
                                                                       name="hours[{{ $index }}][days][]" value="{{ $day }}" 
                                                                       id="days_{{ $index }}_{{ strtolower($day) }}"
                                                                       {{ in_array($day, $schedule['days'] ?? []) ? 'checked' : '' }}>
                                                                <span class="form-check-label">{{ $day }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Open</label>
                                                    <input type="time" class="form-control open-time" 
                                                           name="hours[{{ $index }}][open]" 
                                                           value="{{ $schedule['open'] ?? '09:00' }}"
                                                           {{ isset($schedule['closed']) && $schedule['closed'] ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Close</label>
                                                    <input type="time" class="form-control close-time" 
                                                           name="hours[{{ $index }}][close]" 
                                                           value="{{ $schedule['close'] ?? '17:00' }}"
                                                           {{ isset($schedule['closed']) && $schedule['closed'] ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Closed?</label>
                                                    <label class="form-check form-switch">
                                                        <input class="form-check-input closed-checkbox" type="checkbox" 
                                                               name="hours[{{ $index }}][closed]" value="1" 
                                                               id="closed_{{ $index }}"
                                                               {{ isset($schedule['closed']) && $schedule['closed'] ? 'checked' : '' }}>
                                                        <span class="form-check-label">Yes</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                                    <button type="button" class="btn btn-icon btn-outline-danger btn-sm remove-hours">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4"> 

                    {{-- Settings --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-settings me-2 text-primary"></i>
                                Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-sort-ascending-numbers"></i>
                                    </span>
                                    <input type="number" 
                                           name="sort_order" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', $place->sort_order) }}"
                                           min="0">
                                </div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $place->is_active) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, this place will be visible on the website.
                            </small>
                        </div>
                    </div>

                    {{-- Information --}}
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
                                    <div class="datagrid-content">{{ $place->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Updated</div>
                                    <div class="datagrid-content">{{ $place->updated_at->format('d M Y, h:i A') }}</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Approval Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $place->is_approved ? 'green' : 'yellow' }}">
                                            {{ $place->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Publication Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-{{ $place->is_published ? 'blue' : 'secondary' }}">
                                            {{ $place->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Place
                                </button>
                                <a href="{{ route('places.show', $place) }}" class="btn btn-outline-primary">
                                    <i class="ti ti-eye me-1"></i>
                                    View Place
                                </a>
                                <a href="{{ route('places.index') }}" class="btn btn-outline-secondary">
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
                            Once deleted, this place cannot be recovered.
                        </p>
                        <form action="{{ route('places.destroy', $place) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this place? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i>
                                Delete Place
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let hoursIndex = {{ count($openingHours) }};

    // Preview image
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const previewImg = preview.querySelector('img');
        const currentImage = document.getElementById('current-image');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
                if (currentImage) {
                    currentImage.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    // Add new schedule row
    document.getElementById('add-hours').addEventListener('click', function() {
        const container = document.getElementById('opening-hours-container');
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        
        let daysHtml = '';
        days.forEach(day => {
            daysHtml += `
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" 
                           name="hours[${hoursIndex}][days][]" value="${day}" 
                           id="days_${hoursIndex}_${day.toLowerCase()}">
                    <span class="form-check-label">${day}</span>
                </label>
            `;
        });

        const newRow = document.createElement('div');
        newRow.className = 'opening-hours-row card bg-light mb-3';
        newRow.innerHTML = `
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label">Days</label>
                        <div class="d-flex flex-wrap gap-2">
                            ${daysHtml}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Open</label>
                        <input type="time" class="form-control open-time" name="hours[${hoursIndex}][open]" value="09:00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Close</label>
                        <input type="time" class="form-control close-time" name="hours[${hoursIndex}][close]" value="17:00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Closed?</label>
                        <label class="form-check form-switch">
                            <input class="form-check-input closed-checkbox" type="checkbox" 
                                   name="hours[${hoursIndex}][closed]" value="1" id="closed_${hoursIndex}">
                            <span class="form-check-label">Yes</span>
                        </label>
                    </div>
                    <div class="col-md-2 text-end">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-icon btn-outline-danger btn-sm remove-hours">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(newRow);
        hoursIndex++;

        newRow.querySelector('.closed-checkbox').addEventListener('change', function() {
            toggleTimeInputs(this);
        });
    });

    // Remove schedule row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-hours')) {
            const row = e.target.closest('.opening-hours-row');
            if (document.querySelectorAll('.opening-hours-row').length > 1) {
                row.remove();
            } else {
                alert('You must have at least one schedule');
            }
        }
    });

    // Toggle time inputs when closed checkbox changes
    function toggleTimeInputs(checkbox) {
        const row = checkbox.closest('.opening-hours-row');
        const openTime = row.querySelector('.open-time');
        const closeTime = row.querySelector('.close-time');
        
        openTime.disabled = checkbox.checked;
        closeTime.disabled = checkbox.checked;
    }

    // Initialize existing checkboxes
    document.querySelectorAll('.closed-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleTimeInputs(this);
        });
    });
</script>
@endpush