@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Manage Categories</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name:</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

    <h3 class="mt-4">Existing Categories</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->pid }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->pid) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('categories.delete', $category->pid) }}" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
