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
    
    :root {
        --primary-color: #1dc8e1;
        --secondary-color: #1fe9ba;
        --accent-gradient: linear-gradient(135deg, #1fe9ba 0%, #1dc8e1 100%);
        --dark-bg: #2c3e50;
        --light-bg: #f8f9fa;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
        margin: 0;
        padding: 0;
    }
    
    .page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    .page-wrapper {
        flex: 1;
    }
    
    /* Navigation Bar */
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        height: 64px;
    }
    
    .navbar {
        padding: 0.5rem 0;
        height: 64px;
    }
    
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        display: flex;
        align-items: center;
    }
    
    .navbar-brand img {
        height: 40px;
        margin-right: 10px;
    }
    
    /* Center Navigation Items */
    .navbar-nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Navigation Links */
    .nav-link {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        border-radius: 8px;
    }
    
    .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(29, 200, 225, 0.08);
    }
    
    .nav-link.active {
        color: var(--primary-color);
        background-color: rgba(29, 200, 225, 0.12);
    }
    
    .nav-link i {
        font-size: 0.875rem;
        transition: transform 0.3s ease;
        margin-left: 4px;
    }
    
    .nav-item.nav-dropdown:hover .nav-link i {
        transform: rotate(180deg);
    }
    
    /* Navigation Dropdown - Full Width */
    .nav-dropdown {
        position: static;
    }
    
    .nav-dropdown-menu {
        display: none;
        position: fixed;
        top: 64px;
        left: 0;
        right: 0;
        width: 100vw;
        background: white;
        border: none;
        border-top: 1px solid var(--border-color);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        padding: 48px 0;
        margin-top: 0;
        z-index: 999;
        max-height: 80vh;
        overflow-y: auto;
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
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
        padding: 0 24px;
    }
    
    /* Subcategory Cards */
    .subcategory-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        height: 100%;
        border-radius: 0;
        overflow: hidden;
        background: transparent;
        box-shadow: none;
    }
    
    .subcategory-card:hover {
        background: #f5f5f5;
        box-shadow: none;
        transform: none;
        border-radius: 0;
    }
    
    /* Card Header with Gradient */
    .subcategory-header {
        background: var(--accent-gradient);
        color: white;
        padding: 20px 24px;
        position: relative;
        overflow: hidden;
    }
    
    .subcategory-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .subcategory-header h4 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .card-body {
        background: transparent;
        padding: 0;
    }
    
    .subcategory-card:hover .card-body {
        background: transparent;
    }
    
    .subcategory-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        backdrop-filter: blur(10px);
    }
    
    .subcategory-icon i {
        font-size: 28px;
        color: white;
    }
    
    .badge-count {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 700;
        background: white;
        color: var(--primary-color);
        position: relative;
        z-index: 1;
    }
    
    .subcategory-description {
        font-size: 0.85rem;
        opacity: 0.95;
        margin-top: 8px;
        line-height: 1.5;
        position: relative;
        z-index: 1;
    }
    
    /* Links Container */
    .links-container {
        max-height: 320px;
        overflow-y: auto;
        padding: 16px;
        background: transparent;
    }
    
    .subcategory-card:hover .links-container {
        background: transparent;
    }
    
    .links-container::-webkit-scrollbar {
        width: 5px;
    }
    
    .links-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .links-container::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.2);
        border-radius: 10px;
    }
    
    .links-container::-webkit-scrollbar-thumb:hover {
        background: rgba(0,0,0,0.3);
    }
    
    /* Link Items */
    .link-item {
        padding: 10px 16px;
        border-radius: 0;
        transition: all 0.2s ease;
        cursor: pointer;
        color: var(--text-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        margin-bottom: 4px;
        background: transparent;
        border: none;
    }
    
    .link-item:hover {
        background: rgba(0,0,0,0.05);
        color: var(--primary-color);
        transform: translateX(4px);
        text-decoration: none;
    }
    
    .link-item.active {
        background: rgba(29, 200, 225, 0.1);
        color: var(--primary-color);
        font-weight: 600;
        border-left: 3px solid var(--primary-color);
        padding-left: 13px;
    }
    
    .link-item i {
        font-size: 1rem;
        opacity: 0.5;
        margin-right: 12px;
        color: currentColor;
    }
    
    .link-item:hover i {
        opacity: 0.8;
    }
    
    .link-item.active i {
        opacity: 1;
    }
    
    /* Grid Improvements */
    .nav-dropdown-menu .row {
        row-gap: 32px;
    }
    
    /* Hero Section */
    .hero-section {
        background: var(--accent-gradient);
        position: relative;
        overflow: hidden;
        padding: 0;
        min-height: 500px;
    }
    
    .hero-background {
        padding: 80px 0;
        position: relative;
        z-index: 1;
    }
    
    .hero-content {
        padding: 40px;
        animation: fadeInLeft 0.8s ease;
    }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: white;
        margin: 20px 0;
        line-height: 1.2;
        text-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }
    
    .hero-description {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 32px;
        line-height: 1.6;
        max-width: 600px;
    }
    
    .btn-hero {
        background: white;
        color: var(--primary-color);
        border: none;
        padding: 16px 40px;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        display: inline-flex;
        align-items: center;
    }
    
    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.25);
        background: white;
        color: var(--primary-color);
    }
    
    .hero-illustration {
        position: relative;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeInRight 0.8s ease;
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .hero-svg,
    .hero-svg-default {
        width: 100%;
        max-width: 600px;
        height: auto;
        filter: drop-shadow(0 10px 30px rgba(0,0,0,0.1));
    }
    
    .hero-decoration {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }
    
    .hero-decoration-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation-delay: 0s;
    }
    
    .hero-decoration-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        right: 20%;
        animation-delay: 2s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) scale(1);
        }
        50% {
            transform: translateY(-20px) scale(1.05);
        }
    }
    
    /* SVG Animations */
    .cloud {
        animation: drift 20s linear infinite;
    }
    
    @keyframes drift {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(50px);
        }
    }
    
    .bird {
        animation: fly 3s ease-in-out infinite;
    }
    
    @keyframes fly {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    /* Breadcrumb Section */
    .breadcrumb-section {
        background: white;
        padding: 16px 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .breadcrumb {
        margin: 0;
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item {
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-item a:hover {
        color: var(--primary-color);
    }
    
    .breadcrumb-item.active {
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-muted);
    }
    
    .btn-primary {
        background: var(--accent-gradient);
        border: none;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(29, 200, 225, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(29, 200, 225, 0.4);
        background: var(--accent-gradient);
    }
    
    /* Content Cards */
    .page-wrapper {
        background: var(--light-bg);
        padding: 40px 0;
    }
    
    .page-body {
        width: 100%;
    }
    
    .content-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 32px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .content-sections {
        width: 100%;
    }
    
    .content-section {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    
    .content-section:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    
    /* Footer */
    .footer {
        background: #2c3e50;
        color: #a0aec0;
        padding: 64px 0 24px;
        margin-top: 64px;
    }
    
    .footer-brand {
        font-size: 1.25rem;
        font-weight: 800;
        color: white;
    }
    
    .footer-text {
        font-size: 0.875rem;
        line-height: 1.8;
        color: #a0aec0;
    }
    
    .footer-contact {
        font-size: 0.875rem;
    }
    
    .footer-contact a {
        color: #a0aec0;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .footer-contact a:hover {
        color: var(--primary-color);
    }
    
    .footer-social {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    .social-icon {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        background: var(--accent-gradient);
        color: white;
        transform: translateY(-3px);
    }
    
    .footer-heading {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 10px;
    }
    
    .footer-links a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-block;
    }
    
    .footer-links a:hover {
        color: var(--primary-color);
        transform: translateX(4px);
    }
    
    .footer-section-label {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.875rem;
        margin-top: 16px;
        margin-bottom: 8px;
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 24px;
        margin-top: 48px;
        text-align: center;
        font-size: 0.875rem;
        color: #718096;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 80px;
        opacity: 0.2;
        margin-bottom: 24px;
        color: var(--primary-color);
    }
    
    .empty-state .h4 {
        color: var(--text-dark);
        font-weight: 600;
    }
    
    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 20px;
    }
    
    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #fff8e1 100%);
        color: #856404;
    }
    
    .alert-icon {
        font-size: 24px;
        margin-right: 16px;
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
            gap: 0;
        }
        
        .nav-link {
            border-radius: 0;
        }
        
        .subcategory-card {
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-description {
            font-size: 1.1rem;
        }
        
        .hero-illustration {
            height: 350px;
            margin-top: 40px;
        }
    }
    
    @media (max-width: 768px) {
        .nav-dropdown-menu {
            padding: 24px 0;
        }
        
        .subcategory-header {
            padding: 20px;
        }
        
        .links-container {
            max-height: 240px;
        }
        
        .hero-section {
            min-height: auto;
        }
        
        .hero-background {
            padding: 60px 0 40px;
        }
        
        .hero-content {
            padding: 20px;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-description {
            font-size: 1rem;
        }
        
        .hero-illustration {
            height: 300px;
            margin-top: 20px;
        }
        
        .hero-svg,
        .hero-svg-default {
            max-width: 100%;
        }
        
        .container-fluid {
            padding-left: 20px;
            padding-right: 20px;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.75rem;
        }
        
        .btn-hero {
            padding: 12px 28px;
            font-size: 0.9rem;
        }
        
        .footer {
            padding: 40px 0 20px;
        }
        
        .footer-text {
            font-size: 0.8rem;
        }
    }
</style>
</head>
<body>
    <div class="page">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-header">
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
                                    <i class="ti ti-chevron-down icon"></i>
                                </span>
                                
                                <!-- Dropdown Menu -->
                                <div class="nav-dropdown-menu">
                                    <div class="row g-4">
                                        @forelse($mainCategory->subCategories as $subCategory)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card subcategory-card">
                                                    <div class="subcategory-header">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <h4 class="text-white mb-0">
                                                                {{ $subCategory->name }}
                                                            </h4>
                                                            <span class="badge-count">
                                                                {{ $subCategory->links->count() }}
                                                            </span>
                                                        </div>
                                                        @if($subCategory->description)
                                                            <div class="subcategory-description text-white">
                                                                {{ Str::limit($subCategory->description, 60) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="card-body p-0">
                                                        <div class="links-container">
                                                            @forelse($subCategory->links as $subLink)
                                                                <a href="{{ route('link.view', $subLink->id) }}" 
                                                                   class="link-item {{ $link->id == $subLink->id ? 'active' : '' }}">
                                                                    <i class="ti ti-link icon"></i>
                                                                    {{ $subLink->title }}
                                                                </a>
                                                            @empty
                                                                <div class="text-muted text-center py-3 small">
                                                                    No links available
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="text-muted text-center py-4">
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

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="hero-content">
                                <div class="hero-badge mb-3">
                                    <i class="ti ti-star icon me-2"></i>
                                    {{ $link->subCategory->name }}
                                </div>
                                <h1 class="hero-title">{{ $link->title }}</h1>
                                @if($link->description)
                                    <p class="hero-description">{{ $link->description }}</p>
                                @endif
                                @if($link->url)
                                    <a href="{{ $link->url }}" target="_blank" class="btn btn-hero">
                                        <i class="ti ti-external-link icon me-2"></i>
                                        Visit Link
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="hero-illustration">
                                @if($link->subCategory->svg)
                                    <div class="hero-svg">
                                        {!! $link->subCategory->svg !!}
                                    </div>
                                @else
                                    <!-- Default SVG Illustration -->
                                    <svg viewBox="0 0 800 600" class="hero-svg-default">
                                        <!-- Cloud 1 -->
                                        <g class="cloud" style="animation-delay: 0s;">
                                            <ellipse cx="100" cy="80" rx="40" ry="25" fill="#ffffff" opacity="0.8"/>
                                            <ellipse cx="130" cy="80" rx="50" ry="30" fill="#ffffff" opacity="0.8"/>
                                            <ellipse cx="160" cy="80" rx="40" ry="25" fill="#ffffff" opacity="0.8"/>
                                        </g>
                                        
                                        <!-- Cloud 2 -->
                                        <g class="cloud" style="animation-delay: 2s;">
                                            <ellipse cx="650" cy="100" rx="35" ry="22" fill="#ffffff" opacity="0.7"/>
                                            <ellipse cx="675" cy="100" rx="45" ry="27" fill="#ffffff" opacity="0.7"/>
                                            <ellipse cx="700" cy="100" rx="35" ry="22" fill="#ffffff" opacity="0.7"/>
                                        </g>
                                        
                                        <!-- Birds -->
                                        <path d="M 200 120 Q 210 115 220 120" stroke="#ffffff" fill="none" stroke-width="2" class="bird" style="animation-delay: 0s;"/>
                                        <path d="M 240 130 Q 250 125 260 130" stroke="#ffffff" fill="none" stroke-width="2" class="bird" style="animation-delay: 1s;"/>
                                        
                                        <!-- Building -->
                                        <rect x="450" y="250" width="280" height="280" fill="#34495e" rx="8"/>
                                        <rect x="460" y="260" width="260" height="260" fill="#2c3e50" rx="4"/>
                                        
                                        <!-- Windows -->
                                        <rect x="480" y="280" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="550" y="280" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="620" y="280" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="480" y="360" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="550" y="360" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="620" y="360" width="50" height="60" fill="#3d5a7a" rx="4"/>
                                        <rect x="480" y="440" width="50" height="60" fill="#4a6fa5" rx="4"/>
                                        <rect x="550" y="440" width="50" height="60" fill="#4a6fa5" rx="4"/>
                                        <rect x="620" y="440" width="50" height="60" fill="#4a6fa5" rx="4"/>
                                        
                                        <!-- Construction Frame -->
                                        <rect x="420" y="350" width="15" height="180" fill="#95a5a6" rx="2"/>
                                        <rect x="420" y="350" width="200" height="15" fill="#95a5a6" rx="2"/>
                                        <rect x="605" y="350" width="15" height="180" fill="#95a5a6" rx="2"/>
                                        
                                        <!-- Excavator Body -->
                                        <ellipse cx="280" cy="480" rx="45" ry="35" fill="#2ecc71"/>
                                        <rect x="240" y="460" width="80" height="40" fill="#27ae60" rx="5"/>
                                        
                                        <!-- Excavator Arm -->
                                        <rect x="310" y="440" width="80" height="15" fill="#f39c12" rx="3" transform="rotate(-25 310 447)"/>
                                        <rect x="370" y="405" width="60" height="12" fill="#e67e22" rx="3" transform="rotate(-45 370 411)"/>
                                        
                                        <!-- Excavator Bucket -->
                                        <path d="M 410 380 L 430 370 L 430 390 Z" fill="#95a5a6"/>
                                        
                                        <!-- Tracks -->
                                        <ellipse cx="250" cy="500" rx="30" ry="15" fill="#34495e"/>
                                        <ellipse cx="310" cy="500" rx="30" ry="15" fill="#34495e"/>
                                        <rect x="220" y="492" width="120" height="16" fill="#2c3e50" rx="8"/>
                                        
                                        <!-- Wheels -->
                                        <circle cx="235" cy="500" r="12" fill="#7f8c8d"/>
                                        <circle cx="265" cy="500" r="12" fill="#7f8c8d"/>
                                        <circle cx="295" cy="500" r="12" fill="#7f8c8d"/>
                                        <circle cx="325" cy="500" r="12" fill="#7f8c8d"/>
                                        
                                        <!-- Ground -->
                                        <rect x="0" y="530" width="800" height="70" fill="#16a085" opacity="0.3"/>
                                    </svg>
                                @endif
                                
                                <!-- Decorative Elements -->
                                <div class="hero-decoration hero-decoration-1"></div>
                                <div class="hero-decoration hero-decoration-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Breadcrumb Section -->
        <section class="breadcrumb-section">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $link->subCategory->mainCategory->name }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $link->subCategory->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $link->title }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Content -->
        <main class="page-wrapper">
            <div class="page-body">
                <div class="container-fluid px-4">
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
                        <div class="content-card">
                            <div class="empty-state">
                                <i class="ti ti-file-text icon"></i>
                                <p class="h4 mb-2">No Content Available</p>
                                <p class="text-muted">
                                    This link doesn't have any content yet.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container-xl">
                <div class="row g-4">
                    <!-- Company Info -->
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-brand mb-3">
                            <strong style="color: white; font-size: 1.25rem;">{{ config('app.name') }}</strong>
                        </div>
                        <p class="footer-text mb-3">
                            Waste management Corporation Limited (WAMCO)<br>
                            Ground Floor, Saafu Raajje Building,<br>
                            Boduthakurufaanu Magu, 20386, Malé, Maldives
                        </p>
                        <div class="footer-contact mb-3">
                            <div class="mb-2">
                                <i class="ti ti-mail icon me-2"></i>
                                <a href="mailto:1666@wamco.com.mv">1666@wamco.com.mv</a>
                            </div>
                            <div>
                                <i class="ti ti-phone icon me-2"></i>
                                <a href="tel:1666">1666</a>
                            </div>
                        </div>
                        <div class="footer-social">
                            <a href="#" class="social-icon"><i class="ti ti-brand-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="ti ti-brand-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="ti ti-brand-twitter"></i></a>
                        </div>
                    </div>
                    
                    <!-- Collection Service -->
                    <div class="col-lg-2 col-md-6">
                        <h6 class="footer-heading">COLLECTION SERVICE</h6>
                        <ul class="footer-links">
                            <li><a href="#">Household</a></li>
                            <li><a href="#">Building Service</a></li>
                            <li><a href="#">Building Plus Service</a></li>
                            <li class="footer-section-label">On Demand</li>
                            <li><a href="#">Call And Pick-Up Service</a></li>
                            <li><a href="#">Caps Lite</a></li>
                            <li><a href="#">CAPS - Construction And Demolition Waste (CND)</a></li>
                            <li class="footer-section-label">Commercial</li>
                            <li><a href="#">Commercial Waste Collection Services</a></li>
                        </ul>
                    </div>
                    
                    <!-- Disposal Service -->
                    <div class="col-lg-2 col-md-6">
                        <h6 class="footer-heading">DISPOSAL SERVICE</h6>
                        <ul class="footer-links">
                            <li><a href="#">Waste Management Facilities</a></li>
                            <li><a href="#">Transfer Station Facilities</a></li>
                            <li><a href="#">Special Projects</a></li>
                            <li><a href="#">Expired / Damaged</a></li>
                        </ul>
                    </div>
                    
                    <!-- Other Services -->
                    <div class="col-lg-2 col-md-6">
                        <h6 class="footer-heading">OTHERS SERVICES</h6>
                        <ul class="footer-links">
                            <li><a href="#">Docking Service</a></li>
                            <li><a href="#">Vehicle Transfer Service</a></li>
                        </ul>
                    </div>
                    
                    <!-- About Us -->
                    <div class="col-lg-3 col-md-6">
                        <h6 class="footer-heading">ABOUT US</h6>
                        <ul class="footer-links">
                            <li><a href="#">Corporate Profile</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Media</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Downloads</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script>
        // Enhanced dropdown management with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.nav-dropdown');
            
            dropdowns.forEach(dropdown => {
                let timeout;
                const menu = dropdown.querySelector('.nav-dropdown-menu');
                
                dropdown.addEventListener('mouseenter', function() {
                    clearTimeout(timeout);
                    menu.style.display = 'block';
                    setTimeout(() => menu.style.opacity = '1', 10);
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    timeout = setTimeout(() => {
                        menu.style.opacity = '0';
                        setTimeout(() => menu.style.display = 'none', 300);
                    }, 150);
                });
                
                menu.addEventListener('mouseenter', function() {
                    clearTimeout(timeout);
                });
                
                menu.addEventListener('mouseleave', function() {
                    timeout = setTimeout(() => {
                        menu.style.opacity = '0';
                        setTimeout(() => menu.style.display = 'none', 300);
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>