@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<div class="dashboard-body">
    <!-- Breadcrumb -->
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><a href="{{ route('admin.news.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">News</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add News</span></li>
            </ul>
        </div>

        <!-- Back Button -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    <!-- News Add Form Card -->
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add News</label>

                    <!-- Left Section -->
                    <div class="col-md-8 col-sm-6">
                        <div class="position-relative pb-15">
                            <input type="text" name="title" class="form-control" placeholder="Enter News Title" required>
                        </div>

                        <div class="position-relative pb-15">
                            <textarea name="content" rows="6" class="form-control" placeholder="Enter News Content" required></textarea>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-md-4 col-sm-6">
                        <div class="position-relative pb-15">
                            <input type="file" name="image" class="form-control" placeholder="Upload Image">
                        </div>

                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-main rounded-pill py-9 w-100">
                                <i class="fas fa-plus"></i> Add News
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection