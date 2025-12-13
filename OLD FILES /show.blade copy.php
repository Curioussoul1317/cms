{{-- resources/views/link-view/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $link->title }}</title>
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
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-header">
            <div class="container-xl">
                <a class="navbar-brand" href="#">
                    <strong>{{ config('app.name') }}</strong>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @foreach($mainCategories as $mainCategory)
                            <li class="nav-item nav-dropdown">
                                <span class="nav-link {{ $link->subCategory->mainCategory->id == $mainCategory->id ? 'active' : '' }}">
                                    {{ $mainCategory->name }}
                                    <i class="ti ti-chevron-down icon ms-1"></i>
                                </span>
                                
                                <!-- Dropdown Menu -->
                                <div class="nav-dropdown-menu">
                                    <div class="row g-3">
                                        @forelse($mainCategory->subCategories as $subCategory)
                                            <div class="col-md-4">
                                                <div class="card subcategory-card">
                                                    <div class="subcategory-header">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h4 class="mb-0 text-white" style="font-size: 0.95rem;">
                                                                {{ $subCategory->name }}
                                                            </h4>
                                                            <span class="badge bg-white text-primary badge-count">
                                                                {{ $subCategory->links->count() }}
                                                            </span>
                                                        </div>
                                                        @if($subCategory->description)
                                                            <small class="text-white-50 d-block mt-1" style="font-size: 0.75rem;">
                                                                {{ Str::limit($subCategory->description, 50) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="card-body p-2">
                                                        <div class="links-container">
                                                            @forelse($subCategory->links as $subLink)
                                                                <a href="{{ route('link.view', $subLink->id) }}" 
                                                                   class="link-item {{ $link->id == $subLink->id ? 'active' : '' }}">
                                                                    <i class="ti ti-link icon me-2"></i>
                                                                    {{ $subLink->title }}
                                                                </a>
                                                            @empty
                                                                <div class="text-muted text-center py-3 small">
                                                                    No links
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="text-muted text-center py-3">
                                                    No sub-categories available
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <header class="bg-white border-bottom py-4">
            <div class="container-xl">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($link->subCategory->svg)
                                    <div style="width: 48px; height: 48px;">
                                        {!! $link->subCategory->svg !!}
                                    </div>
                                @else
                                    <div class="avatar avatar-lg bg-primary-lt">
                                        <i class="ti ti-link icon"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="h2 mb-1">{{ $link->title }}</h1>
                                <div class="text-muted">
                                    <a href="#" class="text-muted text-decoration-none">
                                        {{ $link->subCategory->mainCategory->name }}
                                    </a>
                                    <span class="mx-2">›</span> 
                                    <a href="#" class="text-muted text-decoration-none">
                                        {{ $link->subCategory->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($link->url)
                    <div class="col-auto">
                        <a href="{{ $link->url }}" target="_blank" class="btn btn-primary">
                            <i class="ti ti-external-link icon me-2"></i>
                            Visit Link
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="page-wrapper">
            <div class="page-body">
                <div class="container-xl py-4">
                    @if($link->description)
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="text-muted fs-5 mb-0">{{ $link->description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($link->contents->count() > 0)
                        <div class="content-sections">
                            @foreach($link->contents as $content)
                                <div class="content-section mb-4">
                                    @php
                                        $data = $content->data;
                                        $templateView = "components.templates.{$content->template_name}";
                                    @endphp
                                    
                                    @if(view()->exists($templateView))
                                        @include($templateView, ['data' => $data])
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            <div class="d-flex">
                                                <div>
                                                    <i class="ti ti-alert-triangle icon alert-icon"></i>
                                                </div>
                                                <div>
                                                    <h4 class="alert-title">Template Not Found</h4>
                                                    <div class="text-muted">
                                                        The template view <code>{{ $templateView }}</code> does not exist.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-file-text icon"></i>
                                    </div>
                                    <p class="empty-title">No Content Available</p>
                                    <p class="empty-subtitle text-muted">
                                        This link doesn't have any content yet.
                                    </p>
                                </div>
                            </div>
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