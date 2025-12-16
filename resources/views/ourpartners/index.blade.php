@extends('layouts.app')

@section('title', 'Our Partners')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Administration</div>
                <h2 class="page-title">Our Partners</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('ourpartners.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-plus me-1"></i>
                        Add Partner
                    </a>
                    {{-- Mobile button --}}
                    <a href="{{ route('ourpartners.create') }}" class="btn btn-primary d-sm-none btn-icon" aria-label="Add Partner">
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
                    <i class="ti ti-building-community me-2 text-primary"></i>
                    All Partners
                </h3>
                <div class="card-actions">
                    <span class="badge bg-primary-lt">
                        {{ $partners->count() }} {{ Str::plural('partner', $partners->count()) }}
                    </span>
                </div>
            </div>

            @if($partners->count() > 0)
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th class="w-1">Order</th>
                                <th class="w-1">Logo</th>
                                <th>Partner Name</th>
                                <th class="text-center">Status</th>
                                <th class="w-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $partner)
                                <tr>
                                    <td class="text-secondary">
                                        <span class="badge bg-secondary-lt">{{ $partner->order }}</span>
                                    </td>
                                    <td>
                                        @if($partner->image)
                                            <div class="bg-light rounded p-2 d-flex align-items-center justify-content-center" style="width: 80px; height: 50px;">
                                                <img src="{{ $partner->image_url }}" 
                                                     alt="{{ $partner->name }}" 
                                                     style="max-width: 70px; max-height: 40px; object-fit: contain;">
                                            </div>
                                        @else
                                            <span class="avatar rounded bg-secondary-lt text-secondary">
                                                <i class="ti ti-photo-off"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $partner->name }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if($partner->is_active)
                                                <span class="badge bg-green-lt">
                                                    <i class="ti ti-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-lt">
                                                    <i class="ti ti-x me-1"></i> Inactive
                                                </span>
                                            @endif
                                            
                                            @if($partner->is_published ?? false)
                                                <span class="badge bg-blue-lt">
                                                    <i class="ti ti-world me-1"></i> Published
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('ourpartners.edit', $partner) }}" 
                                               class="btn btn-icon btn-ghost-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Partner">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('ourpartners.destroy', $partner) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this partner?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-icon btn-ghost-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Partner">
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
                            <i class="ti ti-building-community" style="font-size: 3rem;"></i>
                        </div>
                        <p class="empty-title">No partners found</p>
                        <p class="empty-subtitle text-secondary">
                            Add your organization's partners and collaborators.
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('ourpartners.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Add First Partner
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