@extends('layouts.public')


@section('content')

<main class="page-wrapper">
        <div class="page-body">
            <div class="" style="padding: 0px;">
                 <div class="row row-cards" style="margin-right: 0px; margin-left: 0px;">                      
                            <div class="col-12" style="padding: 0;">                         
                                
                            
                            @if($heroData)
        @include('components.templates.hero_with_image', ['data' => $heroData])
    @endif





      <!-- Our Company Section -->
      <section id="our-company" class="content-section py-5">      
<style>
/* Corporate Profile Custom Styles */
:root {
    --corprofile-primary: #00D4C8;
    --corprofile-text: #333333;
    --corprofile-text-light: #666666;
    --corprofile-bg: #F5F5F5;
}

.corprofile-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 60px 20px;
    background-color: white;
}

.corprofile-header {
    text-align: center;
    margin-bottom: 60px;
}

.corprofile-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 20px;
}

.corprofile-description {
    font-size: 0.95rem;
    color: var(--corprofile-text-light);
    line-height: 1.7;
    max-width: 900px;
    margin: 0 auto;
}

.corprofile-video-container {
    margin-bottom: 60px;
    text-align: center;
}

.corprofile-video-container video {
    max-width: 100%;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

/* Section Styles */
.corprofile-section {
    margin-bottom: 80px;
}

.corprofile-section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 40px;
    text-align: center;
}

/* Icon Box Styles */
.corprofile-icon-box {
    background: linear-gradient(135deg, #00D4C8 0%, #00B8AD 100%);
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100px;
    width: 100px;
}

.corprofile-icon-box img {
    max-width: 60px;
    max-height: 60px;
    height: auto;
}

/* Vision & Mission Styles */
.corprofile-vm-box {
    padding-left: 30px;
}

.corprofile-vm-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 15px;
}

.corprofile-vm-text {
    font-size: 0.95rem;
    color: var(--corprofile-text-light);
    line-height: 1.7;
}

/* Objectives Section */
.corprofile-objectives-section {
    background-color: var(--corprofile-bg);
    padding: 50px 0;
    margin-left: -20px;
    margin-right: -20px;
}

.corprofile-objective-card {
    background-color: white;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 3px solid var(--corprofile-primary);
}

.corprofile-objective-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 8px;
}

.corprofile-objective-desc {
    font-size: 0.85rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
}

.corprofile-objectives-image {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.corprofile-objectives-image img {
    max-width: 200px;
    height: auto;
}

/* List Styles with Checkmarks */
.corprofile-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.corprofile-list-item {
    padding: 12px 0;
    padding-left: 35px;
    position: relative;
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
}

.corprofile-list-item::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 12px;
    width: 20px;
    height: 20px;
    background-color: var(--corprofile-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
}

/* Numbered List Styles */
.corprofile-numbered-list {
    list-style: none;
    padding: 0;
    margin: 0;
    counter-reset: corprofile-counter;
}

.corprofile-numbered-item {
    padding: 12px 0;
    padding-left: 40px;
    position: relative;
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
    counter-increment: corprofile-counter;
}

.corprofile-numbered-item::before {
    content: counter(corprofile-counter);
    position: absolute;
    left: 0;
    top: 12px;
    width: 24px;
    height: 24px;
    background-color: var(--corprofile-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 13px;
}

/* Strategies and Values Image Container */
.corprofile-image-container {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.corprofile-image-container img {
    max-width: 200px;
    height: auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .corprofile-container {
        padding: 40px 15px;
    }
    
    .corprofile-header h1 {
        font-size: 1.75rem;
    }
    
    .corprofile-section-title {
        font-size: 1.5rem;
    }
    
    .corprofile-vm-box {
        padding-left: 0;
        margin-top: 20px;
    }
    
    .corprofile-icon-box {
        margin: 0 auto 20px;
    }
    
    .corprofile-objectives-image,
    .corprofile-image-container {
        margin-top: 30px;
    }
}

@media (max-width: 576px) {
    .corprofile-icon-box {
        width: 80px;
        height: 80px;
        padding: 20px;
    }
    
    .corprofile-icon-box img {
        max-width: 50px;
        max-height: 50px;
    }
}
</style>

 
<div class="corprofile-container">
    <!-- Header Section -->
    <div class="corprofile-header">
        <h1>Corporate Profile</h1>
        @if($corprofile->description)
            <div class="corprofile-description">
                {{ $corprofile->description }}
            </div>
        @endif
    </div>

    <!-- Video Section -->
    @if($corprofile->video)
        <div class="corprofile-video-container">
            <video width="100%" height="auto" controls>
                <source src="{{ asset('storage/' . $corprofile->video) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif

    <!-- Vision Section -->
    @if($corprofile->vision_text || $corprofile->vision_image)
        <div class="corprofile-section">
            <div class="row align-items-center">
                <div class="col-md-2 mb-4 mb-md-0">
                    @if($corprofile->vision_image)
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->vision_image) }}" alt="Vision">
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <div class="corprofile-vm-box">
                        <h3 class="corprofile-vm-title">Vision</h3>
                        <p class="corprofile-vm-text">{{ $corprofile->vision_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Mission Section -->
    @if($corprofile->mission_text || $corprofile->mission_image)
        <div class="corprofile-section">
            <div class="row align-items-center">
                <div class="col-md-2 mb-4 mb-md-0">
                    @if($corprofile->mission_image)
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->mission_image) }}" alt="Mission">
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <div class="corprofile-vm-box">
                        <h3 class="corprofile-vm-title">Mission</h3>
                        <p class="corprofile-vm-text">{{ $corprofile->mission_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Objectives Section -->
    @if($corprofile->objectives->count() > 0)
        <div class="corprofile-objectives-section">
            <div class="container">
                <h2 class="corprofile-section-title">Objectives</h2>
                
                <div class="row">
                    <div class="col-lg-8">
                        @foreach($corprofile->objectives as $objective)
                            <div class="corprofile-objective-card">
                                <h4 class="corprofile-objective-title">{{ $objective->title }}</h4>
                                <p class="corprofile-objective-desc">{{ $objective->description }}</p>
                            </div>
                        @endforeach
                    </div>
                    @if($corprofile->objectives_image)
                        <div class="col-lg-4">
                            <div class="corprofile-objectives-image">
                                <img src="{{ asset('storage/' . $corprofile->objectives_image) }}" alt="Objectives" class="img-fluid">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Strategies Section -->
    @if($corprofile->strategies->count() > 0)
        <div class="corprofile-section">
            <h2 class="corprofile-section-title">Strategies</h2>
            
            <div class="row align-items-center">
                @if($corprofile->strategies_image)
                    <div class="col-md-2 mb-4 mb-md-0">
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->strategies_image) }}" alt="Strategies">
                        </div>
                    </div>
                @endif
                <div class="{{ $corprofile->strategies_image ? 'col-md-10' : 'col-md-12' }}">
                    <ul class="corprofile-list">
                        @foreach($corprofile->strategies as $strategy)
                            <li class="corprofile-list-item">{{ $strategy->text }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Values Section -->
    @if($corprofile->values->count() > 0)
        <div class="corprofile-section">
            <h2 class="corprofile-section-title">Values</h2>
            
            <div class="row align-items-center">
                <div class="{{ $corprofile->values_image ? 'col-md-9' : 'col-md-12' }}">
                    <ul class="corprofile-list">
                        @foreach($corprofile->values as $value)
                            <li class="corprofile-list-item">{{ $value->text }}</li>
                        @endforeach
                    </ul>
                </div>
                @if($corprofile->values_image)
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="corprofile-image-container">
                            <img src="{{ asset('storage/' . $corprofile->values_image) }}" alt="Values">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Guiding Principles Section -->
    @if($corprofile->principles->count() > 0)
        <div class="corprofile-section">
            <h2 class="corprofile-section-title">Guiding Principles</h2>
            
            <div class="row align-items-center">
                @if($corprofile->principles_image)
                    <div class="col-md-2 mb-4 mb-md-0">
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->principles_image) }}" alt="Guiding Principles">
                        </div>
                    </div>
                @endif
                <div class="{{ $corprofile->principles_image ? 'col-md-10' : 'col-md-12' }}">
                    <ol class="corprofile-numbered-list">
                        @foreach($corprofile->principles as $principle)
                            <li class="corprofile-numbered-item">{{ $principle->text }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    @endif

</div>
</section>

<!-- Board of Directors Section -->
<section id="board-of-directors" class="content-section py-5">

<style>
    /* Board of Directors Custom Styles */
:root {
    --bod-primary: #00D4C8;
    --bod-text: #333333;
    --bod-text-light: #666666;
}

.bod-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 80px 20px;
    background-color: #FFFFFF;
}

.bod-header {
    text-align: center;
    margin-bottom: 80px;
}

.bod-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--bod-text);
    margin-bottom: 0;
}

/* Directors Grid - Single Column Centered */
.bod-grid {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 60px;
}

/* Director Card */
.bod-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
}

