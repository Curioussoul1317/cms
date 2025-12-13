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
                                                    {{ $mainCategory->subCategories->count() }} Sub Categories
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

                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Create New
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item btn-sm" href="{{ route('sub-categories.create') }}?main_category={{ $mainCategory->id }}&type=Page"
                                                        onclick="event.stopPropagation();"
                                                        data-bs-toggle="tooltip"
                                                        title="Create Sub Category">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8h16" /><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /></svg>
                                                        Page
                                                    </a>
                                                    <a class="dropdown-item btn-sm" href="{{ route('sub-categories.create') }}?main_category={{ $mainCategory->id }}&type=SubCateogory"
                                                        onclick="event.stopPropagation();"
                                                        data-bs-toggle="tooltip"
                                                        title="Create Sub Category"> 
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                                                        Sub-Category
                                                    </a>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Sub Categories --}}
                            <div class="card-body">
                                @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)
                                    <div class="divide-y">
                                        @foreach($mainCategory->subCategories as $subCategory)
                                            {{-- Sub Category Card --}}
                                            <div class="card card-sm mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                        @if($subCategory->subtype=="Page")
                                                        <div class="d-flex align-items-center"  >
                                                        <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-browser"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8h16" /><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M8 4v4" /></svg>
                                                                                    </span>
                                                        @else
                                                        <div class="d-flex align-items-center" 
                                                                 onclick="toggleSubCategory({{ $subCategory->id }})"
                                                                 role="button">
                                                                 <span class="avatar avatar-sm me-3 text-white" style="background-color: #2fb344;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                                                                </span>
                                                        @endif                                                            
                                                               
                                                                <div>
                                                                    <h4 class="mb-1">{{ $subCategory->name }}</h4>
                                                                    <div class="text-muted small">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                        {{ $subCategory->links->count() }} Pages
                                                                        @if($subCategory->contents && $subCategory->contents->count() > 0)
                                                                            • {{ $subCategory->contents->count() }} Content Blocks
                                                                        @endif 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="btn-list">
                                                                @if($subCategory->subtype=="Page")
                                                                <a href="{{ route('content.show', ['subcategory', $subCategory->id]) }}" 
                                                                        class="btn btn-icon btn-cyan  btn-sm "
                                                                        target="_blank" rel="noopener noreferrer"
                                                                        onclick="event.stopPropagation();"
                                                                        data-bs-toggle="tooltip"
                                                                        title="View Public Page">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                    </a> 
                                                                    
                                                                     
                                                                    <a href="{{ route('link-contents.index', ['type' => 'sub-category', 'id' => $subCategory->id]) }}" 
                                                                       class="btn btn-icon btn-indigo btn-sm"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="Manage Content Blocks">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                    </a>
                                                                @else
 
                                                                    <a href="{{ route('links.create') }}?sub_category={{ $subCategory->id }}" 
                                                                       class="btn btn-icon btn-indigo btn-sm"
                                                                       onclick="event.stopPropagation();"
                                                                       data-bs-toggle="tooltip"
                                                                       title="Create New Page"> 
                                                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                                                    </a>  
                                                                    
                                                                @endif







  
                                                             

                                                             

                                                                <a href="{{ route('sub-categories.edit', $subCategory) }}" 
                                                                   class="btn btn-icon btn-yellow btn-sm"
                                                                   onclick="event.stopPropagation();"
                                                                   data-bs-toggle="tooltip"
                                                                   title="Edit Sub Category">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                                </a>

                                                                <!-- @if($subCategory->links->count() > 0)                                                  
                                                                    <button class="btn btn-icon btn-success" 
                                                                            onclick="toggleSubCategory({{ $subCategory->id }})" 
                                                                            type="button"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Toggle Pages">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" id="arrow-{{ $subCategory->id }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                                                    </button> 
                                                                @endif -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                   
                                                    <div id="subcategory-{{ $subCategory->id }}" class="mt-3 d-none">
                                                        @if($subCategory->links && $subCategory->links->count() > 0)
                                                            <div class="list-group list-group-flush">
                                                                @foreach($subCategory->links as $link)
                                                                    {{-- Link Item --}}
                                                                    <div class="list-group-item">
                                                                        <div class="row align-items-center">
                                                                            <div class="col">
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="avatar avatar-sm me-3 text-white" style="background-color: #4299e1;">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-browser"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8h16" /><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M8 4v4" /></svg>
                                                                                    </span>
                                                                                    <div>
                                                                                        <div class="fw-bold">{{ $link->title }}</div>
                                                                                        <div class="text-muted small">
                                                                                            @if($link->contents && $link->contents->count() > 0)
                                                                                                {{ $link->contents->count() }} Content Blocks
                                                                                            @else
                                                                                                No content blocks
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <div class="btn-list">
                                                                                    <a href="{{ route('content.show', ['link', $link->id]) }}" 
                                                                                        class="btn btn-icon btn-cyan btn-sm"
                                                                                        target="_blank" rel="noopener noreferrer"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="View Public Page">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                                                    </a>
                                                                                 
                                                                                    <a href="{{ route('link-contents.index', ['type' => 'link', 'id' => $link->id]) }}" 
                                                                                       class="btn btn-icon btn-indigo btn-sm"
                                                                                       data-bs-toggle="tooltip"
                                                                                       title="Manage Content Blocks">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M4 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M14 14m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /></svg>
                                                                                    </a>
                                                                                    <!-- <a href="{{ route('link-contents.create', ['type' => 'link', 'id' => $link->id]) }}" 
                                                                                       class="btn btn-icon btn-info"
                                                                                       data-bs-toggle="tooltip"
                                                                                       title="Add Content Block">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                                                    </a> -->
                                                                                    <a href="{{ route('links.edit', $link) }}" 
                                                                                       class="btn btn-icon btn-yellow btn-sm"
                                                                                       data-bs-toggle="tooltip"
                                                                                       title="Edit Link">
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
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                                                </div>
                                                                <p class="empty-title">No Pages yet</p>
                                                                <p class="empty-subtitle text-muted">
                                                                    Add a page to this sub category
                                                                </p>
                                                                <div class="empty-action">
                                                                    <a href="{{ route('links.create') }}?sub_category={{ $subCategory->id }}" 
                                                                       class="btn btn-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
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
                                   
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" /><path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
                                        </div>
                                        <p class="empty-title">No sub categories yet</p>
                                        <p class="empty-subtitle text-muted">
                                            Create sub categories to organize your links
                                        </p>
                                        <div class="empty-action">
                                            <a href="{{ route('sub-categories.create') }}?main_category={{ $mainCategory->id }}" 
                                               class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                Add Sub Category
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
           
            <div class="card">
                <div class="empty">
                    <div class="empty-img">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 24 24'%3E%3Cpath fill='%23d1d5db' d='M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'/%3E%3C/svg%3E" 
                             alt="No categories" 
                             height="120">
                    </div>
                    <p class="empty-title">No categories yet</p>
                    <p class="empty-subtitle text-muted">
                        Get started by creating main category to organize your content
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
function toggleSubCategory(id) {
    const content = document.getElementById('subcategory-' + id);
    const arrow = document.getElementById('arrow-' + id);
    
    if (content.classList.contains('d-none')) {
        content.classList.remove('d-none');
 
        arrow.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" />';
    } else {
        content.classList.add('d-none');
   
        arrow.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" />';
    }
}

 
document.addEventListener('DOMContentLoaded', function() {
 
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

 
    const firstSubCategory = document.querySelector('[id^="subcategory-"]');
    if (firstSubCategory) {
        firstSubCategory.classList.remove('d-none');
        const id = firstSubCategory.id.replace('subcategory-', '');
        const arrow = document.getElementById('arrow-' + id);
        if (arrow) {
            arrow.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" />';
        }
    }
});
</script>

@endsection