@extends('admin.layouts.header')
@section('title', "index galleryfolder")

@section('content')
<h2>Gallery Folders</h2>

<form action="{{ route('admin.gallery-folder.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Folder name" required>
    <button type="submit">+ Create Folder</button>
</form>

<ul>
    @foreach($folders as $folder)
        <li>
            <a href="{{ route('admin.gallery-folder.show', $folder->id) }}">
                {{ $folder->name }}
            </a>
            <a href="{{ route('admin.gallery-folder.edit', $folder->id) }}">Edit</a>
            <form action="{{ route('admin.gallery-folder.destroy', $folder->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
