{{-- resources/views/components/templates/cards.blade.php --}}

<div class="simple-cards-section"> 
    <div class="cards-container">
        {{-- Section Header --}}
        @if(!empty($data['section_heading']))
            <div class="section-header-simple">
                <h2 class="section-heading-white"> 
                    {{ $data['section_heading'] }}
                </h2>
            </div>
        @endif
        
        @if(!empty($data['section_subtitle']))
            <div class="section-subtitle-simple">
                <p class="subtitle-text-white">
                    {{ $data['section_subtitle'] }}
                </p>
            </div>
        @endif

        {{-- Cards Grid --}}
        @if(isset($data['cards']) && is_array($data['cards']) && count($data['cards']) > 0)
            <div class="simple-cards-grid">
                @foreach($data['cards'] as $card)
                    <div class="simple-card">
                        {{-- Icon with Dashed Circle --}}
                        <div class="simple-icon-container">
                            <div class="simple-dashed-circle">
                                @if(!empty($card['svg_file']))
                                    <div class="simple-svg-icon">
                                        <img src="{{ asset('storage/' . $card['svg_file']) }}" alt="{{ $card['heading'] ?? 'Icon' }}">
                                    </div>
                                @else
                                    <div class="simple-default-icon">
                                        <i class="ti ti-check-circle"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Card Heading (White) --}}
                        @if(!empty($card['heading']))
                            <h3 class="simple-card-heading">
                                {{ $card['heading'] }}
                            </h3>
                        @endif

                        {{-- Card Description (Dark) --}}
                        @if(!empty($card['description']))
                            <p class="simple-card-description">
                                {{ $card['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state-simple">
                <p>No cards to display</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Main Container - Cyan Gradient Background */
    .simple-cards-section {
        background: linear-gradient(135deg, #00d4ff 0%, #00e5cc 50%, #00f5b8 100%);
        padding: 4rem 2rem;
        margin: 0;
    }

    .cards-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Section Header */
    .section-header-simple {
        text-align: center;
        margin-bottom: 1rem;
    }

    .section-heading-white {
        color: white;
        font-size: 2.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-subtitle-simple {
        text-align: center;
        margin-bottom: 3.5rem;
    }

    .subtitle-text-white {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.2rem;
        margin: 0;
    }

    /* Cards Grid */
    .simple-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    /* Individual Card - White Background */
    .simple-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .simple-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    /* Icon Container */
    .simple-icon-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    /* Dashed Circle */
    .simple-dashed-circle {
        width: 180px;
        height: 180px;
        border: 3px dashed #00d4cc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        position: relative;
    }

    /* SVG Icon */
    .simple-svg-icon {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .simple-svg-icon img {
        width: 100%;
        height: 100%;
        max-width: 100px;
        max-height: 100px;
        object-fit: contain;
    }

    /* Default Icon */
    .simple-default-icon {
        font-size: 4.5rem;
        color: #00d4cc;
    }

    .simple-default-icon i {
        font-size: 4.5rem;
    }

    /* Card Heading (White/Dark) */
    .simple-card-heading {
        color: #1a1a1a;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    /* Card Description (Dark) */
    .simple-card-description {
        color: #2d3748;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Empty State */
    .empty-state-simple {
        text-align: center;
        padding: 3rem;
        color: white;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .simple-cards-section {
            padding: 3rem 1.5rem;
        }

        .section-heading-white {
            font-size: 2.25rem;
        }

        .subtitle-text-white {
            font-size: 1.1rem;
        }

        .simple-cards-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .simple-card {
            padding: 2rem 1.5rem;
        }

        .simple-dashed-circle {
            width: 150px;
            height: 150px;
        }

        .simple-svg-icon {
            width: 80px;
            height: 80px;
        }

        .simple-svg-icon img {
            max-width: 80px;
            max-height: 80px;
        }

        .simple-default-icon,
        .simple-default-icon i {
            font-size: 3.5rem;
        }

        .simple-card-heading {
            font-size: 1.35rem;
        }

        .simple-card-description {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 768px) {
        .simple-cards-grid {
            grid-template-columns: 1fr;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    @media (max-width: 576px) {
        .simple-cards-section {
            padding: 2rem 1rem;
        }

        .section-heading-white {
            font-size: 1.85rem;
        }

        .subtitle-text-white {
            font-size: 1rem;
        }

        .simple-card {
            padding: 1.75rem 1.25rem;
        }

        .simple-dashed-circle {
            width: 130px;
            height: 130px;
        }

        .simple-svg-icon {
            width: 70px;
            height: 70px;
        }

        .simple-svg-icon img {
            max-width: 70px;
            max-height: 70px;
        }

        .simple-default-icon,
        .simple-default-icon i {
            font-size: 3rem;
        }

        .simple-card-heading {
            font-size: 1.2rem;
        }

        .simple-card-description {
            font-size: 0.9rem;
        }
    }
</style>