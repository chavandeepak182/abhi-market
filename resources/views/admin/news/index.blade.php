@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<h2>News List</h2>
<a href="{{ route('admin.news.create') }}">+ Add News</a>
<table border="1" cellpadding="8">
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @foreach($news as $n)
        <tr>
            <td>{{ $n->title }}</td>
            <td>{{ $n->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.news.edit', $n->id) }}">Edit</a> |
                <form action="{{ route('admin.news.destroy', $n->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this news?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection