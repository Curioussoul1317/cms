@extends('layouts.app')

@section('title', 'Our Timeline')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Administration</div>
                <h2 class="page-title">Our Timeline</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('ourtimeline.show') }}" class="btn btn-outline-secondary d-none d-sm-inline-block">
                        <i class="ti ti-eye me-1"></i>
                        View Public Page
                    </a>
                    <a href="{{ route('ourtimeline.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Timeline Item
                    </a>
                    {{-- Mobile buttons --}}
                    <a href="{{ route('ourtimeline.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Timeline Item">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-timeline me-2 text-primary"></i>
                    Timeline Items
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $items->count() }} {{ Str::plural('item', $items->count()) }}
                    </span>
                </div>
            </div>

            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">Order</th>
                                <th class="w-1">Year</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="w-1">Image</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="text-secondary">
                                        <span class="badge bg-secondary-lt">{{ $item->order }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-blue text-blue-fg">{{ $item->year }}</span>
                                    </td>
                                    <td class="text-secondary">
                                        <i class="ti ti-calendar me-1"></i>
                                        {{ $item->date->format('d M Y') }}
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;">
                                            {{ Str::limit($item->description, 60) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->image)
                                            <span class="avatar avatar-sm rounded" 
                                                  style="background-image: url('{{ $item->image_url }}')">
                                            </span>
                                        @else
                                            <span class="avatar avatar-sm rounded bg-secondary-lt text-secondary">
                                                <i class="ti ti-photo-off"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($item->is_approved ?? false)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Approved
                                                </span>
                                            @else
                                                <span class="badge bg-yellow-lt">
                                                    <i class="ti ti-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                            
                                            @if($item->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('ourtimeline.edit', $item) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Item">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('ourtimeline.destroy', $item) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this timeline item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Item">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="ti ti-timeline" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No timeline items found</p>
                        <p class="empty-subtitle text-secondary">
                            Add milestones and events to your organization's timeline.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('ourtimeline.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Timeline Item
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush