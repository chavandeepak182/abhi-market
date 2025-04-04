@extends('admin.layouts.header')
@section('content')
<div class="container">
    <h2>Manage Industries</h2>
    <a href="{{ route('industries.create') }}" class="btn btn-primary">Add Industries</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- List insights -->
    <h3 class="mt-4">Insights List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Industries Name</th>
                <th>Subcategory</th>
                <th>Description</th>
                <th>Meta Title</th>
                <th>Meta Keywords</th>
                <th>Meta Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($industries as $industries)
            <tr>
                <td>{{ $industries->id }}</td>
                <td>{{ $industries->industries_name }}</td>
                <td>{{ $industries->subcategory_name }}</td>
                <td>{{ Str::limit($industries->description, 50) }}</td>
                <td>{{ $industries->meta_title }}</td>
                <td>{{ Str::limit($industries->meta_keywords, 30) }}</td>
                <td>{{ Str::limit($industries->meta_description, 50) }}</td>
                <td>
                    <a href="{{ route('industries.edit', $industries->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('industries.delete', $industries->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
