<div class="card">
    <div class="card-body p-4 p-md-5">
        @if(!empty($data['section_title']))
            <h2 class="display-5 fw-bold text-center mb-5">
                {{ $data['section_title'] }}
            </h2>
        @endif
        
        @if(isset($data['features']) && is_array($data['features']))
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($data['features'] as $feature)
                    <div class="col">
                        <div class="card card-sm h-100 text-center feature-card">
                            <div class="card-body">
                                @if(!empty($feature['icon']))
                                    <div class="display-1 mb-3">{{ $feature['icon'] }}</div>
                                @endif
                                
                                @if(!empty($feature['title']))
                                    <h3 class="h4 fw-bold mb-3">
                                        {{ $feature['title'] }}
                                    </h3>
                                @endif
                                
                                @if(!empty($feature['description']))
                                    <p class="text-muted mb-0 lh-base">
                                        {{ $feature['description'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-5">
                <i class="ti ti-sparkles-off icon mb-2"></i>
                <p>No features to display.</p>
            </div>
        @endif
    </div>
</div>

<style>
.feature-card {
    transition: background-color 0.2s ease;
}

.feature-card:hover {
    background-color: #f8f9fa;
}
</style>