@extends('layouts.app')

@section('content')
 
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Content Hierarchy
                </div>
                <h2 class="page-title">
                    View all categories and pages
                </h2>
            </div> 

            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list"> 
                    <a href="{{ route('main-categories.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        Main Category
                    </a> 
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="page-body"> 
    <div class="container-xl">
 

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
                                            <span class="avatar avatar-md me-3 text-white" style="background-color: #206bc4;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-category"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 3h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z" /><path d="M20 3h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z" /><path d="M10 13h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z" /><path d="M17 13a4 4 0 1 1 -3.995 4.2l-.005 -.2l.005 -.2a4 4 0 0 1 3.995 -3.8z" /></svg>
                                            </span>
                                            <div>
                                                <h3 class="card-title mb-1">{{ $mainCategory->name }}</h3>
                                                <div class="text-muted small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                                                    {{ $mainCategory->pages->count() }} Pages
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-auto">
                                        <div class="btn-list">

                                        <a href="{{ route('main-categories.edit', $mainCategory) }}" 
                                                class="btn btn-icon btn-yellow btn-sm"
                                                onclick="event.stopPropagation();"
                                                data-bs-toggle="tooltip"
                                                title="Edit Main Category">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            </a> 

                                        @if($mainCategory->id==1) 
                                        @else 

                                            <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}" 
                                               class="btn btn-primary btn-sm"
                                               onclick="event.stopPropagation();"
                                               data-bs-toggle="tooltip"
                                               title="Create New Page">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                                Create Page
                                            </a>
                                            
                                            @endif 
                                              @if(!$mainCategory->is_approved)
                                                
                                                
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="ti ti-check"></i> Approve
                                                    </button> 
                                            @else
                                                
                                                    <button type="submit" class="btn btn-warning btn-sm"  >
                                                        <i class="ti ti-x"></i> Unapprove
                                                    </button>                                         
                                                @if(!$mainCategory->is_published)
                                                   
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="ti ti-world"></i> Publish
                                                        </button> 
                                                @else 
                                                        <button type="submit" class="btn btn-secondary btn-sm">
                                                            <i class="ti ti-world-off"></i> Unpublish
                                                        </button> 
                                                @endif
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
                                         role="button">
                                        <span class="avatar avatar-sm me-3 text-white" style="background-color: #2fb344;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folders"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
                                        </span>
                                        <div>
                                            <h4 class="mb-1">{{ $page->name }}</h4>
                                            <div class="text-muted small">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                {{ $page->children->count() }} Child Pages
                                                @if($page->contents && $page->contents->count() > 0)
                                                    • {{ $page->contents->count() }} Content Blocks
                                                @endif 
                                            </div> 
                                        </div>
                                    </div>
                                @else
                                    {{-- Single page - not clickable --}}
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                        </span>
                                        <div>
                                            <h4 class="mb-1">{{ $page->name }}</h4>
                                            <div class="text-muted small">
                                                @if($page->contents && $page->contents->count() > 0)
                                                    {{ $page->contents->count() }} Content Blocks
                                                @else
                                                    No content blocks
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <div class="btn-list">
                                    {{-- View Public Page --}}
                                    @if(!$page->has_children)
                                    <a href="{{ route('content.show', ['page', $page->id]) }}" 
                                        class="btn btn-icon btn-cyan btn-sm"
                                        target="_blank" rel="noopener noreferrer"
                                        onclick="event.stopPropagation();"
                                        data-bs-toggle="tooltip"
                                        title="View Public Page">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                    </a> 
                                    @endif
                                    
                                    {{-- Manage Content Blocks --}}
                                    @if(!$page->has_children)
                                    <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $page->id]) }}" 
                                       class="btn btn-icon btn-indigo btn-sm"
                                       onclick="event.stopPropagation();"
                                       data-bs-toggle="tooltip"
                                       title="Manage Content Blocks">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                    </a> 
                                    @endif

                                    {{-- Edit Page --}} 
                                    <a href="{{ route('pages.edit', $page) }}" 
                                       class="btn btn-icon btn-yellow btn-sm"
                                       onclick="event.stopPropagation();"
                                       data-bs-toggle="tooltip"
                                       title="Edit Page">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    </a> 

                                    {{-- Create Child Page (only if has_children is true) --}}
                                    @if($page->has_children)
                                        <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                           class="btn btn-icon btn-success btn-sm"
                                           onclick="event.stopPropagation();"
                                           data-bs-toggle="tooltip"
                                           title="Create Child Page">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                        </a>
                                    @endif

                                    
                                   


                                    <div class="btn-group" role="group">
    @if(!$page->is_approved)
        {{-- Show Approve Button --}} 
            <button type="submit" class="btn btn-success btn-sm">
                <i class="ti ti-check"></i> Approve
            </button> 
    @else 
            <button type="submit" class="btn btn-warning btn-sm"  >
                <i class="ti ti-x"></i> Unapprove
            </button> 

        {{-- Show Publish/Unpublish Buttons --}}
        @if(!$page->is_published) 
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-world"></i> Publish
                </button> 
        @else 
                <button type="submit" class="btn btn-secondary btn-sm">
                    <i class="ti ti-world-off"></i> Unpublish
                </button> 
        @endif
    @endif
