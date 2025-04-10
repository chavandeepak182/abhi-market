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
                <li><span class="text-main-600 fw-normal text-15">Edit Service</span></li>
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
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="row gy-20">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="category" class="form-label">Select Category:</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}"
                                        {{ (isset($subcategory) && $subcategory->pid == $category->pid) ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="property_subcategory_id" class="form-label">Select Subcategory:</label>
                            <select name="property_subcategory_id" id="property_subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->property_subcategory_id }}"
                                        {{ $service->property_subcategory_id == $sub->property_subcategory_id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="service_name" class="form-label">Service Name:</label>
                            <input type="text" name="service_name" class="form-control" value="{{ $service->service_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="summernote" class="form-control">{{ $service->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Service Image</label>
                            @if($service->image)
                                <div class="mb-10">
                                    <img src="{{ asset($service->image) }}" width="100" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mt-10 mb-10">
                            <label for="slug" class="form-label">Slug (URL):</label>
                            <input type="text" name="slug" class="form-control" value="{{ $service->slug }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title:</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $service->meta_title }}">
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords:</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ $service->meta_keywords }}">
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description:</label>
                            <textarea name="meta_description" class="form-control">{{ $service->meta_description }}</textarea>
                        </div>
                        
                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-success rounded-pill py-9">Update Service</button>
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
