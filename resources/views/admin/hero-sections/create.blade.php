@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Create Hero Section</h2>
        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.hero-sections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.hero-sections.form')
    </form>
</div>
@endsection