@extends('layouts.public')

@section('title', $news->title ?? 'News')
 
@section('content')
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

    /* Hero Section */
    .news-hero {
        position: relative;
        width: 100%;
        height: 70vh;
        min-height: 400px;
        max-height: 600px;
        overflow: hidden;
    }

    .news-hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
        padding: 3rem 0 2rem;
    }

    .news-hero-content {
        color: #fff;
    }

    .news-hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .news-hero-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        color: rgba(255,255,255,0.85);
        font-size: 0.9rem;
    }

    .news-hero-meta i {
        color: var(--primary-teal);
        margin-right: 0.4rem;
    }

    .news-badge {
        background: var(--accent-gradient);
        color: #fff;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Content Section */
    .news-content-section {
        padding: 3rem 0;
        background: #fff;
    }

    .news-excerpt {
        font-size: 1.25rem;
        color: var(--text-gray);
        line-height: 1.8;
        border-left: 4px solid var(--primary-teal);
        padding-left: 1.5rem;
        margin-bottom: 2rem;
        font-style: italic;
    }

    .news-body {
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--text-dark);
    }

    .news-body p {
        margin-bottom: 1.5rem;
    }

    /* Gallery Section */
    .gallery-section {
        padding: 2rem 0 3rem;
        background: var(--bg-light);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-teal);
    }

    .gallery-scroll-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-teal) var(--border-color);
        padding-bottom: 1rem;
    }

    .gallery-scroll-container::-webkit-scrollbar {
        height: 6px;
    }

    .gallery-scroll-container::-webkit-scrollbar-track {
        background: var(--border-color);
        border-radius: 10px;
    }

    .gallery-scroll-container::-webkit-scrollbar-thumb {
        background: var(--primary-teal);
        border-radius: 10px;
    }

    .gallery-scroll {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 0;
    }

    .gallery-item {
        flex: 0 0 auto;
        width: 280px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .gallery-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .gallery-item-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: #fff;
        padding: 2rem 1rem 0.75rem;
        font-size: 0.85rem;
    }

    .gallery-item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 217, 180, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-item-overlay {
        opacity: 1;
    }

    .gallery-item-overlay i {
        font-size: 2rem;
        color: #fff;
    }

    /* Other News Section */
    .other-news-section {
        padding: 3rem 0 4rem;
        background: #fff;
    }

    .news-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        border: 1px solid var(--border-color);
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        border-color: var(--primary-teal);
    }

    .news-card-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover .news-card-image img {
        transform: scale(1.1);
    }

    .news-card-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--accent-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .news-card-image-placeholder i {
        font-size: 3rem;
        color: rgba(255,255,255,0.5);
    }

    .news-card-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .news-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .news-card:hover .news-card-title {
        color: var(--primary-teal);
    }

    .news-card-excerpt {
        font-size: 0.9rem;
        color: var(--text-gray);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .news-card-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .news-card-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .news-card-date i {
        color: var(--primary-teal);
        margin-right: 0.4rem;
    }

    .news-card-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-teal);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: gap 0.3s ease;
    }

    .news-card:hover .news-card-link {
        gap: 0.7rem;
    }

    /* Share Buttons */
    .share-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .share-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        color: #fff;
    }

    .share-btn.facebook { background: #1877f2; }
    .share-btn.twitter { background: #1da1f2; }
    .share-btn.whatsapp { background: #25d366; }
    .share-btn.linkedin { background: #0077b5; }
    .share-btn.copy { background: var(--text-gray); }

    /* Lightbox */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
    }

    .lightbox-close {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 45px;
        height: 45px;
        background: rgba(255,255,255,0.1);
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: var(--primary-teal);
    }

    .lightbox-caption {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        background: rgba(0,0,0,0.7);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
    }

    /* Empty State */
    .empty-state-wrapper {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .empty-state {
        text-align: center;
        max-width: 400px;
    }

    .empty-state-icon {
        width: 140px;
        height: 140px;
        background: var(--bg-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        position: relative;
    }

    .empty-state-icon::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border-radius: 50%;
        background: var(--accent-gradient);
        z-index: -1;
        opacity: 0.3;
    }

    .empty-state-icon i {
        font-size: 4rem;
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .empty-state h2 {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.75rem;
    }

    .empty-state p {
        color: var(--text-gray);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn-primary-gradient {
        background: var(--accent-gradient);
        border: none;
        color: #fff;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 217, 180, 0.3);
    }

    .btn-primary-gradient:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 217, 180, 0.4);
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .news-hero {
            height: 50vh;
            min-height: 350px;
        }

        .news-hero-title {
            font-size: 1.75rem;
        }

        .gallery-item {
            width: 240px;
        }
    }

    @media (max-width: 767.98px) {
        .news-hero {
            height: 45vh;
            min-height: 300px;
        }

        .news-hero-title {
            font-size: 1.5rem;
        }

        .news-hero-meta {
            font-size: 0.8rem;
            gap: 1rem;
        }

        .news-hero-overlay {
            padding: 2rem 0 1.5rem;
        }

        .news-content-section {
            padding: 2rem 0;
        }

        .news-excerpt {
            font-size: 1.1rem;
            padding-left: 1rem;
        }

        .news-body {
            font-size: 1rem;
        }

        .gallery-section {
            padding: 1.5rem 0 2rem;
        }

        .gallery-item {
            width: 200px;
        }

        .gallery-item img {
            height: 140px;
        }

        .other-news-section {
            padding: 2rem 0 3rem;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .share-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .news-hero {
            height: 40vh;
            min-height: 280px;
        }

        .news-hero-title {
            font-size: 1.25rem;
        }

        .news-card-image {
            height: 150px;
        }

        .gallery-item {
            width: 180px;
        }

        .gallery-item img {
            height: 120px;
        }
    }
</style> 

<main class="page-wrapper">
    <div class="page-body">
        <div class="" style="padding: 0px;">

            @if($news)
            {{-- Hero Section --}}
            <section class="news-hero">
                @if($news->featured_image)
                <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="news-hero-image">
                @else
                <div class="news-hero-image" style="background: var(--accent-gradient);"></div>
                @endif
                
                <div class="news-hero-overlay">
                    <div class="container">
                        <div class="news-hero-content">
                            <span class="news-badge mb-3 d-inline-block">
                                <i class="fas fa-newspaper me-1"></i> News
                            </span>
                            <h1 class="news-hero-title">{{ $news->title }}</h1>
                            <div class="news-hero-meta">
                                <span>
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $news->published_at?->format('F d, Y') ?? $news->created_at->format('F d, Y') }}
                                </span>
                                @if($news->creator)
                                <span>
                                    <i class="far fa-user"></i>
                                    {{ $news->creator->name }}
                                </span>
                                @endif
                                @if($news->activeImages && $news->activeImages->count() > 0)
                                <span>
                                    <i class="far fa-images"></i>
                                    {{ $news->activeImages->count() }} Photos
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Content Section --}}
            <section class="news-content-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            @if($news->excerpt)
                            <p class="news-excerpt">{{ $news->excerpt }}</p>
                            @endif
                            
                            <div class="news-body">
                                {!! nl2br(e($news->content)) !!}
                            </div>

                            {{-- Share Buttons --}}
                            <div class="share-buttons">
                                <span class="text-muted me-2 d-flex align-items-center">
                                    <i class="fas fa-share-alt me-2"></i> Share:
                                </span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="share-btn facebook" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" 
                                   target="_blank" class="share-btn twitter" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}" 
                                   target="_blank" class="share-btn whatsapp" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($news->title) }}" 
                                   target="_blank" class="share-btn linkedin" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <button type="button" class="share-btn copy" onclick="copyToClipboard()" title="Copy Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Gallery Section --}}
            @if($news->activeImages && $news->activeImages->count() > 0)
            <section class="gallery-section">
                <div class="container">
                    <h2 class="section-title">
                        <i class="fas fa-images"></i>
                        Photo Gallery
                    </h2>
                    <div class="gallery-scroll-container">
                        <div class="gallery-scroll">
                            @foreach($news->activeImages as $image)
                            <div class="gallery-item" onclick="openLightbox('{{ $image->image_url }}', '{{ $image->caption }}')">
                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $news->title }}">
                                @if($image->caption)
                                <div class="gallery-item-caption">{{ $image->caption }}</div>
                                @endif
                                <div class="gallery-item-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif

            {{-- Other News Section --}}
            @if($otherNews && $otherNews->count() > 0)
            <section class="other-news-section">
                <div class="container">
                    <h2 class="section-title">
                        <i class="fas fa-newspaper"></i>
                        More News
                    </h2>
                    <div class="row g-4">
                        @foreach($otherNews as $item)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('news', $item->slug) }}" class="news-card">
                                <div class="news-card-image">
                                    @if($item->featured_image)
                                    <img src="{{ $item->featured_image_url }}" alt="{{ $item->title }}">
                                    @else
                                    <div class="news-card-image-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="news-card-body">
                                    <h3 class="news-card-title">{{ $item->title }}</h3>
                                    @if($item->excerpt)
                                    <p class="news-card-excerpt">{{ $item->excerpt }}</p>
                                    @else
                                    <p class="news-card-excerpt">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                                    @endif
                                </div>
                                <div class="news-card-footer">
                                    <span class="news-card-date">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $item->published_at?->format('M d, Y') ?? $item->created_at->format('M d, Y') }}
                                    </span>
                                    <span class="news-card-link">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            @else
            {{-- Empty State - No News Available --}}
            <div class="empty-state-wrapper">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h2>No News Yet</h2>
                    <p>We don't have any news to show right now. Please check back later for updates and announcements.</p>
                    <a href="{{ url('/') }}" class="btn-primary-gradient">
                        <i class="fas fa-home"></i>
                        Back to Home
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</main>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">
        <i class="fas fa-times"></i>
    </button>
    <img src="" alt="" id="lightbox-image">
    <div class="lightbox-caption" id="lightbox-caption"></div>
</div>

<script>
    // Lightbox Functions
    function openLightbox(src, caption) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-image');
        const lightboxCaption = document.getElementById('lightbox-caption');
        
        lightboxImg.src = src;
        lightboxCaption.textContent = caption || '';
        lightboxCaption.style.display = caption ? 'block' : 'none';
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close lightbox on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // Close lightbox on background click
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });

    // Copy to clipboard
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const btn = document.querySelector('.share-btn.copy');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.background = 'var(--primary-teal)';
            
            setTimeout(function() {
                btn.innerHTML = originalIcon;
                btn.style.background = '';
            }, 2000);
        });
    }

    // Horizontal scroll with mouse wheel
    const galleryContainer = document.querySelector('.gallery-scroll-container');
    if (galleryContainer) {
        galleryContainer.addEventListener('wheel', function(e) {
            if (e.deltaY !== 0) {
                e.preventDefault();
                this.scrollLeft += e.deltaY;
            }
        });
    }
</script>
@endsection 