</div>


                                    {{-- Toggle Arrow (only if has children) --}}
                                    <!-- @if($page->has_children && $page->children->count() > 0)
                                        <button class="btn btn-icon btn-ghost-secondary btn-sm" 
                                                onclick="togglePage({{ $page->id }}); event.stopPropagation();" 
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                title="Toggle Child Pages">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" id="arrow-{{ $page->id }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                        </button>
                                    @endif -->
                                </div>
                            </div>
                        </div>

                        {{-- Child Pages --}}
                        <div id="page-{{ $page->id }}" class="mt-3 d-none">
                            @if($page->children && $page->children->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($page->children as $childPage)
                                        {{-- Child Page Item --}}
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                                        </span>
                                                        <div>
                                                            <div class="fw-bold">{{ $childPage->name }}</div>
                                                            <div class="text-muted small">
                                                                @if($childPage->contents && $childPage->contents->count() > 0)
                                                                    {{ $childPage->contents->count() }} Content Blocks
                                                                @else
                                                                    No content blocks
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="btn-list">
                                                        <a href="{{ route('content.show', ['page', $childPage->id]) }}" 
                                                            class="btn btn-icon btn-cyan btn-sm"
                                                            target="_blank" rel="noopener noreferrer"
                                                            data-bs-toggle="tooltip"
                                                            title="View Public Page">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                        </a>
                                                     
                                                        <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $childPage->id]) }}" 
                                                           class="btn btn-icon btn-indigo btn-sm"
                                                           data-bs-toggle="tooltip"
                                                           title="Manage Content Blocks">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                        </a>

                                                        <a href="{{ route('pages.edit', $childPage) }}" 
                                                           class="btn btn-icon btn-yellow btn-sm"
                                                           data-bs-toggle="tooltip"
                                                           title="Edit Page">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                        </a>

                                                        <div class="btn-group" role="group">
    @if(!$page->is_approved) 
            <button type="submit" class="btn btn-success btn-sm">
                <i class="ti ti-check"></i> Approve
            </button> 
    @else 
            <button type="submit" class="btn btn-warning btn-sm"  >
                <i class="ti ti-x"></i> Unapprove
            </button> 
 
        @if(!$page->is_published) 
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-world"></i> Publish
                </button> 
        @else 
                <button type="submit" class="btn btn-secondary btn-sm">
                    <i class="ti ti-world-off"></i> Unpublish
                </button> 
        @endif
    @endif
</div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                    </div>
                                    <p class="empty-title">No child pages yet</p>
                                    <p class="empty-subtitle text-muted">
                                        Add a child page under this page
                                    </p>
                                    <div class="empty-action">
                                        <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                           class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                            Add Child Page
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
        {{-- No Pages Yet --}}
        <div class="empty">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
            </div>
            <p class="empty-title">No pages yet</p>
            <p class="empty-subtitle text-muted">
                Create pages to organize your content
            </p>
            <div class="empty-action">
                <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}" 
                   class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Page
                </a>
            </div>
        </div>
    @endif
