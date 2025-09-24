@extends('frontend.layouts.header')

@section('title', $blog->blog_name)
@section('description', Str::limit(strip_tags($blog->description), 160))
@section('keywords', $blog->blog_name)

@section('og_tags')
    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $blog->blog_name }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($blog->description), 150) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($blog->image))
        <meta property="og:image" content="{{ url('storage/blogs/'.$blog->image) }}">
    @else
        <meta property="og:image" content="{{ url('images/default-og.jpg') }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $blog->blog_name }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($blog->description), 150) }}">
    <meta name="twitter:image" content="{{ !empty($blog->image) ? url('storage/blogs/'.$blog->image) : url('images/default-og.jpg') }}">

    {{-- Schema Markup --}}
    @if(!empty($blog->schema_markup))
        <script type="application/ld+json">
            {!! $blog->schema_markup !!}
        </script>
    @endif
@endsection


@section('content')

<!-- Hero Section -->
<section class="hero-wrap position-relative" style="background-color:#006186;">
    <div class="hero-bg" style="background-image: url('{{ asset($blog->image) }}'); background-size: cover; background-position: center;"></div>
    <div class="hero-overlay bg-dark opacity-50"></div>

    <div class="container hero-content py-5 text-white">
        <div class="row">
            <div class="col-lg-9">
                <div class="breadcrumb-mini mb-2">
                   
                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                        <!-- <span class="sep">/</span> -->
                    </a>
                </div>

                <h1 class="display-5 fw-bold" style="color:#fff">{{ $blog->blog_name }}</h1>
            </div>
        </div>
    </div>
    <div class="hero-wave"></div>
</section>

<!-- Blog Content Section -->
<div class="container py-5">
    <div class="row">

        <!-- Main Content -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->blog_name }}" class="img-fluid rounded mb-4 shadow-sm">

            <h1 class="mb-3">{{ $blog->blog_name }}</h1>
            

            <p class="text-muted mb-4">
                Published on {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }} 
                <span class="mx-2">|</span>
                Category: <strong>{{ $blog->category_name }}</strong>
            </p>

            <div class="blog-description">
                {!! $blog->description !!}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">

            <!-- Blog Wise Enquiry Form -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Enquiry Form</h5>
                    <form action="{{ route('enquiry.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="page_url" value="{{ url()->current() }}">
                        <input type="hidden" name="page_name" value="{{ $blog->blog_name }}">
                        <input type="hidden" name="report_title" value="{{ $blog->blog_name }}">

                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="contact" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="message" class="form-control" placeholder="Message (Optional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>

            <!-- Latest Blogs -->
            <h5 class="mb-4">Latest Blogs</h5>
            @foreach($latestBlogs as $latest)
                <div class="card mb-3 shadow-sm border-0 latest-item">
                    <a href="{{ route('blog.show', $latest->slug) }}">
                        <img src="{{ asset($latest->image) }}" class="card-img-top" alt="{{ $latest->blog_name }}">
                    </a>
                    <div class="card-body p-3">
                        <a href="{{ route('blog.show', $latest->slug) }}" class="text-dark text-decoration-none">
                            <h6 class="card-title">{{ $latest->blog_name }}</h6>
                        </a>
                        <p class="card-text text-muted" style="font-size: 14px;">
                            {{ Str::limit(strip_tags($latest->description), 60) }}
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            {{ \Carbon\Carbon::parse($latest->created_at)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Related Blogs -->
    <div class="related-blogs mt-5">
        <h4 class="mb-4">Related Blogs</h4>
        <div class="row g-4">
            @foreach($relatedBlogs as $related)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm overflow-hidden related-item h-100">
                        <a href="{{ route('blog.show', $related->slug) }}">
                            <img src="{{ asset($related->image) }}" class="card-img-top" alt="{{ $related->blog_name }}">
                        </a>
                        <div class="card-body">
                            <a href="{{ route('blog.show', $related->slug) }}" class="text-dark text-decoration-none">
                                <h6 class="card-title">{{ $related->blog_name }}</h6>
                            </a>
                            <p class="text-muted mb-1" style="font-size: 14px;">
                                {{ Str::limit(strip_tags($related->description), 60) }}
                            </p>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                {{ \Carbon\Carbon::parse($related->created_at)->format('F d, Y') }}
                            </p>
                            <a href="{{ route('blog.show', $related->slug) }}" class="btn btn-sm btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Optional: CSS for hover effects -->
<style>
    .latest-item:hover, .related-item:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>

@endsection
