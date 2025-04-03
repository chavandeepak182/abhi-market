@extends('frontend.layouts.header')
@section('title', "Details Page")
@section('description', "")
@section('keywords', "")

@section('content')
    <!-- Page Header Start -->
    <div class="page-header details-head" style="background-image: url('../../assets/images/details-bnr.jpg')">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="details-heading" data-cursor="-opaque">Your AI Transformation Needs a Different Leadership Approach</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Our Approach Section Start -->
    <div class="our-approach bg-white">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">JFS Market</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s">Our <span>Insights</span></h2> 
                    </div>
                    <!-- Section Title End -->

                </div>
                <div class="col-lg-6">
                    <div class="search-container float-end">
                        <input type="text" class="search-input" placeholder="Search by term, keyword or category">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Mission Vision Item Start -->
                    <div class="reports-card wow fadeInUp">
                        <!-- Mission Vision Image Start -->
                        <div class="mission-vission-image">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/our-mission-img.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Mission Vision Image End -->
                        <!-- Mission Vision Header Start -->
                        <div class="mission-vission-header">
                            <div class="mission-vission-content">
                                <p class="mb-3">Category</p>
                                <h3><a href="#">AI Integration in Education: Building a Future-Ready Curriculum</a></h3>
                                <p><small>March 31, 2025</small></p>
                            </div>
                        </div>
                        <!-- Mission Vision Header End -->
                    </div>
                    <!-- Mission Vision Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Mission Vision Item Start -->
                    <div class="reports-card wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Mission Vision Image Start -->
                        <div class="mission-vission-image">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/our-vision-img.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Mission Vision Image End -->
                        <!-- Mission Vision Header Start -->
                        <div class="mission-vission-header">
                            <div class="mission-vission-content">
                                <p class="mb-3">Category</p>
                                <h3><a href="#">Global Manufacturing Footprint Rationalization for a Leading Biopharmaceutical Company</a></h3>
                                <p><small>March 31, 2025</small></p>
                            </div>
                        </div>
                        <!-- Mission Vision Header End -->
                    </div>
                    <!-- Mission Vision Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Mission Vision Item Start -->
                    <div class="reports-card wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Mission Vision Image Start -->
                        <div class="mission-vission-image">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/our-value-img.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Mission Vision Image End -->
                        <!-- Mission Vision Header Start -->
                        <div class="mission-vission-header">
                            <div class="mission-vission-content">
                                <p class="mb-3">Category</p>
                                <h3><a href="#">The Future Role of Generative AI in SaaS Pricing</a></h3>
                                <p><small>March 31, 2025</small></p>
                            </div>
                        </div>
                        <!-- Mission Vision Header End -->
                    </div>
                    <!-- Mission Vision Item End -->
                </div>

                <div class="col-lg-12 col-md-6">
                    <!-- Section Btn Start -->
                    <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a href="#" class="btn-default">Load More</a>
                    </div>                     
                    <!-- Section Btn Start -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Approach Section End -->
@endsection