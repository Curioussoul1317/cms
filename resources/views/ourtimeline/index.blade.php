 
@extends('layouts.app')

@section('title', 'Our Timeline')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Our Timeline Management</h2>
            <a href="{{ route('ourtimeline.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Timeline Item
            </a>
            <a href="{{ route('ourtimeline.show') }}" class="btn btn-success">
                <i class="bi bi-eye"></i> View Timeline
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->date->format('d M Y') }}</td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ $item->image_url }}" alt="Timeline" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $item->order }}</td>
                            <td>
                                <a href="{{ route('ourtimeline.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('ourtimeline.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No timeline items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection