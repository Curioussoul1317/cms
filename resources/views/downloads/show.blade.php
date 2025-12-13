 
@extends('layouts.app')

@section('title', 'Downloads')
@section('content')
<style>
    body {
        background-color: #f5f5f5;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .downloads-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .downloads-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .downloads-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0;
    }

    .category-accordion {
        margin-bottom: 16px;
    }

    .category-header {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px 24px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-header:hover {
        background: #edf2f7;
    }

    .category-header.active {
        background: #00d9b4;
        color: white;
        border-color: #00d9b4;
    }

    .category-name {
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0;
    }

    .category-header.active .category-name {
        color: white;
    }

    .category-icon {
        font-size: 1.3rem;
        transition: transform 0.3s;
        color: #00d9b4;
    }

    .category-header.active .category-icon {
        color: white;
        transform: rotate(180deg);
    }

    .category-content {
        display: none;
        background: white;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 8px 8px;
        padding: 0;
    }

    .category-content.active {
        display: block;
    }

    .download-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 28px;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }

    .download-item:last-child {
        border-bottom: none;
    }

    .download-item:hover {
        background: #f9fafb;
    }

    .download-info {
        flex: 1;
    }

    .download-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 8px;
    }

    .download-date {
        display: flex;
        align-items: center;
        font-size: 0.88rem;
        color: #a0aec0;
    }

    .download-date i {
        margin-right: 6px;
    }

    .download-buttons {
        display: flex;
        gap: 12px;
    }

    .download-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #00d9b4;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: none;
    }

    .download-btn:hover {
        background: #00c4a0;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .download-btn i {
        font-size: 1rem;
    }

    .no-files {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }

    .no-categories {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }

    .no-categories i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .download-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .download-buttons {
            width: 100%;
            flex-direction: column;
        }

        .download-btn {
            width: 100%;
            justify-content: center;
        }

        .downloads-header h1 {
            font-size: 1.8rem;
        }
    }
</style>
 


<div class="downloads-container">
    <div class="downloads-header">
        <h1>Downloads</h1>
    </div>

    @forelse($categories as $category)
        <div class="category-accordion">
            <div class="category-header" onclick="toggleCategory({{ $category->id }})">
                <h2 class="category-name">{{ $category->name }}</h2>
                <i class="bi bi-chevron-down category-icon" id="icon-{{ $category->id }}"></i>
            </div>
            <div class="category-content" id="content-{{ $category->id }}">
                @forelse($category->activeDownloadFiles as $file)
                    <div class="download-item">
                        <div class="download-info">
                            <div class="download-title">{{ $file->title }}</div>
                            <div class="download-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $file->date->format('jS F Y') }}
                            </div>
                        </div>
                        <div class="download-buttons">
                            @if($file->eng_file)
                                <a href="{{ route('downloadfiles.download-english', $file) }}" 
                                   class="download-btn" target="_blank">
                                    <i class="bi bi-download"></i>
                                    English
                                </a>
                            @endif
                            @if($file->dhivehi_file)
                                <a href="{{ route('downloadfiles.download-dhivehi', $file) }}" 
                                   class="download-btn" target="_blank">
                                    <i class="bi bi-download"></i>
                                    Dhivehi
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="no-files">
                        <p>No files available in this category</p>
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="no-categories">
            <i class="bi bi-inbox"></i>
            <h3>No download categories available</h3>
        </div>
    @endforelse
</div>

<script>
    function toggleCategory(categoryId) {
        const content = document.getElementById('content-' + categoryId);
        const header = content.previousElementSibling;
        const icon = document.getElementById('icon-' + categoryId);
        
        // Toggle current category
        content.classList.toggle('active');
        header.classList.toggle('active');
        
        // Close other categories (optional - remove if you want multiple open)
        document.querySelectorAll('.category-content').forEach(function(item) {
            if (item.id !== 'content-' + categoryId) {
                item.classList.remove('active');
            }
        });
        
        document.querySelectorAll('.category-header').forEach(function(item) {
            if (item !== header) {
                item.classList.remove('active');
            }
        });
    }
</script>
@endsection