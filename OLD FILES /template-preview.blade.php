<div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
    @foreach(config('templates') as $key => $template)
        <div class="col">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        @if(isset($template['icon']))
                            <i class="{{ $template['icon'] }} icon fs-1 me-3 text-primary"></i>
                        @endif
                        <strong class="card-title mb-0">{{ $template['name'] }}</strong>
                    </div>
                    <p class="text-muted small mb-0">{{ $template['description'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>