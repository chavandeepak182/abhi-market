@extends('admin.layouts.header')
@section('title', "User Management")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Manage Services</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('services.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Service</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card overflow-hidden">
        <div class="card-body overflow-x-auto">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table id="studentTable" class="table table-striped">
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
                <tbody id="user_table_body">
                    @foreach($services as $service)
                    <tr>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $loop->iteration }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $service->service_name }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $service->subcategory_name }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit(strip_tags($service->description), 50) }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $service->meta_title }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($service->meta_keywords, 30) }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($service->meta_description, 50) }}</span></td>
                        <td>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-xs edit"><i class="far fa-edit"></i></a>
                            <form action="{{ route('services.delete', $service->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure?');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 
</div>
@endsection
