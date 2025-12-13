<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
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
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: white;
        color: var(--text-dark);
    }
    
    .page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    .page-wrapper {
        flex: 1;
        padding-top: 70px;
        background-color: white;
    }
    

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        z-index: 1000;
        padding: 0;
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
        flex-wrap: nowrap;
        gap: 2rem;
    }

  
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--text-dark);
        flex-shrink: 0;
    }

    .navbar-brand img {
        height: 40px;
        width: auto;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        list-style: none;
        gap: 0;
        flex: 1;
        justify-content: center;
        flex-direction: row;
        flex-wrap: nowrap;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        position: relative;
        display: inline-flex;
    }

    .nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 1rem 1rem;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .nav-link:hover {
        color: #1dc8e1;
        text-decoration: none;
    }

    .nav-link.active {
        color: #1dc8e1;
    }

    .nav-link i {
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .nav-item.active .nav-link i {
        transform: rotate(180deg);
    }


    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    .missed-collection-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--accent-gradient);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .missed-collection-btn:hover {
        background: #17b3cc;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(29, 200, 225, 0.3);
        text-decoration: none;
    }

    .missed-collection-btn i {
        font-size: 16px;
    }




 .mobile-menu-toggle {
    display: none;
    background: none;
    border: none;
    color: #333;
    font-size: 24px;
    cursor: pointer;
    padding: 0.5rem;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    font-weight: 500;
}

.mobile-menu-toggle i {
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Default state - show hamburger icon */
.mobile-menu-toggle .ti-menu-2 {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1) rotate(0deg);
}

.mobile-menu-toggle .ti-x {
    opacity: 0;
    visibility: hidden;
    transform: translate(-50%, -50%) scale(0.5) rotate(-180deg);
}

/* Active state - show close icon */
.mobile-menu-toggle.active .ti-menu-2 {
    opacity: 0;
    visibility: hidden;
    transform: translate(-50%, -50%) scale(0.5) rotate(180deg);
}

.mobile-menu-toggle.active .ti-x {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1) rotate(0deg);
}


.mobile-menu-toggle:hover {
    border-radius: 8px;
}


.mobile-menu-toggle:active {
    transform: scale(0.9);
}


.mobile-menu-toggle.active {
    color: #1dc8e1;
}


@media (max-width: 968px) {
    .mobile-menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 576px) {
    .mobile-menu-toggle {
        width: 36px;
        height: 36px;
        font-size: 30px;
    }
}

.mobile-nav-overlay {
    position: fixed;
    margin-top: 60px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100vh;
    height: 100dvh;
    background: white;
    z-index: 500;
    display: none;
    flex-direction: column;
    overflow: hidden; 
}

.mobile-nav-overlay.active {
    display: flex;
}


.mobile-nav-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch; 
    padding-bottom: 2rem;
}


.mobile-quick-actions {
    position: sticky;
    top: 0;
    z-index: 10;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    padding: 1rem;
    background: white;
}

.mobile-quick-action { 
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.2s;
}

.mobile-quick-action:hover,
.mobile-quick-action:active {
    text-decoration: none;
    transform: scale(0.98);
}

.mobile-quick-action svg {
    width: 32px;
    height: 32px;
}

.mobile-quick-action span {
    font-size: .75rem;
    line-height: 1rem;
    color:rgb(54, 54, 54);
    text-align: center;
}


.mobile-categories-wrapper {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}


.mobile-category-section {
    /* border-bottom: 1px solid rgb(29, 200, 226); */
}

.mobile-category-header {
    position: sticky;
    top: 0;
    z-index: 5;
    padding: 1rem;
    font-size: 0.875rem;
    font-weight: 700;
    color: rgb(29, 200, 226);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid rgb(29, 200, 226);
}


.mobile-subcategory {
    /* border-bottom: 1px solid #f0f0f0; */
}

.mobile-subcategory-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: white;
    cursor: pointer;
    font-weight: 500;
    color: #333;
    transition: background 0.2s;
    -webkit-tap-highlight-color: transparent;
}

.mobile-subcategory-header:active {
    background: #f8f9fa;
}

.mobile-subcategory-header i {
    font-size: 16px;
    transition: transform 0.3s;
    color: #6b7280;
}

.mobile-subcategory.active .mobile-subcategory-header i {
    transform: rotate(180deg);
    color: #1dc8e1;
}

.mobile-subcategory-links {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #fafafa;
}

.mobile-subcategory.active .mobile-subcategory-links {
    max-height: 1000px; 
}

.mobile-subcategory-link {
    display: block;
    padding: 0.75rem 1rem 0.75rem 2rem;
    color: #555;
    text-decoration: none;
    font-size: 0.9375rem;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    -webkit-tap-highlight-color: transparent;
}

.mobile-subcategory-link:active {
    background: white;
    color: #1dc8e1;
    border-left-color: #1dc8e1;
}

/* Simple Links (no subcategory) */
.mobile-simple-link {
    display: block;
    padding: 1rem;
    color: #333;
    text-decoration: none;
    font-weight: 500;
    background: white;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.2s;
    -webkit-tap-highlight-color: transparent;
}

.mobile-simple-link:active {
    background: #f8f9fa;
    color: #1dc8e1;
}

/* Prevent body scroll when mobile nav is open */
body.mobile-nav-open {
    overflow: hidden;
    position: fixed;
    width: 100%;
    height: 100%;
}

/* Custom Scrollbar for Mobile Nav Content */
.mobile-nav-content::-webkit-scrollbar {
    width: 4px;
}

.mobile-nav-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.mobile-nav-content::-webkit-scrollbar-thumb {
    background: #1dc8e1;
    border-radius: 2px;
}

.mobile-nav-content::-webkit-scrollbar-thumb:hover {
    background: #17b3cc;
}

