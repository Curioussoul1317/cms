@extends('layouts.app')

@section('title', 'Locations')

@section('content')
<div class="page-header">
    <h1 class="page-title">Locations</h1>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Location
    </a>
    <a href="{{ route('locations.map') }}">Locations</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Map ID</th>
                        <th>Places</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                    <tr>
                        <td>{{ $location->id }}</td>
                        <td>
                            <strong>{{ $location->name }}</strong>
                        </td>
                        <td><code>{{ $location->slug }}</code></td>
                        <td>
                            @if($location->map_id)
                            <code>{{ $location->map_id }}</code>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $location->places_count }} places</span>
                        </td>
                        <td>
                            @if($location->is_active)
                            <span class="badge badge-active">Active</span>
                            @else
                            <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.locations.show', $location) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?')">
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
                            <p class="text-muted mt-2">No locations found</p>
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-sm">
                                Create your first location
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($locations->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $locations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection