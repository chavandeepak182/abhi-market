@extends('admin.layouts.header')
@section('title', "Gallery Folders")

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li>
                    <a href="{{ url('admin/dashboard') }}" 
                       class="text-gray-200 fw-normal text-15 hover-text-main-600">
                        Dashboard
                    </a>
                </li>
                <li> 
                    <span class="text-gray-500 fw-normal d-flex">
                        <i class="ph ph-caret-right"></i>
                    </span> 
                </li>
                <li>
                    <span class="text-main-600 fw-normal text-15">Gallery Folders</span>
                </li>
            </ul>
        </div>
        <!-- Breadcrumb End -->
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row gy-20">
                <!-- Left Column (Create Folder) -->
                <div class="col-xxl-4 col-md-4 col-sm-5">
                    <div class="mb-20">
                        <label class="h5 fw-semibold font-heading mb-0">
                            Create Folder 
                            <span class="text-13 text-gray-400 fw-medium">(Required)</span>
                        </label>
                    </div>

                    <form action="{{ route('admin.gallery-folder.store') }}" method="POST">
                        @csrf
                        <div class="position-relative mb-10">
                            <input type="text" class="form-control py-11 pe-76" maxlength="100" 
                                   name="name" placeholder="Enter Folder Name" required>
                        </div>
                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-main rounded-pill py-9">
                                <i class="fas fa-folder-plus"></i> Create Folder
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Column (Existing Folders) -->
                <div class="col-xxl-8 col-md-8 col-sm-7">
                    <div class="mb-20">
                        <label class="h5 fw-semibold font-heading mb-0">Existing Folders</label>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:65%">Folder Name</th>
                                    <th style="width:30%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($folders as $index => $folder)
                                <tr>
                                    <td>{{ $folders->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ route('admin.gallery-folder.show', $folder->id) }}" 
                                           class="text-main-600 fw-medium hover-underline">
                                           <i class="fas fa-folder text-warning me-2"></i>
                                            {{ $folder->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.gallery-folder.edit', $folder->id) }}" 
                                           class="btn btn-sm btn-warning me-2">
                                           <i class="far fa-edit"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.gallery-folder.destroy', $folder->id) }}" 
                                              method="POST" 
                                              style="display:inline-block;" 
                                              onsubmit="return confirm('Are you sure you want to delete this folder and all its images?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500">
                                        No folders created yet.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $folders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
