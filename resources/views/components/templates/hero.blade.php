<div class="  overflow-hidden position-relative" style="background-color: #f5f5f5;">
    <!-- Yellow Banner Section -->
    @if(!empty($data['title']))
    <div class="px-4 px-sm-5 py-3" style="background-color: #ffd700; border-bottom: 1px solid #e6c200;">
        <p class="mb-0 text-center fw-bold" style="color: #333;">
            <span style="color: #000;">Important Announcement:</span> {{ $data['title'] }}
        </p>
    </div>
    @endif
    
    <!-- Main Content Section -->
    <div class="card-body position-relative text-center px-4 px-sm-5 px-lg-6 py-5 py-sm-6" style="z-index: 1;">
        @if(!empty($data['subtitle']))
            <h2 class="fs-3 fw-semibold mb-4 lh-base" style="color: #333;">
                {{ $data['subtitle'] }}
            </h2>
        @endif
        
        @if(!empty($data['description']))
            <p class="fs-5 mb-4 mx-auto lh-base" style="max-width: 60rem; color: #555;">
                {{ $data['description'] }}
            </p>
        @endif
        
        @if(!empty($data['terms']))
            <div class="mt-5">
                <p class="fw-bold mb-2" style="color: #000;">* Terms and Conditions Apply.</p>
                <p class="mb-0" style="color: #555;">*{{ $data['terms'] }}</p>
            </div>
        @endif
    </div>
</div>

<style>
.btn-white {
    background-color: #ffffff;
    border-color: #ffffff;
    color: #4299e1;
}

.btn-white:hover {
    background-color: #f8f9fa;
    border-color: #f8f9fa;
    color: #4299e1;
}

 

.object-fit-cover {
    object-fit: cover;
}

.opacity-25 {
    opacity: 0.25;
}

.opacity-90 {
    opacity: 0.90;
}
</style>