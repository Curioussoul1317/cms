@extends('layouts.app')

@section('title', 'View Location')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $location->name }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Location Details</div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="120">ID:</th>
                        <td>{{ $location->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $location->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code>{{ $location->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Map ID:</th>
                        <td>
                            @if($location->map_id)
                            <code>{{ $location->map_id }}</code>
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Color:</th>
                        <td>
                            <span class="d-inline-block me-2" style="width: 20px; height: 20px; background: {{ $location->color }}; border-radius: 4px; vertical-align: middle;"></span>
                            {{ $location->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td>{{ $location->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($location->is_active)
                            <span class="badge badge-active">Active</span>
                            @else
                            <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $location->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td>{{ $location->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>

                @if($location->description)
                <hr>
                <h6>Description</h6>
                <p class="text-muted">{{ $location->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Places in this Location</span>
                <a href="{{ route('admin.places.create') }}?location_id={{ $location->id }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Place
                </a>
            </div>
            <div class="card-body">
                @if($location->places->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($location->places as $place)
                            <tr>
                                <td><strong>{{ $place->name }}</strong></td>
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
                                    <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mt-2">No places in this location yet</p>
                    <a href="{{ route('admin.places.create') }}?location_id={{ $location->id }}" class="btn btn-primary btn-sm">
                        Add first place
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection