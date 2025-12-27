@extends('layouts.app')

@section('title', 'News Management')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">CMS</div>
                <h2 class="page-title">News Management</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('news.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add News
                    </a>
                    <a href="{{ route('news.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add News">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-check me-2"></i></div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-alert-circle me-2"></i></div>
                    <div>{{ session('error') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('news.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control" placeholder="Search news..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved (Not Published)</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-list">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-search me-1"></i>
                                    Filter
                                </button>
                                <a href="{{ route('news.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-refresh me-1"></i>
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- News Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Order</th>
                            <th style="width: 80px;">Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Images</th>
                            <th>Created</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                        <tr>
                            <td>
                                <span class="badge bg-secondary-lt">{{ $item->sort_order }}</span>
                            </td>
                            <td>
                                @if($item->featured_image)
                                    <span class="avatar avatar-md" style="background-image: url({{ $item->featured_image_url }})"></span>
                                @else
                                    <span class="avatar avatar-md bg-secondary-lt">
                                        <i class="ti ti-photo"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ Str::limit($item->title, 50) }}</div>
                                <div class="text-secondary small">{{ $item->slug }}</div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @if($item->is_approved)
                                        <span class="badge bg-green-lt">
                                            <i class="ti ti-check me-1"></i>Approved
                                        </span>
                                    @else
                                        <span class="badge bg-yellow-lt">
                                            <i class="ti ti-clock me-1"></i>Pending
                                        </span>
                                    @endif
                                    @if($item->is_published)
                                        <span class="badge bg-blue-lt">
                                            <i class="ti ti-world me-1"></i>Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-lt">
                                            <i class="ti ti-world-off me-1"></i>Draft
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-green">Active</span>
                                @else
                                    <span class="badge bg-red">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-cyan-lt">
                                    <i class="ti ti-photo me-1"></i>
                                    {{ $item->images->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="text-secondary">{{ $item->created_at->format('d M Y') }}</div>
                                @if($item->creator)
                                    <div class="small text-muted">by {{ $item->creator->name }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('news.show', $item) }}" 
                                       class="btn btn-icon btn-ghost-primary btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="View">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('news.edit', $item) }}" 
                                       class="btn btn-icon btn-ghost-warning btn-sm"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('news.destroy', $item) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this news? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-icon btn-ghost-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-news-off" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="empty-title">No news found</p>
                                    <p class="empty-subtitle text-secondary">
                                        Try adjusting your search or filter to find what you're looking for.
                                    </p>
                                    <div class="empty-action">
                                        <a href="{{ route('news.create') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>
                                            Add News
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($news->hasPages())
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-secondary">
                        Showing <span>{{ $news->firstItem() }}</span> to <span>{{ $news->lastItem() }}</span> of <span>{{ $news->total() }}</span> entries
                    </p>
                    <div class="ms-auto">
                        {{ $news->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush