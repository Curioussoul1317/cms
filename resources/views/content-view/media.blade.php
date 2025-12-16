@extends('layouts.public')

@section('title', 'Media Center')

@section('content')
<main class="page-wrapper">
    <div class="page-body">
        <div class="" style="padding: 0px;">

            <style>
                :root {
                    --primary-teal: #00d9b4;
                    --primary-teal-dark: #00c4a0;
                    --text-dark: #1a202c;
                    --text-gray: #718096;
                    --text-muted: #a0aec0;
                    --border-color: #e2e8f0;
                    --bg-light: #f8f9fa;
                    --accent-gradient: linear-gradient(135deg, #1dc8e1 0%, #1fe9ba 100%);
                }

                .mediacenter-section {
                    background-color: var(--bg-light);
                    min-height: 100vh;
                    padding: 60px 0;
                }

                /* Sidebar Styles */
                .mediacenter-sidebar {
                    position: sticky;
                    top: 100px;
                }

                .sidebar-title {
                    font-size: 1.75rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 1.5rem;
                    padding-bottom: 1.5rem;
                    border-bottom: 1px solid var(--border-color);
                }

                .categories-list {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .category-item {
                    margin-bottom: 0;
                }

                .category-link {
                    display: flex;
                    align-items: center;
                    padding: 0.875rem 0;
                    color: var(--text-gray);
                    text-decoration: none;
                    font-weight: 500;
                    font-size: 1rem;
                    transition: all 0.2s ease;
                }

                .category-link:hover {
                    color: var(--text-dark);
                }

                .category-link.active {
                    color: var(--text-dark);
                    font-weight: 600;
                }

                .category-indicator {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    border: 2px solid #cbd5e0;
                    background-color: transparent;
                    margin-right: 14px;
                    flex-shrink: 0;
                    transition: all 0.2s ease;
                }

                .category-link:hover .category-indicator {
                    border-color: var(--accent-gradient);
                }

                .category-link.active .category-indicator {
                    background-color: var(--accent-gradient);
                    border-color: var(--accent-gradient);
                }

                /* File Cards */
                .file-card {
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
                    border-left: 4px solid var(--accent-gradient);
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    transition: all 0.3s ease;
                }

                .file-card:hover {
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                    transform: translateY(-2px);
                }

                .file-card-title {
                    font-size: 1.05rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 0.5rem;
                    line-height: 1.5;
                }

                .file-card-reference {
                    font-size: 0.875rem;
                    color: var(--text-gray);
                    margin-bottom: 1rem;
                }

                .btn-view {
                    display: inline-flex;
                    align-items: center;
                    padding: 0.5rem 1.5rem;
                    background: var(--accent-gradient);
                    color: #ffffff;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 0.875rem;
                    text-decoration: none;
                    transition: all 0.2s ease;
                    width: fit-content;
                    margin-bottom: 1rem;
                }

                .btn-view:hover {
                    background: var(--accent-gradient);
                    color: #ffffff;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(0, 217, 180, 0.3);
                }

                .file-card-date {
                    display: flex;
                    align-items: center;
                    font-size: 0.85rem;
                    color: var(--text-muted);
                    margin-top: auto;
                }

                .file-card-date i {
                    margin-right: 0.5rem;
                }

                /* PDF Viewer Section */
                .pdf-viewer-section {
                    max-width: 900px;
                }

                .file-header {
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1.75rem;
                    margin-bottom: 1.5rem;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
                    border-left: 4px solid var(--accent-gradient);
                }

                .back-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    color: var(--text-gray);
                    text-decoration: none;
                    font-size: 0.9rem;
                    margin-bottom: 1.25rem;
                    font-weight: 500;
                    transition: color 0.2s ease;
                }

                .back-btn:hover {
                    color: var(--accent-gradient);
                }

                .file-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 0.75rem;
                    line-height: 1.4;
                }

                .file-reference {
                    color: var(--text-gray);
                    font-size: 0.95rem;
                    font-weight: 500;
                    margin-bottom: 1rem;
                }

                .file-meta {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    color: var(--text-muted);
                    font-size: 0.9rem;
                    margin-bottom: 1.5rem;
                }

                .btn-download {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 0.75rem 2rem;
                    background: var(--accent-gradient);
                    color: #ffffff;
                    border-radius: 50px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 0.95rem;
                    transition: all 0.2s ease;
                }

                .btn-download:hover {
                    background: var(--primary-teal-dark);
                    color: #ffffff;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(0, 217, 180, 0.3);
                }

                .pdf-viewer {
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
                }

                .pdf-container {
                    width: 100%;
                    text-align: center;
                    overflow-x: auto;
                }

                #pdf-canvas {
                    max-width: 100%;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    border-radius: 4px;
                }

                .pdf-controls {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 1rem;
                    margin-top: 1.25rem;
                    padding: 1rem;
                    background: #f7fafc;
                    border-radius: 8px;
                }

                .pdf-control-btn {
                    background: #ffffff;
                    border: 1px solid var(--border-color);
                    padding: 0.625rem 1.25rem;
                    border-radius: 50px;
                    color: var(--text-gray);
                    cursor: pointer;
                    font-weight: 500;
                    font-size: 0.875rem;
                    transition: all 0.2s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                .pdf-control-btn:hover:not(:disabled) {
                    background: var(--accent-gradient);
                    color: #ffffff;
                    border-color: var(--accent-gradient);
                }

                .pdf-control-btn:disabled {
                    opacity: 0.4;
                    cursor: not-allowed;
                }

                .page-info {
                    color: var(--text-gray);
                    font-size: 0.9rem;
                    font-weight: 500;
                }

                /* Empty State */
                .no-files {
                    text-align: center;
                    padding: 5rem 1.5rem;
                    color: var(--text-muted);
                }

                .no-files i {
                    font-size: 4rem;
                    margin-bottom: 1.25rem;
                    opacity: 0.5;
                }

                .no-files p {
                    font-size: 1rem;
                    margin: 0;
                }

                /* Hide/Show sections */
                .hidden {
                    display: none !important;
                }

                /* Animation */
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(15px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .file-card {
                    animation: fadeInUp 0.4s ease forwards;
                    opacity: 0;
                }

                .file-card:nth-child(1) { animation-delay: 0.05s; }
                .file-card:nth-child(2) { animation-delay: 0.1s; }
                .file-card:nth-child(3) { animation-delay: 0.15s; }
                .file-card:nth-child(4) { animation-delay: 0.2s; }
                .file-card:nth-child(5) { animation-delay: 0.25s; }
                .file-card:nth-child(6) { animation-delay: 0.3s; }
                .file-card:nth-child(7) { animation-delay: 0.35s; }
                .file-card:nth-child(8) { animation-delay: 0.4s; }

                /* Responsive Styles */
                @media (max-width: 991.98px) {
                    .mediacenter-section {
                        padding: 40px 0;
                    }

                    .mediacenter-sidebar {
                        position: relative;
                        top: 0;
                        margin-bottom: 2rem;
                    }

                    .sidebar-title {
                        font-size: 1.5rem;
                        margin-bottom: 1rem;
                        padding-bottom: 1rem;
                    }

                    .categories-list {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.5rem;
                    }

                    .category-link {
                        padding: 0.5rem 1rem;
                        background: #ffffff;
                        border-radius: 50px;
                        border: 1px solid var(--border-color);
                    }

                    .category-link.active {
                        background: var(--accent-gradient);
                        color: #ffffff;
                        border-color: var(--accent-gradient);
                    }

                    .category-link.active .category-indicator {
                        background-color: #ffffff;
                        border-color: #ffffff;
                    }

                    .category-indicator {
                        width: 8px;
                        height: 8px;
                        margin-right: 8px;
                    }

                    .file-title {
                        font-size: 1.25rem;
                    }
                }

                @media (max-width: 767.98px) {
                    .mediacenter-section {
                        padding: 30px 0;
                    }

                    .file-card {
                        padding: 1.25rem;
                    }

                    .file-card-title {
                        font-size: 1rem;
                    }

                    .btn-view {
                        padding: 0.5rem 1.25rem;
                        font-size: 0.8rem;
                    }

                    .pdf-controls {
                        flex-wrap: wrap;
                        gap: 0.75rem;
                    }

                    .pdf-control-btn {
                        padding: 0.5rem 1rem;
                        font-size: 0.8rem;
                    }

                    .file-header {
                        padding: 1.25rem;
                    }

                    .file-title {
                        font-size: 1.15rem;
                    }

                    .btn-download {
                        padding: 0.625rem 1.5rem;
                        font-size: 0.875rem;
                        width: 100%;
                        justify-content: center;
                    }
                }

                @media (max-width: 575.98px) {
                    .mediacenter-section {
                        padding: 20px 0;
                    }

                    .sidebar-title {
                        font-size: 1.35rem;
                    }

                    .category-link {
                        font-size: 0.875rem;
                        padding: 0.5rem 0.875rem;
                    }

                    .file-card-title {
                        font-size: 0.95rem;
                    }

                    .file-card-reference {
                        font-size: 0.8rem;
                    }

                    .pdf-viewer {
                        padding: 1rem;
                    }

                    .pdf-controls {
                        padding: 0.75rem;
                    }

                    .page-info {
                        width: 100%;
                        text-align: center;
                        order: -1;
                        margin-bottom: 0.5rem;
                    }

                    .pdf-control-btn {
                        flex: 1;
                        justify-content: center;
                    }
                }
            </style>

            @if($heroData)
                @include('components.templates.hero_with_image', ['data' => $heroData])
            @endif

            <section class="mediacenter-section">
                <div class="container">
                    <div class="row g-4 g-lg-5">

                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <aside class="mediacenter-sidebar">
                                <h1 class="sidebar-title">Media Center</h1>
                                <ul class="categories-list">
                                    @foreach($categories as $category)
                                        <li class="category-item">
                                            <a href="{{ route('corprofile.Media', ['category' => $category->id]) }}"
                                               class="category-link {{ $selectedCategory && $selectedCategory->id == $category->id ? 'active' : '' }}">
                                                <span class="category-indicator"></span>
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                        </div>

                        <!-- Content Area -->
                        <div class="col-lg-9">
                            <main class="mediacenter-content">

                                <!-- Files Grid Section -->
                                <div id="files-grid-section" class="{{ $selectedFile ? 'hidden' : '' }}">
                                    @if($selectedCategory)
                                        <div class="row g-4">
                                            @forelse($files as $file)
                                                <div class="col-12 col-md-6">
                                                    <div class="file-card">
                                                        <h3 class="file-card-title">{{ $file->title }}</h3>
                                                        <p class="file-card-reference">{{ $file->reference_number }}</p>
                                                        <a href="{{ route('corprofile.Media', ['category' => $selectedCategory->id, 'file' => $file->id]) }}"
                                                           class="btn-view">
                                                            <i class="fa-solid fa-eye me-2"></i> View
                                                        </a>
                                                        <div class="file-card-date">
                                                            <i class="fa-regular fa-calendar"></i>
                                                            {{ $file->date->format('jS F Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <div class="no-files">
                                                        <i class="fa-solid fa-inbox d-block"></i>
                                                        <p>No files available in this category</p>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    @else
                                        <div class="no-files">
                                            <i class="fa-solid fa-folder-open d-block"></i>
                                            <p>Select a category to view files</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- PDF Viewer Section -->
                                @if($selectedFile)
                                    <div id="pdf-viewer-section" class="pdf-viewer-section">
                                        <!-- File Header -->
                                        <div class="file-header">
                                            <a href="{{ route('corprofile.Media', ['category' => $selectedCategory->id]) }}" class="back-btn">
                                                <i class="fa-solid fa-arrow-left"></i> Back to files
                                            </a>
                                            <h1 class="file-title">{{ $selectedFile->title }}</h1>
                                            <p class="file-reference">{{ $selectedFile->reference_number }}</p>
                                            <div class="file-meta">
                                                <i class="fa-regular fa-calendar"></i>
                                                <span>{{ $selectedFile->date->format('jS F Y') }}</span>
                                            </div>
                                            <a href="{{ route('corprofile.Mediadownload', $selectedFile) }}" class="btn-download" download>
                                                <i class="fa-solid fa-download"></i>
                                                Download
                                            </a>
                                        </div>

                                        <!-- PDF Viewer -->
                                        <div class="pdf-viewer">
                                            <div class="pdf-container">
                                                <canvas id="pdf-canvas"></canvas>
                                            </div>
                                            <div class="pdf-controls">
                                                <button class="pdf-control-btn" id="prev-page">
                                                    <i class="fa-solid fa-chevron-left"></i>
                                                    <span class="d-none d-sm-inline">Previous</span>
                                                </button>
                                                <span class="page-info">
                                                    Page <span id="page-num"></span> of <span id="page-count"></span>
                                                </span>
                                                <button class="pdf-control-btn" id="next-page">
                                                    <span class="d-none d-sm-inline">Next</span>
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </main>
                        </div>

                    </div>
                </div>
            </section>

            @if($selectedFile)
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
            <script>
                // PDF.js configuration
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                const url = '{{ $selectedFile->file_url }}';
                let pdfDoc = null;
                let pageNum = 1;
                let pageRendering = false;
                let pageNumPending = null;
                let scale = 1.5;
                const canvas = document.getElementById('pdf-canvas');
                const ctx = canvas.getContext('2d');

                // Adjust scale for mobile devices
                function getScale() {
                    if (window.innerWidth < 576) {
                        return 1.0;
                    } else if (window.innerWidth < 768) {
                        return 1.2;
                    }
                    return 1.5;
                }

                function renderPage(num) {
                    pageRendering = true;
                    scale = getScale();

                    pdfDoc.getPage(num).then(function(page) {
                        const viewport = page.getViewport({scale: scale});
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };

                        const renderTask = page.render(renderContext);

                        renderTask.promise.then(function() {
                            pageRendering = false;
                            if (pageNumPending !== null) {
                                renderPage(pageNumPending);
                                pageNumPending = null;
                            }
                        });
                    });

                    document.getElementById('page-num').textContent = num;
                }

                function queueRenderPage(num) {
                    if (pageRendering) {
                        pageNumPending = num;
                    } else {
                        renderPage(num);
                    }
                }

                function onPrevPage() {
                    if (pageNum <= 1) return;
                    pageNum--;
                    queueRenderPage(pageNum);
                    updateButtons();
                }

                function onNextPage() {
                    if (pageNum >= pdfDoc.numPages) return;
                    pageNum++;
                    queueRenderPage(pageNum);
                    updateButtons();
                }

                function updateButtons() {
                    document.getElementById('prev-page').disabled = pageNum <= 1;
                    document.getElementById('next-page').disabled = pageNum >= pdfDoc.numPages;
                }

                document.getElementById('prev-page').addEventListener('click', onPrevPage);
                document.getElementById('next-page').addEventListener('click', onNextPage);

                // Re-render on window resize for responsiveness
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function() {
                        if (pdfDoc) {
                            renderPage(pageNum);
                        }
                    }, 250);
                });

                pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                    pdfDoc = pdfDoc_;
                    document.getElementById('page-count').textContent = pdfDoc.numPages;
                    renderPage(pageNum);
                    updateButtons();
                }).catch(function(error) {
                    console.error('Error loading PDF:', error);
                    document.getElementById('pdf-canvas').parentElement.innerHTML =
                        '<div class="alert alert-danger text-center" role="alert">' +
                        '<i class="fa-solid fa-triangle-exclamation me-2"></i>' +
                        'Error loading PDF. Please try downloading the file instead.</div>';
                });
            </script>
            @endif

        </div>
    </div>
</main>
@endsection