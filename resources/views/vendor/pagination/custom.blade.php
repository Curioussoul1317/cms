<style>
 
/* Pagination Container */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
    padding: 20px 0;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

/* All Pagination Items */
.pagination li {
    display: inline-flex;
}

.pagination li a,
.pagination li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

/* Normal Page Links */
.pagination li a {
    background-color: #ffffff;
    color: #555;
    border: 1px solid #e5e5e5;
}

.pagination li a:hover {
    background-color: #1CEAB9;
    border-color: #1CEAB9;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 234, 185, 0.3);
}

/* Active Page */
.pagination li.active span,
.pagination li span[aria-current="page"] {
    background-color: #1CEAB9;
    border: 1px solid #1CEAB9;
    color: #ffffff;
    font-weight: 600;
}

/* Disabled State (Previous/Next when not available) */
.pagination li.disabled span,
.pagination li span[aria-disabled="true"] {
    background-color: #f5f5f5;
    border: 1px solid #e5e5e5;
    color: #ccc;
    cursor: not-allowed;
}

/* Previous & Next Arrows */
.pagination li:first-child a,
.pagination li:last-child a,
.pagination li:first-child span,
.pagination li:last-child span {
    font-size: 1.1rem;
}

/* Dots/Ellipsis */
.pagination li span.dots,
.pagination li.disabled span:not([aria-disabled]) {
    background: transparent;
    border: none;
    color: #999;
}


/* ============================================
   STYLE VARIANT 2: ROUNDED/PILL STYLE
   ============================================ */

.pagination.pagination-rounded li a,
.pagination.pagination-rounded li span {
    border-radius: 50px;
}


/* ============================================
   STYLE VARIANT 3: MINIMAL STYLE
   ============================================ */

.pagination.pagination-minimal li a,
.pagination.pagination-minimal li span {
    background: transparent;
    border: none;
    color: #666;
    min-width: 36px;
    height: 36px;
}

.pagination.pagination-minimal li a:hover {
    background-color: rgba(28, 234, 185, 0.1);
    color: #1CEAB9;
    transform: none;
    box-shadow: none;
}

.pagination.pagination-minimal li.active span,
.pagination.pagination-minimal li span[aria-current="page"] {
    background-color: #1CEAB9;
    color: #ffffff;
    border-radius: 8px;
}


/* ============================================
   STYLE VARIANT 4: OUTLINE STYLE
   ============================================ */

.pagination.pagination-outline li a {
    background: transparent;
    border: 2px solid #e5e5e5;
    color: #555;
}

.pagination.pagination-outline li a:hover {
    background: transparent;
    border-color: #1CEAB9;
    color: #1CEAB9;
    transform: none;
    box-shadow: none;
}

.pagination.pagination-outline li.active span,
.pagination.pagination-outline li span[aria-current="page"] {
    background: transparent;
    border: 2px solid #1CEAB9;
    color: #1CEAB9;
}


/* ============================================
   SIMPLE PREV/NEXT ONLY STYLE
   ============================================ */

.pagination-simple {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 40px;
}

.pagination-simple a,
.pagination-simple span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination-simple a {
    background-color: #ffffff;
    color: #555;
    border: 1px solid #e5e5e5;
}

.pagination-simple a:hover {
    background-color: #1CEAB9;
    border-color: #1CEAB9;
    color: #ffffff;
}

.pagination-simple span.disabled {
    background-color: #f5f5f5;
    border: 1px solid #e5e5e5;
    color: #ccc;
    cursor: not-allowed;
}

.pagination-simple .page-info {
    font-size: 0.9rem;
    color: #666;
}

 

@media (max-width: 576px) {
    .pagination {
        gap: 4px;
    }

    .pagination li a,
    .pagination li span {
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        font-size: 0.85rem;
    }

    /* Hide some page numbers on mobile */
    .pagination li:not(:first-child):not(:last-child):not(.active) {
        display: none;
    }

    /* Show dots and active */
    .pagination li.active,
    .pagination li.disabled {
        display: inline-flex;
    }

    .pagination-simple {
        gap: 10px;
    }

    .pagination-simple a,
    .pagination-simple span {
        padding: 10px 16px;
        font-size: 0.85rem;
    }

    .pagination-simple .page-info {
        display: none;
    }
}
</style> 



@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span aria-disabled="true">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled">
                        <span class="dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <span aria-current="page">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span aria-disabled="true">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif