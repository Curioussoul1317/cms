<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - WAMCO CMS</title>
    
    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons@1.119.0/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    
    <style>
        :root {
            --tblr-navbar-height: 3.5rem;
        }
        .navbar-brand-image {
            height: 2rem;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/demo-theme.min.js"></script>
    
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="/">
                        <span class="avatar bg-primary text-white me-2">
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        WAMCO CMS
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                            <i class="ti ti-bell icon"></i>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Notifications</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <span class="text-body d-block">System is running smoothly</span>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    All services operational
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm bg-blue-lt">WA</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>WAMCO Admin</div>
                                <div class="mt-1 small text-muted">Administrator</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Condensed Navbar Menu -->
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-home icon"></i>
                                    </span>
                                    <span class="nav-link-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-folder icon"></i>
                                    </span>
                                    <span class="nav-link-title">Categories</span>
                                </a>
                         
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">
                                        <i class="ti ti-folder me-2"></i>
                                        Main Categories
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti ti-folders me-2"></i>
                                        Sub Categories
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti ti-hierarchy me-2"></i>
                                        View Hierarchy
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categories.hierarchy') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-link icon"></i>
                                    </span>
                                    <span class="nav-link-title">Content Hierarchy</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-layout-grid icon"></i>
                                    </span>
                                    <span class="nav-link-title">Content Blocks</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-settings icon"></i>
                                    </span>
                                    <span class="nav-link-title">Settings</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">
                                        <i class="ti ti-user me-2"></i>
                                        Profile Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti ti-palette me-2"></i>
                                        Appearance
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <label class="dropdown-item cursor-pointer">
                                        <span class="form-check">
                                            <input class="form-check-input" type="checkbox" id="theme-toggle">
                                            <span class="form-check-label">
                                                <i class="ti ti-moon me-2"></i>
                                                Dark Mode
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">
                                Waste Management Corporation Limited
                            </h2>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block">
                                    <i class="ti ti-plus icon"></i>
                                    Create New
                                </a>
                                <a href="#" class="btn btn-primary d-sm-none btn-icon">
                                    <i class="ti ti-plus icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <!-- Statistics -->
                    <div class="row row-deck row-cards">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Categories</div>
                                        <div class="ms-auto lh-1">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">Last 7 days</a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item active" href="#">Last 7 days</a>
                                                    <a class="dropdown-item" href="#">Last 30 days</a>
                                                    <a class="dropdown-item" href="#">Last 3 months</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h1 mb-3">12</div>
                                    <div class="d-flex mb-2">
                                        <div>Active Categories</div>
                                        <div class="ms-auto">
                                            <span class="text-green d-inline-flex align-items-center lh-1">
                                                3 <i class="ti ti-trending-up ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 75%" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Sub Categories</div>
                                        <div class="ms-auto lh-1">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">Last 7 days</a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item active" href="#">Last 7 days</a>
                                                    <a class="dropdown-item" href="#">Last 30 days</a>
                                                    <a class="dropdown-item" href="#">Last 3 months</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h1 mb-3">38</div>
                                    <div class="d-flex mb-2">
                                        <div>Active Sub Categories</div>
                                        <div class="ms-auto">
                                            <span class="text-green d-inline-flex align-items-center lh-1">
                                                8 <i class="ti ti-trending-up ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" style="width: 82%" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Links</div>
                                        <div class="ms-auto lh-1">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">Last 7 days</a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item active" href="#">Last 7 days</a>
                                                    <a class="dropdown-item" href="#">Last 30 days</a>
                                                    <a class="dropdown-item" href="#">Last 3 months</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h1 mb-3">156</div>
                                    <div class="d-flex mb-2">
                                        <div>Total Links</div>
                                        <div class="ms-auto">
                                            <span class="text-yellow d-inline-flex align-items-center lh-1">
                                                2 <i class="ti ti-trending-down ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-yellow" style="width: 64%" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="subheader">Content Blocks</div>
                                        <div class="ms-auto lh-1">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">Last 7 days</a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item active" href="#">Last 7 days</a>
                                                    <a class="dropdown-item" href="#">Last 30 days</a>
                                                    <a class="dropdown-item" href="#">Last 3 months</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h1 mb-3">89</div>
                                    <div class="d-flex mb-2">
                                        <div>Active Blocks</div>
                                        <div class="ms-auto">
                                            <span class="text-green d-inline-flex align-items-center lh-1">
                                                12 <i class="ti ti-trending-up ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-cyan" style="width: 91%" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="row row-cards mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Quick Actions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-md-6 col-lg-3">
                                            <a href="#" class="card card-link card-link-pop">
                                                <div class="card-body text-center">
                                                    <div class="avatar avatar-xl mb-3 bg-blue-lt">
                                                        <i class="ti ti-folder icon"></i>
                                                    </div>
                                                    <h3 class="card-title mb-1">Main Categories</h3>
                                                    <p class="text-muted small mb-0">Create and manage categories</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <a href="#" class="card card-link card-link-pop">
                                                <div class="card-body text-center">
                                                    <div class="avatar avatar-xl mb-3 bg-green-lt">
                                                        <i class="ti ti-folders icon"></i>
                                                    </div>
                                                    <h3 class="card-title mb-1">Sub Categories</h3>
                                                    <p class="text-muted small mb-0">Organize into sub-categories</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <a href="#" class="card card-link card-link-pop">
                                                <div class="card-body text-center">
                                                    <div class="avatar avatar-xl mb-3 bg-yellow-lt">
                                                        <i class="ti ti-link icon"></i>
                                                    </div>
                                                    <h3 class="card-title mb-1">Links</h3>
                                                    <p class="text-muted small mb-0">Manage content links</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <a href="#" class="card card-link card-link-pop">
                                                <div class="card-body text-center">
                                                    <div class="avatar avatar-xl mb-3 bg-cyan-lt">
                                                        <i class="ti ti-layout-grid icon"></i>
                                                    </div>
                                                    <h3 class="card-title mb-1">Content Blocks</h3>
                                                    <p class="text-muted small mb-0">View all content blocks</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Features & Recent Activity -->
                    <div class="row row-cards mt-3">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">System Features</h3>
                                </div>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-blue d-block"></span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Hierarchical Organization</strong>
                                                </div>
                                                <div class="text-muted">Structure content with categories</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Dynamic Templates</strong>
                                                </div>
                                                <div class="text-muted">Pre-built content templates</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-yellow d-block"></span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Real-time Updates</strong>
                                                </div>
                                                <div class="text-muted">Instant content changes</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot status-dot-animated bg-cyan d-block"></span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Responsive Design</strong>
                                                </div>
                                                <div class="text-muted">Works on all devices</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Getting Started</h3>
                                </div>
                                <div class="card-body">
                                    <div class="divide-y">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="avatar bg-blue text-white">1</span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Create Main Categories</strong>
                                                </div>
                                                <div class="text-muted">Organize your content structure</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="avatar bg-green text-white">2</span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Add Sub Categories</strong>
                                                </div>
                                                <div class="text-muted">Break down into specific topics</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="avatar bg-yellow text-white">3</span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Create Links</strong>
                                                </div>
                                                <div class="text-muted">Add links to organize resources</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="avatar bg-cyan text-white">4</span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    <strong>Add Content Blocks</strong>
                                                </div>
                                                <div class="text-muted">Enhance with dynamic content</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="#" class="link-secondary">Documentation</a></li>
                                <li class="list-inline-item"><a href="#" class="link-secondary">Support</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright © 2025 <a href="#" class="link-secondary">WAMCO CMS</a>. All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    
    <script>
        // Dark mode toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', currentTheme);
        if (currentTheme === 'dark') {
            themeToggle.checked = true;
        }
        
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                html.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                html.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html>