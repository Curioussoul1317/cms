{{-- resources/views/components/templates/product-detail.blade.php --}}
<div class="container text-center">
  <div class="row justify-content-md-center" style="padding-top: 50px;
    padding-bottom: 50px;"> 
    <div class="col col-lg-10 col-md-10">
     
    
<div class="product-detail-widget-modern">
    <div class="card border-0  ">
        <div class="row g-4">
            {{-- Left Side: Image --}}
            <div class="col-lg-6">
                <div class="product-image-modern">
                    @if(!empty($data['image']))
                        <img src="{{ asset('storage/' . $data['image']) }}" 
                             alt="{{ $data['heading'] ?? 'Product' }}" 
                             class="image-cover">
                    @else
                        <div class="image-placeholder">
                            <i class="ti ti-photo"></i>
                            <p class="text-muted mt-2">No image</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Side: Content --}}
            <div class="col-lg-6">
                <div class="product-content-modern">
                    
                    {{-- Icon & Heading --}}
                    <div class="header-section">
                        <div class="d-flex align-items-start">
                            @if(!empty($data['icon']))
                                <div class="icon-badge-modern">
                                    {{ $data['icon'] }}
                                </div>
                            @endif
                            
                            @if(!empty($data['heading']))
                                <h2 class="main-heading-modern">
                                    {{ $data['heading'] }}
                                </h2>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    @if(!empty($data['description']))
                        <div class="description-section">
                            <p class="description-text">
                                {{ $data['description'] }}
                            </p>
                        </div>
                    @endif

                    {{-- Pricing Table Section --}}
                    <div class="pricing-section-modern">
                        @if(!empty($data['table_heading']))
                            <h4 class="table-heading-modern">
                                {{ $data['table_heading'] }}
                            </h4>
                        @endif

                        <div class="pricing-card">
                            <div class="pricing-table-modern">
                                <div class="table-header">
                                    <div class="table-cell">Unit</div>
                                    <div class="table-cell">Rate*</div>
                                </div>
                                <div class="table-body">
                                    <div class="table-cell unit-cell">
                                        {{ $data['unit_label'] ?? '-' }}
                                    </div>
                                    <div class="table-cell rate-cell">
                                        <span class="rate-value">{{ $data['rate_value'] ?? '-' }}</span>
                                        @if(!empty($data['table_note']))
                                            <span class="rate-note">(Including GST)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($data['table_note']))
                            <small class="table-footer-note">
                                {{ $data['table_note'] }}
                            </small>
                        @endif
                    </div>

                    {{-- Download Section --}}
                    @if(!empty($data['document_file']))
                        <div class="download-section-modern">
                            <div class="download-container">
                                <div class="download-label">
                                    @if(!empty($data['document_heading']))
                                        {{ $data['document_heading'] }}
                                    @else
                                        {{ $data['document_file_original_name'] ?? 'Document' }}
                                    @endif
                                </div>
                                
                                <a href="{{ asset('storage/' . $data['document_file']) }}" 
                                   target="_blank"
                                   download="{{ $data['document_file_original_name'] ?? 'document' }}"
                                   class="btn-download-modern">
                                    {{ $data['document_button_text'] ?? 'DOWNLOAD' }}
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</div>
  </div>
{{-- Keep the same CSS from before --}}

<style>
    /* Main Container */
    .product-detail-widget-modern {
        margin: 0;
        background:rgb(255, 255, 255);
    }

    .product-detail-widget-modern .card {
        border-radius: 16px;
        overflow: hidden;
        background: white;
    }

    /* Left Side - Image */
    .product-image-modern {
        height: 100%;
        min-height: 600px;
        position: relative;
        overflow: hidden;
        background:rgb(245, 0, 0);
        border-radius: 20px;
    }

    .image-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-detail-widget-modern:hover .image-cover {
        transform: scale(1.02);
    }

    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color:rgb(158, 158, 158);
    }

    .image-placeholder i {
        font-size: 4rem;
    }

    /* Right Side - Content */
    .product-content-modern {
        padding: 3rem 3rem 3rem 2.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgb(0 0 0 / 19%);
    }

    /* Header Section */
    .header-section {
        margin-bottom: 0.5rem;
    }

    .icon-badge-modern {
        width: 48px;
        height: 48px;
        background: #a3e635;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-right: 1rem;
        flex-shrink: 0;
        border-radius: 0;
        clip-path: polygon(0 0, 100% 0, 100% 80%, 50% 100%, 0 80%);
    }

    .main-heading-modern {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.3;
        margin: 0;
        padding-top: 0.25rem;
    }

    /* Description */
    .description-section {
        margin-top: -0.5rem;
    }

    .description-text {
        color: #4a5568;
        font-size: 1rem;
        line-height: 1.7;
        margin: 0;
    }

    /* Pricing Section */
    .pricing-section-modern {
        margin-top: 0.5rem;
    }

    .table-heading-modern {
        font-size: 1.15rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    /* Pricing Card */
    .pricing-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .pricing-table-modern {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .table-header {
        display: contents;
    }

    .table-header .table-cell {
        background: #f9fafb;
        padding: 1rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-body {
        display: contents;
    }

    .table-body .table-cell {
        padding: 1.5rem 1.5rem;
        font-size: 1rem;
    }

    .unit-cell {
        color: #1a1a1a;
        font-weight: 500;
        border-right: 1px solid #e5e7eb;
    }

    .rate-cell {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .rate-value {
        color: #1a1a1a;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .rate-note {
        color: #6b7280;
        font-size: 0.85rem;
        font-weight: 400;
        margin-top: 0.25rem;
    }

    .table-footer-note {
        display: block;
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.75rem;
        font-style: italic;
    }

    /* Download Section */
    .download-section-modern {
        margin-top: auto;
        padding-top: 1rem;
    }

    .download-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .download-label {
        font-size: 1.1rem;
        font-weight: 500;
        color: #1a1a1a;
    }

    .btn-download-modern {
        background: #a3e635;
        color: #1a1a1a;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(163, 230, 53, 0.3);
    }

    .btn-download-modern:hover {
        background: #84cc16;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(163, 230, 53, 0.4);
        color: #1a1a1a;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .product-image-modern {
            min-height: 400px;
        }

        .product-content-modern {
            padding: 2rem 1.5rem;
            gap: 1.5rem;
        }

        .main-heading-modern {
            font-size: 1.75rem;
        }

        .description-text {
            font-size: 0.95rem;
        }

        .pricing-table-modern {
            grid-template-columns: 1fr;
        }

        .table-header .table-cell:first-child {
            border-bottom: none;
        }

        .unit-cell {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
        }

        .rate-cell {
            padding-top: 1rem;
        }

        .download-container {
            flex-direction: column;
            text-align: center;
        }

        .btn-download-modern {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .product-image-modern {
            min-height: 300px;
        }

        .product-content-modern {
            padding: 1.5rem 1rem;
        }

        .icon-badge-modern {
            width: 40px;
            height: 40px;
            font-size: 1.5rem;
        }

        .main-heading-modern {
            font-size: 1.5rem;
        }

        .description-text {
            font-size: 0.9rem;
        }

        .table-header .table-cell,
        .table-body .table-cell {
            padding: 1rem;
        }

        .rate-value {
            font-size: 1.1rem;
        }

        .btn-download-modern {
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>