 
<div class="steps-modern-section">
    <div class="container">
        {{-- Section Header --}}
        @if(!empty($data['section_title']) || !empty($data['section_description']))
            <div class="section-header-modern">
                @if(!empty($data['section_title']))
                    <h2 class="section-title-modern">{{ $data['section_title'] }}</h2>
                @endif
                @if(!empty($data['section_description']))
                    <p class="section-description-modern">{{ $data['section_description'] }}</p>
                @endif
            </div>
        @endif

        {{-- Steps --}}
        @if(isset($data['steps']) && is_array($data['steps']) && count($data['steps']) > 0)
            <div class="steps-container-modern">
                @foreach($data['steps'] as $index => $step)
                    @php
                        $stepNumber = $index + 1;
                        $isEven = $stepNumber % 2 === 0;
                    @endphp

                    <div class="step-modern {{ $isEven ? 'step-reverse' : '' }}">
                        <div class="row align-items-center g-5">
                            @if($isEven)
                                {{-- Even steps: Illustration left, content right --}}
                                <div class="col-lg-6">
                                    <div class="step-illustration" data-aos="fade-right">
                                        @if(!empty($step['svg_file']))
                                            <div class="illustration-svg">
                                                <img src="{{ asset('storage/' . $step['svg_file']) }}" alt="{{ $step['heading'] ?? 'Step ' . $stepNumber }}">
                                            </div>
                                        @else
                                            <div class="illustration-placeholder">
                                                <i class="ti ti-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="step-content-modern" data-aos="fade-left">
                                        <div class="step-number-large">{{ $stepNumber }}</div>
                                        
                                        @if(!empty($step['heading']))
                                            <h3 class="step-heading-modern">{{ $step['heading'] }}</h3>
                                        @endif
                                        
                                        @if(!empty($step['description']))
                                            <p class="step-description-modern">{{ $step['description'] }}</p>
                                        @endif
                                        
                                        @if(!empty($step['link_text']) && !empty($step['link_url']))
                                            <a href="{{ $step['link_url'] }}" 
                                               target="_blank" 
                                               class="btn-modern">
                                                {{ $step['link_text'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                {{-- Odd steps: Content left, illustration right --}}
                                <div class="col-lg-6">
                                    <div class="step-content-modern" data-aos="fade-right">
                                        <div class="step-number-large">{{ $stepNumber }}</div>
                                        
                                        @if(!empty($step['heading']))
                                            <h3 class="step-heading-modern">{{ $step['heading'] }}</h3>
                                        @endif
                                        
                                        @if(!empty($step['description']))
                                            <p class="step-description-modern">{{ $step['description'] }}</p>
                                        @endif
                                        
                                        @if(!empty($step['link_text']) && !empty($step['link_url']))
                                            <a href="{{ $step['link_url'] }}" 
                                               target="_blank" 
                                               class="btn-modern">
                                                {{ $step['link_text'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="step-illustration" data-aos="fade-left">
                                        @if(!empty($step['svg_file']))
                                            <div class="illustration-svg">
                                                <img src="{{ asset('storage/' . $step['svg_file']) }}" alt="{{ $step['heading'] ?? 'Step ' . $stepNumber }}">
                                            </div>
                                        @else
                                            <div class="illustration-placeholder">
                                                <i class="ti ti-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state-modern">
                <p>No steps to display</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Main Container */
    .steps-modern-section {
        background: #f8f9fa;
        padding: 5rem 2rem;
        position: relative;
    }

    .steps-modern-section .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Section Header */
    .section-header-modern {
        text-align: center;
        margin-bottom: 5rem;
    }

    .section-title-modern {
        font-size: 2.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .section-description-modern {
        font-size: 1.2rem;
        color: #6b7280;
        max-width: 700px;
        margin: 0 auto;
    }

    /* Steps Container */
    .steps-container-modern {
        position: relative;
    }

    .step-modern {
        margin-bottom: 8rem;
        position: relative;
    }

    .step-modern:last-child {
        margin-bottom: 0;
    }

    /* Step Content */
    .step-content-modern {
        padding: 2rem 0;
    }

    /* Large Step Number */
    .step-number-large {
        font-size: 6rem;
        font-weight: 700;
        color: #00D9A5;
        line-height: 1;
        margin-bottom: 1.5rem;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* Step Heading */
    .step-heading-modern {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    /* Step Description */
    .step-description-modern {
        font-size: 1.1rem;
        color: #4a5568;
        line-height: 1.7;
        margin-bottom: 2rem;
        max-width: 500px;
    }

    /* Button */
    .btn-modern {
        display: inline-block;
        background: #00D9A5;
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 217, 165, 0.3);
    }

    .btn-modern:hover {
        background: #00C494;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 217, 165, 0.4);
        color: white;
    }

    /* Illustration */
    .step-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        position: relative;
    }

    .illustration-svg {
        width: 100%;
        max-width: 450px;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .illustration-svg img {
        width: 100%;
        height: auto;
        max-height: 450px;
        object-fit: contain;
    }

    .illustration-placeholder {
        width: 350px;
        height: 350px;
        background: #e9ecef;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }

    .illustration-placeholder i {
        font-size: 6rem;
    }

    /* Empty State */
    .empty-state-modern {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
        font-size: 1.1rem;
    }

    /* Animation on scroll */
    [data-aos] {
        opacity: 0;
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    [data-aos].aos-animate {
        opacity: 1;
    }

    [data-aos="fade-right"] {
        transform: translateX(-30px);
    }

    [data-aos="fade-right"].aos-animate {
        transform: translateX(0);
    }

    [data-aos="fade-left"] {
        transform: translateX(30px);
    }

    [data-aos="fade-left"].aos-animate {
        transform: translateX(0);
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .steps-modern-section {
            padding: 3rem 1.5rem;
        }

        .section-title-modern {
            font-size: 2.25rem;
        }

        .section-description-modern {
            font-size: 1.1rem;
        }

        .step-modern {
            margin-bottom: 5rem;
        }

        .step-number-large {
            font-size: 4.5rem;
        }

        .step-heading-modern {
            font-size: 1.85rem;
        }

        .step-description-modern {
            font-size: 1rem;
        }

        .step-illustration {
            min-height: 300px;
            margin-bottom: 2rem;
        }

        .illustration-svg {
            max-width: 350px;
        }

        .illustration-svg img {
            max-height: 350px;
        }

        .illustration-placeholder {
            width: 280px;
            height: 280px;
        }

        .illustration-placeholder i {
            font-size: 4rem;
        }

        .btn-modern {
            padding: 0.875rem 2rem;
            font-size: 0.95rem;
        }

        /* Stack content vertically on tablets */
        .step-modern.step-reverse .col-lg-6:first-child {
            order: 2;
        }

        .step-modern.step-reverse .col-lg-6:last-child {
            order: 1;
        }
    }

    @media (max-width: 576px) {
        .steps-modern-section {
            padding: 2rem 1rem;
        }

        .section-header-modern {
            margin-bottom: 3rem;
        }

        .section-title-modern {
            font-size: 1.85rem;
        }

        .section-description-modern {
            font-size: 1rem;
        }

        .step-modern {
            margin-bottom: 3rem;
        }

        .step-content-modern {
            padding: 1rem 0;
        }

        .step-number-large {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .step-heading-modern {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .step-description-modern {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .step-illustration {
            min-height: 250px;
            margin-bottom: 1.5rem;
        }

        .illustration-svg {
            max-width: 280px;
        }

        .illustration-svg img {
            max-height: 280px;
        }

        .illustration-placeholder {
            width: 220px;
            height: 220px;
        }

        .illustration-placeholder i {
            font-size: 3rem;
        }

        .btn-modern {
            padding: 0.75rem 1.75rem;
            font-size: 0.9rem;
            width: 100%;
            text-align: center;
        }
    }
</style>

<script>
    // Simple scroll animation
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -80px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, observerOptions);

        document.querySelectorAll('[data-aos]').forEach(element => {
            observer.observe(element);
        });
    });
</script>