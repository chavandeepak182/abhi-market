@extends('frontend.layouts.header')

@section('title', 'M2square Consultancy - Blog | Latest Blog | Industry Blog')

@section('description', 'Market Research Blog, Market Research Articles.')

@section('keywords', 'market research blog, market research insights, business consulting tips, m2square consultancy blog, data-driven decisions, market analysis articles, consulting industry trends')

@section('content')

<!-- ===== Hero Banner ===== -->
<section class="hero-wrap position-relative" style="background-color:#006186;">
    <div class="hero-bg" style="background-color:#006186; background-size: cover;"></div>
    <div class="hero-overlay bg-dark opacity-50"></div>

    <div class="container hero-content py-5">
        <div class="row">
            <div class="col-lg-9 text-white">
                <!-- Breadcrumb -->
                <div class="breadcrumb-mini mb-2">
                    <a href="{{ url('/') }}" class="text-white">Home</a>
                    <span class="sep">/</span>
                    <span>Blogs</span>
                </div>

                <!-- Heading -->
                <h1 class="hero-title display-5 mb-2" style="color:#fff">Explore Blogs</h1>
                
            </div>
        </div>
    </div>

    <div class="hero-wave"></div>
</section>

<!-- ===== Blogs Section ===== -->
<div class="container py-5">

    <!-- Section Title -->
    <h2 class="section-title mb-4 text-center">Explore Blogs</h2>

    <!-- Search & Category Filter -->
    <form method="GET" action="{{ route('blog') }}" class="mb-5">
        <div class="row g-2 justify-content-center align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control" placeholder="Search blogs...">
            </div>

            <div class="col-md-4">
                <select id="category" name="category" class="form-select">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->pid }}" 
                            {{ request('category') == $category->pid ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Blog Cards -->
    <div class="row gy-4 gx-4">
        @forelse($allIndustries as $blog)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0 blog-box">
                        <img src="{{ asset($blog->image) }}" class="card-img-top" alt="{{ $blog->blog_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $blog->blog_name }}</h5>
                            <p class="card-text">{{ Str::limit(strip_tags($blog->description), 120, '...') }}</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}
                            </small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No blogs found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $allIndustries->withQueryString()->links() }}
    </div>
</div>

<!-- Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category').select2({
            placeholder: "-- Select Category --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
