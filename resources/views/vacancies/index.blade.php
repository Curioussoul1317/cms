 
@extends('layouts.app')

@section('title', 'Vacancies - Admin')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Vacancies Management</h2>
            <a href="{{ route('vacancies.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Vacancy
            </a>
            <a href="{{ route('vacancylocations.index') }}" class="btn btn-info">
                <i class="bi bi-geo-alt"></i> Manage Locations
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Posted Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vacancies as $vacancy)
                            <tr>
                                <td>{{ $vacancy->id }}</td>
                                <td>{{ Str::limit($vacancy->title, 40) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $vacancy->location->location_name }}</span>
                                </td>
                                <td>{{ $vacancy->salary }}</td>
                                <td>{{ $vacancy->posted_date->format('d M Y') }}</td>
                                <td>{{ $vacancy->due_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $vacancy->is_expired ? 'danger' : 'success' }}">
                                        {{ $vacancy->is_expired ? 'Expired' : 'Active' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('vacancies.edit', $vacancy) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('vacancies.destroy', $vacancy) }}" method="POST" class="d-inline">
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
                                <td colspan="8" class="text-center">No vacancies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vacancies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection