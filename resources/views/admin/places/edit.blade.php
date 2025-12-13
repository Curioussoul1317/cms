@extends('layouts.app') 

@section('title', 'Edit Place')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Place</h1>
    <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.places.update', $place) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="location_id" class="form-label">Location <span class="text-danger">*</span></label>
                        <select class="form-select @error('location_id') is-invalid @enderror" 
                                id="location_id" name="location_id" required>
                            <option value="">Select a location</option>
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
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $place->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number', $place->phone_number) }}">
                        @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $place->email) }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="2">{{ old('address', $place->address) }}</textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Opening Hours Section -->
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <strong>Opening Hours</strong>
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
                        <div class="opening-hours-row mb-3 p-3 border rounded bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label">Days</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="hours[{{ $index }}][days][]" value="{{ $day }}" 
                                                   id="days_{{ $index }}_{{ strtolower($day) }}"
                                                   {{ in_array($day, $schedule['days'] ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="days_{{ $index }}_{{ strtolower($day) }}">{{ $day }}</label>
                                        </div>
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
                                    <div class="form-check">
                                        <input class="form-check-input closed-checkbox" type="checkbox" 
                                               name="hours[{{ $index }}][closed]" value="1" 
                                               id="closed_{{ $index }}"
                                               {{ isset($schedule['closed']) && $schedule['closed'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="closed_{{ $index }}">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-hours" style="margin-top: 25px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-hours">
                        <i class="bi bi-plus-lg"></i> Add Schedule
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        @if($place->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($place->image) }}" alt="Current image" style="max-height: 100px;" class="rounded">
                        </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $place->sort_order) }}">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $place->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $place->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Update Place
                </button>
                <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let hoursIndex = {{ count($openingHours) }};

    // Add new schedule row
    document.getElementById('add-hours').addEventListener('click', function() {
        const container = document.getElementById('opening-hours-container');
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        
        let daysHtml = '';
        days.forEach(day => {
            daysHtml += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="hours[${hoursIndex}][days][]" value="${day}" 
                           id="days_${hoursIndex}_${day.toLowerCase()}">
                    <label class="form-check-label" for="days_${hoursIndex}_${day.toLowerCase()}">${day}</label>
                </div>
            `;
        });

        const newRow = document.createElement('div');
        newRow.className = 'opening-hours-row mb-3 p-3 border rounded bg-white';
        newRow.innerHTML = `
            <div class="row align-items-center">
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
                    <div class="form-check">
                        <input class="form-check-input closed-checkbox" type="checkbox" 
                               name="hours[${hoursIndex}][closed]" value="1" id="closed_${hoursIndex}">
                        <label class="form-check-label" for="closed_${hoursIndex}">Yes</label>
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-hours" style="margin-top: 25px;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(newRow);
        hoursIndex++;

        // Add event listener to new closed checkbox
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
        
        if (checkbox.checked) {
            openTime.disabled = true;
            closeTime.disabled = true;
        } else {
            openTime.disabled = false;
            closeTime.disabled = false;
        }
    }

    // Initialize existing checkboxes
    document.querySelectorAll('.closed-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleTimeInputs(this);
        });
    });
</script>
@endpush