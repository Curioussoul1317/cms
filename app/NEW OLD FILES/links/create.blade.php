@extends('layouts.app')

@section('title', 'Create Link')

@section('content')
<div class="container-xl">
  
    <div class="page-header d-print-none ">
        <div class="row g-2 align-items-center">
            <div class="col"> 
                <h2 class="page-title">New Page Creation</h2>
                <div class="text-muted mt-1">Creating new page under: <strong>{{ $selectedSubCategory->mainCategory->name }} of {{ $selectedSubCategory->name }}</strong></div>
            
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('categories.hierarchy') }}" class="btn btn-secondary d-none d-sm-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    Back 
                    </a> 
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="row row-cards">
            <div class="col-lg-12 mx-auto">
                <form action="{{ route('links.store') }}" method="POST">
                    @csrf

                    @if($selectedSubCategory)
                    <input type="hidden" name="sub_category_id" value="{{ $selectedSubCategory->id }}">
                    @endif
                    <div class="row row-cards">
                    <div class="card col-8"> 
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <!-- <div class="mb-3">
                                        <label class="form-label required">Sub Category</label>
                                        <select name="sub_category_id" id="sub_category_id" class="form-select @error('sub_category_id') is-invalid @enderror" required>
                                            <option value="">Select a sub category</option>
                                            @foreach($subCategories as $mainCategoryId => $subs)
                                                <optgroup label="{{ $subs->first()->mainCategory->name }}">
                                                    @foreach($subs as $sub)
                                                        <option value="{{ $sub->id }}" {{ old('sub_category_id', request('sub_category')) == $sub->id ? 'selected' : '' }}>
                                                            {{ $sub->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <small class="form-hint">Choose which sub category this link belongs to</small>
                                        @error('sub_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label required">Title</label>
                                        <input type="text" 
                                               name="title" 
                                               id="title" 
                                               value="{{ old('title') }}" 
                                               class="form-control @error('title') is-invalid @enderror" 
                                               placeholder="Enter Page title"
                                               required>
                                        <small class="form-hint">A descriptive title for this Page</small>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
 

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" 
                                                  id="description" 
                                                  rows="4" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Enter a brief description of this link">{{ old('description') }}</textarea>
                                        <small class="form-hint">Optional description to provide more context about this link</small>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Card -->
                    <div class="card mt-3 col-4">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" 
                                               name="order" 
                                               id="order" 
                                               value="{{ old('order', 0) }}" 
                                               class="form-control @error('order') is-invalid @enderror" 
                                               placeholder="0">
                                        <small class="form-hint">Lower numbers appear first (e.g., 1, 2, 3...)</small>
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div>
                                            <label class="form-check form-switch">
                                                <input type="checkbox" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }} 
                                                       class="form-check-input">
                                                <span class="form-check-label">Active</span>
                                            </label>
                                            <small class="form-hint d-block mt-1">
                                                When inactive, this link will be hidden from public view
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mb-0 mt-3">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <i class="ti ti-info-circle icon alert-icon"></i>
                                    </div>
                                    <div>
                                        <h4 class="alert-title">What's next?</h4>
                                        <div class="text-muted">
                                            After creating this link, you can add content blocks to enhance the page with rich content like cards, galleries, heroes, and more.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex">
                                <a href="{{ route('categories.hierarchy') }}" class="btn btn-link">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="ti ti-plus icon me-1"></i>
                                    Create Link
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>

                <!-- Help Card -->
                <!-- <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-help icon me-2"></i>
                            Quick Tips
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="divide-y">
                            <div class="row">
                                <div class="col-auto">
                                    <span class="avatar bg-blue-lt text-blue">
                                        <i class="ti ti-link icon"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="mb-1"><strong>Valid URLs</strong></div>
                                    <div class="text-muted small">
                                        Make sure your URL starts with http:// or https:// for proper linking
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <span class="avatar bg-green-lt text-green">
                                        <i class="ti ti-file-text icon"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="mb-1"><strong>Descriptive Titles</strong></div>
                                    <div class="text-muted small">
                                        Use clear, descriptive titles that help users understand what the link is about
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <span class="avatar bg-indigo-lt text-indigo">
                                        <i class="ti ti-layout-grid icon"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="mb-1"><strong>Content Blocks</strong></div>
                                    <div class="text-muted small">
                                        After creating the link, add content blocks to build rich, engaging pages
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
 
   
    document.getElementById('url').addEventListener('blur', function(e) {
        const url = e.target.value;
        if (url && !url.match(/^https?:\/\//)) {
            e.target.value = 'https://' + url;
        }
    });
</script>
@endsection