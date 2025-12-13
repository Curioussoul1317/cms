@if($contents && $contents->count() > 0)
    <div class="content-sections">
        @foreach($contents as $content)
            <div class="content-section mb-4">
                @php
                    $data = $content->data;
                    $templateView = "components.templates.{$content->template_name}";
                @endphp
                
                @if(view()->exists($templateView))
                    @include($templateView, ['data' => $data])
                @else
                    <div class="alert alert-warning" role="alert">
                        <div class="d-flex">
                            <div>
                                <i class="ti ti-alert-triangle icon alert-icon"></i>
                            </div>
                            <div>
                                <h4 class="alert-title">Template Not Found</h4>
                                <div class="text-muted">
                                    The template view <code>{{ $templateView }}</code> does not exist.
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body">
            <div class="empty">
                <div class="empty-icon">
                    <i class="ti ti-file-text icon"></i>
                </div>
                <p class="empty-title">No Content Available</p>
                <p class="empty-subtitle text-muted">
                    This {{ $contentType ?? 'item' }} doesn't have any content yet.
                </p>
            </div>
        </div>
    </div>
@endif