@extends('layouts.app')

@section('title', 'Create Place')

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
                <h2 class="page-title">Create Place</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
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

        <form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
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
                                            <option value="{{ $location->id }}" {{ old('location_id', request('location_id')) == $location->id ? 'selected' : '' }}>
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
                                           value="{{ old('name') }}"
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
                                              placeholder="Full address...">{{ old('address') }}</textarea>
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
                                               value="{{ old('phone_number') }}">
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
                                               value="{{ old('email') }}">
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
                                {{-- Sunday - Thursday --}}
                                <div class="opening-hours-row card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-4">
                                                <label class="form-label">Days</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu'] as $day)
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="hours[0][days][]" value="{{ $day }}" 
                                                                   id="days_0_{{ strtolower($day) }}" checked>
                                                            <span class="form-check-label">{{ $day }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Open</label>
                                                <input type="time" class="form-control open-time" name="hours[0][open]" value="09:00">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Close</label>
                                                <input type="time" class="form-control close-time" name="hours[0][close]" value="16:00">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Closed?</label>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input closed-checkbox" type="checkbox" 
                                                           name="hours[0][closed]" value="1" id="closed_0">
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

                                {{-- Friday (Closed) --}}
                                <div class="opening-hours-row card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-4">
                                                <label class="form-label">Days</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="hours[1][days][]" value="Fri" 
                                                               id="days_1_fri" checked>
                                                        <span class="form-check-label">Fri</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Open</label>
                                                <input type="time" class="form-control open-time" name="hours[1][open]" value="09:00" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Close</label>
                                                <input type="time" class="form-control close-time" name="hours[1][close]" value="16:00" disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Closed?</label>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input closed-checkbox" type="checkbox" 
                                                           name="hours[1][closed]" value="1" id="closed_1" checked>
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

                                {{-- Saturday --}}
                                <div class="opening-hours-row card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-4">
                                                <label class="form-label">Days</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="hours[2][days][]" value="Sat" 
                                                               id="days_2_sat" checked>
                                                        <span class="form-check-label">Sat</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Open</label>
                                                <input type="time" class="form-control open-time" name="hours[2][open]" value="09:00">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Close</label>
                                                <input type="time" class="form-control close-time" name="hours[2][close]" value="16:00">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Closed?</label>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input closed-checkbox" type="checkbox" 
                                                           name="hours[2][closed]" value="1" id="closed_2">
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
                                           value="{{ old('sort_order', 0) }}"
                                           min="0">
                                </div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, this place will be visible on the website.
                            </small>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Create Place
                                </button>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    let hoursIndex = 3;

    // Preview image
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const previewImg = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
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