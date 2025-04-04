@extends('admin.layouts.header')

@section('content')

<div class="container">
    <h2>Edit Industries</h2>

    <form action="{{ route('industries.update', $industries->id) }}" method="POST">
        @csrf
        @method('PUT')

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
    <label for="industries_subcategory_id" class="form-label">Select Subcategory:</label>
    <select name="industries_subcategory_id" id="industries_subcategory_id" class="form-control" required>
        <option value="">-- Select Subcategory --</option>
        @foreach($subcategories as $sub)
            <option value="{{ $sub->industries_subcategory_id }}"
                {{ $industries->industries_subcategory_id == $sub->industries_subcategory_id ? 'selected' : '' }}>
                {{ $sub->name }}
            </option>
        @endforeach
    </select>
</div>

        <div class="mb-3">
            <label for="industries_name" class="form-label">Industries Name:</label>
            <input type="text" name="industries_name" class="form-control" value="{{ $industries->industries_name }}" required>
        </div>

        <div class="form-group">
            <label for="image">Industries Image</label>
            @if($industries->image)
                <div>
                    <img src="{{ asset($industries->image) }}" width="100" alt="Current Image">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control">{{ $industries->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title:</label>
            <input type="text" name="meta_title" class="form-control" value="{{ $industries->meta_title }}">
        </div>

        <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords:</label>
            <input type="text" name="meta_keywords" class="form-control" value="{{ $industries->meta_keywords }}">
        </div>

        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description:</label>
            <textarea name="meta_description" class="form-control">{{ $industries->meta_description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Industries</button>
        <a href="{{ route('industries.index') }}" class="btn btn-secondary">Back</a>
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
