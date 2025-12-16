@extends('layouts.app')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Content Blocks
                </div>
                <h2 class="page-title">
                    Content Blocks of {{ $model->name }}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                        class="btn btn-primary d-none d-sm-inline-block"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>                       
                        Add Content
                    </a>

                

                    <a href="{{ route('content.show', ['page', $model->id]) }}" 
                        class="btn btn-cyan d-none d-sm-inline-block"
                        target="_blank" rel="noopener noreferrer"
                        data-bs-toggle="tooltip"
                        title="View Public Page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                        Preview
                    </a>

                    <a href="{{ route('categories.hierarchy') }}" class="btn btn-secondary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Back 
                    </a> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body"> 
    <div class="container-xl">

        <style>
            .banner-section {
                position: relative;
                background-color: rgb(30, 203, 229);
                overflow: hidden;
                min-height: 100vh;
            }

            @media (min-width: 768px) {
                .banner-section {
                    height: 42rem;
                    min-height: auto;
                }
            }

            /* SVG Wave Container */
            .wave-container {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                height: 400px;
                display: flex;
                pointer-events: none;
            }

            .wave-svg {
                width: 100%;
                display: inline-block;
            }

            @keyframes wave-animation-1 {
                0% {
                    transform: translateX(0) translateY(0) scaleY(1);
                }
                25% {
                    transform: translateX(-30px) translateY(-8px) scaleY(1.02);
                }
                50% {
                    transform: translateX(-50px) translateY(-15px) scaleY(1.05);
                }
                75% {
                    transform: translateX(-30px) translateY(-8px) scaleY(1.02);
                }
                100% {
                    transform: translateX(0) translateY(0) scaleY(1);
                }
            }

            @keyframes wave-animation-2 {
                0% {
                    transform: translateX(0) translateY(0) scaleY(1);
                }
                20% {
                    transform: translateX(20px) translateY(-5px) scaleY(0.98);
                }
                40% {
                    transform: translateX(45px) translateY(-12px) scaleY(0.95);
                }
                60% {
                    transform: translateX(60px) translateY(-20px) scaleY(0.93);
                }
                80% {
                    transform: translateX(40px) translateY(-10px) scaleY(0.96);
                }
                100% {
                    transform: translateX(0) translateY(0) scaleY(1);
                }
            }

            .wave-1 {
                animation: wave-animation-1 12s ease-in-out infinite;
            }

            .wave-2 {
                animation: wave-animation-2 8s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite;
            }

            .banner-content {
                position: relative;
                z-index: 10;
                padding: 5rem 0;
            }

            @media (max-width: 767px) {
                .banner-content {
                    padding: 3rem 0;
                }
            }

            .content-wrapper {
                max-width: 600px;
                margin: 0 auto;
            }

            @media (max-width: 767px) {
                .content-wrapper {
                    max-width: 350px;
                    text-align: center;
                }
            }

            @media (min-width: 768px) {
                .content-wrapper {
                    text-align: left;
                }
            }

            .banner-title {
                font-size: 3rem;
                color: white;
                font-weight: bold;
                text-transform: capitalize;
                margin-bottom: 1.5rem;
            }

            @media (min-width: 768px) {
                .banner-title {
                    font-size: 3.75rem;
                }
            }

            .banner-subtitle {
                font-size: 1.125rem;
                color: white;
                font-weight: 500;
                text-transform: capitalize;
                margin-bottom: 2rem;
            }

            @media (min-width: 768px) {
                .banner-subtitle {
                    font-size: 1.5rem;
                }
            }

            .apply-btn {
                background-color: #7DFF7D;
                color: white;
                padding: 0.5rem 1.5rem;
                font-weight: 500;
                text-transform: uppercase;
                border-radius: 50px;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
                border: none;
            }

            .apply-btn:hover {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                filter: brightness(1.05);
                color: white;
            }

            .image-container {
                display: flex;
                align-items: flex-end;
                justify-content: flex-end;
                height: 24rem;
            }

            @media (min-width: 768px) {
                .image-container {
                    height: 42rem;
                }
            }

            .banner-image {
                max-width: 100%;
                height: auto;
            }

            @media (min-width: 768px) {
                .banner-image {
                    min-width: 500px;
                }
            }
        </style>
 
        @if($model->contents && $model->contents->count() > 0)
            <div class="row row-cards" id="content-blocks">
                @foreach($model->contents->sortBy('order') as $content)
                    <div class="col-12 mb-3 content-block" data-content-id="{{ $content->id }}">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex align-items-center">
                                        <div class="drag-handle me-3">
                                            <i class="ti ti-grip-vertical icon text-muted"></i>
                                        </div>
                                        <div>
                                            <h3 class="card-title mb-0">
                                                {{ config('templates.' . $content->template_name . '.name') ?? $content->template_name }}
                                            </h3>
                                            <div class="text-muted small">Order: {{ $content->order }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-auto ms-auto d-print-none">
                                        <div class="btn-list">
 



                                        @if(!$content->is_approved)
<form action="{{ route('approve', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$content->is_published)
<form action="{{ route('publish', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'page-content', 'id' => $content->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif













 

                                            <a href="{{ route('page-contents.edit', ['type' => $type, 'id' => $model->id, 'pageContent' => $content]) }}" 
                                               class="btn btn-icon btn-yellow btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            </a>
                                            <form action="{{ route('page-contents.destroy', ['type' => $type, 'id' => $model->id, 'pageContent' => $content]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $componentPath = 'components.templates.' . $content->template_name;
                                @endphp
                                @if(view()->exists($componentPath))
                                    @include($componentPath, ['data' => $content->data])
                                @else
                                    <div class="alert alert-warning">
                                        Template not found: {{ $content->template_name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-file icon"></i>
                    </div>
                    <p class="empty-title">No Content Blocks Yet</p>
                    <div class="empty-action">
                        <a href="{{ route('page-contents.create', ['type' => $type, 'id' => $model->id]) }}" 
                           class="btn btn-primary">
                            <i class="ti ti-plus icon"></i>
                            Create Content Block
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                            console.log('Order updated successfully', data);
                            // Optional: Show success toast/notification
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
            
            console.log('Sortable initialized successfully');
        }
    });
</script>
@endpush