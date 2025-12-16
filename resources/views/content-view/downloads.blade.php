@extends('layouts.public')

@section('title', 'Downloads')

@section('content')
<main class="page-wrapper">
    <div class="page-body">
        <div class="" style="padding: 0px;">

            <style>
                :root {
                    --primary-teal: #00d9b4;
                    --primary-teal-dark: #00c4a0;
                    --text-dark: #1a202c;
                    --text-muted: #9ca3af;
                    --border-color: #e8e8e8;
                }

                .downloads-section {
                    background-color: #f8f9fa;
                    min-height: 100vh;
                }

                /* Accordion Container */
                .downloads-accordion {
                    border-radius: 0;
                }

                /* Accordion Item */
                .downloads-accordion .accordion-item {
                    border: none;
                    border-bottom: 1px solid var(--border-color);
                    border-radius: 0 !important;
                    background: transparent;
                }

                .downloads-accordion .accordion-item:first-child {
                    border-top: 1px solid var(--border-color);
                }

                /* Accordion Button (Header) */
                .downloads-accordion .accordion-button {
                    background: #ffffff;
                    border: none;
                    border-left: 4px solid var(--primary-teal);
                    border-radius: 0 !important;
                    padding: 1.25rem 1.5rem;
                    font-size: 1rem;
                    font-weight: 600;
                    color: var(--text-dark);
                    box-shadow: none !important;
                    transition: all 0.3s ease;
                }

                .downloads-accordion .accordion-button:hover {
                    background: #fafafa;
                }

                .downloads-accordion .accordion-button:not(.collapsed) {
                    background: linear-gradient(135deg, #00d9b4 0%, #00c9a7 100%);
                    color: #ffffff;
                    border-left: 4px solid var(--primary-teal);
                    border-radius: 8px 8px 0 0 !important;
                }

                /* Custom Arrow Icon */
                .downloads-accordion .accordion-button::after {
                    display: none;
                }

                .downloads-accordion .accordion-button .accordion-icon {
                    color: var(--primary-teal);
                    transition: transform 0.3s ease;
                    font-size: 0.9rem;
                }

                .downloads-accordion .accordion-button:not(.collapsed) .accordion-icon {
                    color: #ffffff;
                    transform: rotate(180deg);
                }

                /* Accordion Body */
                .downloads-accordion .accordion-collapse {
                    border-left: 4px solid var(--primary-teal);
                    border-radius: 0 0 8px 8px !important;
                    overflow: hidden;
                }

                .downloads-accordion .accordion-body {
                    padding: 0;
                    background: #ffffff;
                }

                /* Download Item */
                .download-item {
                    padding: 1.5rem;
                    border-bottom: 1px solid #f0f0f0;
                    transition: background 0.2s ease;
                }

                .download-item:last-child {
                    border-bottom: none;
                }

                .download-item:hover {
                    background: #fafafa;
                }

                .download-title {
                    font-size: 0.95rem;
                    font-weight: 600;
                    color: var(--text-dark);
                    margin-bottom: 0.625rem;
                    line-height: 1.4;
                }

                .download-date {
                    font-size: 0.85rem;
                    color: var(--text-muted);
                    display: flex;
                    align-items: center;
                }

                .download-date i {
                    margin-right: 0.5rem;
                }

                /* Download Buttons */
                .btn-download {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.625rem;
                    padding: 0.75rem 1.75rem;
                    background: var(--primary-teal);
                    color: #ffffff;
                    border-radius: 50px;
                    font-weight: 600;
                    font-size: 0.9rem;
                    border: none;
                    transition: all 0.2s ease;
                    text-decoration: none;
                    white-space: nowrap;
                }

                .btn-download:hover {
                    background: var(--primary-teal-dark);
                    color: #ffffff;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 217, 180, 0.35);
                }

                .btn-download i {
                    font-size: 0.85rem;
                }

                /* Empty States */
                .no-files {
                    padding: 2.5rem 1.5rem;
                    text-align: center;
                    color: var(--text-muted);
                }

                .no-files i {
                    font-size: 2.5rem;
                    margin-bottom: 1rem;
                    opacity: 0.5;
                }

                .no-categories {
                    text-align: center;
                    padding: 5rem 1.5rem;
                    color: var(--text-muted);
                }

                .no-categories i {
                    font-size: 4rem;
                    margin-bottom: 1.25rem;
                    opacity: 0.5;
                }

                .no-categories h3 {
                    font-size: 1.1rem;
                    font-weight: 500;
                    margin: 0;
                }

                /* Responsive - Large tablets */
                @media (max-width: 991.98px) {
                    .download-item {
                        padding: 1.25rem;
                    }

                    .btn-download {
                        padding: 0.625rem 1.25rem;
                        font-size: 0.85rem;
                    }
                }

                /* Responsive - Tablets */
                @media (max-width: 767.98px) {
                    .downloads-section {
                        padding-top: 2rem !important;
                        padding-bottom: 2rem !important;
                    }

                    .download-item .row {
                        flex-direction: column;
                    }

                    .download-buttons {
                        margin-top: 1rem;
                        width: 100%;
                    }

                    .download-buttons .btn-download {
                        flex: 1;
                        justify-content: center;
                    }

                    .downloads-accordion .accordion-button {
                        padding: 1rem 1.25rem;
                        font-size: 0.95rem;
                    }

                    .download-title {
                        font-size: 0.9rem;
                    }

                    .download-date {
                        font-size: 0.8rem;
                    }
                }

                /* Responsive - Mobile */
                @media (max-width: 575.98px) {
                    .downloads-section {
                        padding-top: 1.5rem !important;
                        padding-bottom: 1.5rem !important;
                    }

                    .downloads-section .container {
                        padding-left: 1rem;
                        padding-right: 1rem;
                    }

                    .downloads-accordion .accordion-button {
                        padding: 0.875rem 1rem;
                        font-size: 0.9rem;
                    }

                    .downloads-accordion .accordion-button .accordion-icon {
                        font-size: 0.8rem;
                    }

                    .download-item {
                        padding: 1rem;
                    }

                    .download-title {
                        font-size: 0.875rem;
                        margin-bottom: 0.5rem;
                    }

                    .download-date {
                        font-size: 0.75rem;
                    }

                    .download-buttons {
                        flex-direction: column;
                        gap: 0.5rem !important;
                    }

                    .btn-download {
                        padding: 0.75rem 1rem;
                        font-size: 0.8rem;
                        gap: 0.5rem;
                        width: 100%;
                        justify-content: center;
                    }

                    .no-files {
                        padding: 2rem 1rem;
                    }

                    .no-files i {
                        font-size: 2rem;
                    }

                    .no-files p {
                        font-size: 0.875rem;
                    }

                    .no-categories {
                        padding: 3rem 1rem;
                    }

                    .no-categories i {
                        font-size: 3rem;
                    }

                    .no-categories h3 {
                        font-size: 1rem;
                    }
                }

                /* Extra small devices */
                @media (max-width: 375px) {
                    .downloads-accordion .accordion-button {
                        padding: 0.75rem 0.875rem;
                        font-size: 0.85rem;
                    }

                    .download-item {
                        padding: 0.875rem;
                    }

                    .btn-download {
                        padding: 0.625rem 0.875rem;
                        font-size: 0.75rem;
                    }
                }
            </style>

            @if($heroData)
                @include('components.templates.hero_with_image', ['data' => $heroData])
            @endif

            <section class="downloads-section py-5">
                <div class="container">

                    @if($categories->count() > 0)
                        <div class="accordion downloads-accordion" id="downloadsAccordion">
                            @foreach($categories as $category)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $category->id }}">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} d-flex justify-content-between align-items-center"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $category->id }}"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $category->id }}">
                                            <span>{{ $category->name }}</span>
                                            <i class="fa-solid fa-chevron-down accordion-icon"></i>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $category->id }}"
                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $category->id }}"
                                         data-bs-parent="#downloadsAccordion">
                                        <div class="accordion-body">
                                            @forelse($category->activeDownloadFiles as $file)
                                                <div class="download-item">
                                                    <div class="row align-items-center g-3">
                                                        <div class="col-12 col-md">
                                                            <div class="download-info">
                                                                <div class="download-title">
                                                                    <i class="fa-regular fa-file-lines me-2"></i>
                                                                    {{ $file->title }}
                                                                </div>
                                                                <div class="download-date">
                                                                    <i class="fa-regular fa-calendar"></i>
                                                                    {{ $file->date->format('jS F Y') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-auto">
                                                            <div class="download-buttons d-flex gap-2 gap-lg-3">
                                                                @if($file->eng_file)
                                                                    <a href="{{ route('downloadfiles.download-english', $file) }}"
                                                                       class="btn-download"
                                                                       target="_blank">
                                                                        <i class="fa-solid fa-globe"></i>
                                                                        English
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </a>
                                                                @endif
                                                                @if($file->dhivehi_file)
                                                                    <a href="{{ route('downloadfiles.download-dhivehi', $file) }}"
                                                                       class="btn-download"
                                                                       target="_blank">
                                                                        <i class="fa-solid fa-language"></i>
                                                                        Dhivehi
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="no-files">
                                                    <i class="fa-regular fa-folder-open d-block"></i>
                                                    <p class="mb-0">No files available in this category</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-categories">
                            <i class="fa-solid fa-inbox d-block"></i>
                            <h3>No download categories available</h3>
                        </div>
                    @endif

                </div>
            </section>

            <!-- Bootstrap 5 JS Bundle for Accordion -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        </div>
    </div>
</main>
@endsection