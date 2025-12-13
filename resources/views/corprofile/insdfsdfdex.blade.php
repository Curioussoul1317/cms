@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Corporate Profiles</h2>
                <a href="{{ route('corprofile.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Profile
                </a>
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
                            <th>ID</th>
                            <th>Description</th>
                            <th>Vision</th>
                            <th>Mission</th>
                            <th>Objectives</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ Str::limit($page->description, 50) }}</td>
                                <td>
                                    @if($page->vision_image)
                                        <i class="fas fa-image text-success"></i>
                                    @endif
                                    {{ Str::limit($page->vision_text, 30) }}
                                </td>
                                <td>
                                    @if($page->mission_image)
                                        <i class="fas fa-image text-success"></i>
                                    @endif
                                    {{ Str::limit($page->mission_text, 30) }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $page->objectives->count() }}</span>
                                </td>
                                <td>{{ $page->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('corprofile.show', $page) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('corprofile.edit', $page) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('corprofile.destroy', $page) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this profile?');" 
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
                                <td colspan="7" class="text-center">No corporate profiles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection