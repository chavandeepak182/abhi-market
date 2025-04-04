@extends('admin.layouts.header')

@section('content')

<div class="container">
    <h2>Edit Service</h2>

    <form action="{{ route('services.update', $service->id) }}" method="POST">
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

        <div class="form-group">
            <label for="image">Service Image</label>
            @if($service->image)
                <div>
                    <img src="{{ asset($service->image) }}" width="100" alt="Current Image">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control">{{ $service->description }}</textarea>
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

        <button type="submit" class="btn btn-success">Update Service</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Back</a>
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
