@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Hero Section</h2>
        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Back to List
        </a>
    </div>


    @if(!$heroSection->is_approved)
<form action="{{ route('approve', ['model' => 'hero-section', 'id' => $heroSection->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Approve
    </button>
</form>
@else
<form action="{{ route('unapprove', ['model' => 'hero-section', 'id' => $heroSection->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-warning btn-sm">
        <i class="fas fa-times"></i> Unapprove
    </button>
</form>
@endif

@if(!$heroSection->is_published)
<form action="{{ route('publish', ['model' => 'hero-section', 'id' => $heroSection->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH') 
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-upload"></i> Publish
    </button>
</form>
@else
<form action="{{ route('unpublish', ['model' => 'hero-section', 'id' => $heroSection->id]) }}" method="POST" class="d-inline">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-secondary btn-sm">
        <i class="fas fa-download"></i> Unpublish
    </button>
</form>
@endif

    <form action="{{ route('admin.hero-sections.update', $heroSection) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.hero-sections.form')
    </form>
</div>
@endsection