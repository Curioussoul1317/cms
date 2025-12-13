 
@extends('layouts.app')

@section('title', 'Vacancy Locations - Admin')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Vacancy Locations Management</h2>
            <a href="{{ route('vacancylocations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Location
            </a>
            <a href="{{ route('vacancies.index') }}" class="btn btn-info">
                <i class="bi bi-briefcase"></i> Manage Vacancies
            </a>
            <a href="{{ route('vacancies.show') }}" class="btn btn-success">
                <i class="bi bi-eye"></i> View Vacancies Page
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
                        <th>Location Name</th>
                        <th>Vacancies Count</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr>
                            <td>{{ $location->id }}</td>
                            <td>{{ $location->location_name }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $location->vacancies_count }} vacancies</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $location->is_active ? 'success' : 'secondary' }}">
                                    {{ $location->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('vacancylocations.edit', $location) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('vacancylocations.destroy', $location) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure? This will delete all vacancies in this location!')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection