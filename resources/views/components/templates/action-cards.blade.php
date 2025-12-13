<div class="action-cards-section">
    <div class="container-action">
        {{-- Section Heading --}}
        @if(!empty($data['section_heading']))
            <h2 class="action-section-heading">{{ $data['section_heading'] }}</h2> 
        @endif

        {{-- Action Cards Grid --}}
        @if(isset($data['cards']) && is_array($data['cards']) && count($data['cards']) > 0)
            <div class="action-cards-grid">
                @foreach($data['cards'] as $card)
                    @php
                        $hasLink = !empty($card['link_url']);
                        $cardTag = $hasLink ? 'a' : 'div';
                        $cardAttrs = $hasLink ? 'href="' . $card['link_url'] . '" target="_blank"' : '';
                    @endphp

                    <{{ $cardTag }} class="action-card {{ $hasLink ? 'action-card-link' : '' }}" {!! $cardAttrs !!}>
                        {{-- Icon Area with Mint Background --}}
                        <div class="action-card-icon-area">
                            @if(!empty($card['svg_file']))
                                <div class="action-svg-icon">
                                    <img src="{{ asset('storage/' . $card['svg_file']) }}" alt="{{ $card['text'] ?? 'Icon' }}">
                                </div>
                            @else
                                <div class="action-default-icon"> 
                                    <i class="ti ti-star"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Text Area --}}
                        <div class="action-card-text-area">
                            @if(!empty($card['text']))
                                <p class="action-card-text">{{ $card['text'] }}</p>
                            @endif
                        </div>
                    </{{ $cardTag }}>
                @endforeach
            </div>
        @else
            <div class="empty-state-action">
                <p>No action cards to display</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Main Section */
    .action-cards-section {
        background: #f8f9fa;
        padding: 4rem 2rem;
    }

    .container-action {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Section Heading */
    .action-section-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 3rem;
        text-align: left;
    }

    /* Cards Grid */
    .action-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    /* Individual Card */
    .action-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: block;
        text-decoration: none;
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .action-card-link {
        cursor: pointer;
    }

    /* Icon Area - Mint Background */
    .action-card-icon-area {
        background: linear-gradient(135deg, #A8E6CF 0%, #87DCC0 100%);
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
    }

    /* Dashed circle decoration (optional) */
    .action-card-icon-area::before {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        border: 2px dashed rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* SVG Icon */
    .action-svg-icon {
        width: 150px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .action-svg-icon img {
        width: 100%;
        height: 100%;
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
    }

    /* Default Icon */
    .action-default-icon {
        font-size: 6rem;
        color: white;
        position: relative;
        z-index: 2;
    }

    .action-default-icon i {
        font-size: 6rem;
    }

    /* Text Area */
    .action-card-text-area {
        background: white;
        padding: 2rem 1.5rem;
        text-align: center;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-card-text {
        color: #1a1a1a;
        font-size: 1.1rem;
        font-weight: 500;
        margin: 0;
        line-height: 1.4;
    }

    /* Empty State */
    .empty-state-action {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .action-cards-section {
            padding: 3rem 1.5rem;
        }

        .action-section-heading {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .action-cards-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .action-card-icon-area {
            min-height: 220px;
        }

        .action-card-icon-area::before {
            width: 150px;
            height: 150px;
        }

        .action-svg-icon {
            width: 120px;
            height: 120px;
        }

        .action-svg-icon img {
            max-width: 120px;
            max-height: 120px;
        }

        .action-default-icon,
        .action-default-icon i {
            font-size: 5rem;
        }

        .action-card-text {
            font-size: 1rem;
        }
    }

    @media (max-width: 768px) {
        .action-cards-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }
    }

    @media (max-width: 576px) {
        .action-cards-section {
            padding: 2rem 1rem;
        }

        .action-section-heading {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .action-card-icon-area {
            min-height: 200px;
            padding: 1.5rem;
        }

        .action-card-icon-area::before {
            width: 130px;
            height: 130px;
        }

        .action-svg-icon {
            width: 100px;
            height: 100px;
        }

        .action-svg-icon img {
            max-width: 100px;
            max-height: 100px;
        }

        .action-default-icon,
        .action-default-icon i {
            font-size: 4rem;
        }

        .action-card-text-area {
            padding: 1.5rem 1rem;
        }

        .action-card-text {
            font-size: 0.95rem;
        }
    }
</style>