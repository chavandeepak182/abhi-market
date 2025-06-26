@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<h2>Edit News</h2>
<form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" value="{{ $news->title }}" required><br><br>
    <textarea name="content" required>{{ $news->content }}</textarea><br><br>
    @if($news->image)
        <img src="{{ asset('storage/'.$news->image) }}" width="100"><br>
    @endif
    <input type="file" name="image"><br><br>
    <button type="submit">Update</button>
</form>
@endsection