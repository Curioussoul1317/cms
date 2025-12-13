<div class="card">
    <div class="card-body">
        @if(isset($data['images']) && is_array($data['images']))
            <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 g-3">
                @foreach($data['images'] as $item)
                    @if(!empty($item['image']))
                        <div class="col">
                            <div class="gallery-item position-relative overflow-hidden rounded">
                                <div class="ratio ratio-1x1">
                                    <img src="{{ $item['image'] }}" 
                                         alt="{{ $item['caption'] ?? 'Gallery image' }}" 
                                         class="gallery-image object-fit-cover">
                                </div>
                                
                                @if(!empty($item['caption']))
                                    <div class="gallery-caption position-absolute bottom-0 start-0 end-0 p-3">
                                        <p class="text-white small fw-medium mb-0">{{ $item['caption'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-5">
                <i class="ti ti-photo-off icon mb-2"></i>
                <p>No images to display.</p>
            </div>
        @endif
    </div>
</div>

<style>
.gallery-item {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
    transition: box-shadow 0.3s ease;
}

.gallery-item:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.gallery-image {
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-image {
    transform: scale(1.1);
}

.gallery-caption {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    transform: translateY(0);
}

.object-fit-cover {
    object-fit: cover;
}
</style>