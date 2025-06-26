@extends('admin.layouts.header')
@section('title', "news")
@section('content')
<div class="dashboard-body">
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li>
                    <a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a>
                </li>
                <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li>
                    <a href="{{ route('admin.news.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">News</a>
                </li>
                <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li>
                    <span class="text-main-600 fw-normal text-15">Edit News</span>
                </li>
            </ul>
        </div>

        <div class="flex-align gap-8 flex-wrap">
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ url('admin/news/update/' . $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-20">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">News Title:</label>
                            <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">News Content:</label>
                            <textarea name="content" class="form-control" rows="8" required>{{ $news->content }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">News Image:</label>
                            @if($news->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $news->image) }}" width="100" class="rounded shadow-sm" alt="Current Image">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-success rounded-pill py-9 w-100">
                                <i class="fas fa-sync-alt me-1"></i> Update News
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection