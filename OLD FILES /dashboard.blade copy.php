@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Content Hierarchy</h2>
                <div class="text-muted mt-1">View all categories and their links</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus icon"></i>
                        Main Category
                    </a>
                    <a href="{{ route('sub-categories.create') }}" class="btn btn-success">
                        <i class="ti ti-plus icon"></i>
                        Sub Category
                    </a>
                    <a href="{{ route('links.create') }}" class="btn btn-purple">
                        <i class="ti ti-plus icon"></i>
                        Link
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Categories List --}}
    @if($mainCategories && $mainCategories->count() > 0)
        <div class="row row-cards">
            @foreach($mainCategories as $mainCategory)
                <div class="col-12 mb-3">
                    <div class="card">
                        {{-- Main Category Header --}}
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-center flex-fill">
                                    <i class="ti ti-folder icon me-2 fs-1"></i>
                                    <div>
                                        <h3 class="card-title text-white mb-1">{{ $mainCategory->name }}</h3>
                                        @if($mainCategory->description)
                                            <div class="text-white-50 small">{{ $mainCategory->description }}</div>
                                        @endif
                                    </div>
                                    <span class="badge bg-primary-lt text-primary ms-3">
                                        {{ $mainCategory->subCategories->count() }} Sub Categories
                                    </span>
                                </div>
                                <a href="{{ route('main-categories.edit', $mainCategory) }}" 
                                   class="btn btn-white btn-sm ms-2"
                                   title="Edit">
                                    <i class="ti ti-edit icon"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Sub Categories --}}
                        @if($mainCategory->subCategories && $mainCategory->subCategories->count() > 0)
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($mainCategory->subCategories as $subCategory)
                                        <div class="list-group-item">
                                            {{-- Sub Category Header (Collapsible) --}}
                                            <div class="d-flex align-items-center cursor-pointer" 
                                                 onclick="toggleSubCategory({{ $subCategory->id }})"
                                                 style="cursor: pointer;">
                                                <i class="ti ti-folder icon text-success me-2 fs-2"></i>
                                                <div class="flex-fill">
                                                    <div class="fw-bold text-dark">{{ $subCategory->name }}</div>
                                                    @if($subCategory->description)
                                                        <div class="text-muted small">{{ $subCategory->description }}</div>
                                                    @endif
                                                </div>
                                                <span class="badge bg-success-lt text-success me-2">
                                                    {{ $subCategory->links->count() }} Links
                                                </span>
                                                <a href="{{ route('sub-categories.edit', $subCategory) }}" 
                                                   class="btn btn-sm btn-ghost-success me-2"
                                                   onclick="event.stopPropagation();"
                                                   title="Edit">
                                                    <i class="ti ti-edit icon"></i>
                                                </a>
                                                <i class="ti ti-chevron-down icon text-muted" 
                                                   id="arrow-{{ $subCategory->id }}"
                                                   style="transition: transform 0.3s ease;"></i>
                                            </div>

                                            {{-- Links (Collapsible Content) --}}
                                            <div id="subcategory-{{ $subCategory->id }}" class="collapse-content mt-3" style="display: none;">
                                                @if($subCategory->links && $subCategory->links->count() > 0)
                                                    <div class="list-group">
                                                        @foreach($subCategory->links as $link)
                                                            <div class="list-group-item">
                                                                <div class="d-flex align-items-start">
                                                                    <i class="ti ti-link icon text-purple me-2 mt-1"></i>
                                                                    <div class="flex-fill">
                                                                        <div class="d-flex align-items-center mb-1">
                                                                            <h4 class="mb-0 me-2">{{ $link->name }}</h4>
                                                                            @if($link->contents && $link->contents->count() > 0)
                                                                                <span class="badge bg-purple-lt text-purple">
                                                                                    {{ $link->contents->count() }} Content Blocks
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        
                                                                        @if($link->url)
                                                                            <a href="{{ $link->url }}" 
                                                                               target="_blank"
                                                                               class="text-muted small d-flex align-items-center">
                                                                                <i class="ti ti-external-link icon me-1"></i>
                                                                                {{ $link->url }}
                                                                            </a>
                                                                        @endif

                                                                        @if($link->description)
                                                                            <div class="text-muted small mt-2">{{ Str::limit($link->description, 150) }}</div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="btn-list ms-3">
                                                                        <!-- <a href="{{ route('links.show', $link) }}" 
                                                                           class="btn btn-sm btn-ghost-purple"
                                                                           title="View Contents">
                                                                            <i class="ti ti-eye icon"></i>
                                                                        </a> -->
                                                                        <a href="{{ route('link.view', $link->id) }}" 
                                                                           class="btn btn-sm btn-ghost-purple"
                                                                           title="View Contents">
                                                                            <i class="ti ti-eye icon"></i>
                                                                        </a> 
                                                                        
                                                                        <a href="{{ route('links.edit', $link) }}" 
                                                                           class="btn btn-sm btn-ghost-primary"
                                                                           title="Edit">
                                                                            <i class="ti ti-edit icon"></i>
                                                                        </a>
                                                                        <a href="{{ route('link-contents.index', $link) }}" 
                                                                           class="btn btn-sm btn-ghost-success"
                                                                           title="Add Content">
                                                                            <i class="ti ti-plus icon"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="empty">
                                                        <div class="empty-icon">
                                                            <i class="ti ti-link icon"></i>
                                                        </div>
                                                        <p class="empty-title">No links in this category yet</p>
                                                        <div class="empty-action">
                                                            <a href="{{ route('links.create') }}?sub_category={{ $subCategory->id }}" 
                                                               class="btn btn-primary">
                                                                <i class="ti ti-plus icon"></i>
                                                                Add Link
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-folder icon"></i>
                                    </div>
                                    <p class="empty-title">No sub categories yet</p>
                                    <div class="empty-action">
                                        <a href="{{ route('sub-categories.create') }}?main_category={{ $mainCategory->id }}" 
                                           class="btn btn-primary">
                                            <i class="ti ti-plus icon"></i>
                                            Add Sub Category
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="empty">
                    <div class="empty-img">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 24 24'%3E%3Cpath fill='%23d1d5db' d='M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'/%3E%3C/svg%3E" alt="">
                    </div>
                    <p class="empty-title">No Categories Yet</p>
                    <p class="empty-subtitle text-muted">
                        Get started by creating your first main category
                    </p>
                    <div class="empty-action">
                        <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus icon"></i>
                            Create Main Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function toggleSubCategory(id) {
        const content = document.getElementById('subcategory-' + id);
        const arrow = document.getElementById('arrow-' + id);
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
            arrow.style.transform = 'rotate(180deg)';
        } else {
            content.style.display = 'none';
            arrow.style.transform = 'rotate(0deg)';
        }
    }

    // Expand first sub category by default
    document.addEventListener('DOMContentLoaded', function() {
        const firstSubCategory = document.querySelector('[id^="subcategory-"]');
        if (firstSubCategory) {
            firstSubCategory.style.display = 'block';
            const id = firstSubCategory.id.replace('subcategory-', '');
            const arrow = document.getElementById('arrow-' + id);
            if (arrow) {
                arrow.style.transform = 'rotate(180deg)';
            }
        }
    });
</script>

<style>
    .bg-primary-lt {
        background-color: rgba(32, 107, 196, 0.1) !important;
    }
    .bg-success-lt {
        background-color: rgba(47, 179, 68, 0.1) !important;
    }
    .bg-purple-lt {
        background-color: rgba(174, 62, 201, 0.1) !important;
    }
    .text-purple {
        color: #ae3ec9;
    }
    .btn-purple {
        background-color: #ae3ec9;
        color: #fff;
    }
    .btn-purple:hover {
        background-color: #9c36b5;
        color: #fff;
    }
    .btn-ghost-success:hover {
        background-color: rgba(47, 179, 68, 0.1);
        color: #2fb344;
    }
    .btn-ghost-primary:hover {
        background-color: rgba(32, 107, 196, 0.1);
        color: #206bc4;
    }
    .btn-ghost-purple:hover {
        background-color: rgba(174, 62, 201, 0.1);
        color: #ae3ec9;
    }
    .fs-1 {
        font-size: 2rem !important;
    }
    .fs-2 {
        font-size: 1.5rem !important;
    }
</style>
@endsection