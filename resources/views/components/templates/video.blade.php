<div class="card">
    <div class="card-body">
        @if(!empty($data['title']))
            <h2 class="h1 mb-3">{{ $data['title'] }}</h2>
        @endif
        
        @if(!empty($data['description']))
            <p class="text-muted mb-4">{{ $data['description'] }}</p>
        @endif
        
        @if(!empty($data['video_url']))
            @php
                $videoUrl = $data['video_url'];
                $embedUrl = '';
                
                // Convert YouTube URL to embed
                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $matches)) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                } 
                // Convert Vimeo URL to embed
                elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                    $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                }
                // If already an embed URL
                elseif (strpos($videoUrl, 'youtube.com/embed') !== false || strpos($videoUrl, 'player.vimeo.com') !== false) {
                    $embedUrl = $videoUrl;
                }
            @endphp
            
            @if($embedUrl)
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="{{ $embedUrl }}" 
                        class="rounded"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="alert alert-warning mb-0" role="alert">
                    <div class="d-flex">
                        <div>
                            <i class="ti ti-alert-triangle icon alert-icon"></i>
                        </div>
                        <div>
                            Unable to embed video. Please check the URL.
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>