@extends('layouts.app')
@section('title', 'Places')

@section('content')
<div class="page-header">
    <h1 class="page-title">Places</h1>
    <a href="{{ route('admin.places.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Place
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.places.index') }}" class="row align-items-end">
            <div class="col-md-4">
                <label for="location_id" class="form-label">Filter by Location</label>
                <select name="location_id" id="location_id" class="form-select">
                    <option value="">All Locations</option>
                    @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
                @if(request('location_id'))
                <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($places as $place)
                    <tr>
                        <td>{{ $place->id }}</td>
                        <td>
                            <strong>{{ $place->name }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('admin.locations.show', $place->location) }}" class="text-decoration-none">
                                {{ $place->location->name }}
                            </a>
                        </td>
                        <td>{{ $place->phone_number ?: '-' }}</td>
                        <td>{{ $place->email ?: '-' }}</td>
                        <td>
                            @if($place->is_active)
                            <span class="badge badge-active">Active</span>
                            @else
                            <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.places.show', $place) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.places.destroy', $place) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this place?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No places found</p>
                            <a href="{{ route('admin.places.create') }}" class="btn btn-primary btn-sm">
                                Create your first place
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($places->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $places->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection