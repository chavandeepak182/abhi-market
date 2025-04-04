@extends('admin.layouts.header')
@section('content')
<div class="container">
    <h2>Manage Insights</h2>
    <a href="{{ route('insights.create') }}" class="btn btn-primary">Add Insights</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- List insights -->
    <h3 class="mt-4">Insights List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Insights Name</th>
                <th>Subcategory</th>
                <th>Description</th>
                <th>Meta Title</th>
                <th>Meta Keywords</th>
                <th>Meta Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($insights as $insights)
            <tr>
                <td>{{ $insights->id }}</td>
                <td>{{ $insights->insights_name }}</td>
                <td>{{ $insights->subcategory_name }}</td>
                <td>{{ Str::limit($insights->description, 50) }}</td>
                <td>{{ $insights->meta_title }}</td>
                <td>{{ Str::limit($insights->meta_keywords, 30) }}</td>
                <td>{{ Str::limit($insights->meta_description, 50) }}</td>
                <td>
                    <a href="{{ route('insights.edit', $insights->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('insights.delete', $insights->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
