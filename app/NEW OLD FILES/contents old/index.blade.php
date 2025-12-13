@extends('layouts.app')

@section('content')
 
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $parent->name }} - Content Blocks   
                </h1>
                <p class="text-gray-600">
                    Type: <span class="font-medium capitalize">{{ str_replace('-', ' ', $type) }}</span>
                </p>
                @if($type === 'link' && $parent->url)
                    <p class="text-gray-600 mt-1">
                        URL: <a href="{{ $parent->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $parent->url }}</a>
                    </p>
                @endif
            </div>
            <div class="flex gap-2">
                @if($type === 'link')
                    <a href="{{ route('links.edit', $parent) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                        Edit {{ ucfirst($type) }}
                    </a>
                @else
                    <a href="{{ route('sub-categories.edit', $parent) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                        Edit Sub Category
                    </a>
                @endif
                <a href="{{ route('categories.hierarchy') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                    Back to Hierarchy
                </a>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    {{-- Add Content Button --}}
    <div class="mb-6">
        <a href="{{ route('content.create', ['type' => $type, 'id' => $parent->id]) }}" 
           class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Content Block
        </a>
    </div>

    {{-- Content Blocks --}}
    @if($parent->contents && $parent->contents->count() > 0)
        <div class="space-y-6" id="content-blocks">
            @foreach($parent->contents->sortBy('order') as $content)
                <div class="content-block bg-white rounded-lg shadow-md overflow-hidden" 
                     data-content-id="{{ $content->id }}">
                    
                    {{-- Content Header --}}
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="drag-handle cursor-move text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ config('templates.' . $content->template_name . '.name') ?? $content->template_name }}
                                </h3>
                                <p class="text-sm text-gray-500">Order: {{ $content->order }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('content.edit', ['type' => $type, 'id' => $parent->id, 'content' => $content]) }}" 
                               class="text-blue-600 hover:text-blue-800 p-2 rounded hover:bg-blue-50 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('content.destroy', ['type' => $type, 'id' => $parent->id, 'content' => $content]) }}" 
                                  method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded hover:bg-red-50 transition" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Content Preview --}}
                    <div class="p-6">
                        @php
                            $componentPath = 'components.templates.' . $content->template_name;
                        @endphp
                        @if(view()->exists($componentPath))
                            @include($componentPath, ['data' => $content->data])
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-yellow-800 font-medium">Template not found: {{ $content->template_name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Drag and Drop --}}
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('content-blocks');
                if (container) {
                    new Sortable(container, {
                        handle: '.drag-handle',
                        animation: 150,
                        onEnd: function() {
                            const blocks = document.querySelectorAll('.content-block');
                            const order = Array.from(blocks).map(block => block.dataset.contentId);
                            fetch('{{ route('content.update-order', ['type' => $type, 'id' => $parent->id]) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ order: order })
                            });
                        }
                    });
                }
            });
        </script>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Content Blocks Yet</h3>
            <p class="text-gray-600 mb-6">Get started by creating your first content block</p>
            <a href="{{ route('content.create', ['type' => $type, 'id' => $parent->id]) }}" 
               class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition">
                + Create Content Block
            </a>
        </div>
    @endif
</div>
@endsection