</div>
                            <!-- <div class="card-body">
                                @if($mainCategory->pages && $mainCategory->pages->count() > 0)
                                    <div class="divide-y">
                                        @foreach($mainCategory->pages as $page)
                                            {{-- Page Card --}}
                                            <div class="card card-sm mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            @if($page->has_children && $page->children->count() > 0)
                                                                {{-- Page with children - clickable --}}
                                                                <div class="d-flex align-items-center" 
                                                                     onclick="togglePage({{ $page->id }})"
                                                                     role="button">
                                                                    <span class="avatar avatar-sm me-3 text-white" style="background-color: #2fb344;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folders"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
                                                                    </span>
                                                                    <div>
                                                                        <h4 class="mb-1">{{ $page->name }}</h4>
                                                                        <div class="text-muted small">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                            {{ $page->children->count() }} Child Pages
                                                                            @if($page->contents && $page->contents->count() > 0)
                                                                                • {{ $page->contents->count() }} Content Blocks
                                                                            @endif 
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            @else
                                                                {{-- Single page - not clickable --}}   
                                                                @if(!$page->parent_id)
                                                                sdf
                                                                @endif                                                            
                                                                <div class="d-flex align-items-center">
                                                                    <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                                                    </span>
                                                                    <div>
                                                                        <h4 class="mb-1">{{ $page->name }}</h4>
                                                                        <div class="text-muted small">
                                                                            @if($page->contents && $page->contents->count() > 0)
                                                                                {{ $page->contents->count() }} Content Blocks
                                                                            @else
                                                                                No content blocks
                                                                            @endif 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="btn-list">
                                                                {{-- View Public Page --}}
                                                                <a href="{{ route('content.show', ['page', $page->id]) }}" 
                                                                    class="btn btn-icon btn-cyan btn-sm"
                                                                    target="_blank" rel="noopener noreferrer"
                                                                    onclick="event.stopPropagation();"
                                                                    data-bs-toggle="tooltip"
                                                                    title="View Public Page">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                </a> 
                                                                
                                                                {{-- Manage Content Blocks --}}
                                                                @if(!$page->has_children)
                                                                <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $page->id]) }}" 
                                                                   class="btn btn-icon btn-indigo btn-sm"
                                                                   onclick="event.stopPropagation();"
                                                                   data-bs-toggle="tooltip"
                                                                   title="Manage Content Blocks">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                </a> 
                                                                @endif

                                                                {{-- Create Child Page (only if has_children is true) --}}
                                                                @if($page->has_children)
                                                                    <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                                                       class="btn btn-icon btn-success btn-sm"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="Create Child Page">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                                                    </a>
                                                                @endif

                                                                {{-- Edit Page --}}
                                                                <a href="{{ route('pages.edit', $page) }}" 
                                                                   class="btn btn-icon btn-yellow btn-sm"
                                                                   onclick="event.stopPropagation();"
                                                                   data-bs-toggle="tooltip"
                                                                   title="Edit Page">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                                </a>

                                                                {{-- Toggle Arrow (only if has children) --}}
                                                                @if($page->has_children && $page->children->count() > 0)
                                                                    <button class="btn btn-icon btn-ghost-secondary btn-sm" 
                                                                            onclick="togglePage({{ $page->id }}); event.stopPropagation();" 
                                                                            type="button"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Toggle Child Pages">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" id="arrow-{{ $page->id }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Child Pages --}}
                                                    <div id="page-{{ $page->id }}" class="mt-3 d-none">
                                                        @if($page->children && $page->children->count() > 0)
                                                            <div class="list-group list-group-flush">
                                                                @foreach($page->children as $childPage)
                                                                    {{-- Child Page Item --}}
                                                                    <div class="list-group-item">
                                                                        <div class="row align-items-center">
                                                                            <div class="col">
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                                                                    </span>
                                                                                    <div>
                                                                                        <div class="fw-bold">{{ $childPage->name }}</div>
                                                                                        <div class="text-muted small">
                                                                                            @if($childPage->contents && $childPage->contents->count() > 0)
                                                                                                {{ $childPage->contents->count() }} Content Blocks
                                                                                            @else
                                                                                                No content blocks
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <div class="btn-list">
                                                                                    <a href="{{ route('content.show', ['page', $childPage->id]) }}" 
                                                                                        class="btn btn-icon btn-cyan btn-sm"
                                                                                        target="_blank" rel="noopener noreferrer"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="View Public Page">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                                    </a>
                                                                                 
                                                                                    <a href="{{ route('page-contents.index', ['type' => 'page', 'id' => $childPage->id]) }}" 
                                                                                       class="btn btn-icon btn-indigo btn-sm"
                                                                                       data-bs-toggle="tooltip"
                                                                                       title="Manage Content Blocks">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                                    </a>

                                                                                    <a href="{{ route('pages.edit', $childPage) }}" 
                                                                                       class="btn btn-icon btn-yellow btn-sm"
                                                                                       data-bs-toggle="tooltip"
                                                                                       title="Edit Page">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="empty">
                                                                <div class="empty-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                                                </div>
                                                                <p class="empty-title">No child pages yet</p>
                                                                <p class="empty-subtitle text-muted">
                                                                    Add a child page under this page
                                                                </p>
                                                                <div class="empty-action">
                                                                    <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}&parent_id={{ $page->id }}" 
                                                                       class="btn btn-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                                        Add Child Page
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
                                    {{-- No Pages Yet --}}
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                        </div>
                                        <p class="empty-title">No pages yet</p>
                                        <p class="empty-subtitle text-muted">
                                            Create pages to organize your content
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('pages.create') }}?main_category={{ $mainCategory->id }}" 
                                               class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                Add Page
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div> -->
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- No Main Categories --}}
            <div class="card">
                <div class="empty">
                    <div class="empty-img">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 24 24'%3E%3Cpath fill='%23d1d5db' d='M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'/%3E%3C/svg%3E" 
                             alt="No categories" 
                             height="120">
                    </div>
                    <p class="empty-title">No categories yet</p>
                    <p class="empty-subtitle text-muted">
                        Get started by creating a main category to organize your content
                    </p>
                    <div class="empty-action">
                        <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Create Main Category
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
function togglePage(id) {
    const content = document.getElementById('page-' + id);
    const arrow = document.getElementById('arrow-' + id);
    
    if (content.classList.contains('d-none')) {
        content.classList.remove('d-none');
        // Change arrow to up
        arrow.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" />';
    } else {
        content.classList.add('d-none');
        // Change arrow to down
        arrow.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" />';
    }
}

// Initialize tooltips and optionally expand first page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection