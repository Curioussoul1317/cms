

@extends('layouts.public')


@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        
    @if($heroData)
        @include('components.templates.hero_with_image', ['data' => $heroData])
    @endif
        <!-- Our Company Section -->
        <section id="our-company" class="content-section py-5">      
<style>
/* Corporate Profile Custom Styles */
:root {
    --corprofile-primary: #00D4C8;
    --corprofile-primary-light: #E6F9F7;
    --corprofile-secondary: #6C757D;
    --corprofile-text: #333333;
    --corprofile-text-light: #666666;
    --corprofile-bg-light: #F8F9FA;
}

.corprofile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.corprofile-header {
    text-align: center;
    margin-bottom: 50px;
}

.corprofile-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 20px;
}

.corprofile-description {
    font-size: 1rem;
    color: var(--corprofile-text-light);
    line-height: 1.8;
    max-width: 900px;
    margin: 0 auto;
}

.corprofile-video-container {
    margin-bottom: 50px;
    text-align: center;
}

.corprofile-video-container video {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

/* Section Styles */
.corprofile-section {
    margin-bottom: 60px;
    padding: 50px 0;
}

.corprofile-section-light {
    background-color: var(--corprofile-bg-light);
    border-radius: 20px;
    padding: 50px 40px;
}

.corprofile-section-primary {
    background-color: var(--corprofile-primary-light);
    border-radius: 20px;
    padding: 50px 40px;
}

.corprofile-section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 30px;
}

.corprofile-section-text {
    font-size: 1.1rem;
    color: var(--corprofile-text-light);
    line-height: 1.8;
}

/* Icon Box Styles */
.corprofile-icon-box {
    background: linear-gradient(135deg, var(--corprofile-primary) 0%, #00B8AD 100%);
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 150px;
    box-shadow: 0 10px 30px rgba(0, 212, 200, 0.3);
}

.corprofile-icon-box img {
    max-width: 100%;
    height: auto;
    max-height: 120px;
}

/* Vision & Mission Styles */
.corprofile-vm-box {
    background-color: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    height: 100%;
}

.corprofile-vm-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 15px;
}

.corprofile-vm-text {
    font-size: 1rem;
    color: var(--corprofile-text-light);
    line-height: 1.7;
}

/* Objectives Cards */
.corprofile-objectives-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.corprofile-objective-card {
    background-color: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.corprofile-objective-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.corprofile-objective-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 12px;
}

.corprofile-objective-desc {
    font-size: 0.95rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
}

.corprofile-objectives-image {
    text-align: center;
    margin-top: 30px;
}

.corprofile-objectives-image img {
    max-width: 250px;
    height: auto;
}

