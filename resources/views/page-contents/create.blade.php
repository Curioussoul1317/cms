@extends('layouts.app')

@section('content')
<div class="container-xl ">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Add Content Block</h2>
                        <div class="text-muted mt-1"> 
                            <span class="fw-semibold">{{ $model->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card">
                <div class="card-body">
                    @if($template)
                        {{-- Form with selected template --}}
                        <form action="{{ route('page-contents.store', ['type' => $type, 'id' => $model->id]) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf

                            {{-- Hidden template field --}}
                            <input type="hidden" name="template" value="{{ $templateName }}">

                            {{-- Show selected template --}}
                            <div class="alert alert-info mb-4" role="alert">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Selected Template: {{ $template['name'] }} </div>
                                        <div class="h4 mb-0 mt-1">
                                        <i class="{{ $template['icon'] }}" style="font-size: 3rem;"></i>    
                                        </div>
                                    </div>
                                    <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                                       class="btn btn-sm btn-primary">
                                        Back to widgets
                                    </a>
                                </div>
                            </div>

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
                                            <input type="file" 
                                                   name="{{ $field['name'] }}" 
                                                   class="form-control @error($field['name']) is-invalid @enderror"
                                                   @if(!empty($field['accept'])) accept="{{ $field['accept'] }}" @endif
                                                   {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            
                                            @if(!empty($field['accept']))
                                                <div class="form-text">
                                                    Accepted formats: {{ $field['accept'] }}
                                                </div>
                                            @endif
                                            
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
                                                        {{-- Items will be added here by JavaScript --}}
                                                    </div>
                                                </div>
                                            </div>

                                        @elseif($field['type'] === 'textarea')
                                            {{-- Textarea Field --}}
                                            <textarea name="data[{{ $field['name'] }}]" 
                                                      rows="4"
                                                      class="form-control @error('data.' . $field['name']) is-invalid @enderror"
                                                      {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('data.' . $field['name']) }}</textarea>
                                            
                                            @error('data.' . $field['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        @else
                                            {{-- Regular Input Field --}}
                                            <input type="{{ $field['type'] }}" 
                                                   name="data[{{ $field['name'] }}]"
                                                   value="{{ old('data.' . $field['name']) }}"
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
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add Content
                                    </button>
                                    <a href="{{ route('page-contents.index', ['type' => $type, 'id' => $model->id]) }}" 
                                       class="btn btn-link">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>

                    @else
                        {{-- Template Selection --}}
                        <div class="text-center py-4">
                            <h3 class="card-title mb-4">Select a Template</h3>
                            
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                @foreach($templates as $key => $tmpl)
                                    <div class="col">
                                        <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id, 'template' => $key]) }}" 
                                           class="card card-link card-link-pop text-decoration-none h-100">
                                            <div class="card-body text-center">
                                                @if(isset($tmpl['icon']) && str_starts_with($tmpl['icon'], 'ti ti-'))
                                                    <div class="mb-3">
                                                        <i class="{{ $tmpl['icon'] }}" style="font-size: 3rem;"></i>
                                                    </div>
                                                @else
                                                    <div class="display-4 mb-3">{{ $tmpl['icon'] ?? '📄' }}</div>
                                                @endif
                                                <h4 class="card-title mb-2">{{ $tmpl['name'] }}</h4>
                                                <p class="text-muted small mb-0">{{ $tmpl['description'] ?? '' }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($template)
<script>
let repeaterCounters = {};

function addRepeaterItem(repeaterName, fields) {
    if (!repeaterCounters[repeaterName]) {
        repeaterCounters[repeaterName] = 0;
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
        nestedCounters[counterKey] = 0;
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
@endif
@endsection