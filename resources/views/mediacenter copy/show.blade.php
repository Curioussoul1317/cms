 
@extends('layouts.app')

@section('title', 'Media Center')
 
@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .mediacenter-wrapper {
        display: flex;
        min-height: 100vh;
        padding: 40px 20px;
        max-width: 1400px;
        margin: 0 auto;
        gap: 40px;
    }

    /* Sidebar */
    .mediacenter-sidebar {
        width: 280px;
        flex-shrink: 0;
    }

    .sidebar-header {
        margin-bottom: 40px;
    }

    .sidebar-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0;
    }

    .categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        margin-bottom: 8px;
    }

    .category-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #4a5568;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .category-link:hover {
        background-color: #e6fffa;
        color: #1a202c;
        text-decoration: none;
    }

    .category-link.active {
        background-color: #e6fffa;
        color: #00d9b4;
        font-weight: 600;
    }

    .category-icon {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #cbd5e0;
        margin-right: 12px;
        transition: all 0.2s;
    }

    .category-link.active .category-icon {
        background-color: #00d9b4;
        width: 10px;
        height: 10px;
    }

    /* Content Area */
    .mediacenter-content {
        flex: 1;
    }

    .content-header {
        margin-bottom: 30px;
    }

    .content-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0;
    }

    /* File Cards Grid */
    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 24px;
    }

    .file-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .file-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .file-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .file-card-subtitle {
        font-size: 0.9rem;
        color: #718096;
        margin-bottom: 16px;
    }

    .file-card-date {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: #a0aec0;
        margin-bottom: 16px;
    }

    .file-card-date i {
        margin-right: 6px;
    }

    .view-btn {
        display: inline-block;
        padding: 8px 24px;
        background: #00d9b4;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .view-btn:hover {
        background: #00c4a0;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* PDF Viewer Section */
    .pdf-viewer-section {
        max-width: 900px;
    }

    .file-header {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #718096;
        text-decoration: none;
        font-size: 0.9rem;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-btn:hover {
        color: #00d9b4;
        text-decoration: none;
    }

    .file-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 12px;
    }

    .file-subtitle {
        color: #00d9b4;
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 16px;
    }

    .file-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .file-meta i {
        color: #00d9b4;
    }

    .download-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 28px;
        background: #00d9b4;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s;
        border: none;
    }

    .download-btn:hover {
        background: #00c4a0;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .pdf-viewer {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .pdf-container {
        width: 100%;
        text-align: center;
    }

    #pdf-canvas {
        max-width: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 4px;
    }

    .pdf-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin-top: 20px;
        padding: 16px;
        background: #f7fafc;
        border-radius: 8px;
    }

    .pdf-control-btn {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 6px;
        color: #4a5568;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
    }

    .pdf-control-btn:hover:not(:disabled) {
        background: #00d9b4;
        color: white;
        border-color: #00d9b4;
    }

    .pdf-control-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .page-info {
        color: #718096;
        font-size: 0.9rem;
    }

    .no-files {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }

    .no-files i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    /* Hide/Show sections */
    .hidden {
        display: none !important;
    }

    @media (max-width: 992px) {
        .mediacenter-wrapper {
            flex-direction: column;
        }

        .mediacenter-sidebar {
            width: 100%;
        }

        .categories-list {
            display: flex;
            overflow-x: auto;
            gap: 8px;
        }

        .category-item {
            margin-bottom: 0;
        }

        .files-grid {
            grid-template-columns: 1fr;
        }
    }
</style> 

<div class="mediacenter-wrapper">
    <!-- Sidebar -->
    <aside class="mediacenter-sidebar">
        <div class="sidebar-header">
            <h1>Media Center</h1>
        </div>

        <ul class="categories-list">
            @foreach($categories as $category)
                <li class="category-item">
                    <a href="{{ route('mediacenter.index', ['category' => $category->id]) }}" 
                       class="category-link {{ $selectedCategory && $selectedCategory->id == $category->id ? 'active' : '' }}">
                        <span class="category-icon"></span>
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <!-- Content -->
    <main class="mediacenter-content">
        <!-- Files Grid Section -->
        <div id="files-grid-section" class="{{ $selectedFile ? 'hidden' : '' }}">
            @if($selectedCategory)
                <div class="content-header">
                    <h2>{{ $selectedCategory->name }}</h2>
                </div>

                <div class="files-grid">
                    @forelse($files as $file)
                        <div class="file-card">
                            <h3 class="file-card-title">{{ $file->title }}</h3>
                            <p class="file-card-subtitle">{{ $file->reference_number }}</p>
                            <div class="file-card-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $file->date->format('jS F Y') }}
                            </div>
                            <a href="{{ route('mediacenter.index', ['category' => $selectedCategory->id, 'file' => $file->id]) }}" 
                               class="view-btn">
                                View
                            </a>
                        </div>
                    @empty
                        <div class="no-files">
                            <i class="bi bi-inbox"></i>
                            <p>No files available in this category</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="no-files">
                    <i class="bi bi-folder-x"></i>
                    <p>No categories available</p>
                </div>
            @endif
        </div>

        <!-- PDF Viewer Section -->
        @if($selectedFile)
        <div id="pdf-viewer-section" class="pdf-viewer-section">
            <!-- File Header -->
            <div class="file-header">
                <a href="{{ route('mediacenter.index', ['category' => $selectedCategory->id]) }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Back to files
                </a>
                <h1 class="file-title">{{ $selectedFile->title }}</h1>
                <p class="file-subtitle">{{ $selectedFile->reference_number }}</p>
                <div class="file-meta">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $selectedFile->date->format('jS F Y') }}</span>
                </div>
                <a href="{{ route('mediafiles.download', $selectedFile) }}" class="download-btn" download>
                    <i class="bi bi-download"></i>
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
                        <i class="bi bi-chevron-left"></i> Previous
                    </button>
                    <span class="page-info">
                        Page <span id="page-num"></span> of <span id="page-count"></span>
                    </span>
                    <button class="pdf-control-btn" id="next-page">
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </main>
</div>

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
    const scale = 1.5;
    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');

    function renderPage(num) {
        pageRendering = true;
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
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
        updateButtons();
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
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

    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page-count').textContent = pdfDoc.numPages;
        renderPage(pageNum);
        updateButtons();
    }).catch(function(error) {
        console.error('Error loading PDF:', error);
        document.getElementById('pdf-canvas').parentElement.innerHTML = 
            '<p style="color: #e53e3e; padding: 40px; text-align: center;">Error loading PDF. Please try downloading the file instead.</p>';
    });
</script>
@endif
@endsection