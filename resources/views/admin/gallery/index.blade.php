@extends('admin.layouts.header')
@section('title', "Gallery")

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
                    <span class="text-main-600 fw-normal text-15">Manage Gallery</span>
                </li>
            </ul>
        </div>
         <div class="back-button">
             <a href="{{ route('admin.gallery.create') }}" class="add-btn">+ Add Image</a>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="table-wrapper">
        <table class="gallery-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Preview</th>
                    <th>Link</th>
                    <th>Folder</th>
                    <th>Title</th> <!-- ✅ Title column added -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $gallery)
                    <tr>
                        <td>{{ $gallery->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $gallery->image) }}" 
                                 width="80" 
                                 alt="{{ $gallery->alt ?? 'Gallery Image' }}">
                        </td>
                        <td>
                            <div class="link-box">
                                <input type="text" 
                                       id="link-{{ $gallery->id }}" 
                                       value="{{ asset('storage/' . ltrim($gallery->image, '/')) }}" 
                                       readonly>
                                <button type="button" class="copy-btn" onclick="copyToClipboard('link-{{ $gallery->id }}')">
                                    📋 Copy
                                </button>
                            </div>
                        </td>
                        <td>{{ $gallery->folder?->name ?? 'No Folder' }}</td>
                        <td>{{ $gallery->title ?? 'No Title' }}</td> <!-- ✅ Show Title -->
                        <td>
                            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" 
                               class="btn btn-warning btn-xs edit">
                                <i class="far fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" 
                                  method="POST" 
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-xs delete" 
                                        onclick="return confirm('Are you sure?');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No images found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table><br>
    </div>

    {{-- Pagination --}}
    @if(method_exists($galleries, 'links'))
        <div class="pagination-wrapper">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
