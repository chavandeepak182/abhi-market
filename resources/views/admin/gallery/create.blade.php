@extends('admin.layouts.header')
@section('title', "create gallery")
@section('content')
<h2>Upload Image</h2>
<form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Folder</label>
    <select name="folder_id" required>
        @foreach($folders as $folder)
            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
        @endforeach
    </select>

    <label>Title</label>
    <input type="text" name="title">

    <label>Image</label>
    <input type="file" name="image" required>

    <button type="submit">Upload</button>
</form>

@endsection
