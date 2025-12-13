@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Edit Content</h2>
                        <div class="text-muted mt-1">
                            Page: <span class="fw-semibold">{{ $model->name }}</span> | 
                            Template: <span class="fw-semibold">{{ $template['name'] ?? $pageContent->template_name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card">
                <div class="card-body">
                    {{-- Show selected template info --}}
                    <div class="alert alert-info mb-4" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Editing Template: {{ $template['name'] ?? $pageContent->template_name }}</div>
                                <div class="h4 mb-0 mt-1">
                                    <i class="{{ $template['icon'] ?? 'ti ti-file' }}" style="font-size: 3rem;"></i>    
                                </div>
                            </div>
                            <a href="{{ route('page-contents.index', ['type' => $type, 'id' => $model->id]) }}" class="btn btn-sm btn-primary">
                                Back to Contents
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('page-contents.update', ['type' => $type, 'id' => $model->id, 'pageContent' => $pageContent->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Template Fields --}}
                        <div class="border-top pt-4">
                            <h3 class="card-title mb-4">Template Fields</h3>

                            @foreach($template['fields'] as $field)
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $field['label'] }}
                                        @if($field['required'] ?? false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if($field['type'] === 'file')
                                        {{-- File Upload Field --}}
                                        
                                        {{-- Show current file if exists --}}
                                        @if(!empty($pageContent->data[$field['name']]))
                                            <div class="alert alert-light border mb-3" role="alert">
                                                <div class="d-flex align-items-start gap-3">
                                                    @if(str_contains($field['accept'] ?? '', 'image'))
                                                        {{-- Show image preview --}}
                                                        <img src="{{ asset('storage/' . $pageContent->data[$field['name']]) }}" 
                                                             alt="Current image" 
                                                             class="rounded shadow-sm"
                                                             style="max-height: 200px; max-width: 100%;">
                                                    @else
                                                        {{-- Show file icon for documents --}}
                                                        <div class="text-blue fs-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="flex-fill">
                                                        <div class="text-muted small mb-1">Current file:</div>
                                                        <div class="fw-semibold mb-2">
                                                            {{ $pageContent->data[$field['name'] . '_original_name'] ?? basename($pageContent->data[$field['name']]) }}
                                                        </div>
                                                        <a href="{{ asset('storage/' . $pageContent->data[$field['name']]) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                                                                <line x1="10" y1="14" x2="20" y2="4"></line>
                                                                <polyline points="15 4 20 4 20 9"></polyline>
                                                            </svg>
                                                            View/Download file
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <input type="file" 
                                               name="{{ $field['name'] }}" 
                                               class="form-control @error($field['name']) is-invalid @enderror"
                                               @if(!empty($field['accept'])) accept="{{ $field['accept'] }}" @endif>
                                        
                                        <div class="form-text">
                                            @if(!empty($pageContent->data[$field['name']]))
                                                <span class="text-warning">⚠️ Leave empty to keep current file, or upload a new file to replace it.</span><br>
                                            @endif
                                            @if(!empty($field['accept']))
                                                <span>Accepted formats: {{ $field['accept'] }}</span>
                                            @endif
                                        </div>
                                        
                                        @error($field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    @elseif($field['type'] === 'repeater')
                                        {{-- Repeater Field --}}
                                        <div class="card bg-light">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="card-title">{{ $field['label'] }}</span>
                                                    <button type="button" 
                                                            onclick="addRepeaterItem('{{ $field['name'] }}', {{ json_encode($field['fields']) }})" 
                                                            class="btn btn-primary btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                                        </svg>
                                                        Add {{ $field['label'] }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="repeater_{{ $field['name'] }}" class="vstack gap-3">
                                                    @if(!empty($pageContent->data[$field['name']]) && is_array($pageContent->data[$field['name']]))
                                                        @foreach($pageContent->data[$field['name']] as $index => $item)
                                                            <div class="card position-relative">
                                                                <button type="button" 
                                                                        onclick="this.closest('.card').remove()" 
                                                                        class="btn btn-icon btn-sm position-absolute top-0 end-0 m-2"
                                                                        style="z-index: 1;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                    </svg>
                                                                </button>
                                                                <div class="card-body pe-5">
                                                                    @foreach($field['fields'] as $subField)
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                {{ $subField['label'] }}
                                                                                @if($subField['required'] ?? false)
                                                                                    <span class="text-danger">*</span>
                                                                                @endif
                                                                            </label>
                                                                            
                                                                            @if(isset($subField['type']) && $subField['type'] === 'repeater')
                                                                                {{-- Nested repeater --}}
                                                                                <div class="card bg-light">
                                                                                    <div class="card-header">
                                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                                            <label class="form-label mb-0 fw-bold">
                                                                                                {{ $subField['label'] }}
                                                                                            </label>
                                                                                            <button type="button" 
                                                                                                    onclick="addNestedRepeaterItem('{{ $field['name'] }}', {{ $index }}, '{{ $subField['name'] }}', {{ json_encode($subField['fields'] ?? []) }})" 
                                                                                                    class="btn btn-success btn-sm">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                                                                </svg>
                                                                                                Add
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div id="repeater_{{ $field['name'] }}_{{ $index }}_{{ $subField['name'] }}" class="vstack gap-2">
                                                                                            @if(!empty($item[$subField['name']]) && is_array($item[$subField['name']]))
                                                                                                @foreach($item[$subField['name']] as $nestedIndex => $nestedItem)
                                                                                                    <div class="card card-sm position-relative">
                                                                                                        <button type="button" 
                                                                                                                onclick="this.closest('.card').remove()" 
                                                                                                                class="btn btn-icon btn-sm position-absolute top-0 end-0 m-1"
                                                                                                                style="z-index: 1;">
                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                        <div class="card-body pe-4">
                                                                                                            @foreach($subField['fields'] as $nestedField)
                                                                                                                <div class="mb-2">
                                                                                                                    <label class="form-label form-label-sm">
                                                                                                                        {{ $nestedField['label'] }}
                                                                                                                    </label>
                                                                                                                    @if($nestedField['type'] === 'textarea')
                                                                                                                        <textarea name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}][{{ $nestedIndex }}][{{ $nestedField['name'] }}]" 
                                                                                                                                  rows="2"
                                                                                                                                  class="form-control form-control-sm">{{ $nestedItem[$nestedField['name']] ?? '' }}</textarea>
                                                                                                                    @else
                                                                                                                        <input type="{{ $nestedField['type'] }}" 
                                                                                                                               name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}][{{ $nestedIndex }}][{{ $nestedField['name'] }}]"
                                                                                                                               value="{{ $nestedItem[$nestedField['name']] ?? '' }}"
                                                                                                                               class="form-control form-control-sm">
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif(isset($subField['type']) && $subField['type'] === 'textarea')
                                                                                <textarea name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}]" 
                                                                                          rows="3"
                                                                                          class="form-control"
                                                                                          {{ ($subField['required'] ?? false) ? 'required' : '' }}>{{ $item[$subField['name']] ?? '' }}</textarea>
                                                                            @else
                                                                                <input type="{{ $subField['type'] ?? 'text' }}" 
                                                                                       name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}]"
                                                                                       value="{{ $item[$subField['name']] ?? '' }}"
                                                                                       class="form-control"
                                                                                       {{ ($subField['required'] ?? false) ? 'required' : '' }}>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($field['type'] === 'textarea')
                                        {{-- Textarea Field --}}
                                        <textarea name="data[{{ $field['name'] }}]" 
                                                  rows="4"
                                                  class="form-control @error('data.' . $field['name']) is-invalid @enderror"
                                                  {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('data.' . $field['name'], $pageContent->data[$field['name']] ?? '') }}</textarea>
                                        
                                        @error('data.' . $field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    @else
                                        {{-- Regular Input Field --}}
                                        <input type="{{ $field['type'] }}" 
                                               name="data[{{ $field['name'] }}]"
                                               value="{{ old('data.' . $field['name'], $pageContent->data[$field['name']] ?? '') }}"
                                               class="form-control @error('data.' . $field['name']) is-invalid @enderror"
                                               {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                        
                                        @error('data.' . $field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Submit Button --}}
                        <div class="card-footer bg-transparent mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                    Update Content
                                </button>
                                <a href="{{ route('page-contents.index', ['type' => $type, 'id' => $model->id]) }}" class="btn btn-link">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let repeaterCounters = {};

function addRepeaterItem(repeaterName, fields) {
    if (!repeaterCounters[repeaterName]) {
        const existing = document.querySelectorAll(`#repeater_${repeaterName} > .card`).length;
        repeaterCounters[repeaterName] = existing;
    }
    
    const container = document.getElementById('repeater_' + repeaterName);
    const index = repeaterCounters[repeaterName]++;
    
    let fieldsHtml = '';
    fields.forEach(field => {
        const required = field.required ? 'required' : '';
        const inputName = `data[${repeaterName}][${index}][${field.name}]`;
        
        if (field.type === 'repeater') {
            // Nested repeater support
            const nestedRepeaterName = `${repeaterName}_${index}_${field.name}`;
            fieldsHtml += `
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0 fw-bold">
                                ${field.label}
                            </label>
                            <button type="button" 
                                    onclick="addNestedRepeaterItem('${repeaterName}', ${index}, '${field.name}', ${JSON.stringify(field.fields).replace(/"/g, '&quot;')})" 
                                    class="btn btn-success btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add ${field.label}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="repeater_${nestedRepeaterName}" class="vstack gap-2">
                            <!-- Nested items will be added here -->
                        </div>
                    </div>
                </div>
            `;
        } else if (field.type === 'textarea') {
            fieldsHtml += `
                <div class="mb-3">
                    <label class="form-label">
                        ${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    <textarea name="${inputName}" rows="3"
                              class="form-control"
                              ${required}></textarea>
                </div>
            `;
        } else {
            fieldsHtml += `
                <div class="mb-3">
                    <label class="form-label">
                        ${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    <input type="${field.type}" 
                           name="${inputName}"
                           class="form-control"
                           ${required}>
                </div>
            `;
        }
    });
    
    const itemHtml = `
        <div class="card position-relative">
            <button type="button" 
                    onclick="this.closest('.card').remove()" 
                    class="btn btn-icon btn-sm position-absolute top-0 end-0 m-2"
                    style="z-index: 1;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="card-body pe-5">
                ${fieldsHtml}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}

// Function for nested repeaters
let nestedCounters = {};

function addNestedRepeaterItem(parentName, parentIndex, fieldName, fields) {
    const counterKey = `${parentName}_${parentIndex}_${fieldName}`;
    if (!nestedCounters[counterKey]) {
        const existing = document.querySelectorAll(`#repeater_${counterKey} > .card`).length;
        nestedCounters[counterKey] = existing;
    }
    
    const container = document.getElementById(`repeater_${counterKey}`);
    const index = nestedCounters[counterKey]++;
    
    let fieldsHtml = '';
    fields.forEach(field => {
        const required = field.required ? 'required' : '';
        const inputName = `data[${parentName}][${parentIndex}][${fieldName}][${index}][${field.name}]`;
        
        if (field.type === 'textarea') {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label form-label-sm">
                        ${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    <textarea name="${inputName}" rows="2"
                              class="form-control form-control-sm"
                              ${required}></textarea>
                </div>
            `;
        } else {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label form-label-sm">
                        ${field.label} ${field.required ? '<span class="text-danger">*</span>' : ''}
                    </label>
                    <input type="${field.type}" 
                           name="${inputName}"
                           class="form-control form-control-sm"
                           ${required}>
                </div>
            `;
        }
    });
    
    const itemHtml = `
        <div class="card card-sm position-relative">
            <button type="button" 
                    onclick="this.closest('.card').remove()" 
                    class="btn btn-icon btn-sm position-absolute top-0 end-0 m-1"
                    style="z-index: 1;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="card-body pe-4">
                ${fieldsHtml}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}
</script>
@endsection