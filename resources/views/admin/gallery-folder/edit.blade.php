@extends('admin.layouts.header')

@section('title', 'Edit Gallery Folder')

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ route('admin.gallery-folder.index') }}" class="text-gray">Gallery Folders</a></li>
                <li class="text-main">Edit</li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.gallery-folder.update', $galleryFolder->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Folder Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $galleryFolder->name) }}" 
                           class="form-control" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.gallery-folder.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
