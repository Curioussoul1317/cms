@extends('layouts.app')

@section('title', 'Sub Categories')

@section('content')
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Sub Categories</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('sub-categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus icon"></i>
                Create New Sub Category
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Main Category</th>
                    <th>Heading</th>
                    <th>Links</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="w-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subCategories as $subCategory)
                    <tr>
                        <td class="text-muted">{{ $subCategory->id }}</td>
                        <td class="text-nowrap">
                            <strong>{{ $subCategory->name }}</strong>
                        </td>
                        <td class="text-nowrap">{{ $subCategory->mainCategory->name }}</td>
                        <td>{{ Str::limit($subCategory->heading, 30) }}</td>
                        <td class="text-nowrap">
                            <span class="badge bg-blue-lt">{{ $subCategory->links_count }}</span>
                        </td>
                        <td class="text-nowrap">{{ $subCategory->order }}</td>
                        <td class="text-nowrap">
                            @if($subCategory->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="btn-list">
                                <a href="{{ route('sub-categories.edit', $subCategory) }}" class="btn btn-sm btn-icon btn-primary" title="Edit">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('sub-categories.destroy', $subCategory) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Are you sure you want to delete this sub category?')" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-folder-off icon"></i>
                                </div>
                                <p class="empty-title">No sub categories found</p>
                                <p class="empty-subtitle text-muted">
                                    Get started by creating your first sub category
                                </p>
                                <div class="empty-action">
                                    <a href="{{ route('sub-categories.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus icon"></i>
                                        Create Sub Category
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subCategories->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $subCategories->links() }}
        </div>
    @endif
</div>
@endsection