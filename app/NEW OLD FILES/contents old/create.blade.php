@extends('layouts.app')

@section('content') 
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Add Content to Link</h1>
            <p class="text-gray-600">Link: <span class="font-semibold">{{ $parent->name }}</span></p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            @if($template)
                {{-- Form with selected template --}}
                <form action="{{ route('link-contents.store', $parent) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- Hidden template field --}}
                    <input type="hidden" name="template" value="{{ $templateName }}">

                    {{-- Show selected template --}}
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">Selected Template:</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $template['icon'] ?? '📄' }} {{ $template['name'] }}
                                </p>
                            </div>
                            <a href="{{ route('link-contents.create', $parent) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                Change Template
                            </a>
                        </div>
                    </div>

                    {{-- Template Fields --}}
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Template Fields</h3>
                        
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
                                    <input type="file" 
                                           name="{{ $field['name'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                           @if(!empty($field['accept'])) accept="{{ $field['accept'] }}" @endif
                                           {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                    
                                    @if(!empty($field['accept']))
                                        <p class="text-sm text-gray-500 mt-1">
                                            Accepted formats: {{ $field['accept'] }}
                                        </p>
                                    @endif
                                    
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
                                            {{-- Items will be added here by JavaScript --}}
                                        </div>
                                    </div>

                                @elseif($field['type'] === 'textarea')
                                    {{-- Textarea Field --}}
                                    <textarea name="data[{{ $field['name'] }}]" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old('data.' . $field['name']) }}</textarea>
                                    
                                    @error('data.' . $field['name'])
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror

                                @else
                                    {{-- Regular Input Field --}}
                                    <input type="{{ $field['type'] }}" 
                                           name="data[{{ $field['name'] }}]"
                                           value="{{ old('data.' . $field['name']) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                    
                                    @error('data.' . $field['name'])
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-between pt-4 border-t">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                            Add Content
                        </button>
                        <a href="{{ route('links.show', $parent) }}" 
                           class="text-gray-600 hover:text-gray-800 transition">
                            Cancel
                        </a>
                    </div>
                </form>

            @else
                {{-- Template Selection --}}
                <div class="text-center py-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Select a Template</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($templates as $key => $tmpl)
                            <a href="{{ route('link-contents.create', ['link' => $parent, 'template' => $key]) }}" 
                               class="block p-6 bg-white border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition">
                                <div class="text-4xl mb-3">{{ $tmpl['icon'] ?? '📄' }}</div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $tmpl['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $tmpl['description'] ?? '' }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
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
                        <!-- Nested items will be added here -->
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
@endif
@endsection