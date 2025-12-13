<div class="card">
    <div class="card-body p-4 p-md-5">
        @if(!empty($data['heading']))
            <h2 class="display-5 fw-bold mb-3">
                {{ $data['heading'] }}
            </h2>
        @endif
        
        @if(!empty($data['subheading']))
            <h3 class="h3 fw-medium text-muted mb-4">
                {{ $data['subheading'] }}
            </h3>
        @endif
        
        @if(!empty($data['content']))
            <div class="text-muted fs-5 lh-lg">
                {!! nl2br(e($data['content'])) !!}
            </div>
        @endif
    </div>
</div>