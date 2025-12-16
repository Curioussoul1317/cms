@extends('layouts.app')

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

@section('content')
<div class="bod-container">
    
    <!-- Actions -->
    <div class="bod-actions">
        <a href="{{ route('bod.index') }}" class="bod-btn bod-btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Management
        </a>
        <a href="{{ route('bod.create') }}" class="bod-btn bod-btn-primary">
            <i class="fas fa-plus"></i> Add Director
        </a>
    </div>

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
            <a href="{{ route('bod.create') }}" class="bod-btn bod-btn-primary">
                <i class="fas fa-plus"></i> Add First Director
            </a>
        </div>
    @endif

</div>
@endsection