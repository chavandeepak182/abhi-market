@extends('admin.layouts.header')
@section('title', "Edit Press Release")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li><a href="{{ route('press-releases.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">All Press Releases</a></li>
                <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li><span class="text-main-600 fw-normal text-15">Edit Press Release</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right -->
        <div class="flex-align gap-8 flex-wrap">
            <a href="{{ route('press-releases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('press-releases.update', $pressRelease->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row gy-20">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $pressRelease->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $pressRelease->short_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" id="summernote" class="form-control">{{ old('content', $pressRelease->content) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Publish Date <span class="text-danger">*</span></label>
                            <input type="date" name="publish_date" class="form-control"
                                   value="{{ old('publish_date', \Carbon\Carbon::parse($pressRelease->publish_date)->format('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Author Name</label>
                            <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $pressRelease->author_name) }}">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Industry Category</label>
                            <select name="industry_category_id" class="form-control" required>
                                <option value="">-- Select Industry --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}" {{ $pressRelease->industry_category_id == $category->pid ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Image</label><br>
                            @if($pressRelease->image)
                                <img src="{{ asset($pressRelease->image) }}" width="120" class="mb-2 rounded" alt="Current Image">
                            @endif
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug URL</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $pressRelease->slug) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $pressRelease->meta_title) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $pressRelease->meta_keywords) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $pressRelease->meta_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Schema Markup / OG Meta</label>
                            <textarea name="schema_markup" class="form-control" style="height:150px;">{{ old('schema_markup', $pressRelease->schema_markup) }}</textarea>
                        </div>

                        <div class="flex-align mt-20">
                            <button type="submit" class="btn btn-success rounded-pill py-9">Update Press Release</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Summernote Editor --}}
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection
