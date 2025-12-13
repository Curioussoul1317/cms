@extends('layouts.app')

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

@section('content')
<div class="corprofile-container">
    
    <!-- Action Buttons -->
    <div class="corprofile-actions">
        <a href="{{ route('corprofile.edit', $corprofile) }}" class="corprofile-btn corprofile-btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('corprofile.index') }}" class="corprofile-btn corprofile-btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

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
@endsection