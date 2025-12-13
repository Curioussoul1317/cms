{{-- resources/views/link-view/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sdfsdf</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
    }
    
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    /* Center Navigation Items */
    .navbar-nav {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    /* Navigation Dropdown Styles - Full Width */
    .nav-dropdown {
        position: static;
    }
    
    .nav-dropdown-menu {
        display: none;
        position: fixed;
        top: 73px;
        left: 0;
        right: 0;
        width: 100vw;
        background: white;
        border: none;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        border-radius: 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 40px 0;
        margin-top: 0;
        z-index: 1050;
        max-height: 80vh;
        overflow-y: auto;
        animation: fadeInDown 0.3s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .nav-dropdown:hover .nav-dropdown-menu,
    .nav-dropdown-menu:hover {
        display: block;
    }
    
    /* Dropdown Content Container */
    .nav-dropdown-menu > .row {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Navigation Links */
    .nav-link {
        color: #495057;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .nav-link:hover {
        color: #0054a6;
        background-color: transparent;
        border-radius: 0;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: linear-gradient(135deg, #1fe9ba 0%, #1dc8e1 100%);
        transition: width 0.3s ease;
    }
    
    .nav-link:hover::after {
        width: 80%;
    }
    
    .nav-link.active {
        color: #0054a6;
        background-color: transparent;
        border-radius: 0;
    }
    
    .nav-link.active::after {
        width: 80%;
    }
    
    .nav-item.nav-dropdown:hover .nav-link i {
        transform: rotate(180deg);
    }
    
    .nav-link i {
        transition: transform 0.3s ease;
    }
    
    /* Subcategory Cards */
    .subcategory-card {
        transition: all 0.3s ease;
        cursor: default;
        border: 1px solid #e9ecef;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }
    
    .subcategory-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        transform: translateY(-4px);
        border-color: #667eea;
    }
    
    .subcategory-header {
        background: linear-gradient(135deg, #1fe9ba 0%, #1dc8e1 100%);
        color: white;
        padding: 16px 20px;
    }
    
    .subcategory-header h4 {
        font-size: 1rem;
        font-weight: 600;
    }
    
    .badge-count {
        font-size: 0.7rem;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 600;
    }
    
    /* Links Container */
    .links-container {
        max-height: 280px;
        overflow-y: auto;
        padding: 8px;
    }
    
    .links-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .links-container::-webkit-scrollbar-track {
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .links-container::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .links-container::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }
    
    /* Link Items */
    .link-item {
        padding: 10px 14px;
        border-radius: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        margin-bottom: 4px;
    }
    
    .link-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e7f3ff 100%);
        color: #0054a6;
        transform: translateX(6px);
        text-decoration: none;
    }
    
    .link-item.active {
        background: linear-gradient(135deg, #e7f3ff 0%, #d4e9ff 100%);
        color: #0054a6;
        font-weight: 600;
        border-left: 3px solid #667eea;
    }
    
    .link-item i {
        font-size: 1rem;
        opacity: 0.7;
    }
    
    /* Grid Improvements */
    .nav-dropdown-menu .row {
        row-gap: 24px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .nav-dropdown-menu {
            position: absolute;
            width: 100%;
            left: 0;
            right: 0;
            top: 100%;
        }
        
        .navbar-nav {
            justify-content: flex-start;
        }
    }
</style>
</head>
<body>
    <div class="page">
        <!-- Navigation Bar -->
   
        <!-- Header -->
     

        <!-- Content -->
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

        <!-- Footer -->
        <footer class="footer footer-transparent border-top mt-5">
            <div class="container-xl">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="text-muted py-3">
                            <small>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script>
        // Keep dropdown open when hovering over it
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            
            dropdowns.forEach(dropdown => {
                let timeout;
                const menu = dropdown.querySelector('.nav-dropdown-menu');
                
                dropdown.addEventListener('mouseenter', function() {
                    clearTimeout(timeout);
                    menu.style.display = 'block';
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    timeout = setTimeout(() => {
                        menu.style.display = 'none';
                    }, 200);
                });
                
                menu.addEventListener('mouseenter', function() {
                    clearTimeout(timeout);
                });
                
                menu.addEventListener('mouseleave', function() {
                    timeout = setTimeout(() => {
                        menu.style.display = 'none';
                    }, 200);
                });
            });
        });
    </script>
</body>
</html>