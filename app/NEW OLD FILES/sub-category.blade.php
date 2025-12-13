

@extends('layouts.public')

@section('title', 'Create Link')

@section('content')
 
  <!-- Content -->
  @include('components.hero-section', ['heroSection' => $heroSection]) 
        <main class="page-wrapper">
            <div class="page-body">
            <div class="container-xl py-4">
    {{-- Breadcrumb --}}
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('categories.hierarchy') }}" class="text-muted">
                        <i class="ti ti-arrow-left icon me-1"></i>
                        Back to Categories
                    </a>
                </div>
                <h2 class="page-title">
                    <i class="ti ti-folder icon text-success me-2"></i>
                    {{ $subCategory->name }}
                </h2>
                @if($subCategory->description)
                    <div class="text-muted mt-1">{{ $subCategory->description }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- SubCategory Contents --}}
    @if($subCategory->contents && $subCategory->contents->count() > 0)
        <div class="row row-cards mb-4">
            @foreach($subCategory->contents as $content)
                <div class="col-12 mb-3">
                    <div class="card">
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
    @endif

    {{-- Links in this SubCategory --}}
    @if($subCategory->links && $subCategory->links->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-link icon me-2"></i>
                    Links in this Category
                </h3>
            </div>
            <div class="list-group list-group-flush">
                @foreach($subCategory->links as $link)
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-link icon text-purple me-2"></i>
                                    <div>
                                        <div class="fw-bold">{{ $link->name }}</div>
                                        @if($link->description)
                                            <div class="text-muted small">{{ $link->description }}</div>
                                        @endif
                                        @if($link->url)
                                            <a href="{{ $link->url }}" 
                                               target="_blank" 
                                               class="text-primary small">
                                                <i class="ti ti-external-link icon"></i>
                                                {{ $link->url }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                @if($link->contents && $link->contents->count() > 0)
                                    <a href="{{ route('link.view', $link->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="ti ti-eye icon"></i>
                                        View Link
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty">
            <div class="empty-icon">
                <i class="ti ti-link icon"></i>
            </div>
            <p class="empty-title">No links in this category</p>
        </div>
    @endif
</div>
            </div>
        </main>

       
        @endsection