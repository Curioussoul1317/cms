<div class="hero-with-image overflow-hidden position-relative" 
     style="background-color: {{ $data['background_color'] ?? '#4DD0E1' }}; min-height: 500px;">
    
    <div class="container h-100">
        <div class="row align-items-center h-100 py-5">
            <!-- Left Content Column -->
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                <div class="hero-content text-white px-3 px-lg-4">
                    @if(!empty($data['title']))
                        <h1 class="display-4 fw-bold mb-4 lh-base" style="font-size: clamp(2rem, 5vw, 3.5rem);">
                            {{ $data['title'] }}
                        </h1>
                    @endif
                    
                    @if(!empty($data['subtitle']))
                        <p class="fs-4 mb-4 fw-medium" style="font-size: clamp(1rem, 3vw, 1.5rem);">
                            {{ $data['subtitle'] }}
                        </p>
                    @endif
                    
                    @if(!empty($data['button_text']))
                        <a href="{{ $data['button_link'] ?? '#' }}" 
                           class="btn btn-warning btn-lg px-5 py-3 fw-bold text-uppercase rounded-pill shadow-lg">
                            {{ $data['button_text'] }}
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Right Image Column -->
            <div class="col-lg-6 col-md-6">
                <div class="hero-image text-center text-md-end">
                    @if(!empty($data['image']))
                        <img src="{{ asset('storage/' . $data['image']) }}" 
                             alt="Hero Image" 
                             class="img-fluid"
                             style="max-height: 500px; object-fit: contain;">
                    @else
                        <!-- Placeholder if no image -->
                        <div class="placeholder-image bg-white bg-opacity-25 rounded-3 mx-auto" 
                             style="width: 100%; max-width: 400px; height: 400px; display: flex; align-items: center; justify-content: center;">
                            <i class="ti ti-photo" style="font-size: 4rem; opacity: 0.5;"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-with-image {
    position: relative;
}

.hero-content {
    animation: fadeInUp 0.8s ease-out;
}

.hero-image {
    animation: fadeInRight 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.btn-warning {
    background-color: #CDDC39;
    border-color: #CDDC39;
    color: #000;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background-color: #C0CA33;
    border-color: #C0CA33;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2) !important;
}

@media (max-width: 768px) {
    .hero-with-image {
        min-height: auto !important;
    }
    
    .hero-content {
        text-align: center;
    }
}
</style>