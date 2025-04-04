@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Add Service</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="category">Select Category</label>
            <select id="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="property_subcategory_id">Select Subcategory</label>
            <select name="property_subcategory_id" id="property_subcategory_id" class="form-control" required>
                <option value="">-- Select Subcategory --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service_name">Service Name</label>
            <input type="text" name="service_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Service Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input type="text" name="meta_title" class="form-control">
        </div>

        <div class="form-group">
            <label for="meta_keywords">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control">
        </div>

        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea name="meta_description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Service</button>
    </form>
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
@endsection
