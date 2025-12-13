@extends('layouts.public')

@section('title', $item->name)

@section('content')
    <main class="page-wrapper">
        <div class="page-body">
            <div class="" style="padding: 0px;">

                {{-- Contents Section --}}
                @if($item->contents && $item->contents->count() > 0)
                    <div class="row row-cards" style="margin-right: 0px; margin-left: 0px;">
                        @foreach($item->contents as $content)
                            <div class="col-12" style="padding: 0;">
                                @php
                                    $componentPath = 'components.templates.' . $content->template_name;
                                @endphp
                                
                                @if(view()->exists($componentPath))
                                    @include($componentPath, ['data' => $content->data])
                                @else
                                    <div class="alert alert-warning">
                                        <div class="d-flex">
                                            <div>
                                                <i class="ti ti-alert-triangle icon alert-icon"></i>
                                            </div>
                                            <div>
                                                <h4 class="alert-title">Template Not Found</h4>
                                                <div class="text-muted">
                                                    The template <code>{{ $content->template_name }}</code> does not exist.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Child Pages Section (Only if page has children) --}}
                @if($item->has_children && $item->children && $item->children->count() > 0)
                    <div class="container-xl py-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-files icon me-2"></i>
                                    Pages in this Section
                                </h3>
                            </div>
                            <div class="list-group list-group-flush">
                                @foreach($item->children as $childPage)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-file icon text-blue me-2"></i>
                                                    <div>
                                                        <div class="fw-bold">{{ $childPage->name }}</div>
                                                        @if($childPage->description)
                                                            <div class="text-muted small">{{ $childPage->description }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @if($childPage->contents && $childPage->contents->count() > 0)
                                                    <a href="{{ route('content.show', ['page', $childPage->id]) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="ti ti-eye icon"></i>
                                                        View Page
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">No Content</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Breadcrumb / Navigation (Optional) --}}
                <!-- @if($item->parent)
                    <div class="container-xl py-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('content.show', ['page', $item->mainCategory->id]) }}">
                                        {{ $item->mainCategory->name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('content.show', ['page', $item->parent->id]) }}">
                                        {{ $item->parent->name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $item->name }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                @endif -->

                {{-- Empty State (when no content at all) --}}
                @if($item->contents->count() === 0 && (!$item->has_children || $item->children->count() === 0))
                    <div class="container-xl py-4">
                        <div class="empty">
                         
                            <p class="empty-title">No Content Available</p>
                            <p class="empty-subtitle text-muted">
                                This page doesn't have any content yet.
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>
@endsection