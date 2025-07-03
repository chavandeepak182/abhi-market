@extends('frontend.layouts.header')

@section('title', $news->meta_title ?? $news->title)
@section('description', $news->meta_description ?? '')
@section('keywords', $news->meta_keywords ?? '')

@section('content')
<!-- Hero Section Start -->
<div class="hero p-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <div class="section-title dark-section">
                        <p class="wow fadeInUp text-white">
                            <a href="{{ url('/') }}" class="text-white">Home</a> /
                            <a href="#" class="text-white">News</a>
                        </p>

                        @php $words = explode(' ', $news->title); @endphp
                        <h1 class="text-anime-style-2" data-cursor="-opaque" style="white-space: nowrap;">
                            <span>{{ $words[0] }}</span> {{ implode(' ', array_slice($words, 1)) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Overview Section Start -->
<div class="page-service-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Sidebar Contact Box -->
                
                <!-- Sidebar Contact Box End -->
            </div>

            <div class="col-lg-8">
                <div class="service-single-content">
                    <div class="service-featured-image">
                        <figure class="image-anime reveal">
                            @if(!empty($news->image) && file_exists(public_path('storage/' . $news->image)))
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                            @else
                                <img src="{{ asset('assets/images/default-service.jpg') }}" alt="Default News Image">
                            @endif
                        </figure>
                    </div>

                    <div class="service-entry">
                        <p class="wow fadeInUp">{!! $news->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Overview Section End -->

<!-- CTA Section -->
<div class="our-pricing py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <div class="section-title mb-4 px-3">
                    <h2 class="text-anime-style-2" data-cursor="-opaque">
                        How can we help you achieve high-impact results?
                    </h2>
                </div>
                <div class="mt-3 wow fadeInUp" data-wow-delay="0.2s">
                    <a href="{{ url('/contact') }}" class="btn-default">Let's Start</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section End -->
@endsection
