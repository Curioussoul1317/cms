{{-- resources/views/components/templates/cards-grouped.blade.php --}}

<div class="gradient-cards-grouped-section">
    <div class="card border-0 overflow-hidden">
        <div class="gradient-background-cyan">
            <div class="card-body p-5">
                {{-- Section Header --}}
                @if(!empty($data['section_heading']) || !empty($data['section_subtitle']))
                    <div class="section-header text-center mb-5">
                        @if(!empty($data['section_heading']))
                            <h2 class="section-heading text-white mb-2">
                                {{ $data['section_heading'] }}
                            </h2>
                        @endif
                        
                        @if(!empty($data['section_subtitle']))
                            <p class="section-subtitle text-white-75">
                                {{ $data['section_subtitle'] }}
                            </p>
                        @endif
                    </div>
                @endif

                {{-- Card Groups as Tabs --}}
                @if(isset($data['card_groups']) && is_array($data['card_groups']) && count($data['card_groups']) > 0)
                    
                    {{-- Tab Navigation --}}
                    <div class="tabs-navigation-cyan">
                        @foreach($data['card_groups'] as $groupIndex => $group)
                            <button class="tab-button-cyan {{ $groupIndex === 0 ? 'active' : '' }}" 
                                    onclick="toggleGroupCyan({{ $groupIndex }})"
                                    data-group="{{ $groupIndex }}">
                                {{ $group['group_heading'] ?? 'Group ' . ($groupIndex + 1) }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Tab Content --}}
                    <div class="card-groups-container-cyan">
                        @foreach($data['card_groups'] as $groupIndex => $group)
                            <div class="group-cards-panel {{ $groupIndex === 0 ? 'show' : '' }}" 
                                 data-panel="{{ $groupIndex }}">
                                
                                @if(isset($group['cards']) && is_array($group['cards']) && count($group['cards']) > 0)
                                    <div class="service-cards-grid-cyan">
                                        @foreach($group['cards'] as $card)
                                            <div class="service-card-cyan">
                                                {{-- Icon/Illustration Container with Dashed Circle --}}
                                                <div class="card-icon-container-cyan">
                                                    <div class="dashed-circle-cyan">
                                                        <div class="icon-wrapper-cyan">
                                                            @if(!empty($card['svg_file']))
                                                                <div class="svg-icon-cyan">
                                                                    <img src="{{ asset('storage/' . $card['svg_file']) }}" alt="{{ $card['heading'] ?? 'Icon' }}">
                                                                </div>
                                                            @else
                                                                <div class="default-icon-cyan">
                                                                    <i class="ti ti-check-circle"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Card Content --}}
                                                <div class="card-content-cyan">
                                                    @if(!empty($card['heading']))
                                                        <h3 class="card-heading-cyan">{{ $card['heading'] }}</h3>
                                                    @endif
                                                    
                                                    @if(!empty($card['description']))
                                                        <p class="card-subtext-cyan">{{ $card['description'] }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-white-75 mb-0">No cards in this group</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="text-center py-5">
                        <p class="text-white-75">No card groups to display</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Main Container - Cyan Gradient Background */
    .gradient-cards-grouped-section {
        margin: 0;
    }

    .gradient-background-cyan {
        background: linear-gradient(135deg, #00d4ff 0%, #00c9cc 50%, #00bfa5 100%);
        padding: 3rem 2rem 4rem;
        position: relative;
        overflow: hidden;
        min-height: 500px;
    }

    /* Section Header */
    .section-header {
        position: relative;
        z-index: 2;
    }

    .section-heading {
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }

    /* Tab Navigation (like in image) */
    .tabs-navigation-cyan {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-bottom: 3rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 2;
    }

    .tab-button-cyan {
        background: none;
        border: none;
        color: white;
        font-size: 1.25rem;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }

    .tab-button-cyan:hover {
        opacity: 0.9;
    }

    .tab-button-cyan.active {
        border-bottom-color: #00ff88;
        font-weight: 600;
    }

    /* Card Groups Container */
    .card-groups-container-cyan {
        position: relative;
        z-index: 2;
    }

    .group-cards-panel {
        display: none;
        animation: fadeInCyan 0.4s ease;
    }

    .group-cards-panel.show {
        display: block;
    }

    @keyframes fadeInCyan {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Service Cards Grid */
    .service-cards-grid-cyan {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Individual Service Card - White Background */
    .service-card-cyan {
        background: white;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .service-card-cyan:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* Icon Container */
    .card-icon-container-cyan {
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: center;
    }

    /* Dashed Circle (matches image) */
    .dashed-circle-cyan {
        width: 200px;
        height: 200px;
        border: 3px dashed #00d4cc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        animation: rotateCyan 20s linear infinite;
    }

    @keyframes rotateCyan {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Icon Wrapper - prevents rotation of icon */
    .icon-wrapper-cyan {
        animation: counterRotateCyan 20s linear infinite;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes counterRotateCyan {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(-360deg);
        }
    }

    /* SVG Icon */
    .svg-icon-cyan {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .svg-icon-cyan img {
        width: 100%;
        height: 100%;
        max-width: 120px;
        max-height: 120px;
        object-fit: contain;
    }

    /* Default Icon */
    .default-icon-cyan {
        font-size: 5rem;
        color: #00d4cc;
    }

    .default-icon-cyan i {
        font-size: 5rem;
    }

    /* Card Content */
    .card-content-cyan {
        margin-top: 1.5rem;
    }

    .card-heading-cyan {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-subtext-cyan {
        color: #1a1a1a;
        font-size: 1rem;
        font-weight: 400;
        margin: 0;
    }

    /* Pause animation on hover */
    .service-card-cyan:hover .dashed-circle-cyan {
        animation-play-state: paused;
    }

    .service-card-cyan:hover .icon-wrapper-cyan {
        animation-play-state: paused;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .gradient-background-cyan {
            padding: 2rem 1rem 3rem;
        }

        .service-cards-grid-cyan {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .tabs-navigation-cyan {
            gap: 2rem;
        }

        .tab-button-cyan {
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
        }

        .service-card-cyan {
            padding: 2rem 1.5rem;
        }

        .dashed-circle-cyan {
            width: 160px;
            height: 160px;
        }

        .svg-icon-cyan {
            width: 100px;
            height: 100px;
        }

        .svg-icon-cyan img {
            max-width: 100px;
            max-height: 100px;
        }

        .default-icon-cyan,
        .default-icon-cyan i {
            font-size: 4rem;
        }

        .card-heading-cyan {
            font-size: 1.25rem;
        }

        .card-subtext-cyan {
            font-size: 0.95rem;
        }

        .section-heading {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .service-cards-grid-cyan {
            grid-template-columns: 1fr;
            max-width: 400px;
        }

        .tabs-navigation-cyan {
            gap: 1rem;
            flex-wrap: wrap;
        }

        .tab-button-cyan {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .gradient-background-cyan {
            padding: 1.5rem 0.75rem 2rem;
        }

        .dashed-circle-cyan {
            width: 140px;
            height: 140px;
        }

        .svg-icon-cyan {
            width: 80px;
            height: 80px;
        }

        .svg-icon-cyan img {
            max-width: 80px;
            max-height: 80px;
        }

        .default-icon-cyan,
        .default-icon-cyan i {
            font-size: 3rem;
        }

        .card-heading-cyan {
            font-size: 1.1rem;
        }

        .card-subtext-cyan {
            font-size: 0.9rem;
        }

        .section-heading {
            font-size: 1.75rem;
        }
    }
</style>

<script>
    function toggleGroupCyan(index) {
        // Remove active class from all tabs and panels
        document.querySelectorAll('.tab-button-cyan').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.group-cards-panel').forEach(panel => {
            panel.classList.remove('show');
        });

        // Add active class to clicked tab and corresponding panel
        document.querySelector(`.tab-button-cyan[data-group="${index}"]`).classList.add('active');
        document.querySelector(`.group-cards-panel[data-panel="${index}"]`).classList.add('show');
    }
</script>