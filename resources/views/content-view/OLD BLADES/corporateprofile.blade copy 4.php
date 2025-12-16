@extends('layouts.public')


@section('content')

<style>
    .backdivgray{
        background-color: #f3f3f3;
    }
    .backdivwhite{
        background-color:rgb(255, 255, 255);
    }
    </style>

<main class="page-wrapper">
        <div class="page-body">
            <div class="" style="padding: 0px;">
                 <div class="row row-cards" style="margin-right: 0px; margin-left: 0px;">                      
                            <div class="col-12" style="padding: 0;">   
                                
                <!-- Our Company Section -->   
                <style>
/* Corporate Profile Custom Styles */
:root {
    --corprofile-primary: #00D4C8;
    --corprofile-primary-dark: #00B8AD;
    --corprofile-lime: #CDDC39;
    --corprofile-text: #1a1a1a;
    --corprofile-text-light: #666666;
    --corprofile-bg: #F5F5F5;
    --corprofile-bg-dark: #E8E8E8;
    --accent-gradient: linear-gradient(135deg, #1dc8e1 0%,  #1fe9ba 100%);
}

.corprofile-hero {
    max-width: 1100px;
    margin: 0 auto;
    padding: 60px 20px; 
} 
.corprofile-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 60px 20px; 
}

/* Header - Description only, no title */
.corprofile-header {
    text-align: center;
    margin-bottom: 60px;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto; 
}

.corprofile-header h1 {
    display: none; /* Hide the Corporate Profile title as per design */
}

.corprofile-description {
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.8;
    text-align: center;
}

/* Section Styles */
.corprofile-section {
    margin-bottom: 60px;
}

.corprofile-section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 30px;
}

/* Icon Box Styles - Square with rounded corners */
.corprofile-icon-box {
    background: var(--accent-gradient);
    border-radius: 12px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 140px;
    height: 140px;
}

.corprofile-icon-box img {
    max-width: 80px;
    max-height: 80px;
    height: auto;
    filter: brightness(0) invert(1);
}

/* Vision & Mission Styles */
.corprofile-vm-row {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-bottom: 50px;
}

.corprofile-vm-content {
    flex: 1;
}

.corprofile-vm-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 12px;
}

.corprofile-vm-text {
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.7;
    margin: 0;
}

/* Objectives Section */
.corprofile-objectives-section {
    background-color: var(--corprofile-bg);
    padding: 60px 0;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    width: 100vw;
}

.corprofile-objectives-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.corprofile-objectives-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 40px;
    text-align: center;
}

.corprofile-objectives-grid {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.corprofile-objectives-list {
    flex: 1;
}

.corprofile-objective-card {
    background-color: white;
    padding: 18px 20px;
    margin-bottom: 15px;
    border-left: 3px solid var(--corprofile-primary);
}

.corprofile-objective-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 6px;
}

.corprofile-objective-desc {
    font-size: 0.85rem;
    color: var(--corprofile-text-light);
    line-height: 1.5;
    margin: 0;
}

