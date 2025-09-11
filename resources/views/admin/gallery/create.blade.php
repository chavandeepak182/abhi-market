@extends('admin.layouts.header')
@section('title', "Create Gallery")

@section('content')
<div class="dashboard-body">

    <!-- Breadcrumb -->
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
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
                    <span class="text-main-600 fw-normal text-15">Upload Image</span>
                </li>
            </ul>
        </div>

        <div class="back-button">
            <a href="{{ route('admin.gallery.index') }}" class="add-btn">← Back to Gallery</a>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Upload New Image</h4>

            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Folder</label>
                    <select name="folder_id" class="form-control" required>
                        <option value="">-- Select Folder --</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Optional title">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-main rounded-pill">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