/* List Styles with Checkmarks */
.corprofile-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.corprofile-list-item {
    padding: 15px 0;
    padding-left: 40px;
    position: relative;
    font-size: 1rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.corprofile-list-item:last-child {
    border-bottom: none;
}

.corprofile-list-item::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 15px;
    width: 25px;
    height: 25px;
    background-color: var(--corprofile-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

/* Numbered List Styles */
.corprofile-numbered-list {
    list-style: none;
    padding: 0;
    margin: 0;
    counter-reset: corprofile-counter;
}

.corprofile-numbered-item {
    padding: 15px 0;
    padding-left: 50px;
    position: relative;
    font-size: 1rem;
    color: var(--corprofile-text-light);
    line-height: 1.6;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    counter-increment: corprofile-counter;
}

.corprofile-numbered-item:last-child {
    border-bottom: none;
}

.corprofile-numbered-item::before {
    content: counter(corprofile-counter);
    position: absolute;
    left: 0;
    top: 15px;
    width: 30px;
    height: 30px;
    background-color: #FF6B6B;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
}

/* Content Box with Image */
.corprofile-content-box {
    background-color: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.corprofile-image-container {
    text-align: center;
    padding: 20px;
}

.corprofile-image-container img {
    max-width: 100%;
    height: auto;
    max-height: 300px;
    border-radius: 15px;
}

/* Action Buttons */
.corprofile-actions {
    position: fixed;
    top: 100px;
    right: 30px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 1000;
}

.corprofile-btn {
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.corprofile-btn-primary {
    background-color: var(--corprofile-primary);
    color: white;
}

.corprofile-btn-primary:hover {
    background-color: #00B8AD;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 212, 200, 0.3);
}

.corprofile-btn-secondary {
    background-color: white;
    color: var(--corprofile-text);
    border: 2px solid #E0E0E0;
}

.corprofile-btn-secondary:hover {
    background-color: var(--corprofile-bg-light);
    color: var(--corprofile-text);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .corprofile-section {
        padding: 30px 0;
    }
    
    .corprofile-section-light,
    .corprofile-section-primary {
        padding: 30px 20px;
    }
    
    .corprofile-header h1 {
        font-size: 2rem;
    }
    
    .corprofile-section-title {
        font-size: 1.5rem;
    }
    
    .corprofile-objectives-grid {
        grid-template-columns: 1fr;
    }
    
    .corprofile-actions {
        position: static;
        flex-direction: row;
        justify-content: center;
        margin-bottom: 30px;
    }
    
    .corprofile-content-box {
        padding: 25px;
    }
}

@media (max-width: 576px) {
    .corprofile-container {
        padding: 20px 15px;
    }
    
    .corprofile-icon-box {
        padding: 20px;
        min-height: 120px;
    }
    
    .corprofile-icon-box img {
        max-height: 80px;
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
                <div class="col-md-3 mb-4 mb-md-0">
                    @if($corprofile->vision_image)
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->vision_image) }}" alt="Vision">
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
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
                <div class="col-md-3 mb-4 mb-md-0">
                    @if($corprofile->mission_image)
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->mission_image) }}" alt="Mission">
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
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
        <div class="corprofile-section corprofile-section-light">
            <h2 class="corprofile-section-title text-center">Objectives</h2>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="corprofile-objectives-grid">
                        @foreach($corprofile->objectives as $objective)
                            <div class="corprofile-objective-card">
                                <h4 class="corprofile-objective-title">{{ $objective->title }}</h4>
                                <p class="corprofile-objective-desc">{{ $objective->description }}</p>
                            </div>
                        @endforeach
                    </div>
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
    @endif

    <!-- Strategies Section -->
    @if($corprofile->strategies->count() > 0)
        <div class="corprofile-section corprofile-section-primary">
            <h2 class="corprofile-section-title">Strategies</h2>
            
            <div class="row align-items-center">
                @if($corprofile->strategies_image)
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->strategies_image) }}" alt="Strategies">
                        </div>
                    </div>
                @endif
                <div class="{{ $corprofile->strategies_image ? 'col-md-9' : 'col-md-12' }}">
                    <div class="corprofile-content-box">
                        <ul class="corprofile-list">
                            @foreach($corprofile->strategies as $strategy)
                                <li class="corprofile-list-item">{{ $strategy->text }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Values Section -->
    @if($corprofile->values->count() > 0)
        <div class="corprofile-section corprofile-section-light">
            <h2 class="corprofile-section-title">Values</h2>
            
            <div class="row align-items-center">
                <div class="{{ $corprofile->values_image ? 'col-md-8' : 'col-md-12' }}">
                    <div class="corprofile-content-box">
                        <ul class="corprofile-list">
                            @foreach($corprofile->values as $value)
                                <li class="corprofile-list-item">{{ $value->text }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if($corprofile->values_image)
                    <div class="col-md-4 mb-4 mb-md-0 order-md-last order-first">
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
        <div class="corprofile-section corprofile-section-primary">
            <h2 class="corprofile-section-title">Guiding Principles</h2>
            
            <div class="row align-items-center">
                @if($corprofile->principles_image)
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->principles_image) }}" alt="Guiding Principles">
                        </div>
                    </div>
                @endif
                <div class="{{ $corprofile->principles_image ? 'col-md-9' : 'col-md-12' }}">
                    <div class="corprofile-content-box">
                        <ol class="corprofile-numbered-list">
                            @foreach($corprofile->principles as $principle)
                                <li class="corprofile-numbered-item">{{ $principle->text }}</li>
                            @endforeach
                        </ol>
                    </div>
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
    --bod-bg: #FFFFFF;
}