.corprofile-objectives-image {
    flex: 0 0 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.corprofile-objectives-image img {
    max-width: 180px;
    height: auto;
}

/* Strategies Section - Teal background bar */
.corprofile-strategies-section {
    background: linear-gradient(135deg, #00D4C8 0%, #00B8AD 100%);
    padding: 50px 0;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    width: 100vw;
    margin-bottom: 60px;
}

.corprofile-strategies-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: flex-start;
    gap: 40px;
}

.corprofile-strategies-icon {
    flex: 0 0 140px;
}

.corprofile-strategies-icon-box {
    background: linear-gradient(135deg, #00D4C8 0%, #00B8AD 100%);
    border-radius: 12px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 140px;
    height: 140px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.corprofile-strategies-icon-box img {
    max-width: 80px;
    max-height: 80px;
    height: auto;
    filter: brightness(0) invert(1);
}

.corprofile-strategies-content {
    flex: 1;
    padding-top: 10px;
}

.corprofile-strategies-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
    margin-bottom: 20px;
}

/* Strategy List with Checkmarks */
.corprofile-strategy-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.corprofile-strategy-item {
    padding: 8px 0;
    padding-left: 35px;
    position: relative;
    font-size: 0.9rem;
    color: white;
    line-height: 1.6;
}

.corprofile-strategy-item::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 8px;
    width: 22px;
    height: 22px;
    background-color: var(--corprofile-lime);
    color: var(--corprofile-text);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
}

/* Values Section */
.corprofile-values-section {
    margin-bottom: 60px;
}

.corprofile-values-grid {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.corprofile-values-content {
    flex: 1;
}

.corprofile-values-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 20px;
}

.corprofile-values-image {
    flex: 0 0 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.corprofile-values-image img {
    max-width: 180px;
    height: auto;
}

/* List Styles with Checkmarks */
.corprofile-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.corprofile-list-item {
    padding: 10px 0;
    padding-left: 35px;
    position: relative;
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.5;
}

.corprofile-list-item::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 10px;
    width: 22px;
    height: 22px;
    background-color: var(--corprofile-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
}

/* Guiding Principles Section */
.corprofile-principles-section {
    margin-bottom: 60px;
}

.corprofile-principles-grid {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.corprofile-principles-icon {
    flex: 0 0 140px;
}

.corprofile-principles-content {
    flex: 1;
}

.corprofile-principles-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--corprofile-text);
    margin-bottom: 20px;
}

/* Numbered List Styles */
.corprofile-numbered-list {
    list-style: none;
    padding: 0;
    margin: 0;
    counter-reset: corprofile-counter;
}

.corprofile-numbered-item {
    padding: 10px 0;
    padding-left: 40px;
    position: relative;
    font-size: 0.9rem;
    color: var(--corprofile-text-light);
    line-height: 1.5;
    counter-increment: corprofile-counter;
}

.corprofile-numbered-item::before {
    content: counter(corprofile-counter);
    position: absolute;
    left: 0;
    top: 10px;
    width: 24px;
    height: 24px;
    background-color: var(--corprofile-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .corprofile-container {
        padding: 40px 15px;
    }
    
    .corprofile-vm-row {
        flex-direction: column;
        gap: 20px;
    }
    
    .corprofile-icon-box {
        width: 120px;
        height: 120px;
        padding: 25px;
    }
    
    .corprofile-objectives-grid {
        flex-direction: column;
    }
    
    .corprofile-objectives-image {
        flex: none;
        width: 100%;
    }
    
    .corprofile-strategies-inner {
        flex-direction: column;
        gap: 30px;
    }
    
    .corprofile-strategies-icon {
        flex: none;
    }
    
    .corprofile-values-grid {
        flex-direction: column;
    }
    
    .corprofile-values-image {
        flex: none;
        width: 100%;
    }
    
    .corprofile-principles-grid {
        flex-direction: column;
        gap: 30px;
    }
    
    .corprofile-principles-icon {
        flex: none;
    }
}
</style> 

<section class="backdivgray" >    
<div class="corprofile-hero" >
    <!-- Header Section - Description Only -->
    @if($corprofile->description)
        <div class="corprofile-header">
            <div class="corprofile-description">
                {{ $corprofile->description }}
            </div>
        </div>
    @endif
    </div>
<scetion> 
 

<section id="our-company" class="backdivwhite">  
<div class="corprofile-container">

    <!-- Vision Section -->
    @if($corprofile->vision_text || $corprofile->vision_image)
        <div class="corprofile-section">
            <div class="corprofile-vm-row">
                @if($corprofile->vision_image)
                    <div class="corprofile-icon-box">
                        <img src="{{ asset('storage/' . $corprofile->vision_image) }}" alt="Vision">
                    </div>
                @endif
                <div class="corprofile-vm-content">
                    <h3 class="corprofile-vm-title">Vision</h3>
                    <p class="corprofile-vm-text">{{ $corprofile->vision_text }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Mission Section -->
    @if($corprofile->mission_text || $corprofile->mission_image)
        <div class="corprofile-section">
            <div class="corprofile-vm-row">
                @if($corprofile->mission_image)
                    <div class="corprofile-icon-box">
                        <img src="{{ asset('storage/' . $corprofile->mission_image) }}" alt="Mission">
                    </div>
                @endif
                <div class="corprofile-vm-content">
                    <h3 class="corprofile-vm-title">Mission</h3>
                    <p class="corprofile-vm-text">{{ $corprofile->mission_text }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Objectives Section - Full Width Gray Background -->
@if($corprofile->objectives->count() > 0)
    <div class="corprofile-objectives-section">
        <div class="corprofile-objectives-inner">
            <h2 class="corprofile-objectives-title">Objectives</h2>
            
            <div class="corprofile-objectives-grid">
                <div class="corprofile-objectives-list">
                    @foreach($corprofile->objectives as $objective)
                        <div class="corprofile-objective-card">
                            <h4 class="corprofile-objective-title">{{ $objective->title }}</h4>
                            <p class="corprofile-objective-desc">{{ $objective->description }}</p>
                        </div>
                    @endforeach
                </div>
                @if($corprofile->objectives_image)
                    <div class="corprofile-objectives-image">
                        <img src="{{ asset('storage/' . $corprofile->objectives_image) }}" alt="Objectives">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Strategies Section - Full Width Teal Background -->
@if($corprofile->strategies->count() > 0)
    <div class="corprofile-strategies-section">
        <div class="corprofile-strategies-inner">
            @if($corprofile->strategies_image)
                <div class="corprofile-strategies-icon">
                    <div class="corprofile-strategies-icon-box">
                        <img src="{{ asset('storage/' . $corprofile->strategies_image) }}" alt="Strategies">
                    </div>
                </div>
            @endif
            <div class="corprofile-strategies-content">
                <h2 class="corprofile-strategies-title">Strategies</h2>
                <ul class="corprofile-strategy-list">
                    @foreach($corprofile->strategies as $strategy)
                        <li class="corprofile-strategy-item">{{ $strategy->text }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="corprofile-container">
    <!-- Values Section -->
    @if($corprofile->values->count() > 0)
        <div class="corprofile-values-section">
            <div class="corprofile-values-grid">
                <div class="corprofile-values-content">
                    <h2 class="corprofile-values-title">Values</h2>
                    <ul class="corprofile-list">
                        @foreach($corprofile->values as $value)
                            <li class="corprofile-list-item">{{ $value->text }}</li>
                        @endforeach
                    </ul>
                </div>
                @if($corprofile->values_image)
                    <div class="corprofile-values-image">
                        <img src="{{ asset('storage/' . $corprofile->values_image) }}" alt="Values">
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Guiding Principles Section -->
    @if($corprofile->principles->count() > 0)
        <div class="corprofile-principles-section">
            <div class="corprofile-principles-grid">
                @if($corprofile->principles_image)
                    <div class="corprofile-principles-icon">
                        <div class="corprofile-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->principles_image) }}" alt="Guiding Principles">
                        </div>
                    </div>
                @endif
                <div class="corprofile-principles-content">
                    <h2 class="corprofile-principles-title">Guiding Principles</h2>
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
     <!-- End Our Company Section -->


<!-- Board of Directors Section -->
<style>
/* Board of Directors Custom Styles */
.bod-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 80px 20px; 
}

.bod-header {
    text-align: center;
    margin-bottom: 60px;
}

.bod-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
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

/* Image Container */
.bod-image-wrapper {
    position: relative;
    width: 160px;
    height: 160px;
    margin-bottom: 20px;
    cursor: pointer;
}

.bod-image-container {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    transform: scale(1.05);
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
    padding: 25px;
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
    font-size: 0.8rem;
    line-height: 1.4;
    text-align: center;
    max-height: 100%;
    overflow-y: auto;
}

/* Director Info */
.bod-director-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.bod-director-title {
    font-size: 0.85rem;
    font-weight: 400;
    color: #00D4C8;
}

/* Empty State */
.bod-empty {
    text-align: center;
    padding: 60px 20px;
}

.bod-empty-text {
    font-size: 1rem;
    color: #666;
}

/* Responsive */
@media (max-width: 768px) {
    .bod-container {
        padding: 60px 15px;
    }
    
    .bod-title {
        font-size: 1.5rem;
    }
    
    .bod-grid {
        gap: 50px;
    }
    
    .bod-image-wrapper {
        width: 140px;
        height: 140px;
    }
}
</style>

<section id="board-of-directors" class="backdivgray">
 
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
<!--End Board of Directors Section -->

<!-- Timeline Section -->
<style>
/* Timeline Styles */
.ourtimeline-section {
    /* background-color: #E8E8E8; */
}

.ourtimeline-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 80px 20px;
}

.ourtimeline-header {
    text-align: center;
    margin-bottom: 40px;
}

.ourtimeline-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.ourtimeline-header p {
    color: #888;
    font-size: 0.85rem;
    margin: 0;
}

/* Years Navigation */
.timeline-years-nav {
    text-align: center;
    margin-bottom: 40px;
}

.year-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #00D4C8;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    user-select: none;
    display: block;
}

.year-title:hover {
    color: #00B8AD;
}

.year-title.active {
    color: #CDDC39;
}

/* Timeline Content */
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
    width: 2px;
    background: #CDDC39;
}

.year-items {
    display: none;
    position: relative;
}

.year-items.active {
    display: block;
}

/* Timeline Item */
.timeline-item {
    position: relative;
    margin-bottom: 80px;
    display: flex;
    align-items: flex-start;
}

/* Timeline dot */
.timeline-item::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 30px;
    width: 10px;
    height: 10px;
    background-color: #FF4444;
    border-radius: 50%;
    z-index: 10;
}

