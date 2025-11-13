@extends('frontend.layouts.header')

@section('title', 'Latest News - M2square Consultancy')
@section('description', 'Stay updated with the latest market insights and industry news from M2square Consultancy.')
@section('keywords', 'market news, industry insights, m2square consultancy news, research updates')

@section('content')

<!-- ===== Hero Banner ===== -->
<section class="hero-wrap position-relative" style="background-color:#006186;">
    <div class="hero-overlay bg-dark opacity-50"></div>
    <div class="container hero-content py-5">
        <div class="row">
            <div class="col-lg-9 text-white">
                <div class="breadcrumb-mini mb-2">
                    <a href="{{ url('/') }}" class="text-white">Home</a>
                    <span class="sep">/</span>
                    <span>News</span>
                </div>
                <h1 class="hero-title display-5 mb-2" style="color:#fff">Latest News</h1>
            </div>
        </div>
    </div>
    <div class="hero-wave"></div>
</section>

<!-- ===== News Section ===== -->
<div class="container py-5">

    <!-- Section Title -->
    <h2 class="section-title mb-4 text-center">Explore News</h2>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('news') }}" class="mb-5">
        <div class="row g-2 justify-content-center align-items-center">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control" placeholder="Search news...">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- News Cards -->
    <div class="row gy-4 gx-4">
        @forelse($newsList as $item)
            <div class="col-md-4">
                <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                        @else
                            <img src="{{ asset('assets/images/no-image.jpg') }}" class="card-img-top" alt="No image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($item->content), 120, '...') }}</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}
                            </small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No news found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $newsList->withQueryString()->links() }}
    </div>
</div>

@endsection
