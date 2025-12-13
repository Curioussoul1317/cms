@extends('layouts.app')

@section('title', 'Main Categories')

@section('content')
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Main Categories</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus icon"></i>
                Create New Category
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
                    <th>Slug</th>
                    <th>Sub Categories</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="w-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-muted">{{ $category->id }}</td>
                        <td class="text-nowrap">
                            <strong>{{ $category->name }}</strong>
                        </td>
                        <td class="text-muted text-nowrap">{{ $category->slug }}</td>
                        <td class="text-nowrap">
                            <span class="badge bg-blue-lt">{{ $category->sub_categories_count }}</span>
                        </td>
                        <td class="text-nowrap">{{ $category->order }}</td>
                        <td class="text-nowrap">
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="btn-list">
                                <a href="{{ route('main-categories.edit', $category) }}" class="btn btn-sm btn-icon btn-primary" title="Edit">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('main-categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Are you sure you want to delete this category?')" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <div class="empty">
                                <div class="empty-icon">
                                    <i class="ti ti-folder-off icon"></i>
                                </div>
                                <p class="empty-title">No categories found</p>
                                <p class="empty-subtitle text-muted">
                                    Get started by creating your first main category
                                </p>
                                <div class="empty-action">
                                    <a href="{{ route('main-categories.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus icon"></i>
                                        Create Main Category
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection