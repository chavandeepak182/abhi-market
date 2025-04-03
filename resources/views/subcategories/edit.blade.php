@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Edit Subcategory</h2>

    <form action="{{ route('subcategories.update', $subcategory->property_subcategory_id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="pid" class="form-label">Select Category:</label>
            <select name="pid" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->pid }}" {{ $subcategory->pid == $category->pid ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Subcategory</button>
        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
