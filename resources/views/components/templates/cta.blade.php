{{-- resources/views/components/templates/cta.blade.php --}}
<div class="card rounded-3 overflow-hidden" 
     style="background: {{ $data['background_color'] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }}">
    <div class="card-body text-center text-white px-4 px-sm-5 py-5 py-sm-6">
        @if(!empty($data['title']))
            <h2 class="display-5 fw-bold mb-3">
                {{ $data['title'] }}
            </h2>
        @endif
        
        @if(!empty($data['description']))
            <p class="fs-4 mb-4 mx-auto opacity-90" style="max-width: 42rem;">
                {{ $data['description'] }}
            </p>
        @endif
        
        @if(!empty($data['button_text']) && !empty($data['button_url']))
            <a href="{{ $data['button_url'] }}" 
               target="_blank"
               class="btn btn-lg btn-white fw-bold shadow-lg">
                {{ $data['button_text'] }}
            </a>
        @endif
    </div>
</div>

<style>
.btn-white {
    background-color: #ffffff;
    border-color: #ffffff;
    color: #1f2937;
}

.btn-white:hover {
    background-color: #f8f9fa;
    border-color: #f8f9fa;
    color: #1f2937;
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.2) !important;
}

.opacity-90 {
    opacity: 0.90;
}
</style>