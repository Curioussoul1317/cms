@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Content</h1>
            <p class="text-gray-600">
                Link: <span class="font-semibold">{{ $link->name }}</span> | 
                Template: <span class="font-semibold">{{ $template['name'] ?? $linkContent->template_name }}</span>
            </p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('link-contents.update', [$link, $linkContent]) }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Template Fields --}}
                @foreach($template['fields'] as $field)
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            {{ $field['label'] }}
                            @if($field['required'] ?? false)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        @if($field['type'] === 'file')
                            {{-- File Upload Field --}}
                            
                            {{-- Show current file if exists --}}
                            @if(!empty($linkContent->data[$field['name']]))
                                <div class="mb-3 p-3 bg-gray-50 rounded border border-gray-200">
                                    <p class="text-sm text-gray-600 mb-2 font-medium">Current file:</p>
                                    
                                    @if(str_contains($field['accept'] ?? '', 'image'))
                                        {{-- Show image preview --}}
                                        <img src="{{ asset('storage/' . $linkContent->data[$field['name']]) }}" 
                                             alt="Current image" 
                                             class="max-w-full h-auto rounded shadow-sm mb-2"
                                             style="max-height: 200px;">
                                    @else
                                        {{-- Show file name for documents --}}
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-800">
                                                {{ $linkContent->data[$field['name'] . '_original_name'] ?? basename($linkContent->data[$field['name']]) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $linkContent->data[$field['name']]) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1 text-blue-600 text-sm hover:underline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View/Download file
                                    </a>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   name="{{ $field['name'] }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   @if(!empty($field['accept'])) accept="{{ $field['accept'] }}" @endif>
                            
                            <p class="text-sm text-gray-500 mt-2">
                                @if(!empty($linkContent->data[$field['name']]))
                                    <span class="text-amber-600">⚠️ Leave empty to keep current file, or upload a new file to replace it.</span><br>
                                @endif
                                @if(!empty($field['accept']))
                                    <span class="text-gray-600">Accepted formats: {{ $field['accept'] }}</span>
                                @endif
                            </p>
                            
                            @error($field['name'])
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        @elseif($field['type'] === 'repeater')
                            {{-- Repeater Field --}}
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-gray-700 font-medium">{{ $field['label'] }}</span>
                                    <button type="button" 
                                            onclick="addRepeaterItem('{{ $field['name'] }}', {{ json_encode($field['fields']) }})" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                                        + Add {{ $field['label'] }}
                                    </button>
                                </div>
                                <div id="repeater_{{ $field['name'] }}" class="space-y-3">
                                    @if(!empty($linkContent->data[$field['name']]) && is_array($linkContent->data[$field['name']]))
                                        @foreach($linkContent->data[$field['name']] as $index => $item)
                                            <div class="border border-gray-200 rounded-lg p-4 bg-white relative">
                                                <button type="button" 
                                                        onclick="this.closest('.border').remove()" 
                                                        class="absolute top-2 right-2 text-red-600 hover:text-red-800 font-bold text-xl">
                                                    ×
                                                </button>
                                                <div class="grid grid-cols-1 gap-4 pr-8">
                                                    @foreach($field['fields'] as $subField)
                                                        <div>
                                                            <label class="block text-gray-700 font-medium mb-1 text-sm">
                                                                {{ $subField['label'] }}
                                                                @if($subField['required'] ?? false) * @endif
                                                            </label>
                                                            
                                                            @if(isset($subField['type']) && $subField['type'] === 'repeater')
                                                                {{-- Nested repeater --}}
                                                                <div class="border border-gray-200 rounded p-2 bg-gray-50">
                                                                    <button type="button" 
                                                                            onclick="addNestedRepeaterItem('{{ $field['name'] }}', {{ $index }}, '{{ $subField['name'] }}', {{ json_encode($subField['fields'] ?? []) }})" 
                                                                            class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded mb-2">
                                                                        + Add
                                                                    </button>
                                                                    <div id="repeater_{{ $field['name'] }}_{{ $index }}_{{ $subField['name'] }}">
                                                                        @if(!empty($item[$subField['name']]) && is_array($item[$subField['name']]))
                                                                            @foreach($item[$subField['name']] as $nestedIndex => $nestedItem)
                                                                                <div class="border border-gray-300 rounded p-2 bg-white relative mb-2">
                                                                                    <button type="button" 
                                                                                            onclick="this.closest('.border').remove()" 
                                                                                            class="absolute top-1 right-1 text-red-600 hover:text-red-800 text-lg">
                                                                                        ×
                                                                                    </button>
                                                                                    <div class="grid grid-cols-1 gap-2 pr-6">
                                                                                        @foreach($subField['fields'] as $nestedField)
                                                                                            <div>
                                                                                                <label class="block text-gray-600 font-medium mb-1 text-xs">
                                                                                                    {{ $nestedField['label'] }}
                                                                                                </label>
                                                                                                @if($nestedField['type'] === 'textarea')
                                                                                                    <textarea name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}][{{ $nestedIndex }}][{{ $nestedField['name'] }}]" 
                                                                                                              rows="2"
                                                                                                              class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm">{{ $nestedItem[$nestedField['name']] ?? '' }}</textarea>
                                                                                                @else
                                                                                                    <input type="{{ $nestedField['type'] }}" 
                                                                                                           name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}][{{ $nestedIndex }}][{{ $nestedField['name'] }}]"
                                                                                                           value="{{ $nestedItem[$nestedField['name']] ?? '' }}"
                                                                                                           class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm">
                                                                                                @endif
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @elseif(isset($subField['type']) && $subField['type'] === 'textarea')
                                                                <textarea name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}]" 
                                                                          rows="3"
                                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                                          {{ ($subField['required'] ?? false) ? 'required' : '' }}>{{ $item[$subField['name']] ?? '' }}</textarea>
                                                            @else
                                                                <input type="{{ $subField['type'] ?? 'text' }}" 
                                                                       name="data[{{ $field['name'] }}][{{ $index }}][{{ $subField['name'] }}]"
                                                                       value="{{ $item[$subField['name']] ?? '' }}"
                                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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

                        @elseif($field['type'] === 'textarea')
                            {{-- Textarea Field --}}
                            <textarea name="data[{{ $field['name'] }}]" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('data.' . $field['name'], $linkContent->data[$field['name']] ?? '') }}</textarea>
                            
                            @error('data.' . $field['name'])
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        @else
                            {{-- Regular Input Field --}}
                            <input type="{{ $field['type'] }}" 
                                   name="data[{{ $field['name'] }}]"
                                   value="{{ old('data.' . $field['name'], $linkContent->data[$field['name']] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   {{ ($field['required'] ?? false) ? 'required' : '' }}>
                            
                            @error('data.' . $field['name'])
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                @endforeach

                {{-- Submit Button --}}
                <div class="flex items-center justify-between pt-4 border-t">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                        Update Content
                    </button>
                    <a href="{{ route('links.show', $link) }}" 
                       class="text-gray-600 hover:text-gray-800 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let repeaterCounters = {};

