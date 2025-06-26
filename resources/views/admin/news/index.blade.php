@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<!-- <h2>News List</h2> -->
<!-- <a href="{{ route('admin.news.create') }}">+ Add News</a> -->
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Manage News</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add News</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>
        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-20">
                    <h5 class="fw-semibold font-heading mb-0">News List</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $n)
                                <tr>
                                    <td>{{ $n->title }}</td>
                                    <td>
                                        @if($n->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.news.edit', $n->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.news.destroy', $n->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this news?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($news->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No news found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

@endsection