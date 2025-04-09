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
                <li><a href="{{ url('admin/insight') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Insights</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Edit Insight</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('insights.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('insights.update', $insights->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="insights_subcategory_id" class="form-label">Select Subcategory:</label>
                            <select name="insights_subcategory_id" id="insights_subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->insights_subcategory_id }}"
                                        {{ $insights->insights_subcategory_id == $sub->insights_subcategory_id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="insights_name" class="form-label">Insights Name:</label>
                            <input type="text" name="insights_name" class="form-control" value="{{ $insights->insights_name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="summernote" class="form-control">{{ $insights->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Insights Image</label>
                            @if($insights->image)
                                <div>
                                    <img src="{{ asset($insights->image) }}" width="100" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title:</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $insights->meta_title }}">
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords:</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ $insights->meta_keywords }}">
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description:</label>
                            <textarea name="meta_description" class="form-control">{{ $insights->meta_description }}</textarea>
                        </div>

                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-success rounded-pill py-9">Update Service</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('category').addEventListener('change', function () {
        let categoryId = this.value;
        let subcategoryDropdown = document.getElementById('insights_subcategory_id');

        fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
                data.forEach(sub => {
                    subcategoryDropdown.innerHTML += `<option value="${sub.insights_subcategory_id}">${sub.name}</option>`;
                });
            });
    });
</script>
@endsection