/* Odd items - text left, image right */
.timeline-item:nth-child(odd) {
    flex-direction: row;
}

.timeline-item:nth-child(odd) .timeline-description-wrapper {
    width: calc(50% - 30px);
    text-align: right;
    padding-right: 30px;
}

.timeline-item:nth-child(odd) .timeline-image {
    width: calc(50% - 30px);
    margin-left: auto;
    padding-left: 30px;
}

/* Even items - image left, text right */
.timeline-item:nth-child(even) {
    flex-direction: row;
}

.timeline-item:nth-child(even) .timeline-image {
    width: calc(50% - 30px);
    padding-right: 30px;
    order: 1;
}

.timeline-item:nth-child(even) .timeline-description-wrapper {
    width: calc(50% - 30px);
    text-align: left;
    padding-left: 30px;
    margin-left: auto;
    order: 2;
}

.timeline-description {
    background: white;
    padding: 18px 22px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-size: 0.85rem;
    line-height: 1.6;
    color: #333;
    margin-bottom: 10px;
    display: inline-block;
}

.timeline-date {
    color: #999;
    font-size: 0.75rem;
}

.timeline-image img {
    width: 100%;
    max-width: 280px;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.12);
}

/* Responsive */
@media (max-width: 768px) {
    .ourtimeline-container {
        padding: 60px 15px;
    }
    
    .timeline-content-wrapper::before {
        left: 20px;
        transform: none;
    }
    
    .timeline-item {
        flex-direction: column !important;
        padding-left: 50px;
        margin-bottom: 50px;
    }
    
    .timeline-item::before {
        left: 20px;
        transform: none;
        top: 0;
    }
    
    .timeline-item:nth-child(odd) .timeline-description-wrapper,
    .timeline-item:nth-child(even) .timeline-description-wrapper {
        width: 100%;
        text-align: left;
        padding: 0;
        order: 1;
        margin-left: 0;
    }
    
    .timeline-item:nth-child(odd) .timeline-image,
    .timeline-item:nth-child(even) .timeline-image {
        width: 100%;
        padding: 0;
        margin: 15px 0 0 0;
        order: 2;
    }
    
    .timeline-description {
        display: block;
    }
    
    .year-title {
        font-size: 1.3rem;
    }
}
</style> 

