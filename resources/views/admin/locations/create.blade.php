@extends('layouts.app')

@section('title', 'Create Location')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('admin.locations.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Locations
                    </a>
                </div>
                <h2 class="page-title">Create Location</h2>
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

        <form action="{{ route('admin.locations.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    {{-- Basic Details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-map-pin me-2 text-primary"></i>
                                Location Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Name</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter location name..."
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Slug</label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug"
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           placeholder="Auto-generated if empty"
                                           value="{{ old('slug') }}">
                                    <small class="form-hint">Leave empty to auto-generate from name</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="3"
                                              placeholder="Brief description of this location...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map Selector --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-map me-2 text-primary"></i>
                                Map Region
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Map ID</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-map-2"></i>
                                        </span>
                                        <input type="text" 
                                               name="map_id" 
                                               id="map_id"
                                               class="form-control bg-light @error('map_id') is-invalid @enderror" 
                                               placeholder="Click on map to select region"
                                               value="{{ old('map_id') }}"
                                               readonly>
                                    </div>
                                    <small class="form-hint">Click on the map below to select a region</small>
                                    @error('map_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Color</label>
                                    <div class="input-group">
                                        <input type="color" 
                                               name="color" 
                                               id="color"
                                               class="form-control form-control-color @error('color') is-invalid @enderror" 
                                               value="{{ old('color', '#1CEAB9') }}"
                                               style="width: 50px;">
                                        <input type="text" 
                                               id="color_text" 
                                               class="form-control bg-light" 
                                               value="{{ old('color', '#1CEAB9') }}" 
                                               readonly>
                                    </div>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
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
                            </div>

                            {{-- Interactive Map --}}
                            <div class="map-selector-container mt-4">
                                <div class="selected-region-info" id="selectedRegionInfo">
                                    <i class="ti ti-info-circle me-2"></i> No region selected - click on the map below
                                </div>
                                <div class="map-wrapper">
                                    @include('admin.locations.partials.map-svg')
                                </div>
                                
                                {{-- Region Legend --}}
                                <div class="map-legend">
                                    <div class="legend-item" data-region="north-region">
                                        <span class="legend-color" style="background: #9ff291;"></span>
                                        <span>North Region</span>
                                    </div>
                                    <div class="legend-item" data-region="greater-male">
                                        <span class="legend-color" style="background: #9ff291;"></span>
                                        <span>Greater Male'</span>
                                    </div>
                                    <div class="legend-item" data-region="south-region">
                                        <span class="legend-color" style="background: rgba(28,234,185,0.5);"></span>
                                        <span>South Region</span>
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
                            <label class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="form-check-label">Active</span>
                            </label>
                            <small class="form-hint d-block mt-2">
                                When active, this location will be available for selection.
                            </small>
                        </div>
                    </div>

                    {{-- Tips --}}
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
                                    <span class="avatar avatar-sm bg-cyan-lt text-cyan">
                                        <i class="ti ti-map"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Map Regions</h4>
                                    <p class="text-secondary small mb-0">Click on the interactive map to associate this location with a map region.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <span class="avatar avatar-sm bg-purple-lt text-purple">
                                        <i class="ti ti-building"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Places</h4>
                                    <p class="text-secondary small mb-0">Add places to this location after creating it.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Create Location
                                </button>
                                <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
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

<style>
    .map-selector-container {
        background: var(--tblr-bg-surface-secondary);
        border: 2px dashed var(--tblr-border-color);
        border-radius: 8px;
        padding: 24px;
        text-align: center;
    }

    .selected-region-info {
        background: var(--tblr-bg-surface);
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.875rem;
        color: var(--tblr-secondary);
        border: 1px solid var(--tblr-border-color);
    }

    .selected-region-info.selected {
        background: rgba(var(--tblr-success-rgb), 0.1);
        color: var(--tblr-success);
        border-color: var(--tblr-success);
        font-weight: 500;
    }

    .map-wrapper {
        display: inline-block;
        max-height: 500px;
        overflow: hidden;
    }

    .map-wrapper svg {
        max-height: 480px;
        width: auto;
    }

    .map-region-selectable {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .map-region-selectable:hover path {
        fill: #1CEAB9 !important;
        filter: drop-shadow(0 0 8px rgba(28, 234, 185, 0.6));
    }

    .map-region-selectable.selected path {
        fill: #1CEAB9 !important;
        stroke: #0d9488 !important;
        stroke-width: 2 !important;
        filter: drop-shadow(0 0 12px rgba(28, 234, 185, 0.8));
    }

    .map-legend {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--tblr-secondary);
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s;
        border: 1px solid transparent;
    }

    .legend-item:hover {
        background: var(--tblr-bg-surface);
        border-color: var(--tblr-border-color);
    }

    .legend-item.selected {
        background: rgba(var(--tblr-success-rgb), 0.1);
        border-color: var(--tblr-success);
        font-weight: 500;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1px solid rgba(0,0,0,0.1);
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapIdInput = document.getElementById('map_id');
        const selectedInfo = document.getElementById('selectedRegionInfo');
        const regions = document.querySelectorAll('.map-region-selectable');
        const legendItems = document.querySelectorAll('.legend-item');
        const colorInput = document.getElementById('color');
        const colorText = document.getElementById('color_text');

        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });

        // Color picker sync
        colorInput?.addEventListener('input', function() {
            colorText.value = this.value;
        });

        // Function to select a region
        function selectRegion(regionId, regionName) {
            mapIdInput.value = regionId;

            selectedInfo.innerHTML = `<i class="ti ti-check me-2"></i> Selected: <strong>${regionName}</strong> (${regionId})`;
            selectedInfo.classList.add('selected');

            regions.forEach(r => r.classList.remove('selected'));
            document.querySelectorAll(`.map-region-selectable[data-region-id="${regionId}"]`).forEach(r => {
                r.classList.add('selected');
            });

            legendItems.forEach(item => {
                item.classList.toggle('selected', item.dataset.region === regionId);
            });
        }

        // Handle region click
        regions.forEach(region => {
            region.addEventListener('click', function() {
                selectRegion(this.dataset.regionId, this.dataset.regionName);
            });
        });

        // Handle legend click
        legendItems.forEach(item => {
            item.addEventListener('click', function() {
                const regionId = this.dataset.region;
                const regionElement = document.querySelector(`.map-region-selectable[data-region-id="${regionId}"]`);
                if (regionElement) {
                    selectRegion(regionId, regionElement.dataset.regionName);
                }
            });
        });

        // If there's an old value, select it
        const oldValue = '{{ old('map_id') }}';
        if (oldValue) {
            const existingRegion = document.querySelector(`.map-region-selectable[data-region-id="${oldValue}"]`);
            if (existingRegion) {
                selectRegion(oldValue, existingRegion.dataset.regionName);
            }
        }
    });
</script>
@endpush