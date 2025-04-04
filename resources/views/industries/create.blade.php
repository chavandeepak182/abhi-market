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
                <li><a href="{{ url('admin/industries') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Industries</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add Industry</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('industries.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('industries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Industry <span class="text-13 text-gray-400 fw-medium"></span> </label>
                    <div class="col-md-6 col-sm-5">
                        <div class="position-relative pb-15 form-group">
                            <label for="category">Select Category</label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="industries_subcategory_id">Select Subcategory</label>
                            <select name="industries_subcategory_id" id="industries_subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="industries_name">Industry Name</label>
                            <input type="text" name="industries_name" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="position-relative flex-align">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Insight</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-7">
                        <div class="position-relative pb-15 form-group">
                            <label for="image">Industry Image</label>
                            <input type="file" name="image" class="form-control">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('category').addEventListener('change', function () {
    let categoryId = this.value;
    let subcategoryDropdown = document.getElementById('industries_subcategory_id');

    fetch(`/get-subcategories-industries/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
            data.forEach(sub => {
                subcategoryDropdown.innerHTML += `<option value="${sub.industries_subcategory_id}">${sub.name}</option>`;
            });
        });
});
</script>
@endsection
