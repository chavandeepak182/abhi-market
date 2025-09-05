@extends('admin.layouts.header')
@section('title', "User Management")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><a href="{{ url('admin/blog') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Blog</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add Blog</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('blog.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Blog <span class="text-13 text-gray-400 fw-medium"></span> </label>
                    <div class="col-md-8 col-sm-5">
                        <div class="position-relative pb-15 form-group">
                            <label for="category">Select Blog Category</label>
                            <select id="category" name="category_id" class="form-control" required>
                                <option value="">-- Select Blog Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- <div class="position-relative pb-15 form-group">
                            <label for="industries_subcategory_id">Select Subcategory</label>
                            <select name="industries_subcategory_id" id="industries_subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div> -->

                        <div class="position-relative pb-15 form-group">
                            <label for="blog_name">Blog Name</label>
                            <input type="text" name="blog_name" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="summernote" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-7">
                        <div class="position-relative pb-15 form-group">
                            <label for="image">Blog  Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Slug URL</label>
                            <input type="text" name="slug" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Publish Date</label>
                            <input type="date" name="publish_date" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Select Status --</option>
                                <option value="active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Tag</label>
                            <input type="text" name="tag" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Author Name</label>
                            <input type="text" name="author_name" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" class="form-control"></textarea>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">Schema Markup / Open Graph Meta / Twitter Card Meta</label>
                            <textarea name="schema_markup" id="schema_markup" class="form-control" style="height:150px;"></textarea>
                        </div>

                        <div class="position-relative flex-align">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Insight</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
