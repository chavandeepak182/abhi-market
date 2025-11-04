@extends('frontend.layouts.header')

{{-- Page Meta --}}
@section('title', $pressRelease->meta_title ?? $pressRelease->title)
@section('description', Str::limit(strip_tags($pressRelease->meta_description ?? $pressRelease->short_description), 160))
@section('keywords', $pressRelease->meta_keywords ?? '')

{{-- Robots --}}
@section('robots')
    <meta name="robots" content="index, follow">
@endsection

{{-- Open Graph & Twitter & Schema --}}
@section('og_tags')
    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $pressRelease->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($pressRelease->short_description), 150) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($pressRelease->image))
        <meta property="og:image" content="{{ url($pressRelease->image) }}">
    @else
        <meta property="og:image" content="{{ url('images/default-og.jpg') }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pressRelease->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($pressRelease->short_description), 150) }}">
    <meta name="twitter:image" content="{{ !empty($pressRelease->image) ? url($pressRelease->image) : url('images/default-og.jpg') }}">

    {{-- Schema Markup --}}
    @if(!empty($pressRelease->schema_markup))
        <script type="application/ld+json">
            {!! $pressRelease->schema_markup !!}
        </script>
    @endif
@endsection


@section('content')

<!-- Hero Section -->
<section class="hero-wrap position-relative" style="background-color:#006186;">
    <div class="hero-bg" 
         style="background-image: url('{{ asset($pressRelease->image) }}'); background-size: cover; background-position: center;">
    </div>
    <div class="hero-overlay bg-dark opacity-50"></div>

    <div class="container hero-content py-5 text-white text-center">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="display-5 fw-bold text-white">{{ $pressRelease->title }}</h1>
        </div>
    </div>
</div>
</section>

<!-- Press Release Content Section -->
<div class="container py-5">
    <div class="row">

        <!-- Main Content -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            @if($pressRelease->image)
                <div style="width: 100%; height: 400px; overflow: hidden; border-radius: 8px;">
                    <img src="{{ asset($pressRelease->image) }}" 
                        alt="{{ $pressRelease->title }}" 
                        class="w-100 h-100 shadow-sm" 
                        style="object-fit: cover;">
                </div>
            @endif

            <h1 class="mb-3">{{ $pressRelease->title }}</h1>

            <p class="text-muted mb-4">
                Published on {{ \Carbon\Carbon::parse($pressRelease->publish_date)->format('F d, Y') }}
                <span class="mx-2">|</span>
                Category: <strong>{{ $pressRelease->category_name ?? 'N/A' }}</strong>
                @if(!empty($pressRelease->author_name))
                    <span class="mx-2">|</span> Author: <strong>{{ $pressRelease->author_name }}</strong>
                @endif
            </p>

            <div class="press-content">
                {!! $pressRelease->content !!}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">

            <!-- Press Release Enquiry Form -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Enquiry Form</h5>
                    <form action="{{ route('enquiry.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page_url" value="{{ url()->current() }}">
                        <input type="hidden" name="page_name" value="{{ $pressRelease->title }}">
                        <input type="hidden" name="report_title" value="{{ $pressRelease->title }}">

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

            <!-- Latest Press Releases -->
            <h5 class="mb-4">Latest Press Releases</h5>
            @foreach($latestPressReleases as $latest)
                <div class="card mb-3 shadow-sm border-0 latest-item">
                    <a href="{{ route('press-releases.details', $latest->slug) }}">
                        <img src="{{ asset($latest->image) }}" class="card-img-top" alt="{{ $latest->title }}">
                    </a>
                    <div class="card-body p-3">
                        <a href="{{ route('press-releases.details', $latest->slug) }}" class="text-dark text-decoration-none">
                            <h6 class="card-title">{{ $latest->title }}</h6>
                        </a>
                        <p class="card-text text-muted" style="font-size: 14px;">
                            {{ Str::limit(strip_tags($latest->short_description), 60) }}
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            {{ \Carbon\Carbon::parse($latest->publish_date)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Related Press Releases -->
    <div class="related-blogs mt-5">
        <h4 class="mb-4">Related Press Releases</h4>
        <div class="row g-4">
            @foreach($relatedPressReleases as $related)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm overflow-hidden related-item h-100">
                        <a href="{{ route('press-releases.details', $related->slug) }}">
                            <img src="{{ asset($related->image) }}" class="card-img-top" alt="{{ $related->title }}">
                        </a>
                        <div class="card-body">
                            <a href="{{ route('press-releases.details', $related->slug) }}" class="text-dark text-decoration-none">
                                <h6 class="card-title">{{ $related->title }}</h6>
                            </a>
                            <p class="text-muted mb-1" style="font-size: 14px;">
                                {{ Str::limit(strip_tags($related->short_description), 60) }}
                            </p>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                {{ \Carbon\Carbon::parse($related->publish_date)->format('F d, Y') }}
                            </p>
                            <a href="{{ route('press-releases.details', $related->slug) }}" class="btn btn-sm btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .latest-item:hover, .related-item:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>

@endsection
