@extends('admin.layouts.header')

@section('title', "Edit Gallery")

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
                    <span class="text-main-600 fw-normal text-15">Edit Gallery</span>
                </li>
            </ul>
        </div>
        <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="gallery-wrapper">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="upload-form">
            @csrf
            @method('PUT')

            <!-- Folder Select -->
            <label class="folder-label">Select Folder</label>
            <div class="folder-select-wrapper">
                <span class="folder-icon">📂</span>
                <select name="folder_id" required class="folder-select">
                    <option value="">-- Choose Folder --</option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}" 
                            {{ $gallery->folder_id == $folder->id ? 'selected' : '' }}>
                            {{ $folder->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Upload Box -->
            <div class="upload-box">
                <input type="file" 
                       name="image" 
                       id="imageUpload" 
                       accept="image/png, image/jpeg" 
                       hidden>
                <label for="imageUpload" class="upload-area">
                    <div class="upload-icon">🖼️</div>
                    <p><strong>Click to change</strong> or <span class="browse">Browse</span></p>
                    <small>PNG, JPEG (max 5MB)</small>
                </label>
            </div>

            <!-- Show existing image -->
            @if($gallery->image)
                <div class="mb-3">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/'.$gallery->image) }}" 
                         alt="{{ $gallery->alt }}" 
                         width="200" 
                         class="rounded shadow">
                </div>
            @endif

            <!-- Banner Title -->
            <input type="text" 
                   name="title" 
                   value="{{ old('title', $gallery->title) }}"
                   placeholder="Gallery Title" 
                   class="title-input">

            <!-- Upload Button -->
            <button type="submit" class="upload-btn">
                💾 Update Image
            </button>
        </form>
    </div>
</div>

<!-- CSS -->
<style>

</style>
@endsection
