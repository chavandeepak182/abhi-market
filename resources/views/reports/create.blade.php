@extends('admin.layouts.header')
@section('title', "Adding Report")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><a href="{{ url('admin/reports') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">All Reports</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add Report</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Report <span class="text-13 text-gray-400 fw-medium"></span> </label>
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
                        <div class="position-relative pb-15 form-group">
                            <label for="report_name">Report Name</label>
                            <input type="text" name="report_name" id="report_name" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="summernote">Description</label>
                            <textarea name="description" id="summernote" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-7">
                        <div class="position-relative pb-15 form-group">
                            <label for="image">Report Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Slug URL</label>
                            <input type="text" name="slug" id="slug" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control"></textarea>
                        </div>

                        <div class="position-relative flex-align">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Report</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
