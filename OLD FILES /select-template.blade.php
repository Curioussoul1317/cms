{{-- resources/views/link-contents/select-template.blade.php --}}
@extends('layouts.app')

@section('title', 'Select Template')

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
                        <li class="breadcrumb-item">
                            <a href="{{ route('link-contents.index', $link) }}">{{ $link->title }}</a>
                        </li>
                        <li class="breadcrumb-item active">Select Template</li>
                    </ol>
                </nav>
                <h2 class="page-title">Select a Template</h2>
                <div class="text-muted mt-1">Choose from our pre-built templates to add content to your link</div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @foreach($templates as $key => $template)
        <div class="col">
            <a href="{{ route('link-contents.create', ['link' => $link, 'template' => $key]) }}" class="card card-link card-link-pop text-decoration-none">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="{{ $template['icon'] }} icon" style="font-size: 4rem; color: var(--tblr-primary);"></i>
                    </div>
                    <h3 class="card-title mb-2">{{ $template['name'] }}</h3>
                    <p class="text-muted small mb-0">{{ $template['description'] }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('link-contents.index', $link) }}" class="btn btn-ghost-secondary">
            <i class="ti ti-arrow-left icon"></i>
            Back to Content List
        </a>
    </div>
</div>
@endsection