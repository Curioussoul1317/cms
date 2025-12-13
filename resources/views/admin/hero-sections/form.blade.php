<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="route_name" class="form-label">Route / Page <span class="text-danger">*</span></label>
                    <select name="route_name" id="route_name" class="form-select @error('route_name') is-invalid @enderror" required>
                        <option value="">Select Route</option>
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
                    @error('route_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Select the page where this hero section will appear</small>
                </div>

                <input type="hidden" name="section" id="section" value="{{ old('section', $heroSection->section ?? '') }}">

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $heroSection->title ?? '') }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <textarea name="subtitle" 
                              id="subtitle" 
                              rows="3" 
                              class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $heroSection->subtitle ?? '') }}</textarea>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   name="button_text" 
                                   id="button_text" 
                                   class="form-control @error('button_text') is-invalid @enderror" 
                                   value="{{ old('button_text', $heroSection->button_text ?? '') }}">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="button_link" class="form-label">Button Link</label>
                            <input type="url" 
                                   name="button_link" 
                                   id="button_link" 
                                   class="form-control @error('button_link') is-invalid @enderror" 
                                   value="{{ old('button_link', $heroSection->button_link ?? '') }}" 
                                   placeholder="https://example.com">
                            @error('button_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="background_color" class="form-label">Background Color <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="color" 
                               name="background_color" 
                               id="background_color" 
                               class="form-control form-control-color @error('background_color') is-invalid @enderror" 
                               value="{{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}" 
                               required>
                        <input type="text" 
                               id="background_color_text" 
                               class="form-control" 
                               value="{{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}" 
                               readonly>
                    </div>
                    @error('background_color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hero Image</label>
                    <input type="file" 
                           name="image" 
                           id="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Recommended size: 800x600px. Max 2MB.</small>
                </div>

                @if(isset($heroSection) && $heroSection->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' . $heroSection->image) }}" 
                                 alt="Current Hero Image" 
                                 class="img-thumbnail" 
                                 style="max-width: 300px;">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', $heroSection->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <small class="form-text text-muted">Only active hero sections will be displayed on the website</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div id="hero-preview" 
                     style="background-color: {{ old('background_color', $heroSection->background_color ?? '#4DD0E1') }}; padding: 20px; border-radius: 8px; color: white; min-height: 200px;">
                    <h6 id="preview-title" class="fw-bold mb-2">{{ old('title', $heroSection->title ?? 'Your Title Here') }}</h6>
                    <p id="preview-subtitle" class="mb-2 small">{{ old('subtitle', $heroSection->subtitle ?? 'Your subtitle will appear here') }}</p>
                    <button id="preview-button" class="btn btn-warning btn-sm" style="display: {{ old('button_text', $heroSection->button_text ?? '') ? 'inline-block' : 'none' }}">
                        {{ old('button_text', $heroSection->button_text ?? 'Button') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="ti ti-device-floppy"></i> Save Hero Section
                </button>
                <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary w-100">
                    <i class="ti ti-x"></i> Cancel
                </a>
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
        previewTitle.textContent = this.value || 'Your Title Here';
    });

    subtitleInput?.addEventListener('input', function() {
        previewSubtitle.textContent = this.value || 'Your subtitle will appear here';
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
</script>
@endpush