@extends('layouts.app')

@section('title', 'View Place')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $place->name }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.places.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Place Details</div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="130">ID:</th>
                        <td>{{ $place->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $place->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code>{{ $place->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <td>
                            <a href="{{ route('admin.locations.show', $place->location) }}">
                                {{ $place->location->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{{ $place->phone_number ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $place->email ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $place->address ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($place->is_active)
                            <span class="badge badge-active">Active</span>
                            @else
                            <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td>{{ $place->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $place->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td>{{ $place->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>

                @if($place->description)
                <hr>
                <h6>Description</h6>
                <p class="text-muted">{{ $place->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Opening Hours</div>
            <div class="card-body">
                @if($place->opening_hours && count($place->opening_hours) > 0)
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Days</th>
                            <th>Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($place->opening_hours as $schedule)
                        <tr>
                            <td>{{ implode(', ', $schedule['days'] ?? []) }}</td>
                            <td>
                                @if(isset($schedule['closed']) && $schedule['closed'])
                                <span class="text-danger">Closed</span>
                                @else
                                {{ $schedule['open'] ?? '-' }} - {{ $schedule['close'] ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-muted">No opening hours set</p>
                @endif
            </div>
        </div>

        @if($place->image)
        <div class="card mt-4">
            <div class="card-header">Image</div>
            <div class="card-body">
                <img src="{{ Storage::url($place->image) }}" alt="{{ $place->name }}" class="img-fluid rounded">
            </div>
        </div>
        @endif
    </div>
</div>
@endsection