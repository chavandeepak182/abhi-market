@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    <form action="{{ route('categories.update', $category->pid) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name:</label>
            <input type="text" name="category_name" class="form-control" value="{{ $category->category_name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
