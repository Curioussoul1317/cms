 
@extends('layouts.app')

@section('title', 'Our Partners - Admin')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Our Partners Management</h2>
            <a href="{{ route('ourpartners.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Partner
            </a>
            <a href="{{ route('ourpartners.show') }}" class="btn btn-success">
                <i class="bi bi-eye"></i> View Partners Page
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
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $partner)
                        <tr>
                            <td>{{ $partner->id }}</td>
                            <td>
                                <img src="{{ $partner->image_url }}" alt="{{ $partner->name }}" 
                                     style="height: 50px; max-width: 100px; object-fit: contain;">
                            </td>
                            <td>{{ $partner->name }}</td>
                            <td>{{ $partner->order }}</td>
                            <td>
                                <span class="badge bg-{{ $partner->is_active ? 'success' : 'secondary' }}">
                                    {{ $partner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('ourpartners.edit', $partner) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('ourpartners.destroy', $partner) }}" method="POST" class="d-inline">
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
                            <td colspan="6" class="text-center">No partners found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection