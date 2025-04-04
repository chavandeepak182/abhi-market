@extends('admin.layouts.header')
@section('content')
<div class="container">
    <h2>Manage Services</h2>
    <a href="{{ route('services.create') }}" class="btn btn-primary">Add Service</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- List Services -->
    <h3 class="mt-4">Services List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Subcategory</th>
                <th>Description</th>
                <th>Meta Title</th>
                <th>Meta Keywords</th>
                <th>Meta Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->subcategory_name }}</td>
                <td>{{ Str::limit($service->description, 50) }}</td>
                <td>{{ $service->meta_title }}</td>
                <td>{{ Str::limit($service->meta_keywords, 30) }}</td>
                <td>{{ Str::limit($service->meta_description, 50) }}</td>
                <td>
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('services.delete', $service->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
