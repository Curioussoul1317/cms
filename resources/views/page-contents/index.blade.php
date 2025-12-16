@extends('layouts.app')

@section('title', 'Content Blocks - ' . $model->name)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('categories.hierarchy') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Categories
                    </a>
                </div>
                <h2 class="page-title">Content Blocks</h2>
                <div class="text-secondary mt-1">
                    Managing: <strong>{{ $model->name }}</strong>
                </div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('content.show', ['page', $model->id]) }}" 
                       class="btn btn-cyan d-none d-sm-inline-block"
                       target="_blank" 
                       rel="noopener noreferrer"
                       data-bs-toggle="tooltip"
                       title="View Public Page">
                        <i class="ti ti-eye me-1"></i>
                        Preview
                    </a>
                    <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                       class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Content
                    </a>
                    <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                       class="btn btn-primary d-sm-none btn-icon" 
                       aria-label="Add Content">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-check me-2"></i></div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-alert-circle me-2"></i></div>
                    <div>{{ session('error') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        {{-- Info Card --}}
        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <span class="avatar bg-primary-lt text-primary">
                            <i class="ti ti-layout-list"></i>
                        </span>
                    </div>
                    <div class="flex-fill">
                        <div class="fw-medium">{{ $model->contents ? $model->contents->count() : 0 }} Content Block(s)</div>
                        <div class="text-secondary small">Drag and drop to reorder blocks</div>
                    </div>
                    <div>
                        <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i>
                            Add Block
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if($model->contents && $model->contents->count() > 0)
            <div id="content-blocks">
                @foreach($model->contents->sortBy('order') as $content)
                    <div class="card mb-3 content-block" data-content-id="{{ $content->id }}">
                        <div class="card-header">
                            <div class="d-flex align-items-center w-100">
                                {{-- Drag Handle --}}
                                <div class="drag-handle me-3 cursor-grab" style="cursor: grab;">
                                    <i class="ti ti-grip-vertical text-secondary" style="font-size: 1.25rem;"></i>
                                </div>
                                
                                {{-- Template Info --}}
                                <div class="flex-fill">
                                    <h3 class="card-title mb-0">
                                        <i class="ti ti-template me-1 text-primary"></i>
                                        {{ config('templates.' . $content->template_name . '.name') ?? $content->template_name }}
                                    </h3>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="badge bg-secondary-lt">
                                            <i class="ti ti-sort-ascending-numbers me-1"></i>
                                            Order: {{ $content->order }}
                                        </span>
                                        
                                        {{-- Status Badges --}}
                                        @if($content->is_approved)
                                            <span class="badge bg-green-lt">
                                                <i class="ti ti-check me-1"></i>
                                                Approved
                                            </span>
                                        @else
                                            <span class="badge bg-yellow-lt">
                                                <i class="ti ti-clock me-1"></i>
                                                Pending
                                            </span>
                                        @endif
                                        
                                        @if($content->is_published)
                                            <span class="badge bg-blue-lt">
                                                <i class="ti ti-world me-1"></i>
                                                Published
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-lt">
                                                <i class="ti ti-world-off me-1"></i>
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                {{-- Actions --}}
                                <div class="btn-list flex-nowrap">
                                    {{-- 
                                        APPROVE/PUBLISH WORKFLOW LOGIC:
                                        - NOT approved: Show "Approve" button only
                                        - Approved but NOT published: Show "Unapprove" and "Publish" buttons
                                        - Published: Show only "Unpublish" button (approval buttons hidden)
                                    --}}
                                    
                                    {{-- Approval Buttons: Only show if NOT published --}}
                                    @if(!$content->is_published)
                                        @if(!$content->is_approved)
                                            <form action="{{ route('approve', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Approve">
                                                    <i class="ti ti-check me-1"></i>
                                                    Approve
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('unapprove', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-warning btn-sm" data-bs-toggle="tooltip" title="Unapprove">
                                                    <i class="ti ti-x me-1"></i>
                                                    Unapprove
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    {{-- Publish Buttons: Only show if approved --}}
                                    @if($content->is_approved)
                                        @if(!$content->is_published)
                                            <form action="{{ route('publish', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Publish">
                                                    <i class="ti ti-upload me-1"></i>
                                                    Publish
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('unpublish', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Unpublish">
                                                    <i class="ti ti-download me-1"></i>
                                                    Unpublish
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    <div class="vr mx-2"></div>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('page-contents.edit', ['type' => $type, 'id' => $model->id, 'pageContent' => $content]) }}" 
                                       class="btn btn-icon btn-ghost-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit Content">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    
                                    {{-- Delete Button --}}
                                    <form action="{{ route('page-contents.destroy', ['type' => $type, 'id' => $model->id, 'pageContent' => $content]) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this content block?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-icon btn-ghost-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete Content">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Content Preview --}}
                        <div class="card-body bg-light">
                            <div class="content-preview" style="max-height: 400px; overflow: hidden; position: relative;">
                                @php
                                    $componentPath = 'components.templates.' . $content->template_name;
                                @endphp
                                @if(view()->exists($componentPath))
                                    <div style="transform: scale(0.75); transform-origin: top left; width: 133.33%;">
                                        @include($componentPath, ['data' => $content->data])
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <div class="d-flex">
                                            <div><i class="ti ti-alert-triangle me-2"></i></div>
                                            <div>Template not found: <code>{{ $content->template_name }}</code></div>
                                        </div>
                                    </div>
                                @endif
                                
                                {{-- Fade overlay --}}
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(transparent, var(--tblr-bg-surface-secondary));"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-file-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No Content Blocks Yet</p>
                        <p class="empty-subtitle text-secondary">
                            Add content blocks to build your page layout.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                               class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Create Content Block
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .drag-handle:active {
        cursor: grabbing !important;
    }
    
    .sortable-ghost {
        opacity: 0.4;
        background: var(--tblr-primary-lt);
    }
    
    .sortable-drag {
        background: var(--tblr-bg-surface);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .content-block {
        transition: transform 0.2s ease;
    }
    
    .content-block:hover {
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Sortable
        const container = document.getElementById('content-blocks');
        
        if (container) {
            const sortable = new Sortable(container, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                forceFallback: true,
                onEnd: function(evt) {
                    // Get all content blocks
                    const blocks = container.querySelectorAll('.content-block');
                    const order = Array.from(blocks).map(block => block.dataset.contentId);
                    
                    // Send the new order to the server
                    fetch('{{ route('page-contents.update-order', ['type' => $type, 'id' => $model->id]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success notification
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
                            alert.innerHTML = `
                                <div class="d-flex">
                                    <div><i class="ti ti-check me-2"></i></div>
                                    <div>Order updated successfully</div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            `;
                            document.body.appendChild(alert);
                            
                            // Auto-dismiss after 3 seconds
                            setTimeout(() => {
                                alert.remove();
                            }, 3000);
                        } else {
                            console.error('Failed to update order:', data.message);
                            alert('Failed to update order: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                        alert('Error updating order. Please refresh the page and try again.');
                    });
                }
            });
        }
    });
</script>
@endpush