.bod-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
    background-color: #FAFAFA;
}

.bod-header {
    text-align: center;
    margin-bottom: 60px;
}

.bod-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--bod-text);
    margin-bottom: 20px;
}

.bod-subtitle {
    font-size: 1.1rem;
    color: var(--bod-text-light);
    max-width: 800px;
    margin: 0 auto;
}

/* Directors Grid */
.bod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 50px;
    padding: 40px 0;
}

/* Director Card */
.bod-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 20px;
    transition: transform 0.3s ease;
}

.bod-card:hover {
    transform: translateY(-10px);
}

/* Image Container with Hover Effect */
.bod-image-wrapper {
    position: relative;
    width: 250px;
    height: 250px;
    margin-bottom: 25px;
    cursor: pointer;
}

.bod-image-container {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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
    font-size: 0.9rem;
    line-height: 1.6;
    text-align: center;
    max-height: 100%;
    overflow-y: auto;
}

/* Custom Scrollbar for Description */
.bod-description-text::-webkit-scrollbar {
    width: 4px;
}

.bod-description-text::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
}

.bod-description-text::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.5);
    border-radius: 10px;
}

/* Director Info */
.bod-director-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--bod-text);
    margin-bottom: 8px;
}

.bod-director-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bod-primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Red Dot Decoration */
.bod-card::after {
    content: '';
    width: 8px;
    height: 8px;
    background-color: #FF4444;
    border-radius: 50%;
    position: absolute;
    top: 50px;
    right: 80px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bod-card:hover::after {
    opacity: 1;
}

/* Action Buttons */
.bod-actions {
    text-align: center;
    margin-bottom: 40px;
}

.bod-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin: 0 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.bod-btn-primary {
    background-color: var(--bod-primary);
    color: white;
    border: none;
}

.bod-btn-primary:hover {
    background-color: #00B8AD;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 212, 200, 0.3);
}

.bod-btn-secondary {
    background-color: white;
    color: var(--bod-text);
    border: 2px solid #E0E0E0;
}

.bod-btn-secondary:hover {
    background-color: #F5F5F5;
    color: var(--bod-text);
    transform: translateY(-2px);
}

/* Empty State */
.bod-empty {
    text-align: center;
    padding: 80px 20px;
}

.bod-empty-icon {
    font-size: 4rem;
    color: #CCCCCC;
    margin-bottom: 20px;
}

.bod-empty-text {
    font-size: 1.2rem;
    color: var(--bod-text-light);
    margin-bottom: 30px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .bod-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
    }
}

@media (max-width: 768px) {
    .bod-container {
        padding: 40px 15px;
    }
    
    .bod-title {
        font-size: 2rem;
    }
    
    .bod-grid {
        grid-template-columns: 1fr;
        gap: 50px;
    }
    
    .bod-image-wrapper {
        width: 220px;
        height: 220px;
    }
    
    .bod-description-text {
        font-size: 0.85rem;
        padding: 5px;
    }
}