/* Red Dot Above Image */
.bod-card::before {
    content: '';
    width: 8px;
    height: 8px;
    background-color: #FF4444;
    border-radius: 50%;
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
}

/* Image Container with Hover Effect */
.bod-image-wrapper {
    position: relative;
    width: 200px;
    height: 200px;
    margin-bottom: 25px;
    cursor: pointer;
}

.bod-image-container {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
}

.bod-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(100%);
    transition: all 0.4s ease;
}

.bod-image-container:hover .bod-image {
    filter: grayscale(0%);
    transform: scale(1.1);
}

/* Description Overlay */
.bod-description-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 212, 200, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
    z-index: 2;
}

.bod-image-wrapper:hover .bod-description-overlay {
    opacity: 1;
    visibility: visible;
}

.bod-description-text {
    color: white;
    font-size: 0.85rem;
    line-height: 1.5;
    text-align: center;
    max-height: 100%;
    overflow-y: auto;
}

/* Director Info */
.bod-director-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--bod-text);
    margin-bottom: 5px;
}

.bod-director-title {
    font-size: 0.9rem;
    font-weight: 400;
    color: var(--bod-text-light);
}

/* Empty State */
.bod-empty {
    text-align: center;
    padding: 80px 20px;
}

.bod-empty-text {
    font-size: 1.1rem;
    color: var(--bod-text-light);
}

/* Responsive Design */
@media (max-width: 768px) {
    .bod-container {
        padding: 60px 15px;
    }
    
    .bod-title {
        font-size: 1.75rem;
    }
    
    .bod-grid {
        gap: 50px;
    }
    
    .bod-image-wrapper {
        width: 180px;
        height: 180px;
    }
}
</style>
 
<div class="bod-container">
    <!-- Header -->
    <div class="bod-header">
        <h1 class="bod-title">Board of Directors</h1>
    </div>

    <!-- Directors Grid -->
    @if($directors->count() > 0)
        <div class="bod-grid">
            @foreach($directors as $director)
                <div class="bod-card">
                    <div class="bod-image-wrapper">
                        <div class="bod-image-container">
                            @if($director->image)
                                <img src="{{ asset('storage/' . $director->image) }}" 
                                     alt="{{ $director->name }}" 
                                     class="bod-image">
                            @else
                                <div style="width: 100%; height: 100%; background: #ddd;"></div>
                            @endif
                            
                            @if($director->description)
                                <div class="bod-description-overlay">
                                    <p class="bod-description-text">{{ $director->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="bod-director-info">
                        <h3 class="bod-director-name">{{ $director->name }}</h3>
                        <p class="bod-director-title">{{ $director->title }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bod-empty">
            <p class="bod-empty-text">No board members found</p>
        </div>
    @endif

</div> 

</section>

<!-- Timeline Section -->
<section id="timeline" class="content-section py-5">
   
<style>
    .ourtimeline-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 80px 20px;
        background-color: #E8E8E8;
    }

    .ourtimeline-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .ourtimeline-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .ourtimeline-header p {
        color: #888;
        font-size: 0.9rem;
    }

    /* Years list - centered */
    .timeline-years-list {
        text-align: center;
        margin-bottom: 60px;
    }

    .year-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #00bcd4;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
        user-select: none;
        display: block;
    }

    .year-title:hover {
        color: #0097a7;
    }

    .year-title.active {
        color: #cddc39;
    }

    /* Timeline container */
    .timeline-content-wrapper {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
    }

    /* Center vertical line */
    .timeline-content-wrapper::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 3px;
        background: #cddc39;
    }

    .year-items {
        display: none;
        position: relative;
    }

    .year-items.active {
        display: block;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 100px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
    }

    /* Timeline center dot */
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 50%;
        margin-top: -8px;
        width: 14px;
        height: 14px;
        background-color: #cddc39;
        border: 4px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 3px #cddc39;
        z-index: 10;
    }

    /* Alternating layout */
    .timeline-item:nth-child(odd) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(odd) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(odd) .timeline-image {
        order: 2;
        margin-left: calc(50% + 25px);
    }

    .timeline-item:nth-child(even) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(even) .timeline-image {
        order: 1;
        margin-right: calc(50% + 25px);
    }

    .timeline-item:nth-child(even) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    .timeline-description-wrapper {
        flex: 0 0 350px;
        max-width: 350px;
    }

    .timeline-description {
        background: white;
        padding: 20px 24px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        font-size: 0.85rem;
        line-height: 1.6;
        color: #2c2c2c;
        margin-bottom: 10px;
    }

    .timeline-date {
        color: #999;
        font-size: 0.8rem;
        padding: 0 5px;
    }

    .timeline-image {
        flex: 0 0 280px;
        max-width: 280px;
    }

    .timeline-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    @media (max-width: 992px) {
        .timeline-content-wrapper::before {
            left: 30px;
            transform: none;
        }

        .timeline-item {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding-left: 70px;
            gap: 20px;
        }

        .timeline-item::before {
            left: 30px;
            transform: none;
        }

        .timeline-item:nth-child(odd) .timeline-description-wrapper,
        .timeline-item:nth-child(even) .timeline-description-wrapper {
            order: 1 !important;
            text-align: left !important;
            padding: 0 !important;
            max-width: 100%;
            flex: 1;
        }

        .timeline-item:nth-child(odd) .timeline-image,
        .timeline-item:nth-child(even) .timeline-image {
            order: 2 !important;
            margin: 0 !important;
            max-width: 100%;
            flex: 1;
        }
    }