/* Safe area padding for devices with notches */
@supports (padding: max(0px)) {
    .mobile-nav-overlay {
        padding-top: max(0px, env(safe-area-inset-top));
        padding-bottom: max(0px, env(safe-area-inset-bottom));
    }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .mobile-quick-actions {
        padding: 0.75rem;
        gap: 0.75rem;
    }
    
    .mobile-quick-action {
        padding: 0.75rem;
        gap: 0.35rem;
    }
    
    .mobile-quick-action svg {
        width: 28px;
        height: 28px;
    }
    
    .mobile-quick-action span {
        font-size: 0.75rem;
    }
}


@media (max-height: 500px) and (orientation: landscape) {
    .mobile-quick-actions {
        position: static;
        box-shadow: none;
    }
}



    .nav-dropdown-backdrop {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 998;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-dropdown-backdrop.active {
        display: block;
        opacity: 1;
    }


    .nav-dropdown-menu {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        width: 100%;
        background: white;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 999;
        max-height: calc(100vh - 70px);
        overflow-y: auto;
    }

    .nav-dropdown-menu.active {
        display: block;
        opacity: 1;
    }

    .dropdown-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2.5rem 2rem;
        display: flex;
        gap: 3rem;
    }

 
    .dropdown-main {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

  
    .category-section {
        display: flex;
        flex-direction: column;
    }

    .category-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .category-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #1fe9ba 0%, #1dc8e1 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .category-icon i {
        font-size: 24px;
        color: white;
    }

    .category-info h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }

    .category-info p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }


    .subcategory-links {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .subcategory-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 0;
        color: #374151;
        text-decoration: none;
        font-size: 0.9375rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .subcategory-link:hover {
        color: #1dc8e1;
        padding-left: 0.5rem;
        text-decoration: none;
    }

    .subcategory-link.active {
        color: #1dc8e1;
        font-weight: 600;
        padding-left: 0.5rem;
    }

    .subcategory-link i {
        font-size: 8px;
        color: #1dc8e1;
        flex-shrink: 0;
    }


    .dropdown-sidebar {
        width: 320px;
        border-left: 1px solid #e5e7eb;
        padding-left: 2.5rem;
    }

    .sidebar-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
    }

    .sidebar-links {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #374151;
        text-decoration: none;
        font-size: 0.9375rem;
        font-weight: 500;
        transition: all 0.2s ease;
        padding: 0.5rem 0;
    }

    .sidebar-link:hover {
        color: #1dc8e1;
        padding-left: 0.5rem;
        text-decoration: none;
    }

    .sidebar-link.active {
        color: #1dc8e1;
        font-weight: 600;
        padding-left: 0.5rem;
    }

    .sidebar-link i {
        font-size: 10px;
        color: #1dc8e1;
        flex-shrink: 0;
    }

    .floating-buttons {
        position: fixed;
        right: 2rem;
        bottom: 24rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }

    .floating-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    .floating-btn.AvasPay {
        background: rgb(255, 255, 255);
    }

    .floating-btn.WAMCOOnline {
        background: rgb(255, 255, 255);
    }

    .floating-btn svg {
        width: 28px;
        height: 28px;
        fill: white;
    }

    @media (max-width: 968px) {
           .floating-buttons {
               display: none;
           }
       }

 
    @media (max-width: 1200px) {
        .dropdown-main {
            grid-template-columns: repeat(2, 1fr);
        }

        .nav-link {
            padding: 1rem 0.75rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 968px) {
        .navbar-nav {
            display: none;
        }

        .dropdown-main {
            grid-template-columns: 1fr;
        }

        .dropdown-sidebar {
            width: 100%;
            border-left: none;
            border-top: 1px solid #e5e7eb;
            padding-left: 0;
            padding-top: 2rem;
            margin-top: 2rem;
        }

        .dropdown-container {
            flex-direction: column;
        }

        .nav-dropdown-backdrop {
            display: none !important;
        }

        .nav-dropdown-menu {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .floating-buttons {
            right: 1rem;
            bottom: 1rem;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
        }

        .floating-btn svg {
            width: 24px;
            height: 24px;
        }
    }

    @media (max-width: 576px) {
        .navbar-container {
            padding: 0 1rem;
            gap: 1rem;
        }

        .dropdown-container {
            padding: 1.5rem 1rem;
        }

        .navbar-brand {
            font-size: 1rem;
            margin-right: 0px;
        }

        .navbar-brand img {
            height: 32px;
        }
    }

 
    .footer {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d3748 100%);
        color: white;
        padding: 3rem 0 0;
        margin-top: 4rem;
    }

    .footer-brand {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .footer-text {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .footer-contact a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-contact a:hover {
        color: #1dc8e1;
        text-decoration: none;
    }

    .footer-heading {
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
        color: white;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #1dc8e1;
        padding-left: 0.5rem;
        text-decoration: none;
    }

    .footer-section-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    .footer-social {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .social-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-icon:hover {
        background: #1dc8e1;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .footer-bottom {
        margin-top: 3rem;
        padding: 1.5rem 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.875rem;
    }

    .container-xl {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    </style>
</head>
<body class="layout-fluid">
    <div class="page">
 

    <nav class="navbar">
    <div class="navbar-container">
 
        <a href="{{ route('home') }}" class="navbar-brand">
            <svg width="50" height="50" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="item"><path fill-rule="evenodd" clip-rule="evenodd" d="M51.4755 38.2565C51.4755 38.2565 51.4304 38.3341 51.3553 38.4743L51.0099 39.0825C50.7196 39.5831 50.3091 40.2264 49.8686 40.8522C49.2795 41.6857 48.6418 42.4839 47.959 43.2426L46.0193 41.5255C46.6174 40.8319 47.1756 40.1049 47.6912 39.3478C48.0741 38.7797 48.4295 38.1914 48.6798 37.7434L48.9751 37.2002L49.0903 36.98L51.4755 38.2565Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M43.3512 47.2546L43.1435 47.3922L42.5478 47.7702C42.0648 48.0731 41.404 48.456 40.7258 48.8064C39.8214 49.2699 38.8904 49.6794 37.9376 50.0329L37.0967 47.8227C37.9529 47.4847 38.7886 47.0969 39.5995 46.6613C40.2077 46.3335 40.7958 45.978 41.2288 45.6927C41.4416 45.55 41.6193 45.4424 41.7419 45.3473L41.9471 45.2046L43.3437 47.2546H43.3512Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M32.0359 51.4318L31.7857 51.4594L31.0974 51.5195C30.5292 51.562 29.7684 51.5945 29.01 51.587C28.6371 51.587 28.2592 51.572 27.8963 51.552C27.5334 51.532 27.2105 51.5094 26.9277 51.4844C26.3596 51.4318 25.9841 51.3793 25.9841 51.3793L26.2344 49.2542C26.2344 49.2542 26.5773 49.2943 27.0979 49.3318C27.3482 49.3493 27.661 49.3669 27.9864 49.3769C28.3117 49.3869 28.6521 49.3919 29.005 49.3769C29.6983 49.3769 30.3916 49.3268 30.9097 49.2793L31.5304 49.2117L31.7806 49.1816L32.0309 51.4193L32.0359 51.4318Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.1051 49.8824L19.8723 49.7898L19.2366 49.5245C18.716 49.2992 18.0328 48.9764 17.367 48.6184C16.4798 48.1394 15.6216 47.6087 14.7966 47.029L15.8854 45.4546C16.6568 45.9724 17.4573 46.4455 18.283 46.8713C18.9037 47.1892 19.5345 47.4745 20.02 47.6723L20.6057 47.9026L20.8384 47.9902L20.1051 49.8824Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3241 42.9943L10.1614 42.8015L9.72593 42.2734C9.36803 41.8354 8.91502 41.2346 8.49205 40.6114C7.92948 39.7804 7.41634 38.9171 6.95532 38.0258L8.45701 37.2373C8.9018 38.0592 9.39488 38.8541 9.93367 39.6177C10.3366 40.1884 10.7696 40.739 11.1075 41.1395L11.5129 41.6226L11.6781 41.8078L10.3216 42.9943H10.3241Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.87549 32.4036L4.82043 32.1533C4.7879 31.9931 4.73784 31.7628 4.68027 31.4875C4.57015 30.9343 4.45002 30.1934 4.36492 29.45C4.25656 28.4576 4.20558 27.4597 4.21225 26.4614H5.6764C5.68911 27.4006 5.75597 28.3383 5.87662 29.2698C5.96672 29.9657 6.09437 30.659 6.20699 31.1721C6.26706 31.4224 6.31712 31.6427 6.34965 31.7904C6.38219 31.938 6.40972 32.0407 6.40972 32.0407L4.87549 32.4061V32.4036Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.97559 20.5471C4.97559 20.5471 5.06318 20.1992 5.22587 19.6535C5.38855 19.1079 5.61631 18.402 5.88661 17.7112C6.25013 16.7846 6.66799 15.8803 7.13802 15.0029L8.23425 15.5786C7.80696 16.4194 7.42923 17.2844 7.10298 18.1693C6.8527 18.8326 6.64997 19.5084 6.51231 20.019C6.37466 20.5296 6.29207 20.88 6.29207 20.88L4.98059 20.5471H4.97559Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.2729 3.54408C20.2729 3.54408 20.6108 3.41642 21.1439 3.24121C21.677 3.066 22.3803 2.86075 23.1011 2.69055C24.0597 2.46559 25.0308 2.29842 26.0094 2.18994L26.1045 2.97088C25.1596 3.09339 24.2228 3.27141 23.2989 3.50403C22.6081 3.68425 21.9248 3.897 21.4217 4.07472C20.9187 4.25243 20.5833 4.38509 20.5833 4.38509L20.2729 3.54408Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M31.8909 2.22998C31.8909 2.22998 32.2513 2.27503 32.7994 2.36514C33.3475 2.45525 34.0683 2.60043 34.7791 2.78065C35.7296 3.02359 36.6648 3.32281 37.5798 3.67673L37.382 4.20487C36.4815 3.87653 35.5622 3.60238 34.629 3.38388C33.9307 3.21868 33.2249 3.09352 32.6918 3.01593C32.1587 2.93834 31.8008 2.90079 31.8008 2.90079L31.8859 2.22998H31.8909Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M42.7431 6.44531C42.7431 6.44531 43.0409 6.65056 43.4814 6.98597C43.9219 7.32137 44.4825 7.77942 45.0306 8.27002C45.7545 8.92384 46.4398 9.61918 47.0829 10.3525L46.8327 10.5778C45.5392 9.15751 44.0806 7.89704 42.4878 6.82327L42.7381 6.45532L42.7431 6.44531Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M50.3616 15.1755C51.2536 16.904 51.9319 18.7347 52.3814 20.6271L52.2713 20.6522C52.0285 19.7174 51.7302 18.798 51.3778 17.8988C51.0243 16.9988 50.6182 16.1204 50.1614 15.2682L50.3616 15.1655V15.1755Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M21.7544 49.147C22.275 46.3562 23.7767 42.7017 25.8565 41.265C24.2848 38.8371 24.1246 35.5606 24.3073 33.0451C26.3646 36.7195 28.8975 40.4115 32.3313 42.8069C28.5295 43.5903 24.938 45.9457 21.7544 49.157V49.147ZM33.5026 40.4715C31.1125 38.782 28.9801 36.1588 26.6474 32.0314L22.24 24.2319L21.4716 32.4544C21.1938 35.443 21.4566 38.1287 22.27 40.4015C20.3554 42.6241 19.0964 45.8781 18.5508 48.4687L16.1206 60.0001L23.9669 51.585C26.9703 48.3611 30.1213 46.3712 33.1147 45.6653L38.9162 44.3037L33.5026 40.4791V40.4715Z" fill="rgba(146, 199, 64, 1)" stroke-width="0.5" stroke="#92C740" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3056 31.2876C48.0141 32.2538 45.8016 32.0385 43.9095 31.5955C46.1921 30.344 48.2344 28.7921 49.1654 26.4368C50.2792 29.513 52.2113 32.444 54.3838 34.947C52.8345 34.4014 50.5169 33.0197 49.2956 31.2901L49.3056 31.2876ZM55.3248 33.6004C53.2525 31.22 51.6832 28.682 50.8048 26.3041L49.0102 21.4482L47.456 25.0701C46.7427 26.7346 45.2886 28.0737 42.6281 29.4379L36.8716 32.389L44.0497 33.9358C45.2587 34.2242 46.5019 34.3438 47.7438 34.2913C48.2989 34.2575 48.8474 34.1524 49.3757 33.9784C50.8464 35.3673 52.5892 36.436 54.4939 37.1172L60.0001 38.9669L55.3474 33.6204L55.3248 33.6004Z" fill="rgba(146, 199, 64, 1)" stroke-width="0.5" stroke="#92C740" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.6365 16.5725C13.8556 12.9131 11.6606 9.37382 8.85746 6.22001C11.3603 7.2888 14.7191 9.31625 16.0956 11.3137C18.3481 10.7004 21.3891 11.4163 23.7567 12.2047C20.483 12.9231 17.0191 14.0945 14.6365 16.5725ZM23.9619 10.1673C22.4323 9.6198 20.8556 9.21427 19.2517 8.95582C18.446 8.83159 17.6316 8.77216 16.8164 8.7781C14.7816 6.86079 11.9209 5.2163 9.67338 4.23261L0 0L6.40721 7.18618C9.21787 10.3375 11.0124 13.5338 11.593 16.5049L12.8995 23.0729L17.1117 18.3872C18.7711 16.5525 21.2539 15.326 25.0281 14.3949L31.5355 12.7929L23.9619 10.1673Z" fill="rgba(8, 160, 162, 1)" stroke-width="0.5" stroke="#08A0A2" opacity="1" pathLength="1" stroke-dashoffset="0px" stroke-dasharray="1px 1px"></path></svg>
        </a>

 
        <ul class="navbar-nav"> 
            @foreach($mainCategories->where('is_published', 1) as $mainCategory)
            @if($mainCategory->id ==1)
            @else
                <li class="nav-item" data-dropdown="category-{{ $mainCategory->id }}">
                    <span class="nav-link {{ 
                        isset($item) && isset($item->mainCategory) && $item->mainCategory->id == $mainCategory->id ? 'active' : '' 
                    }}">
                        {{ $mainCategory->name }}
                        <i class="ti ti-chevron-down"></i>
                    </span>
                </li>
                @endif
            @endforeach 

            @foreach($staticNav as $staticCategory)
        <li class="nav-item" data-dropdown="static-{{ $staticCategory['identifier'] }}">
            <span class="nav-link">
                {{ $staticCategory['name'] }}
                <i class="ti ti-chevron-down"></i>
            </span>
        </li>
    @endforeach
        </ul>

        <div class="navbar-actions">
            <a href="#" class="missed-collection-btn">
                <i class="ti ti-trash"></i>
                <span>MISSED COLLECTION</span>
            </a>

            <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">
                <i class="ti ti-menu-2"></i>
                <i class="ti ti-x"></i>
            </button>
        </div>
    </div>
</nav>


<div class="nav-dropdown-backdrop"></div> 

@foreach($staticNav as $staticCategory)
<div class="nav-dropdown-menu" data-dropdown-content="static-{{ $staticCategory['identifier'] }}">
    <div class="dropdown-container">
        <div class="dropdown-main">
            @foreach($staticCategory['pages'] as $page)
                <div class="category-section">
                    <div class="category-header">
                        @if($page['has_children'])
                            <div class="category-icon">
                                <i class="{{ $page['icon'] ?? 'ti ti-folder' }}"></i>
                            </div>
                            <div class="category-info">
                                <h3>{{ $page['name'] }}</h3>
                            </div>
                        @endif
                    </div>
                    
                    @if($page['has_children'] && count($page['children']) > 0)
                        <div class="subcategory-links">
                            @foreach($page['children'] as $child)
                            <a href="{{ route($child['route']) }}{{ isset($child['section']) ? '#' . $child['section'] : '' }}" class="subcategory-link">
                                <i class="ti ti-circle-filled"></i>
                                {{ $child['name'] }}
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</div>
@endforeach

@foreach($mainCategories->where('is_published', 1) as $mainCategory)
    <div class="nav-dropdown-menu" data-dropdown-content="category-{{ $mainCategory->id }}">
        <div class="dropdown-container">
            <div class="dropdown-main">
                @forelse($mainCategory->pages->where('is_published', 1)->whereNull('parent_id') as $page)
                @if($page->id ==1)
                @else
                    <div class="category-section">
                        <div class="category-header">
                            @if($page->has_children && $page->children->where('is_published', 1)->count() > 0)
                                <div class="category-icon"> 
                                    @if($page->icon)
                                        <i class="{{ $page->icon }}"></i>
                                    @else
                                        <i class="ti ti-folder"></i>
                                    @endif
                                </div>
                                <div class="category-info">
                                    <h3>{{ $page->name }}</h3>
                                    @if($page->description)
                                        <p>{{ Str::limit($page->description, 100) }}</p>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('content.show', ['page', $page->id]) }}" 
                                   class="subcategory-link">
                                    <div class="category-icon"> 
                                        @if($page->icon)
                                            <i class="{{ $page->icon }}"></i>
                                        @else
                                            <i class="ti ti-folder"></i>
                                        @endif
                                    </div>
                                    <div class="category-info">
                                        <h3>{{ $page->name }}</h3>
                                        @if($page->description)
                                            <p>{{ Str::limit($page->description, 100) }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endif
                        </div>
                        @if($page->has_children && $page->children->where('is_published', 1)->count() > 0)
                            <div class="subcategory-links"> 
                                @foreach($page->children->where('is_published', 1)->sortBy('order') as $childPage)
                                    <a href="{{ route('content.show', ['page', $childPage->id]) }}" 
                                       class="subcategory-link {{ isset($item) && $item->id == $childPage->id ? 'active' : '' }}">
                                        <i class="ti ti-circle-filled"></i>
                                        {{ $childPage->name }}   
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
                @empty
                    <div class="category-section">
                        <div class="text-muted text-center py-4">
                            No pages available
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="dropdown-sidebar">
                <h4 class="sidebar-title">I WANT TO</h4>
                <div class="sidebar-links">
                    <a href="#" class="sidebar-link">
                        <i class="ti ti-circle-filled"></i>
                        Report a missed household collections
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="ti ti-circle-filled"></i>
                        Sign Up for household collection Service
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="ti ti-circle-filled"></i>
                        Sign up for Commercial Collection Service
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach




<div class="mobile-nav-overlay">
    <div class="mobile-nav-content">

        <div class="mobile-quick-actions">
            <a href="https://wamco.com.mv/avaspay/" target="_blank" rel="noopener noreferrer" class="mobile-quick-action">
                <svg id="Component_17_6" data-name="Component 17 6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 15.815 20.72">
                    <path id="Path_5246" data-name="Path 5246" d="M1012.847,1033.378h-8.228l4.7-1.509A2.926,2.926,0,0,1,1012.847,1033.378Z" transform="translate(-999.811 -1031.728)" fill="#1acdce"></path>
                    <path id="Path_5247" data-name="Path 5247" d="M1007.108,1042.116a2.945,2.945,0,0,0,2.082,5.026h6.436v2.379a2.928,2.928,0,0,1-2.927,2.927h-9.961a2.928,2.928,0,0,1-2.927-2.927v-12.052a2.927,2.927,0,0,1,2.926-2.927h9.962a2.927,2.927,0,0,1,2.927,2.926h0v3.785h-6.436A2.936,2.936,0,0,0,1007.108,1042.116Z" transform="translate(-999.811 -1031.728)" fill="#1acdce"></path>
                </svg>
                <span>Avas Pay</span>
            </a>
            <a href="https://wamco.com.mv/online/" target="_blank" rel="noopener noreferrer" class="mobile-quick-action">
                <svg id="Component_16_7" data-name="Component 16 7" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 13.855 19.331">
                    <path variants="[object Object]" id="Path_5243" data-name="Path 5243" d="M1042.262,1039.987h-6.317v-2.257a4.2,4.2,0,0,1,4.2-4.2h2.114Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path>
                    <path id="Path_5244" data-name="Path 5244" d="M1049.8,1037.73v2.257h-6.317v-6.46h2.114a4.2,4.2,0,0,1,4.2,4.2Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path>
                    <path id="Path_5245" data-name="Path 5245" d="M1035.945,1041.12H1049.8v4.729a6.927,6.927,0,0,1-13.853.164c0-.055,0-.109,0-.164Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path>
                </svg>
                <span>WAMCO Online</span>
            </a>
        </div>


        <div class="mobile-categories-wrapper">          

            @foreach($mainCategories->where('is_published', 1) as $mainCategory)
                <div class="mobile-category-section">
       
                    <div class="mobile-category-header">
                        {{ $mainCategory->name }}
                    </div>

                    @foreach($mainCategory->pages->where('is_published', 1)->whereNull('parent_id')->sortBy('order') as $page)
                        @if($page->has_children && $page->children->where('is_published', 1)->count() > 0)
               
                            <div class="mobile-subcategory">
                                <div class="mobile-subcategory-header">
                                    <span>{{ $page->name }}</span>
                                    <i class="ti ti-chevron-down"></i>
                                </div>
                                <div class="mobile-subcategory-links">
                                    @foreach($page->children->where('is_published', 1)->sortBy('order') as $childPage)
                                        <a href="{{ route('content.show', ['page', $childPage->id]) }}" class="mobile-subcategory-link">
                                            {{ $childPage->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
        
                            <a href="{{ route('content.show', ['page', $page->id]) }}" class="mobile-simple-link">
                                {{ $page->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endforeach

            @foreach($staticNav as $staticCategory)
        <div class="mobile-category-section">
            <div class="mobile-category-header">
                {{ $staticCategory['name'] }}
            </div>

            @foreach($staticCategory['pages'] as $page)
                @if($page['has_children'] && count($page['children']) > 0)
                    <div class="mobile-subcategory">
                        <div class="mobile-subcategory-header">
                            <span>{{ $page['name'] }}</span>
                            <i class="ti ti-chevron-down"></i>
                        </div>
                        <div class="mobile-subcategory-links">
                            @foreach($page['children'] as $child)
                            <a href="{{ route($child['route']) }}{{ isset($child['section']) ? '#' . $child['section'] : '' }}" class="mobile-subcategory-link">
                                {{ $child['name'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach

        </div>
    </div>
</div>
 
 
        <div class="floating-buttons">
            <a target="_blank" rel="noopener noreferrer" href="https://wamco.com.mv/avaspay/" class="floating-btn AvasPay" title="Avas Pay">
                <svg id="Component_17_6" data-name="Component 17 6" xmlns="https://www.w3.org/2000/svg" width="30" height="35" viewBox="0 0 15.815 20.72"><path id="Path_5246" data-name="Path 5246" d="M1012.847,1033.378h-8.228l4.7-1.509A2.926,2.926,0,0,1,1012.847,1033.378Z" transform="translate(-999.811 -1031.728)" fill="#1acdce"></path><path id="Path_5247" data-name="Path 5247" d="M1007.108,1042.116a2.945,2.945,0,0,0,2.082,5.026h6.436v2.379a2.928,2.928,0,0,1-2.927,2.927h-9.961a2.928,2.928,0,0,1-2.927-2.927v-12.052a2.927,2.927,0,0,1,2.926-2.927h9.962a2.927,2.927,0,0,1,2.927,2.926h0v3.785h-6.436A2.936,2.936,0,0,0,1007.108,1042.116Z" transform="translate(-999.811 -1031.728)" fill="#1acdce"></path></svg>
            </a>
           
            <a target="_blank" rel="noopener noreferrer" href="https://wamco.com.mv/online/" class="floating-btn WAMCOOnline" title="WAMCO Online">
                <svg id="Component_16_7" data-name="Component 16 7" xmlns="https://www.w3.org/2000/svg" width="30" height="35" viewBox="0 0 13.855 19.331"><path variants="[object Object]" id="Path_5243" data-name="Path 5243" d="M1042.262,1039.987h-6.317v-2.257a4.2,4.2,0,0,1,4.2-4.2h2.114Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path><path id="Path_5244" data-name="Path 5244" d="M1049.8,1037.73v2.257h-6.317v-6.46h2.114a4.2,4.2,0,0,1,4.2,4.2Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path><path id="Path_5245" data-name="Path 5245" d="M1035.945,1041.12H1049.8v4.729a6.927,6.927,0,0,1-13.853.164c0-.055,0-.109,0-.164Z" transform="translate(-1035.944 -1033.527)" fill="#28e4b8"></path></svg>
            </a> 
        </div>
 
        @yield('content') 

     
        <footer class="footer">
            <div class="container-xl">
                <div class="row justify-content-md-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
 
                            <div class="col-lg-3 col-md-6">
                                <div class="footer-brand mb-4">
                                    <svg width="50" height="50" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 0.5rem;"><path fill-rule="evenodd" clip-rule="evenodd" d="M51.4755 38.2565C51.4755 38.2565 51.4304 38.3341 51.3553 38.4743L51.0099 39.0825C50.7196 39.5831 50.3091 40.2264 49.8686 40.8522C49.2795 41.6857 48.6418 42.4839 47.959 43.2426L46.0193 41.5255C46.6174 40.8319 47.1756 40.1049 47.6912 39.3478C48.0741 38.7797 48.4295 38.1914 48.6798 37.7434L48.9751 37.2002L49.0903 36.98L51.4755 38.2565Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M43.3512 47.2546L43.1435 47.3922L42.5478 47.7702C42.0648 48.0731 41.404 48.456 40.7258 48.8064C39.8214 49.2699 38.8904 49.6794 37.9376 50.0329L37.0967 47.8227C37.9529 47.4847 38.7886 47.0969 39.5995 46.6613C40.2077 46.3335 40.7958 45.978 41.2288 45.6927C41.4416 45.55 41.6193 45.4424 41.7419 45.3473L41.9471 45.2046L43.3437 47.2546H43.3512Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M32.0359 51.4318L31.7857 51.4594L31.0974 51.5195C30.5292 51.562 29.7684 51.5945 29.01 51.587C28.6371 51.587 28.2592 51.572 27.8963 51.552C27.5334 51.532 27.2105 51.5094 26.9277 51.4844C26.3596 51.4318 25.9841 51.3793 25.9841 51.3793L26.2344 49.2542C26.2344 49.2542 26.5773 49.2943 27.0979 49.3318C27.3482 49.3493 27.661 49.3669 27.9864 49.3769C28.3117 49.3869 28.6521 49.3919 29.005 49.3769C29.6983 49.3769 30.3916 49.3268 30.9097 49.2793L31.5304 49.2117L31.7806 49.1816L32.0309 51.4193L32.0359 51.4318Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.1051 49.8824L19.8723 49.7898L19.2366 49.5245C18.716 49.2992 18.0328 48.9764 17.367 48.6184C16.4798 48.1394 15.6216 47.6087 14.7966 47.029L15.8854 45.4546C16.6568 45.9724 17.4573 46.4455 18.283 46.8713C18.9037 47.1892 19.5345 47.4745 20.02 47.6723L20.6057 47.9026L20.8384 47.9902L20.1051 49.8824Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.3241 42.9943L10.1614 42.8015L9.72593 42.2734C9.36803 41.8354 8.91502 41.2346 8.49205 40.6114C7.92948 39.7804 7.41634 38.9171 6.95532 38.0258L8.45701 37.2373C8.9018 38.0592 9.39488 38.8541 9.93367 39.6177C10.3366 40.1884 10.7696 40.739 11.1075 41.1395L11.5129 41.6226L11.6781 41.8078L10.3216 42.9943H10.3241Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.87549 32.4036L4.82043 32.1533C4.7879 31.9931 4.73784 31.7628 4.68027 31.4875C4.57015 30.9343 4.45002 30.1934 4.36492 29.45C4.25656 28.4576 4.20558 27.4597 4.21225 26.4614H5.6764C5.68911 27.4006 5.75597 28.3383 5.87662 29.2698C5.96672 29.9657 6.09437 30.659 6.20699 31.1721C6.26706 31.4224 6.31712 31.6427 6.34965 31.7904C6.38219 31.938 6.40972 32.0407 6.40972 32.0407L4.87549 32.4061V32.4036Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.97559 20.5471C4.97559 20.5471 5.06318 20.1992 5.22587 19.6535C5.38855 19.1079 5.61631 18.402 5.88661 17.7112C6.25013 16.7846 6.66799 15.8803 7.13802 15.0029L8.23425 15.5786C7.80696 16.4194 7.42923 17.2844 7.10298 18.1693C6.8527 18.8326 6.64997 19.5084 6.51231 20.019C6.37466 20.5296 6.29207 20.88 6.29207 20.88L4.98059 20.5471H4.97559Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M20.2729 3.54408C20.2729 3.54408 20.6108 3.41642 21.1439 3.24121C21.677 3.066 22.3803 2.86075 23.1011 2.69055C24.0597 2.46559 25.0308 2.29842 26.0094 2.18994L26.1045 2.97088C25.1596 3.09339 24.2228 3.27141 23.2989 3.50403C22.6081 3.68425 21.9248 3.897 21.4217 4.07472C20.9187 4.25243 20.5833 4.38509 20.5833 4.38509L20.2729 3.54408Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M31.8909 2.22998C31.8909 2.22998 32.2513 2.27503 32.7994 2.36514C33.3475 2.45525 34.0683 2.60043 34.7791 2.78065C35.7296 3.02359 36.6648 3.32281 37.5798 3.67673L37.382 4.20487C36.4815 3.87653 35.5622 3.60238 34.629 3.38388C33.9307 3.21868 33.2249 3.09352 32.6918 3.01593C32.1587 2.93834 31.8008 2.90079 31.8008 2.90079L31.8859 2.22998H31.8909Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M42.7431 6.44531C42.7431 6.44531 43.0409 6.65056 43.4814 6.98597C43.9219 7.32137 44.4825 7.77942 45.0306 8.27002C45.7545 8.92384 46.4398 9.61918 47.0829 10.3525L46.8327 10.5778C45.5392 9.15751 44.0806 7.89704 42.4878 6.82327L42.7381 6.45532L42.7431 6.44531Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M50.3616 15.1755C51.2536 16.904 51.9319 18.7347 52.3814 20.6271L52.2713 20.6522C52.0285 19.7174 51.7302 18.798 51.3778 17.8988C51.0243 16.9988 50.6182 16.1204 50.1614 15.2682L50.3616 15.1655V15.1755Z" fill="rgba(8, 160, 162, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M21.7544 49.147C22.275 46.3562 23.7767 42.7017 25.8565 41.265C24.2848 38.8371 24.1246 35.5606 24.3073 33.0451C26.3646 36.7195 28.8975 40.4115 32.3313 42.8069C28.5295 43.5903 24.938 45.9457 21.7544 49.157V49.147ZM33.5026 40.4715C31.1125 38.782 28.9801 36.1588 26.6474 32.0314L22.24 24.2319L21.4716 32.4544C21.1938 35.443 21.4566 38.1287 22.27 40.4015C20.3554 42.6241 19.0964 45.8781 18.5508 48.4687L16.1206 60.0001L23.9669 51.585C26.9703 48.3611 30.1213 46.3712 33.1147 45.6653L38.9162 44.3037L33.5026 40.4791V40.4715Z" fill="rgba(146, 199, 64, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3056 31.2876C48.0141 32.2538 45.8016 32.0385 43.9095 31.5955C46.1921 30.344 48.2344 28.7921 49.1654 26.4368C50.2792 29.513 52.2113 32.444 54.3838 34.947C52.8345 34.4014 50.5169 33.0197 49.2956 31.2901L49.3056 31.2876ZM55.3248 33.6004C53.2525 31.22 51.6832 28.682 50.8048 26.3041L49.0102 21.4482L47.456 25.0701C46.7427 26.7346 45.2886 28.0737 42.6281 29.4379L36.8716 32.389L44.0497 33.9358C45.2587 34.2242 46.5019 34.3438 47.7438 34.2913C48.2989 34.2575 48.8474 34.1524 49.3757 33.9784C50.8464 35.3673 52.5892 36.436 54.4939 37.1172L60.0001 38.9669L55.3474 33.6204L55.3248 33.6004Z" fill="rgba(146, 199, 64, 1)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.6365 16.5725C13.8556 12.9131 11.6606 9.37382 8.85746 6.22001C11.3603 7.2888 14.7191 9.31625 16.0956 11.3137C18.3481 10.7004 21.3891 11.4163 23.7567 12.2047C20.483 12.9231 17.0191 14.0945 14.6365 16.5725ZM23.9619 10.1673C22.4323 9.6198 20.8556 9.21427 19.2517 8.95582C18.446 8.83159 17.6316 8.77216 16.8164 8.7781C14.7816 6.86079 11.9209 5.2163 9.67338 4.23261L0 0L6.40721 7.18618C9.21787 10.3375 11.0124 13.5338 11.593 16.5049L12.8995 23.0729L17.1117 18.3872C18.7711 16.5525 21.2539 15.326 25.0281 14.3949L31.5355 12.7929L23.9619 10.1673Z" fill="rgba(8, 160, 162, 1)"></path></svg>
                                    <div>
                                        <strong style="color: white; font-size: 1rem; display: block;">WAMCO</strong>
                                        <span style="color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; display: block;">WASTE MANAGEMENT</span>
                                        <span style="color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; display: block;">CORPORATION LIMITED</span>
                                    </div>
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
                   
                            @foreach($mainCategories->where('is_published', 1) as $mainCategory)
                                <div class="col-lg-2 col-md-6">
                                    <h6 class="footer-heading">{{ strtoupper($mainCategory->name) }}</h6>
                                    <ul class="footer-links">
                                        @foreach($mainCategory->pages->where('is_published', 1)->whereNull('parent_id')->sortBy('order') as $page)
                                            @if($page->has_children && $page->children->where('is_published', 1)->count() > 0)
                                                {{-- Parent page with children - show as section label --}}
                                                <li class="footer-section-label" style="color: rgb(29, 200, 226); margin-top: {{ $loop->first ? '0' : '1rem' }};">
                                                    {{ $page->name }}
                                                </li>
                                                
                                                {{-- Show child pages --}}
                                                @foreach($page->children->where('is_published', 1)->sortBy('order') as $childPage)
                                                    <li>
                                                        <a href="{{ route('content.show', ['page', $childPage->id]) }}">
                                                            {{ $childPage->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                {{-- Single page without children --}}
                                                <li>
                                                    <a href="{{ route('content.show', ['page', $page->id]) }}">
                                                        {{ $page->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    © {{ date('Y') }} WAMCO. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');
            const backdrop = document.querySelector('.nav-dropdown-backdrop');
            const dropdownMenus = document.querySelectorAll('.nav-dropdown-menu');
            let currentOpenDropdown = null;

            function closeDropdown() {
                if (currentOpenDropdown) {
                    currentOpenDropdown.classList.remove('active');
                    const dropdownContent = document.querySelector(`[data-dropdown-content="${currentOpenDropdown.dataset.dropdown}"]`);
                    if (dropdownContent) {
                        dropdownContent.classList.remove('active');
                        setTimeout(() => {
                            dropdownContent.style.display = 'none';
                        }, 300);
                    }
                    backdrop.classList.remove('active');
                    currentOpenDropdown = null;
                }
            }

            function openDropdown(navItem) {
                const dropdownId = navItem.dataset.dropdown;
                const dropdownContent = document.querySelector(`[data-dropdown-content="${dropdownId}"]`);
                
                if (dropdownContent) {
                    navItem.classList.add('active');
                    dropdownContent.style.display = 'block';
                    setTimeout(() => {
                        dropdownContent.classList.add('active');
                    }, 10);
                    backdrop.classList.add('active');
                    currentOpenDropdown = navItem;
                }
            }

            navItems.forEach(navItem => {
                const navLink = navItem.querySelector('.nav-link');
                
                if (navLink) {
                    navLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (currentOpenDropdown === navItem) {
                            closeDropdown();
                        } else {
                            if (currentOpenDropdown) {
                                closeDropdown();
                            }
                            openDropdown(navItem);
                        }
                    });
                }
            });

            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    closeDropdown();
                });
            }

            document.addEventListener('click', function(e) {
                if (currentOpenDropdown && 
                    !currentOpenDropdown.contains(e.target) && 
                    !e.target.closest('.nav-dropdown-menu')) {
                    closeDropdown();
                }
            });

            dropdownMenus.forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
            const mobileSubcategories = document.querySelectorAll('.mobile-subcategory');

            function disableBodyScroll() {
                document.body.classList.add('mobile-nav-open');
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            }

            function enableBodyScroll() {
                document.body.classList.remove('mobile-nav-open');
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
            }

            function openMobileMenu() {
                if (mobileNavOverlay) {
                    mobileNavOverlay.classList.add('active');
                }
                if (mobileMenuToggle) {
                    mobileMenuToggle.classList.add('active');
                }
                disableBodyScroll();
            }

            function closeMobileMenu() {
                if (mobileNavOverlay) {
                    mobileNavOverlay.classList.remove('active');
                }
                if (mobileMenuToggle) {
                    mobileMenuToggle.classList.remove('active');
                }
                enableBodyScroll();
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (mobileNavOverlay && mobileNavOverlay.classList.contains('active')) {
                        closeMobileMenu();
                    } else {
                        openMobileMenu();
                    }
                });
            }

            mobileSubcategories.forEach(subcategory => {
                const header = subcategory.querySelector('.mobile-subcategory-header');
                
                if (header) {
                    header.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const parentSection = subcategory.closest('.mobile-category-section');
                        if (parentSection) {
                            const otherSubcategories = parentSection.querySelectorAll('.mobile-subcategory');
                            
                            otherSubcategories.forEach(other => {
                                if (other !== subcategory) {
                                    other.classList.remove('active');
                                }
                            });
                        }
                        
                        subcategory.classList.toggle('active');
                    });
                }
            });

            if (mobileNavOverlay) {
                mobileNavOverlay.addEventListener('click', function(e) {
                    if (e.target === mobileNavOverlay) {
                        closeMobileMenu();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (currentOpenDropdown) {
                        closeDropdown();
                    }
                    if (mobileNavOverlay && mobileNavOverlay.classList.contains('active')) {
                        closeMobileMenu();
                    }
                }
            });

            window.addEventListener('orientationchange', function() {
                if (mobileNavOverlay && mobileNavOverlay.classList.contains('active')) {
                    setTimeout(function() {
                        mobileNavOverlay.style.height = '100vh';
                    }, 100);
                }
            });

            let touchStartY = 0;
            
            if (mobileNavOverlay) {
                mobileNavOverlay.addEventListener('touchstart', function(e) {
                    touchStartY = e.touches[0].clientY;
                }, { passive: true });

                mobileNavOverlay.addEventListener('touchmove', function(e) {
                    const mobileNavContent = mobileNavOverlay.querySelector('.mobile-nav-content');
                    if (!mobileNavContent) return;
                    
                    const scrollTop = mobileNavContent.scrollTop;
                    const scrollHeight = mobileNavContent.scrollHeight;
                    const clientHeight = mobileNavContent.clientHeight;
                    const touchY = e.touches[0].clientY;
                    const deltaY = touchY - touchStartY;

                    if ((scrollTop === 0 && deltaY > 0) || 
                        (scrollTop + clientHeight >= scrollHeight && deltaY < 0)) {
                        e.preventDefault();
                    }
                }, { passive: false });
            }
        });
    </script>
</body>
</html>