@media (max-width: 576px) {
    .bod-image-wrapper {
        width: 200px;
        height: 200px;
    }
    
    .bod-director-name {
        font-size: 1.1rem;
    }
    
    .bod-director-title {
        font-size: 0.9rem;
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
            <div class="bod-empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <p class="bod-empty-text">No board members found</p>
            
        </div>
    @endif

</div> 

        </section>



        <!-- Timeline Section -->
        <section id="timeline" class="content-section py-5">
   
<style>
    body {
        background-color: #e8e8e8;
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .ourtimeline-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .ourtimeline-header {
        text-align: center;
        margin-bottom: 80px;
    }

    .ourtimeline-header h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .ourtimeline-header p {
        color: #888;
        font-size: 0.88rem;
        font-weight: 400;
    }

    /* Years list - centered */
    .timeline-years-list {
        text-align: center;
        margin-bottom: 60px;
    }

    .year-title {
        font-size: 2.3rem;
        font-weight: 700;
        color: #00bcd4;
        margin-bottom: 20px;
        cursor: pointer;
        transition: all 0.3s;
        user-select: none;
        display: inline-block;
        width: 100%;
    }

    .year-title:hover {
        color: #0097a7;
        transform: scale(1.05);
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
        width: 4px;
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
        margin-bottom: 120px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 50px;
    }

    /* Timeline center dot */
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 50%;
        margin-top: -10px;
        width: 18px;
        height: 18px;
        background-color: #cddc39;
        border: 5px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 4px #cddc39;
        z-index: 10;
    }

    /* FIRST ITEM (Index 0) - Description LEFT, Image RIGHT */
    .timeline-item:nth-child(1) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(1) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(1) .timeline-image {
        order: 2;
        margin-left: calc(50% + 30px);
    }

    /* SECOND ITEM (Index 1) - Image LEFT, Description RIGHT */
    .timeline-item:nth-child(2) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(2) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
    }

    .timeline-item:nth-child(2) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    /* THIRD ITEM - Same as FIRST */
    .timeline-item:nth-child(3) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(3) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(3) .timeline-image {
        order: 2;
        margin-left: calc(50% + 30px);
    }

    /* FOURTH ITEM - Same as SECOND */
    .timeline-item:nth-child(4) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(4) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
    }

    .timeline-item:nth-child(4) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    /* Continue pattern for more items */
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
        margin-left: calc(50% + 30px);
    }

    .timeline-item:nth-child(even) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(even) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
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
        padding: 24px 26px;
        border-radius: 8px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        font-size: 0.9rem;
        line-height: 1.6;
        color: #2c2c2c;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .timeline-date {
        color: #999;
        font-size: 0.82rem;
        font-weight: 400;
        padding: 0 5px;
    }

    .timeline-image {
        flex: 0 0 350px;
        max-width: 350px;
    }

    .timeline-image img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    /* Dashed connector lines */
    .timeline-connector {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 3px;
        z-index: 5;
        background: repeating-linear-gradient(
            to right,
            #00bcd4 0,
            #00bcd4 10px,
            transparent 10px,
            transparent 18px
        );
    }

    /* Connector for odd items (description on left) */
    .timeline-item:nth-child(odd) .timeline-connector {
        left: calc(50% + 15px);
        width: 70px;
    }

    /* Connector for even items (description on right) */
    .timeline-item:nth-child(even) .timeline-connector {
        right: calc(50% + 15px);
        width: 70px;
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

        .timeline-connector {
            display: none;
        }

        .timeline-years-list .year-title {
            font-size: 2rem;
        }
    }
</style> 

<div class="ourtimeline-container">
    <div class="ourtimeline-header">
        <h1>Our Timeline</h1> 
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
                        <div class="timeline-connector"></div>
                        
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
    body {
        background-color: #ffffff;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .ourpartners-section {
        padding: 80px 20px;
        max-width: 1200px;
        margin: 0 auto;
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
        letter-spacing: 0.3px;
    }

    .partners-grid {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 50px;
        row-gap: 40px;
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
        max-width: 140px;
        max-height: 80px;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(0%);
        transition: filter 0.3s ease;
    }

    .partner-item:hover .partner-logo {
        filter: grayscale(0%) brightness(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .partners-grid {
            gap: 30px;
            row-gap: 30px;
        }

        .partner-logo {
            max-width: 100px;
            max-height: 60px;
        }

        .ourpartners-header h1 {
            font-size: 1.6rem;
        }

        .ourpartners-section {
            padding: 50px 15px;
        }
    }

    @media (max-width: 480px) {
        .partners-grid {
            gap: 25px;
            row-gap: 25px;
        }

        .partner-logo {
            max-width: 80px;
            max-height: 50px;
        }
    }
</style> 

<!-- <section class="ourpartners-section"> -->
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
<!-- </section>  -->
        </section>

    </div>
</div>



 
















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