</style> 

<div class="ourtimeline-container">
    <div class="ourtimeline-header">
        <h1>Our Timeline</h1>
        <p>Click on a year to expand</p>
    </div>

    <!-- Years list centered -->
    <div class="timeline-years-list">
        @foreach($groupedByYear as $year => $items)
            <h2 class="year-title {{ $loop->first ? 'active' : '' }}" data-year="{{ $year }}">
                {{ $year }}
            </h2>
        @endforeach
    </div>

    <!-- Timeline items -->
    <div class="timeline-content-wrapper">
        @foreach($groupedByYear as $year => $items)
            <div class="year-items {{ $loop->first ? 'active' : '' }}" id="year-{{ $year }}">
                @foreach($items as $item)
                    <div class="timeline-item">
                        <div class="timeline-description-wrapper">
                            <div class="timeline-description">
                                {{ $item->description }}
                            </div>
                            <div class="timeline-date">
                                {{ $item->date->format('jS F Y') }}
                            </div>
                        </div>

                        @if($item->image)
                            <div class="timeline-image">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Timeline event">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const yearTitles = document.querySelectorAll('.year-title');
        
        yearTitles.forEach(function(yearTitle) {
            yearTitle.addEventListener('click', function() {
                const year = this.getAttribute('data-year');
                
                // Hide all year items
                document.querySelectorAll('.year-items').forEach(function(item) {
                    item.classList.remove('active');
                });
                
                // Remove active class from all year titles
                yearTitles.forEach(function(title) {
                    title.classList.remove('active');
                });
                
                // Show selected year items
                const selectedYear = document.getElementById('year-' + year);
                if (selectedYear) {
                    selectedYear.classList.add('active');
                }
                
                // Add active class to clicked year
                this.classList.add('active');
            });
        });
    });
</script> 
</section>

<!-- Our Partners Section -->
<section id="our-partners" class="content-section py-5">

<style>
    .ourpartners-section {
        padding: 80px 20px;
        max-width: 1100px;
        margin: 0 auto;
        background-color: #ffffff;
    }

    .ourpartners-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .ourpartners-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0;
    }

    .partners-grid {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 40px;
        row-gap: 30px;
    }

    .partner-item {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .partner-item:hover {
        transform: scale(1.05);
    }

    .partner-logo {
        max-width: 120px;
        max-height: 60px;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(0%);
    }

    @media (max-width: 768px) {
        .partners-grid {
            gap: 30px;
            row-gap: 25px;
        }

        .partner-logo {
            max-width: 90px;
            max-height: 50px;
        }

        .ourpartners-header h1 {
            font-size: 1.75rem;
        }

        .ourpartners-section {
            padding: 60px 15px;
        }
    }
</style> 

<div class="ourpartners-section">
    <div class="ourpartners-header">
        <h1>Our Partners</h1> 
    </div>

    <div class="partners-grid">
        @foreach($partners as $partner)
            <div class="partner-item">
                <img src="{{ $partner->image_url }}" 
                     alt="{{ $partner->name }}" 
                     class="partner-logo"
                     title="{{ $partner->name }}">
            </div>
        @endforeach
    </div>
</div>
</section>

                        
                            </div>                   
                    </div>
                 </div>
        </div>
    </main>

<style>
.content-section {
    scroll-margin-top: 100px;  
    border-bottom: 1px solid #e9ecef;
}

.content-section:last-child {
    border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to section if hash exists in URL
    if (window.location.hash) {
        setTimeout(function() {
            const element = document.querySelector(window.location.hash);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    }
});
</script>
@endsection