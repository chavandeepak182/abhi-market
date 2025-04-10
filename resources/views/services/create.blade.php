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
                <li><a href="{{ url('admin/services') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Services</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add Service</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('services.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Service <span class="text-13 text-gray-400 fw-medium"></span> </label>
                    <div class="col-md-8 col-sm-5">
                        <div class="position-relative pb-15">
                            <select id="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="position-relative pb-15">
                            <select name="property_subcategory_id" id="property_subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div>

                        <div class="position-relative pb-15">
                            <input type="text" name="service_name" class="form-control" placeholder="Enter Service Name" required>
                        </div>

                        <div class="position-relative pb-15">
                            <textarea name="description" id="summernote" class="form-control" placeholder="Add Description" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-7">
                        <div class="position-relative pb-15">
                            <input type="file" name="image" class="form-control" placeholder="Service Banner">
                        </div>

                        <div class="position-relative pb-15">
                            <input type="text" name="slug" class="form-control" placeholder="Enter Slug URL" required>
                        </div>
                        
                        <div class="position-relative pb-15">
                            <input type="text" name="meta_title" class="form-control" placeholder="Meta Title">
                        </div>

                        <div class="position-relative pb-15">
                            <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords">
                        </div>

                        <div class="position-relative pb-15">
                            <textarea name="meta_description" class="form-control" placeholder="Add Meta Description" required></textarea>
                        </div>

                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Service</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('category').addEventListener('change', function () {
            let categoryId = this.value;
            let subcategoryDropdown = document.getElementById('property_subcategory_id');

            fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
                data.forEach(sub => {
                    subcategoryDropdown.innerHTML += `<option value="${sub.property_subcategory_id}">${sub.name}</option>`;
                });
            });
        });
    </script>
</div>
@endsection