<section id="timeline" class="backdivwhite"> 
<div class="ourtimeline-section">
    <div class="ourtimeline-container">
        <div class="ourtimeline-header">
            <h1>Our Timeline</h1>
            <p>Click on a year to expand</p>
        </div>

        <!-- Years Navigation -->
        <div class="timeline-years-nav">
            @foreach($groupedByYear as $year => $items)
                <h2 class="year-title {{ $loop->first ? 'active' : '' }}" data-year="{{ $year }}">
                    {{ $year }}
                </h2>
            @endforeach
        </div>

        <!-- Timeline Content -->
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
<!-- End Timeline Section -->

<!-- Our Partners Section -->
<style>
/* Partners Section Styles */
.ourpartners-section {
    padding: 80px 20px;
    max-width: 1100px;
    margin: 0 auto;
    /* background-color: #ffffff; */
    position: relative;
}

.ourpartners-header {
    text-align: center;
    margin-bottom: 50px;
}

.ourpartners-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0;
}

.partners-grid {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 50px;
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
    max-width: 100px;
    max-height: 50px;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* Red dot decoration */
.ourpartners-section::after {
    content: '';
    position: absolute;
    bottom: 40px;
    right: 40px;
    width: 8px;
    height: 8px;
    background-color: #FF4444;
    border-radius: 50%;
}

@media (max-width: 768px) {
    .partners-grid {
        gap: 30px;
        row-gap: 20px;
    }

    .partner-logo {
        max-width: 80px;
        max-height: 40px;
    }

    .ourpartners-header h1 {
        font-size: 1.5rem;
    }

    .ourpartners-section {
        padding: 60px 15px;
    }
    
    .ourpartners-section::after {
        bottom: 20px;
        right: 20px;
    }
}
</style> 

<section id="our-partners" class="backdivgray">

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
<!-- End Our Partners Section -->








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