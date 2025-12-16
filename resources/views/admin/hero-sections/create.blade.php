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
@endsection@extends('layouts.app')

@section('title', 'Create Hero Section')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="{{ route('admin.hero-sections.index') }}" class="text-secondary text-decoration-none">
                        <i class="ti ti-arrow-left me-1"></i> Back to Hero Sections
                    </a>
                </div>
                <h2 class="page-title">Create Hero Section</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if($errors->any())
            <div class="alert alert-danger">
                <div class="d-flex">
                    <div><i class="ti ti-alert-triangle me-2"></i></div>
                    <div>
                        <h4 class="alert-title">Please fix the following errors:</h4>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.hero-sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.hero-sections.form')
        </form>
    </div>
</div>
@endsection