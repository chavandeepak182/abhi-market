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
                <div class="sidebar-cta-box wow fadeInUp">
                    <div class="cta-box-content">
                        <h3>Need Help? We Are Here To Help You</h3>
                    </div>

                    <div class="cta-contact-info">
                        <div class="cta-info-item">
                            <form id="enquiryctForm" action="{{ route('enquiry.store') }}" method="POST" class="wow fadeInUp" data-wow-delay="0.4s">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="contact" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn-default py-2">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
<div class="our-pricing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 offset-2 text-center">
                <div class="section-title mb-0">
                    <h2 class="text-anime-style-2" data-cursor="-opaque">How can we help you achieve high-impact results?</h2>
                </div>
                <div class="mt-5 wow fadeInUp" data-wow-delay="0.2s">
                    <a href="{{ url('/contact') }}" class="btn-default">Let's Start</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CTA Section End -->
@endsection
