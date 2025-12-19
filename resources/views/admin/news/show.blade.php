@extends('layouts.app')

@section('title', 'View News')

@section('page-header')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="page-pretitle">News Management</div>
        <div class="page-title-wrapper d-flex justify-content-between align-items-center">
            <h2 class="page-title">View News</h2>
            <div class="btn-list">
                <a href="{{ route('news.edit', $news) }}" class="btn btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                        <path d="M16 5l3 3"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('news.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M9 14l-4 -4l4 -4"/>
                        <path d="M5 10h11a4 4 0 1 1 0 8h-1"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-xl">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">{{ $news->title }}</h3>
                </div>
                @if($news->featured_image)
                <img src="{{ $news->featured_image_url }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-muted">Slug:</span> 
                        <code>{{ $news->slug }}</code>
                    </div>

                    @if($news->excerpt)
                    <div class="mb-4">
                        <h4 class="text-muted">Excerpt</h4>
                        <p class="lead">{{ $news->excerpt }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h4 class="text-muted">Content</h4>
                        <div class="content-body">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gallery Images --}}
            @if($news->images->count() > 0)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Gallery Images ({{ $news->images->count() }})</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($news->images as $image)
                        <div class="col-md-4">
                            <div class="card">
                                <a href="{{ $image->image_url }}" target="_blank">
                                    <img src="{{ $image->image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body p-2">
                                    @if($image->caption)
                                    <p class="mb-1 small"><strong>Caption:</strong> {{ $image->caption }}</p>
                                    @endif
                                    @if($image->alt_text)
                                    <p class="mb-0 small text-muted"><strong>Alt:</strong> {{ $image->alt_text }}</p>
                                    @endif
                                    <span class="badge bg-azure-lt">Order: {{ $image->sort_order }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Status & Actions --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Status & Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Status:</span>
                        {!! $news->status_badge !!}
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Active:</span>
                        @if($news->is_active)
                        <span class="badge bg-green">Yes</span>
                        @else
                        <span class="badge bg-red">No</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Sort Order:</span>
                        <span class="badge bg-azure">{{ $news->sort_order }}</span>
                    </div>

                    <hr>

                    {{-- Action Buttons --}}
                    <div class="d-grid gap-2">
                        @if(!$news->is_approved)
                        <form action="{{ route('news.approve', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10"/>
                                </svg>
                                Approve
                            </button>
                        </form>
                        @else
                        <form action="{{ route('news.unapprove', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M18 6l-12 12"/>
                                    <path d="M6 6l12 12"/>
                                </svg>
                                Unapprove
                            </button>
                        </form>
                        @endif

                        @if($news->is_approved && !$news->is_published)
                        <form action="{{ route('news.publish', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                    <path d="M9 12l2 2l4 -4"/>
                                </svg>
                                Publish
                            </button>
                        </form>
                        @elseif($news->is_published)
                        <form action="{{ route('news.unpublish', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                                </svg>
                                Unpublish
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('news.toggle-active', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-{{ $news->is_active ? 'danger' : 'success' }} w-100">
                                @if($news->is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                    <path d="M13.048 17.942a9.298 9.298 0 0 1 -1.048 .058c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a17.986 17.986 0 0 1 -1.362 1.975"/>
                                    <path d="M22 22l-5 -5"/>
                                    <path d="M17 22l5 -5"/>
                                </svg>
                                Deactivate
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                </svg>
                                Activate
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Approval Info --}}
            @if($news->is_approved)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Approval Information</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Approved By</div>
                            <div class="datagrid-content">{{ $news->approver->name ?? 'N/A' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Approved At</div>
                            <div class="datagrid-content">{{ $news->approved_at?->format('M d, Y H:i') ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Publish Info --}}
            @if($news->is_published)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Publish Information</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Published By</div>
                            <div class="datagrid-content">{{ $news->publisher->name ?? 'N/A' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Published At</div>
                            <div class="datagrid-content">{{ $news->published_at?->format('M d, Y H:i') ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Meta Information --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Meta Information</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Created By</div>
                            <div class="datagrid-content">{{ $news->creator->name ?? 'N/A' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Created At</div>
                            <div class="datagrid-content">{{ $news->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        @if($news->updater || $news->updated_at != $news->created_at)
                        <div class="datagrid-item">
                            <div class="datagrid-title">Updated By</div>
                            <div class="datagrid-content">{{ $news->updater->name ?? 'N/A' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Updated At</div>
                            <div class="datagrid-content">{{ $news->updated_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                        <div class="datagrid-item">
                            <div class="datagrid-title">Gallery Images</div>
                            <div class="datagrid-content">{{ $news->images->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border-danger">
                <div class="card-header bg-danger-lt">
                    <h3 class="card-title text-danger">Danger Zone</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Once you delete this news, there is no going back. Please be certain.</p>
                    <form action="{{ route('news.destroy', $news) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this news? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7l16 0"/>
                                <path d="M10 11l0 6"/>
                                <path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Delete News
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection