@extends('layouts.app')

@section('title', 'Add Content Block - ' . $model->name)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('page-contents.index', ['type' => $type, 'id' => $model->id]) }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Content Blocks
                    </a>
                </div>
                <h2 class="page-title">Add Content Block</h2>
                <div class="text-secondary mt-1">
                    Page: <strong>{{ $model->name }}</strong>
                </div>
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

        @if($template)
            {{-- Template Form --}}
            <form action="{{ route('page-contents.store', ['type' => $type, 'id' => $model->id]) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="template" value="{{ $templateName }}">

                <div class="row">
                    <div class="col-lg-8">
                        {{-- Selected Template Info --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if(isset($template['icon']) && str_starts_with($template['icon'], 'ti ti-'))
                                            <span class="avatar avatar-lg bg-primary-lt text-primary">
                                                <i class="{{ $template['icon'] }}" style="font-size: 1.5rem;"></i>
                                            </span>
                                        @else
                                            <span class="avatar avatar-lg bg-primary-lt">
                                                {{ $template['icon'] ?? '📄' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-fill">
                                        <div class="fw-medium">{{ $template['name'] }}</div>
                                        @if(isset($template['description']))
                                            <div class="text-secondary small">{{ $template['description'] }}</div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-arrows-exchange me-1"></i>
                                            Change Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Template Fields --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-forms me-2 text-primary"></i>
                                    Template Fields
                                </h3>
                            </div>
                            <div class="card-body">
                                @foreach($template['fields'] as $field)
                                    <div class="mb-3">
                                        <label class="form-label {{ ($field['required'] ?? false) ? 'required' : '' }}">
                                            {{ $field['label'] }}
                                        </label>

                                        @if($field['type'] === 'file')
                                            {{-- File Upload Field --}}
                                            <input type="file" 
                                                   name="{{ $field['name'] }}" 
                                                   class="form-control @error($field['name']) is-invalid @enderror"
                                                   @if(!empty($field['accept'])) accept="{{ $field['accept'] }}" @endif
                                                   {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @if(!empty($field['accept']))
                                                <small class="form-hint">Accepted formats: {{ $field['accept'] }}</small>
                                            @endif
                                            @error($field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        @elseif($field['type'] === 'repeater')
                                            {{-- Repeater Field --}}
                                            <div class="card bg-light">
                                                <div class="card-header">
                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                        <span class="fw-medium">
                                                            <i class="ti ti-list me-1"></i>
                                                            {{ $field['label'] }} Items
                                                        </span>
                                                        <button type="button" 
                                                                onclick="addRepeaterItem('{{ $field['name'] }}', {{ json_encode($field['fields']) }})" 
                                                                class="btn btn-primary btn-sm">
                                                            <i class="ti ti-plus me-1"></i>
                                                            Add Item
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div id="repeater_{{ $field['name'] }}" class="vstack gap-3">
                                                        {{-- Items will be added here by JavaScript --}}
                                                    </div>
                                                    <div class="text-center text-secondary py-3" id="empty_{{ $field['name'] }}">
                                                        <i class="ti ti-inbox me-1"></i>
                                                        No items yet. Click "Add Item" to add one.
                                                    </div>
                                                </div>
                                            </div>

                                        @elseif($field['type'] === 'textarea')
                                            {{-- Textarea Field --}}
                                            <textarea name="data[{{ $field['name'] }}]" 
                                                      rows="4"
                                                      class="form-control @error('data.' . $field['name']) is-invalid @enderror"
                                                      placeholder="Enter {{ strtolower($field['label']) }}..."
                                                      {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('data.' . $field['name']) }}</textarea>
                                            @error('data.' . $field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        @elseif($field['type'] === 'select')
                                            {{-- Select Field --}}
                                            <select name="data[{{ $field['name'] }}]"
                                                    class="form-select @error('data.' . $field['name']) is-invalid @enderror"
                                                    {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                <option value="">Select {{ $field['label'] }}...</option>
                                                @foreach($field['options'] ?? [] as $value => $label)
                                                    <option value="{{ $value }}" {{ old('data.' . $field['name']) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('data.' . $field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        @elseif($field['type'] === 'color')
                                            {{-- Color Picker --}}
                                            <div class="input-group">
                                                <input type="color" 
                                                       name="data[{{ $field['name'] }}]"
                                                       value="{{ old('data.' . $field['name'], '#000000') }}"
                                                       class="form-control form-control-color @error('data.' . $field['name']) is-invalid @enderror"
                                                       {{ ($field['required'] ?? false) ? 'required' : '' }}
                                                       style="width: 60px;">
                                                <input type="text" 
                                                       class="form-control bg-light" 
                                                       value="{{ old('data.' . $field['name'], '#000000') }}" 
                                                       readonly>
                                            </div>
                                            @error('data.' . $field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        @else
                                            {{-- Regular Input Field --}}
                                            <input type="{{ $field['type'] }}" 
                                                   name="data[{{ $field['name'] }}]"
                                                   value="{{ old('data.' . $field['name']) }}"
                                                   class="form-control @error('data.' . $field['name']) is-invalid @enderror"
                                                   placeholder="Enter {{ strtolower($field['label']) }}..."
                                                   {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @error('data.' . $field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
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
                                    <div class="me-2">
                                        <span class="badge bg-primary-lt text-primary">1</span>
                                    </div>
                                    <div class="small text-secondary">
                                        Fill in all required fields marked with a red asterisk.
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-2">
                                        <span class="badge bg-primary-lt text-primary">2</span>
                                    </div>
                                    <div class="small text-secondary">
                                        For repeater fields, add as many items as needed.
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-primary-lt text-primary">3</span>
                                    </div>
                                    <div class="small text-secondary">
                                        Content blocks can be reordered after creation.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i>
                                        Add Content Block
                                    </button>
                                    <a href="{{ route('page-contents.index', ['type' => $type, 'id' => $model->id]) }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="ti ti-x me-1"></i>
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            {{-- Template Selection Grid --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-template me-2 text-primary"></i>
                        Select a Template
                    </h3>
                    <div class="card-actions">
                        <span class="badge bg-primary-lt">{{ count($templates) }} templates available</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($templates as $key => $tmpl)
                            <div class="col">
                                <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id, 'template' => $key]) }}" 
                                   class="card card-link card-link-pop h-100 text-decoration-none">
                                    <div class="card-body text-center py-4">
                                        <div class="mb-3">
                                            @if(isset($tmpl['icon']) && str_starts_with($tmpl['icon'], 'ti ti-'))
                                                <span class="avatar avatar-xl bg-primary-lt text-primary">
                                                    <i class="{{ $tmpl['icon'] }}" style="font-size: 2rem;"></i>
                                                </span>
                                            @else
                                                <span class="avatar avatar-xl bg-primary-lt" style="font-size: 2rem;">
                                                    {{ $tmpl['icon'] ?? '📄' }}
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="card-title mb-2">{{ $tmpl['name'] }}</h4>
                                        @if(isset($tmpl['description']))
                                            <p class="text-secondary small mb-0">{{ $tmpl['description'] }}</p>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-transparent text-center py-2">
                                        <span class="text-primary small fw-medium">
                                            <i class="ti ti-plus me-1"></i>
                                            Select Template
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@if($template)
@push('scripts')
<script>
    let repeaterCounters = {};

    function addRepeaterItem(repeaterName, fields) {
        // Hide empty state
        const emptyState = document.getElementById('empty_' + repeaterName);
        if (emptyState) {
            emptyState.style.display = 'none';
        }

        if (!repeaterCounters[repeaterName]) {
            repeaterCounters[repeaterName] = 0;
        }
        
        const container = document.getElementById('repeater_' + repeaterName);
        const index = repeaterCounters[repeaterName]++;
        
        let fieldsHtml = '';
        fields.forEach(field => {
            const required = field.required ? 'required' : '';
            const requiredBadge = field.required ? '<span class="text-danger">*</span>' : '';
            const inputName = `data[${repeaterName}][${index}][${field.name}]`;
            
            if (field.type === 'repeater') {
                // Nested repeater support
                const nestedRepeaterName = `${repeaterName}_${index}_${field.name}`;
                fieldsHtml += `
                    <div class="card bg-white mb-3">
                        <div class="card-header py-2">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <span class="fw-medium small">
                                    <i class="ti ti-list me-1"></i>
                                    ${field.label}
                                </span>
                                <button type="button" 
                                        onclick="addNestedRepeaterItem('${repeaterName}', ${index}, '${field.name}', ${JSON.stringify(field.fields).replace(/"/g, '&quot;')})" 
                                        class="btn btn-success btn-sm">
                                    <i class="ti ti-plus me-1"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="repeater_${nestedRepeaterName}" class="vstack gap-2">
                                <!-- Nested items will be added here -->
                            </div>
                            <div class="text-center text-secondary py-2 small" id="empty_${nestedRepeaterName}">
                                <i class="ti ti-inbox me-1"></i>
                                No items yet
                            </div>
                        </div>
                    </div>
                `;
            } else if (field.type === 'textarea') {
                fieldsHtml += `
                    <div class="mb-3">
                        <label class="form-label">
                            ${field.label} ${requiredBadge}
                        </label>
                        <textarea name="${inputName}" rows="3"
                                  class="form-control"
                                  placeholder="Enter ${field.label.toLowerCase()}..."
                                  ${required}></textarea>
                    </div>
                `;
            } else if (field.type === 'file') {
                fieldsHtml += `
                    <div class="mb-3">
                        <label class="form-label">
                            ${field.label} ${requiredBadge}
                        </label>
                        <input type="file" 
                               name="${inputName}"
                               class="form-control"
                               ${field.accept ? `accept="${field.accept}"` : ''}
                               ${required}>
                    </div>
                `;
            } else {
                fieldsHtml += `
                    <div class="mb-3">
                        <label class="form-label">
                            ${field.label} ${requiredBadge}
                        </label>
                        <input type="${field.type}" 
                               name="${inputName}"
                               class="form-control"
                               placeholder="Enter ${field.label.toLowerCase()}..."
                               ${required}>
                    </div>
                `;
            }
        });
        
        const itemHtml = `
            <div class="card position-relative repeater-item">
                <div class="card-header py-2 bg-white">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <span class="text-secondary small">
                            <i class="ti ti-grip-vertical me-1"></i>
                            Item #${index + 1}
                        </span>
                        <button type="button" 
                                onclick="removeRepeaterItem(this, '${repeaterName}')" 
                                class="btn btn-icon btn-ghost-danger btn-sm">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    ${fieldsHtml}
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', itemHtml);
    }

    function removeRepeaterItem(button, repeaterName) {
        const item = button.closest('.repeater-item');
        const container = document.getElementById('repeater_' + repeaterName);
        
        item.remove();
        
        // Show empty state if no items left
        if (container.children.length === 0) {
            const emptyState = document.getElementById('empty_' + repeaterName);
            if (emptyState) {
                emptyState.style.display = 'block';
            }
        }
    }

    // Function for nested repeaters
    let nestedCounters = {};

    function addNestedRepeaterItem(parentName, parentIndex, fieldName, fields) {
        const counterKey = `${parentName}_${parentIndex}_${fieldName}`;
        
        // Hide empty state
        const emptyState = document.getElementById('empty_' + counterKey);
        if (emptyState) {
            emptyState.style.display = 'none';
        }

        if (!nestedCounters[counterKey]) {
            nestedCounters[counterKey] = 0;
        }
        
        const container = document.getElementById(`repeater_${counterKey}`);
        const index = nestedCounters[counterKey]++;
        
        let fieldsHtml = '';
        fields.forEach(field => {
            const required = field.required ? 'required' : '';
            const requiredBadge = field.required ? '<span class="text-danger">*</span>' : '';
            const inputName = `data[${parentName}][${parentIndex}][${fieldName}][${index}][${field.name}]`;
            
            if (field.type === 'textarea') {
                fieldsHtml += `
                    <div class="mb-2">
                        <label class="form-label form-label-sm">
                            ${field.label} ${requiredBadge}
                        </label>
                        <textarea name="${inputName}" rows="2"
                                  class="form-control form-control-sm"
                                  placeholder="Enter ${field.label.toLowerCase()}..."
                                  ${required}></textarea>
                    </div>
                `;
            } else {
                fieldsHtml += `
                    <div class="mb-2">
                        <label class="form-label form-label-sm">
                            ${field.label} ${requiredBadge}
                        </label>
                        <input type="${field.type}" 
                               name="${inputName}"
                               class="form-control form-control-sm"
                               placeholder="Enter ${field.label.toLowerCase()}..."
                               ${required}>
                    </div>
                `;
            }
        });
        
        const itemHtml = `
            <div class="card card-sm position-relative nested-item bg-light">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-secondary small">Sub-item #${index + 1}</span>
                        <button type="button" 
                                onclick="removeNestedItem(this, '${counterKey}')" 
                                class="btn btn-icon btn-ghost-danger btn-sm">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    ${fieldsHtml}
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', itemHtml);
    }

    function removeNestedItem(button, counterKey) {
        const item = button.closest('.nested-item');
        const container = document.getElementById('repeater_' + counterKey);
        
        item.remove();
        
        // Show empty state if no items left
        if (container.children.length === 0) {
            const emptyState = document.getElementById('empty_' + counterKey);
            if (emptyState) {
                emptyState.style.display = 'block';
            }
        }
    }
</script>
@endpush
@endif