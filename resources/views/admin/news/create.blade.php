@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<h2>Add News</h2>
<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="content" placeholder="Content" required></textarea><br><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Submit</button>
</form>
@endsection