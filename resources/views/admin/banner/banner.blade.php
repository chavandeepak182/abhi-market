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
                <li><span class="text-main-600 fw-normal text-15">Banners</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->
    </div>
    

    <div class="card">
        <div class="card-body">
            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row gy-20">
                    <div class="col-xxl-4 col-md-4 col-sm-5">
                        <div class="mb-20">
                            <label class="h5 fw-semibold font-heading mb-0">Banner Image <span class="text-13 text-gray-400 fw-medium">(Required)</span> </label>
                        </div>

                        <div id="fileUpload" class="fileUpload image-upload mb-10"></div>

                        <div class="position-relative">
                            <input type="text" class="text-counter placeholder-13 form-control py-11 pe-76" maxlength="100" id="courseTitle" name="title" placeholder="Banner Title">
                        </div>
                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-main rounded-pill py-9"><i class="fas fa-upload"></i> Upload Banner</button>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-md-8 col-sm-7">
                        <div class="mb-20">
                            <label class="h5 fw-semibold font-heading mb-0">Existing Banners</label>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($banners as $banner)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $banner->image) }}" width="100">
                                        </td>
                                        <td>{{ $banner->title }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>

                                            <!-- Delete Form -->
                                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                                @csrf
                                                <!-- @method('DELETE') Laravel DELETE request -->
                                                <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
@endsection
