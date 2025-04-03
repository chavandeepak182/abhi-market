@extends('frontend.layouts.header')
@section('title', "Overview Page")
@section('description', "")
@section('keywords', "")

@section('content')
<!-- Hero Section Start -->
    <div class="hero p-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <!-- Hero Content Start -->
                    <div class="hero-content">
                        <!-- Section Title Start -->
                        <div class="section-title dark-section">
                            <p class="wow fadeInUp text-white"><a href="{{ url('/') }}" class="text-white">Home</a> / <a href="#" class="text-white">Category</a> / Service Type</p>
                            <h1 class="text-anime-style-2" data-cursor="-opaque"><span>Industrial</span> & Professional Services</h1>
                        </div>
                        <!-- Section Title End -->
                    </div>
                    <!-- Hero Content End -->
                </div>

                <div class="col-lg-5">
                    <!-- Hero Image Start -->
                    <div class="hero-image">
                        <!-- Hero Img Start -->
                        <div class="hero-img">
                            <figure>
                                <img src="{{ asset('assets') }}/images/hero-img.png" alt="">
                            </figure>
                        </div>
                        <!-- Hero Img End -->                      
                    </div>
                    <!-- Hero Image End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Overview Section Start -->
    <div class="col-lg-8 offset-2 mt-5">
        <!-- Case Study Single Content Start -->
        <div class="service-single-content">
            <!-- Case Study Entry Start -->
            <div class="service-entry">
                <h2 class="text-anime-style-2">Overview</h2>
                <p class="wow fadeInUp">Investment Management involves strategically handling financial assets to achieve specific goals and maximize returns. It includes creating diversified portfolios, assessing market trends, and making informed decisions to grow wealth while managing risks. With expert guidance, management ensures alignment with your financial objectives, whether for individual growth, retirement planning, or institutional success. </p>

                <!-- Case Study List Video Start -->
                <div class="service-list-video">
                    <!-- Case Study List Start -->
                    <div class="service-entry-list wow fadeInUp" data-wow-delay="0.2s">
                        <ul>
                            <li>dynamic adjustments to adapt market changes</li>
                            <li>retirement and estate planning services</li>
                            <li>goal-oriented investment track with mileston</li>
                            <li>investment plan a align with your financial goals</li>
                            <li>allocation for balanced growth and stability</li>
                        </ul>
                    </div>
                    <!-- Case Study List End -->
                </div>
                <!-- Case Study List Video End -->

                <!-- Service Guidance Box Satrt -->
                <div class="service-guidance">
                    <h2 class="text-anime-style-2">Expert guidance invest management</h2>

                    <p class="wow fadeInUp">Expert Guidance in Investment Management ensures your are met with tailored strategies and professional insights. Our team of seasoned advisors analyzes your unique needs, market conditions, and risk tolerance to create a customized investment plan.</p>

                    <!-- Service Guidance Box Start -->
                    <div class="service-guidance-box">
                        <!-- Service Guidance Item Start -->
                        <div class="service-guidance-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="service-guidance-content">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-6.svg" alt="">
                                </div>
                                <div class="service-guidance-title">
                                    <h3>market analysis</h3>
                                </div>
                            </div>
                            <div class="service-guidance-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/service-guidance-img-1.jpg" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Service Guidance Item End -->

                        <!-- Service Guidance Item Start -->
                        <div class="service-guidance-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="service-guidance-content">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-3.svg" alt="">
                                </div>
                                <div class="service-guidance-title">
                                    <h3>Ethical investing</h3>
                                </div>
                            </div>
                            <div class="service-guidance-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/service-guidance-img-2.jpg" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Service Guidance Item End -->

                        <!-- Service Guidance Item Start -->
                        <div class="service-guidance-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="service-guidance-content">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-2.svg" alt="">
                                </div>
                                <div class="service-guidance-title">
                                    <h3>Wealth planning</h3>
                                </div>
                            </div>
                            <div class="service-guidance-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/service-guidance-img-3.jpg" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Service Guidance Item End -->
                    </div>
                    <!-- Service Guidance Box End -->
                </div>
                <!-- Service Guidance Box End -->

                <!-- Service Steps Start -->
                <div class="services-steps">
                    <h2 class="text-anime-style-2">Our step - by-step management</h2>

                    <p class="wow fadeInUp">Our step-by-step management process ensures a structured approach to your financial goals We begin by assessing your unique financial situation, including risk tolerance and investment objectives. Next, we strategize and create a personalized investment.</p>

                    <!-- Service Step Box Start -->
                    <div class="service-steps-box">
                        <!-- Service Step Item List Start -->
                        <div class="service-step-item-list">
                            <!-- Service Step Item Start -->
                            <div class="service-step-item wow fadeInUp">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-4.svg" alt="">
                                </div>
                                <div class="service-step-item-content">
                                    <h3>retirement planning</h3>
                                    <p>Financial goals are specific targets you set to achieve financial success.</p>
                                </div>
                            </div>
                            <!-- Service Step Item End -->

                            <!-- Service Step Item Start -->
                            <div class="service-step-item wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-5.svg" alt="">
                                </div>
                                <div class="service-step-item-content">
                                    <h3>Tailored strategy</h3>
                                    <p>Financial goals are specific targets you set to achieve financial success.</p>
                                </div>
                            </div>
                            <!-- Service Step Item End -->

                            <!-- Service Step Item Start -->
                            <div class="service-step-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-6.svg" alt="">
                                </div>
                                <div class="service-step-item-content">
                                    <h3>Report progress</h3>
                                    <p>Financial goals are specific targets you set to achieve financial success.</p>
                                </div>
                            </div>
                            <!-- Service Step Item End -->
                        </div>
                        <!-- Service Step Item List End -->

                        <!-- Service Entry List Start -->
                        <div class="service-entry-list wow fadeInUp" data-wow-delay="0.6s">
                            <ul>
                                <li>implement investment</li>
                                <li>financial planing</li>
                                <li>investment management</li>
                            </ul>
                        </div>
                        <!-- Service Entry List End -->
                    </div>
                    <!-- Service Step Box End -->
                </div>
                <!-- Service Steps End -->

                <!-- Service Feature Start -->
                <div class="service-feature">
                    <h2 class="text-anime-style-2">investment management feature</h2>

                    <p class="wow fadeInUp">"Investment management features include personalized portfolio strategies, risk assessment, continuous monitoring, and performance optimization.</p>

                    <!-- Service Entry List Start -->
                    <div class="service-entry-list wow fadeInUp" data-wow-delay="0.2s">
                        <ul>
                            <li>tax-efficient strategies</li>
                            <li>diversified investmen</li>
                            <li>sustainable investment</li>
                            <li>long-term wealth creation</li>
                            <li>active portfolio monitoring</li>
                            <li>risk assessment</li>
                        </ul>
                    </div>
                    <!-- Service Entry List End -->
                </div>
                <!-- Service Feature End -->
            </div>
            <!-- Case Study Entry End -->
        </div>
        <!-- Case Study Single Content End -->
    </div>
    <!-- Overview Section end -->

    <!-- Our Approach Section Start -->
    <div class="our-approach bg-white">
        <div class="container">
            <div class="row">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay="0.2s">Related <span>Insights</span></h2> 
                </div>
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
            </div>
        </div>
    </div>
    <!-- Our Approach Section End -->

    <!-- CTA-->
    <div class="our-pricing">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 offset-2 text-center">
                    <!-- Section Title Start -->
                    <div class="section-title mb-0">
                        <h2 class="text-anime-style-2" data-cursor="-opaque">How can we help you achieve high-impact results?</span></h2>
                    </div>
                    <!-- Section Title End -->
                     <!-- Section Button Start -->
                    <div class="mt-5 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/contact') }}" class="btn-default">Let's Start</a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>
        </div>
    </div>
    <!-- CTA -->
@endsection