@extends('layouts.app')

@section('title', 'Content Hierarchy')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">CMS</div>
                <h2 class="page-title">Content Hierarchy</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('main-categories.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Main Category
                    </a>
                    <a href="{{ route('main-categories.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Main Category">
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

        @if($mainCategories && $mainCategories->count() > 0)
            <div class="row row-deck row-cards">
                @foreach($mainCategories as $mainCategory)
                    <div class="col-12">
                        <div class="card">
                            {{-- Main Category Header --}}
                            <div class="card-header">
                                <div class="row align-items-center w-100">
                                    <div class="col">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-md bg-primary text-white me-3">
                                                <i class="ti ti-category"></i>
                                            </span>
                                            <div>
                                                <h3 class="card-title mb-1">{{ $mainCategory->name }}</h3>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-secondary small">
                                                        <i class="ti ti-folder me-1"></i>
                                                        {{ $mainCategory->pages->count() }} Pages
                                                    </span>
                                                    {{-- Status Badges --}}
                                                    @if($mainCategory->is_approved)
                                                        <span class="badge bg-green-lt">
                                                            <i class="ti ti-check me-1"></i>Approved
                                                        </span>
                                                    @else
                                                        <span class="badge bg-yellow-lt">
                                                            <i class="ti ti-clock me-1"></i>Pending
                                                        </span>
                                                    @endif
                                                    @if($mainCategory->is_published)
                                                        <span class="badge bg-blue-lt">
                                                            <i class="ti ti-world me-1"></i>Published
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary-lt">
                                                            <i class="ti ti-world-off me-1"></i>Draft
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="btn-list">
                                            <a href="{{ route('main-categories.edit', $mainCategory) }}" 
                                               class="btn btn-icon btn-ghost-warning btn-sm"
                                               onclick="event.stopPropagation();"
                                               data-bs-toggle="tooltip"
                                               title="Edit Main Category">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            @if($mainCategory->id != 1)
                                                <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}" 
                                                   class="btn btn-primary btn-sm"
                                                   onclick="event.stopPropagation();"
                                                   data-bs-toggle="tooltip"
                                                   title="Create New Page">
                                                    <i class="ti ti-plus me-1"></i>
                                                    Create Page
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pages --}}
                            <div class="card-body">
                                @if($mainCategory->pages && $mainCategory->pages->whereNull('parent_id')->count() > 0)
                                    <div class="divide-y">
                                        @foreach($mainCategory->pages->whereNull('parent_id') as $page)
                                            {{-- Page Card --}}
                                            <div class="card card-sm mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            @if($page->has_children)
                                                                {{-- Page with children - clickable --}}
                                                                <div class="d-flex align-items-center" 
                                                                     onclick="togglePage({{ $page->id }})"
                                                                     role="button"
                                                                     style="cursor: pointer;">
                                                                    <span class="avatar avatar-sm bg-green text-white me-3">
                                                                        <i class="ti ti-folders"></i>
                                                                    </span>
                                                                    <div class="flex-fill">
                                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                                            <h4 class="mb-0">{{ $page->name }}</h4>
                                                                            {{-- Status Badges --}}
                                                                            @if($page->is_approved)
                                                                                <span class="badge bg-green-lt badge-sm">Approved</span>
                                                                            @else
                                                                                <span class="badge bg-yellow-lt badge-sm">Pending</span>
                                                                            @endif
                                                                            @if($page->is_published)
                                                                                <span class="badge bg-blue-lt badge-sm">Published</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-secondary small">
                                                                            <i class="ti ti-file-text me-1"></i>
                                                                            {{ $page->children->count() }} Child Pages
                                                                            @if($page->contents && $page->contents->count() > 0)
                                                                                <span class="mx-1">•</span>
                                                                                {{ $page->contents->count() }} Content Blocks
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <i class="ti ti-chevron-down ms-2" id="arrow-{{ $page->id }}"></i>
                                                                </div>
                                                            @else
                                                                {{-- Single page - not clickable --}}
                                                                <div class="d-flex align-items-center">
                                                                    <span class="avatar avatar-sm bg-azure text-white me-3">
                                                                        <i class="ti ti-file"></i>
                                                                    </span>
                                                                    <div>
                                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                                            <h4 class="mb-0">{{ $page->name }}</h4>
                                                                            {{-- Status Badges --}}
                                                                            @if($page->is_approved)
                                                                                <span class="badge bg-green-lt badge-sm">Approved</span>
                                                                            @else
                                                                                <span class="badge bg-yellow-lt badge-sm">Pending</span>
                                                                            @endif
                                                                            @if($page->is_published)
                                                                                <span class="badge bg-blue-lt badge-sm">Published</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-secondary small">
                                                                            @if($page->contents && $page->contents->count() > 0)
                                                                                <i class="ti ti-layout-list me-1"></i>
                                                                                {{ $page->contents->count() }} Content Blocks
                                                                            @else
                                                                                <span class="text-muted">No content blocks</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="btn-list flex-nowrap">
                                                                {{-- View Public Page --}}
                                                                @if(!$page->has_children)
                                                                    <a href="{{ route('content.show', ['page', $page->id]) }}" 
                                                                       class="btn btn-icon btn-ghost-cyan btn-sm"
                                                                       target="_blank" 
                                                                       rel="noopener noreferrer"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="View Public Page">
                                                                        <i class="ti ti-eye"></i>
                                                                    </a>
                                                                @endif
                                                                
                                                                {{-- Manage Content Blocks --}}
                                                                @if(!$page->has_children)
                                                                    <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $page->id]) }}" 
                                                                       class="btn btn-icon btn-ghost-indigo btn-sm"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="Manage Content Blocks">
                                                                        <i class="ti ti-layout-grid"></i>
                                                                    </a>
                                                                @endif

                                                                {{-- Edit Page --}}
                                                                <a href="{{ route('pages.edit', $page) }}" 
                                                                   class="btn btn-icon btn-ghost-warning btn-sm"
                                                                   onclick="event.stopPropagation();"
                                                                   data-bs-toggle="tooltip"
                                                                   title="Edit Page">
                                                                    <i class="ti ti-edit"></i>
                                                                </a>

                                                                {{-- Create Child Page (only if has_children is true) --}}
                                                                @if($page->has_children)
                                                                    <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                                                       class="btn btn-icon btn-ghost-success btn-sm"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="Create Child Page">
                                                                        <i class="ti ti-plus"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Child Pages (collapsible) --}}
                                                    @if($page->has_children)
                                                        <div id="page-{{ $page->id }}" class="mt-3 d-none">
                                                            @if($page->children && $page->children->count() > 0)
                                                                <div class="list-group list-group-flush">
                                                                    @foreach($page->children as $childPage)
                                                                        <div class="list-group-item bg-light">
                                                                            <div class="row align-items-center">
                                                                                <div class="col">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <span class="avatar avatar-sm bg-azure text-white me-3">
                                                                                            <i class="ti ti-file"></i>
                                                                                        </span>
                                                                                        <div>
                                                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                                                <div class="fw-bold">{{ $childPage->name }}</div>
                                                                                                {{-- Status Badges --}}
                                                                                                @if($childPage->is_approved)
                                                                                                    <span class="badge bg-green-lt badge-sm">Approved</span>
                                                                                                @else
                                                                                                    <span class="badge bg-yellow-lt badge-sm">Pending</span>
                                                                                                @endif
                                                                                                @if($childPage->is_published)
                                                                                                    <span class="badge bg-blue-lt badge-sm">Published</span>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div class="text-secondary small">
                                                                                                @if($childPage->contents && $childPage->contents->count() > 0)
                                                                                                    <i class="ti ti-layout-list me-1"></i>
                                                                                                    {{ $childPage->contents->count() }} Content Blocks
                                                                                                @else
                                                                                                    <span class="text-muted">No content blocks</span>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <div class="btn-list flex-nowrap">
                                                                                        <a href="{{ route('content.show', ['page', $childPage->id]) }}" 
                                                                                           class="btn btn-icon btn-ghost-cyan btn-sm"
                                                                                           target="_blank" 
                                                                                           rel="noopener noreferrer"
                                                                                           data-bs-toggle="tooltip"
                                                                                           title="View Public Page">
                                                                                            <i class="ti ti-eye"></i>
                                                                                        </a>
                                                                                        <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $childPage->id]) }}" 
                                                                                           class="btn btn-icon btn-ghost-indigo btn-sm"
                                                                                           data-bs-toggle="tooltip"
                                                                                           title="Manage Content Blocks">
                                                                                            <i class="ti ti-layout-grid"></i>
                                                                                        </a>
                                                                                        <a href="{{ route('pages.edit', $childPage) }}" 
                                                                                           class="btn btn-icon btn-ghost-warning btn-sm"
                                                                                           data-bs-toggle="tooltip"
                                                                                           title="Edit Page">
                                                                                            <i class="ti ti-edit"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="empty py-4">
                                                                    <div class="empty-icon">
                                                                        <i class="ti ti-file-off" style="font-size: 2rem;"></i>
                                                                    </div>
                                                                    <p class="empty-title">No child pages yet</p>
                                                                    <p class="empty-subtitle text-secondary">
                                                                        Add a child page under this page
                                                                    </p>
                                                                    <div class="empty-action">
                                                                        <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                                                           class="btn btn-primary btn-sm">
                                                                            <i class="ti ti-plus me-1"></i>
                                                                            Add Child Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {{-- No Pages Yet --}}
                                    <div class="empty py-4">
                                        <div class="empty-icon">
                                            <i class="ti ti-file-off" style="font-size: 2rem;"></i>
                                        </div>
                                        <p class="empty-title">No pages yet</p>
                                        <p class="empty-subtitle text-secondary">
                                            Create pages to organize your content
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}" 
                                               class="btn btn-primary">
                                                <i class="ti ti-plus me-1"></i>
                                                Add Page
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- No Main Categories --}}
            <div class="card">
                <div class="card-body">
                    <div class="empty py-5">
                        <div class="empty-icon">
                            <i class="ti ti-folder-off" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No categories yet</p>
                        <p class="empty-subtitle text-secondary">
                            Get started by creating a main category to organize your content
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Create Main Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePage(id) {
        const content = document.getElementById('page-' + id);
        const arrow = document.getElementById('arrow-' + id);
        
        if (content.classList.contains('d-none')) {
            content.classList.remove('d-none');
            arrow.classList.remove('ti-chevron-down');
            arrow.classList.add('ti-chevron-up');
        } else {
            content.classList.add('d-none');
            arrow.classList.remove('ti-chevron-up');
            arrow.classList.add('ti-chevron-down');
        }
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush