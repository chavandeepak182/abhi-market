@extends('admin.layouts.header')

@section('content')

<div class="container">
    <h2>Edit Insights</h2>

    <form action="{{ route('insights.update', $insights->id) }}" method="POST">
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
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control">{{ $insights->description }}</textarea>
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

        <button type="submit" class="btn btn-success">Update Insights</button>
        <a href="{{ route('insights.index') }}" class="btn btn-secondary">Back</a>
    </form>
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
