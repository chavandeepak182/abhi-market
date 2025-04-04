@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Add Industries</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('industries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="category">Select Category</label>
            <select id="category" name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="industries_subcategory_id">Select Subcategory</label>
            <select name="industries_subcategory_id" id="industries_subcategory_id" class="form-control" required>
                <option value="">-- Select Subcategory --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="industries_name">Industries Name</label>
            <input type="text" name="industries_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Industries Image</label>
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

        <button type="submit" class="btn btn-primary">Add Industries</button>
    </form>
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
