@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Hero Sections</h4>
                    <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Add New Hero
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Route</th>
                                    <th>Section</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($heroSections as $hero)
                                    <tr>
                                        <td>{{ $hero->id }}</td>
                                        <td><code>{{ $hero->route_name }}</code></td>
                                        <td>
                                            @if($hero->section)
                                                <span class="badge bg-info">{{ $hero->section }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($hero->title, 40) }}</td>
                                        <td>
                                            @if($hero->image)
                                                <img src="{{ asset('storage/' . $hero->image) }}" 
                                                     alt="Hero" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hero->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.hero-sections.edit', $hero) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.hero-sections.destroy', $hero) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this hero section?');"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">No hero sections found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $heroSections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection