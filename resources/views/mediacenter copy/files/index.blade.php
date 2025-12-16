 
@extends('layouts.app')

@section('title', 'Media Files - Admin')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Media Files Management</h2>
            <a href="{{ route('mediafiles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Upload New File
            </a>
            <a href="{{ route('mediacategories.index') }}" class="btn btn-info">
                <i class="bi bi-folder"></i> Manage Categories
            </a>
            <a href="{{ route('mediacenter.index') }}" class="btn btn-success">
                <i class="bi bi-eye"></i> View Media Center
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Reference #</th>
                            <th>File Size</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ Str::limit($file->title, 40) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $file->category->name }}</span>
                                </td>
                                <td>{{ $file->date->format('d M Y') }}</td>
                                <td><code>{{ $file->reference_number }}</code></td>
                                <td>{{ $file->file_size_formatted }}</td>
                                <td>
                                    <span class="badge bg-{{ $file->is_active ? 'success' : 'secondary' }}">
                                        {{ $file->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('mediafiles.download', $file) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <a href="{{ route('mediafiles.edit', $file) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('mediafiles.destroy', $file) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No files found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $files->links() }}
            </div>
        </div>
    </div>
</div>
@endsection