@extends('admin.layouts.header')
@section('title', "Add Press Release")

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
                <li><span class="text-main-600 fw-normal text-15">Add Press Release</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <a href="{{ route('press-releases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('press-releases.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Press Release</label>

                    <div class="form-group">
                        <label for="industry_category_id">Industry Category</label>
                        <select name="industry_category_id" id="industry_category_id" class="form-control" required>
                            <option value="">Select Industry Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-8 col-sm-5">
                        <div class="form-group pb-15">
                            <label for="title">Press Release Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group pb-15">
                            <label for="author_name">Author Name</label>
                            <input type="text" name="author_name" id="author_name" class="form-control">
                        </div>

                        <div class="form-group pb-15">
                            <label for="publish_date">Publish Date</label>
                            <input type="date" name="publish_date" id="publish_date" class="form-control" required>
                        </div>

                        <div class="form-group pb-15">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group pb-15">
                            <label for="content">Full Content</label>
                            <textarea name="content" id="summernote" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-7">
                        <div class="form-group pb-15">
                            <label for="image">Press Release Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="form-group pb-15">
                            <label for="slug">Slug URL</label>
                            <input type="text" name="slug" id="slug" class="form-control" required>
                        </div>

                        <div class="form-group pb-15">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control">
                        </div>

                        <div class="form-group pb-15">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control">
                        </div>

                        <div class="form-group pb-15">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group pb-15">
                            <label for="schema_markup">Schema Markup / Open Graph Meta</label>
                            <textarea name="schema_markup" id="schema_markup" class="form-control" style="height:150px;"></textarea>
                        </div>

                        <div class="position-relative flex-align">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Press Release</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Summernote Script -->
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
