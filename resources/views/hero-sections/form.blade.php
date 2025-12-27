<div class="row">
    <div class="col-lg-8">
        {{-- Hero Details --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-layout-navbar me-2 text-primary"></i>
                    Hero Details
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label required">Route / Page</label>
                        <select name="route_name" id="route_name" class="form-select @error('route_name') is-invalid @enderror" required>
                            <option value="">Select page...</option>
                            @foreach($availableRoutes as $routeKey => $routeName)
                                @php
                                    [$route, $section] = strpos($routeKey, ':') !== false 
                                        ? explode(':', $routeKey, 2) 
                                        : [$routeKey, null];
                                @endphp
                                <option value="{{ $route }}" 
                                        data-section="{{ $section }}"
                                        {{ old('route_name', $heroSection->route_name ?? '') == $route && old('section', $heroSection->section ?? '') == $section ? 'selected' : '' }}>
                                    {{ $routeName }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="section" id="section" value="{{ old('section', $heroSection->section ?? '') }}">
                        <small class="form-hint">Select the page where this hero section will appear</small>
                        @error('route_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label required">Title</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               placeholder="Enter hero title..."
                               value="{{ old('title', $heroSection->title ?? '') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Subtitle</label>
                        <textarea name="subtitle" 
                                  id="subtitle" 
                                  rows="3" 
                                  class="form-control @error('subtitle') is-invalid @enderror"
                                  placeholder="Enter hero subtitle...">{{ old('subtitle', $heroSection->subtitle ?? '') }}</textarea>
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Button Settings --}}
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-click me-2 text-primary"></i>
                    Button Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Button Text</label>
                        <input type="text" 
                               name="button_text" 
                               id="button_text" 
                               class="form-control @error('button_text') is-invalid @enderror" 
                               placeholder="e.g., Learn More"
                               value="{{ old('button_text', $heroSection->button_text ?? '') }}">
                        <small class="form-hint">Leave empty to hide button</small>
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Button Link</label>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="ti ti-link"></i>
                            </span>
                            <input type="url" 
                                   name="button_link" 
                                   id="button_link" 
                                   class="form-control @error('button_link') is-invalid @enderror" 
                                   placeholder="https://example.com"
                                   value="{{ old('button_link', $heroSection->button_link ?? '') }}">
                        </div>
                        @error('button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Appearance --}}
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-palette me-2 text-primary"></i>
                    Appearance
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Background Color</label>
                        <div class="input-group">
                            <input type="color" 
                                   name="background_color" 
                                   id="background_color" 
                                   class="form-control form-control-color @error('background_color') is-invalid @enderror" 
                                   value="{{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}" 
                                   style="width: 50px;"
                                   required>
                            <input type="text" 
                                   id="background_color_text" 
                                   class="form-control bg-light" 
                                   value="{{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}" 
                                   readonly>
                        </div>
                        @error('background_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hero Image</label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/*"
                               onchange="previewHeroImage(this)">
                        <small class="form-hint">Recommended: 800x600px, max 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(isset($heroSection) && $heroSection->image)
                        <div class="col-12">
                            <label class="form-label">Current Image</label>
                            <div class="p-3 bg-light rounded">
                                <img src="{{ asset('storage/' . $heroSection->image) }}" 
                                     alt="Current Hero Image" 
                                     id="current-hero-image"
                                     class="rounded" 
                                     style="max-width: 300px; max-height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Live Preview --}}
        <div class="card mb-3" style="position: sticky; top: 1rem; z-index: 100;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-eye me-2 text-primary"></i>
                    Live Preview
                </h3>
            </div>
            <div class="card-body p-0">
                <div id="hero-preview" 
                     style="background-color: {{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}; padding: 24px; color: white; min-height: 180px; position: relative; overflow: hidden;">
                    @if(isset($heroSection) && $heroSection->image)
                        <div style="position: absolute; top: 0; right: 0; width: 40%; height: 100%; background-image: url('{{ asset('storage/' . $heroSection->image) }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
                    @endif
                    <div style="position: relative; z-index: 1;">
                        <h4 id="preview-title" class="fw-bold mb-2">{{ old('title', $heroSection->title ?? ' Title Here') }}</h4>
                        <p id="preview-subtitle" class="mb-3 small opacity-90">{{ old('subtitle', $heroSection->subtitle ?? ' subtitle will appear here') }}</p>
                        <button id="preview-button" class="btn btn-warning btn-sm" style="display: {{ old('button_text', $heroSection->button_text ?? '') ? 'inline-block' : 'none' }}">
                            {{ old('button_text', $heroSection->button_text ?? 'Button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', $heroSection->is_active ?? true) ? 'checked' : '' }}>
                    <span class="form-check-label">Active</span>
                </label>
                <small class="form-hint d-block mt-2">
                    Only active hero sections will be displayed on the website.
                </small>
            </div>
        </div>

        {{-- Information (Edit only) --}}
        @if(isset($heroSection))
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
                            <div class="datagrid-content">{{ $heroSection->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Last Updated</div>
                            <div class="datagrid-content">{{ $heroSection->updated_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Approval Status</div>
                            <div class="datagrid-content">
                                <span class="status status-{{ $heroSection->is_approved ? 'green' : 'yellow' }}">
                                    {{ $heroSection->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Publication Status</div>
                            <div class="datagrid-content">
                                <span class="status status-{{ $heroSection->is_published ? 'blue' : 'secondary' }}">
                                    {{ $heroSection->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>
                        {{ isset($heroSection) ? 'Update Hero Section' : 'Create Hero Section' }}
                    </button>
                    <a href="{{ route('hero-sections.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-x me-1"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle route selection with section
    const routeSelect = document.getElementById('route_name');
    const sectionInput = document.getElementById('section');
    
    routeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const section = selectedOption.getAttribute('data-section');
        sectionInput.value = section || '';
    });

    // Live preview updates
    const titleInput = document.getElementById('title');
    const subtitleInput = document.getElementById('subtitle');
    const buttonTextInput = document.getElementById('button_text');
    const backgroundColorInput = document.getElementById('background_color');
    const backgroundColorText = document.getElementById('background_color_text');
    
    const previewTitle = document.getElementById('preview-title');
    const previewSubtitle = document.getElementById('preview-subtitle');
    const previewButton = document.getElementById('preview-button');
    const heroPreview = document.getElementById('hero-preview');

    titleInput?.addEventListener('input', function() {
        previewTitle.textContent = this.value || ' Title Here';
    });

    subtitleInput?.addEventListener('input', function() {
        previewSubtitle.textContent = this.value || ' subtitle will appear here';
    });

    buttonTextInput?.addEventListener('input', function() {
        previewButton.textContent = this.value || 'Button';
        previewButton.style.display = this.value ? 'inline-block' : 'none';
    });

    backgroundColorInput?.addEventListener('input', function() {
        heroPreview.style.backgroundColor = this.value;
        backgroundColorText.value = this.value;
    });
});

function previewHeroImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentImage = document.getElementById('current-hero-image');
            if (currentImage) {
                currentImage.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush