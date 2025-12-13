@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Board of Directors Management</h2>
                <div>
                    <a href="{{ route('bod.show', 1) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Public Page
                    </a>
                    <a href="{{ route('bod.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Director
                    </a>
                </div>
            </div>
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($directors as $director)
                            <tr>
                                <td>{{ $director->order }}</td>
                                <td>
                                    @if($director->image)
                                        <img src="{{ asset('storage/' . $director->image) }}" 
                                             alt="{{ $director->name }}" 
                                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: #ddd;"></div>
                                    @endif
                                </td>
                                <td>{{ $director->name }}</td>
                                <td>{{ $director->title }}</td>
                                <td>
                                    @if($director->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('bod.edit', $director) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('bod.destroy', $director) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this director?');" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No directors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $directors->links() }}
        </div>
    </div>
</div>
@endsection