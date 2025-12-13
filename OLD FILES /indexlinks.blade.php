@extends('layouts.app')

@section('title', 'Links')

@section('content')
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Links</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('links.create') }}" class="btn btn-primary">
                <i class="ti ti-plus icon"></i>
                Create New Link
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
                    <th>Title</th>
                    <th>URL</th>
                    <th>Sub Category</th>
                    <th>Main Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="w-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                    <tr>
                        <td class="text-muted">{{ $link->id }}</td>
                        <td>
                            <strong>{{ $link->title }}</strong>
                        </td>
                        <td>
                            <a href="{{ $link->url }}" target="_blank" class="text-blue">
                                {{ Str::limit($link->url, 40) }}
                            </a>
                        </td>
                        <td class="text-nowrap">{{ $link->subCategory->name }}</td>
                        <td class="text-nowrap">{{ $link->subCategory->mainCategory->name }}</td>
                        <td class="text-nowrap">{{ $link->order }}</td>
                        <td class="text-nowrap">
                            @if($link->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <div class="btn-list">
                                <a href="{{ route('link-contents.index', $link) }}" class="btn btn-sm btn-purple" title="Manage Content">
                                    <i class="ti ti-file-text icon"></i>
                                    Content
                                </a>
                                <a href="{{ route('link.view', $link->id) }}" target="_blank" class="btn btn-sm btn-success" title="Preview">
                                    <i class="ti ti-eye icon"></i>
                                    Preview
                                </a>
                                <a href="{{ route('links.edit', $link) }}" class="btn btn-sm btn-icon btn-primary" title="Edit">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('links.destroy', $link) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Are you sure you want to delete this link?')" title="Delete">
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
                                    <i class="ti ti-link-off icon"></i>
                                </div>
                                <p class="empty-title">No links found</p>
                                <p class="empty-subtitle text-muted">
                                    Get started by creating your first link
                                </p>
                                <div class="empty-action">
                                    <a href="{{ route('links.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus icon"></i>
                                        Create Link
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($links->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $links->links() }}
        </div>
    @endif
</div>
@endsection