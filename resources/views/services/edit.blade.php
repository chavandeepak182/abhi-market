@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Edit Service</h2>

    <form action="{{ route('services.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="subcategory_id" class="form-label">Select Subcategory:</label>
            <select name="subcategory_id" class="form-control" required>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" {{ $service->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                        {{ $subcategory->subcategory_name }}
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
@endsection
