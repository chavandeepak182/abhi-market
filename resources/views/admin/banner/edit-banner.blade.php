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
                <li><a href="{{ url('admin/banners') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Banners</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Edit Banner</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row gy-20">
                    <div class="col-xxl-4 col-md-4 col-sm-5">
                        <div class="mb-3">
                            <label>Banner Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $banner->title }}">
                        </div>

                        <div class="mb-3">
                            <label>Current Image</label><br>
                            <img src="{{ asset('storage/' . $banner->image) }}" width="150">
                        </div>

                        <div class="mb-3">
                            <label>Upload New Image (Optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Update Banner</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>
@endsection
