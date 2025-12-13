@extends('layouts.app')

@section('title', 'Manage Content')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('links.index') }}">Links</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $link->title }}</li>
                    </ol>
                </nav>
                <h2 class="page-title">Content for: {{ $link->title }}</h2>
                <div class="text-muted mt-1">
                    {{ $link->subCategory->mainCategory->name }} > {{ $link->subCategory->name }}
                </div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="{{ route('link.view', $link->id) }}" target="_blank" class="btn btn-success">
                        <i class="ti ti-eye icon"></i>
                        Preview Link
                    </a>
                    <a href="{{ route('link-contents.select-template', $link) }}" class="btn btn-primary">
                        <i class="ti ti-plus icon"></i>
                        Add Content
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($link->contents->count() > 0)
    <div class="alert alert-info mb-4" role="alert">
        <div class="d-flex">
            <div>
                <i class="ti ti-bulb icon alert-icon"></i>
            </div>
            <div>
                <strong>Tip:</strong> Drag and drop content blocks to reorder them. The order here will be the same as in the preview.
            </div>
        </div>
    </div>

    <div id="sortable-contents">
        @foreach($link->contents as $content)
        <div class="card mb-3 content-item" data-id="{{ $content->id }}">
            {{-- Drag Handle --}}
            <div class="card-header drag-handle" style="cursor: move;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-grip-horizontal icon me-2 text-muted"></i>
                        <i class="{{ config("templates.{$content->template_name}.icon", 'ti-file') }} icon fs-1 me-3 text-primary"></i>
                        <div>
                            <h3 class="card-title mb-1">{{ $content->getTemplateName() }}</h3>
                            <div class="text-muted small">{{ config("templates.{$content->template_name}.description") }}</div>
                        </div>
                    </div>
                    <div class="btn-list">
                        @if($content->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                        <a href="{{ route('link-contents.edit', [$link, $content]) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-pencil icon"></i>
                            Edit
                        </a>
                        <form action="{{ route('link-contents.destroy', [$link, $content]) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this content?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="ti ti-trash icon"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Content Preview --}}
            <div class="card-body bg-light">
                <h4 class="mb-3">
                    <i class="ti ti-eye icon me-2 text-muted"></i>
                    Content Preview:
                </h4>
                <div class="preview-container bg-white rounded border p-3">
                    @php
                        $data = $content->data;
                        $templateView = "components.templates.{$content->template_name}";
                    @endphp
                    
                    @if(view()->exists($templateView))
                        <div class="preview-scale">
                            @include($templateView, ['data' => $data])
                        </div>
                    @else
                        <div class="alert alert-warning mb-0" role="alert">
                            <i class="ti ti-alert-triangle icon me-2"></i>
                            Template view not found: <code>{{ $templateView }}</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Add Sortable.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortableContainer = document.getElementById('sortable-contents');
        
        if (sortableContainer) {
            const sortable = Sortable.create(sortableContainer, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    // Get new order
                    const items = sortableContainer.querySelectorAll('.content-item');
                    const order = Array.from(items).map(item => item.getAttribute('data-id'));
                    
                    // Send AJAX request to update order
                    fetch('{{ route("link-contents.update-order", $link) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order: order
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Order updated successfully!', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to update order', 'error');
                    });
                }
            });
        }
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `toast show position-fixed top-0 end-0 m-3`;
        notification.setAttribute('role', 'alert');
        notification.innerHTML = `
            <div class="toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white">
                <i class="ti ti-${type === 'success' ? 'check' : 'alert-circle'} icon me-2"></i>
                <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    </script>

    <style>
    /* Sortable styles */
    .sortable-ghost {
        opacity: 0.4;
        background: #f8f9fa;
    }

    .sortable-drag {
        opacity: 0;
    }

    .drag-handle:hover {
        background-color: #f1f3f5;
    }

    .content-item {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .content-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Preview scaling */
    .preview-container {
        overflow: hidden;
        max-height: 400px;
    }

    .preview-scale {
        transform: scale(0.75);
        transform-origin: top left;
        width: 133.33%;
    }
    </style>

    @else
    <div class="card">
        <div class="card-body">
            <div class="empty">
                <div class="empty-icon">
                    <i class="ti ti-file-text icon"></i>
                </div>
                <p class="empty-title">No content yet</p>
                <p class="empty-subtitle text-muted">
                    Get started by adding content using a pre-built template.
                </p>
                <div class="empty-action">
                    <a href="{{ route('link-contents.select-template', $link) }}" class="btn btn-primary">
                        <i class="ti ti-plus icon"></i>
                        Add First Content
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection