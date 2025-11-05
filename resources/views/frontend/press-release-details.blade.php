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
<style>
   .hero-section{
    width:100%;
}

.press-title{
    font-size:2.1rem;
    line-height:1.3;
    max-width:1100px;
    margin:auto;
}

@media(max-width: 768px){
    .press-title{
        font-size:1.45rem;
    }
}
</style>
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center justify-content-center"
         style="background:#006186; padding:50px 0;">
    <div class="container text-center">
        <h1 class="press-title fw-bold text-white m-0">
            {{ $pressRelease->title }}
        </h1>
    </div>
</section>


<!-- Press Release Content Section -->
<div class="container py-5">
    <div class="row">

        <!-- Main Content -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            <h1 class="mb-3">{{ $pressRelease->title }}</h1>

            <p class="text-white mb-4" style="background:#006186;">
                Published on {{ \Carbon\Carbon::parse($pressRelease->publish_date)->format('F d, Y') }}
                <span class="mx-2">|</span>
                Category: <strong>{{ $pressRelease->category_name ?? 'N/A' }}</strong>
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

           
        </div>
    </div>

    <!-- Related Press Releases -->
    <div class="related-blogs mt-5">
        <h4 class="mb-4">Related Press Releases</h4>
        <div class="row g-4">
            @foreach($relatedPressReleases as $related)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm overflow-hidden related-item h-100">
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