function addRepeaterItem(repeaterName, fields) {
    if (!repeaterCounters[repeaterName]) {
        const existing = document.querySelectorAll(`#repeater_${repeaterName} > .border`).length;
        repeaterCounters[repeaterName] = existing;
    }
    
    const container = document.getElementById('repeater_' + repeaterName);
    const index = repeaterCounters[repeaterName]++;
    
    let fieldsHtml = '';
    fields.forEach(field => {
        const required = field.required ? 'required' : '';
        const inputName = `data[${repeaterName}][${index}][${field.name}]`;
        
        if (field.type === 'repeater') {
            const nestedRepeaterName = `${repeaterName}_${index}_${field.name}`;
            fieldsHtml += `
                <div class="border border-gray-300 rounded-lg p-3 mb-3 bg-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-gray-700 font-bold">
                            ${field.label}
                        </label>
                        <button type="button" 
                                onclick="addNestedRepeaterItem('${repeaterName}', ${index}, '${field.name}', ${JSON.stringify(field.fields).replace(/"/g, '&quot;')})" 
                                class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded">
                            + Add ${field.label}
                        </button>
                    </div>
                    <div id="repeater_${nestedRepeaterName}" class="space-y-2">
                    </div>
                </div>
            `;
        } else if (field.type === 'textarea') {
            fieldsHtml += `
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm">
                        ${field.label} ${field.required ? '*' : ''}
                    </label>
                    <textarea name="${inputName}" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              ${required}></textarea>
                </div>
            `;
        } else {
            fieldsHtml += `
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-sm">
                        ${field.label} ${field.required ? '*' : ''}
                    </label>
                    <input type="${field.type}" 
                           name="${inputName}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           ${required}>
                </div>
            `;
        }
    });
    
    const itemHtml = `
        <div class="border border-gray-200 rounded-lg p-4 bg-white relative mb-3">
            <button type="button" 
                    onclick="this.closest('.border').remove()" 
                    class="absolute top-2 right-2 text-red-600 hover:text-red-800 font-bold text-xl">
                ×
            </button>
            <div class="grid grid-cols-1 gap-4 pr-8">
                ${fieldsHtml}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}

let nestedCounters = {};

function addNestedRepeaterItem(parentName, parentIndex, fieldName, fields) {
    const counterKey = `${parentName}_${parentIndex}_${fieldName}`;
    if (!nestedCounters[counterKey]) {
        const existing = document.querySelectorAll(`#repeater_${counterKey} > .border`).length;
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
                <div>
                    <label class="block text-gray-600 font-medium mb-1 text-xs">
                        ${field.label} ${field.required ? '*' : ''}
                    </label>
                    <textarea name="${inputName}" rows="2"
                              class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm"
                              ${required}></textarea>
                </div>
            `;
        } else {
            fieldsHtml += `
                <div>
                    <label class="block text-gray-600 font-medium mb-1 text-xs">
                        ${field.label} ${field.required ? '*' : ''}
                    </label>
                    <input type="${field.type}" 
                           name="${inputName}"
                           class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm"
                           ${required}>
                </div>
            `;
        }
    });
    
    const itemHtml = `
        <div class="border border-gray-300 rounded p-3 bg-white relative">
            <button type="button" 
                    onclick="this.closest('.border').remove()" 
                    class="absolute top-1 right-1 text-red-600 hover:text-red-800 font-bold text-lg">
                ×
            </button>
            <div class="grid grid-cols-1 gap-2 pr-6">
                ${fieldsHtml}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}
</script>
@endsection