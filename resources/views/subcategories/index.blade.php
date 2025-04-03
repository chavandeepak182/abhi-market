@extends('admin.layouts.header')

@section('content')
<div class="container">
    <h2>Manage Subcategories</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('subcategories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="pid" class="form-label">Select Category:</label>
            <select name="pid" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Subcategory</button>
    </form>

    <h3 class="mt-4">Existing Subcategories</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subcategory Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
            <tr>
                <td>{{ $subcategory->property_subcategory_id }}</td>
                <td>{{ $subcategory->name }}</td>
                <td>{{ $subcategory->category_name }}</td>
                <td>
                    <a href="{{ route('subcategories.edit', $subcategory->property_subcategory_id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('subcategories.delete', $subcategory->property_subcategory_id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

