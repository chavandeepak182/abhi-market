@extends('frontend.layouts.header')
@section('title', $industries->meta_title)
@section('description', $industries->meta_description)
@section('keywords', $industries->meta_keywords)

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
                        <p class="wow fadeInUp text-white"><a href="{{ url('/') }}" class="text-white">Home</a> / <a href="#" class="text-white">{{ $industries->industries_name }}</a> / Service Type</p>
                        @php
                            $words = explode(' ', $industries->industries_name);
                        @endphp
                        <h1 class="text-anime-style-2" data-cursor="-opaque"><span>{{ $words[0] }}</span> {{ implode(' ', array_slice($words, 1)) }}</h1>
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
<div class="page-service-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Service Sidebar Start -->
                <div class="service-sidebar">
                    <!-- Service Category List Start -->
                    <div class="service-catagery-list wow fadeInUp">
                        <h3>Our Industries</h3>
                        <ul id="ndustry-list" class="mb-3">
                            {{-- Insights will be loaded here via AJAX --}}
                        </ul>
                        <button id="loadMore" class="btn btn-primary">Load More</button>
                    </div>
                    <!-- Service Category List End -->

                    <!-- Sidebar Cta Box Start -->
                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.25s">
                        <!-- CTA Contact Content Start -->
                        <div class="cta-box-content">
                            <h3>Need Help? We Are Here To Help You</h3>
                        </div>
                        <!-- CTA Contact Content End -->

                        <!-- CTA Contact Info Start -->
                        <div class="cta-contact-info">
                            <!-- CTA Info Item Start -->
                            <div class="cta-info-item">
                                <form id="enquiryctForm" action="{{ route('enquiry.store') }}" method="POST" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required data-error="Please Enter Your Name">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group col-md-12 mb-4">
                                            <input type="text" name="contact" id="contact" class="form-control" placeholder="Phone Number" required>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group col-md-12 mb-4">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" required>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn-default py-2">send</button>
                                            <div id="msgSubmit" class="h3 hidden"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- CTA Info Item End -->
                        </div>
                        <!-- CTA Contact Info End -->
                    </div>
                    <!-- Sidebar Cta Box End -->
                </div>
                <!-- Service Sidebar End -->
            </div>

            <div class="col-lg-8">
                <!-- Case Study Single Content Start -->
                <div class="service-single-content">
                    <!-- Case Study Image Start -->
                    <div class="service-featured-image">
                        <figure class="image-anime reveal">
                            @if(!empty($industries->image) && file_exists(public_path($industries->image)))
                                <img src="{{ asset($industries->image) }}" alt="{{ $industries->industries_name }}">
                            @else
                                <img src="{{ asset('assets/images/default-service.jpg') }}" alt="Default Image">
                            @endif
                        </figure>
                    </div>
                    <!-- Case Study Image End -->
                    <div class="service-entry">
                        <p class="wow fadeInUp">{!! $industries->description !!}</p>

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

                            <!-- Case Study Image Video Start -->
                            <div class="service-image-video">
                                <!-- Video Image Start -->
                                <div class="video-image">
                                    <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">
                                        <figure class="image-anime">
                                            <img src="{{ asset('assets') }}/images/service-video-bg.jpg" alt="">
                                        </figure>
                                    </a>
                                </div>
                                <!-- Video Image End -->

                                <!-- Video Play Button Start -->
                                <div class="video-play-button">
                                    <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                </div>
                                <!-- Video Play Button End -->
                            </div>
                            <!-- Case Study Image Video End -->
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

                    <!-- Our FAQs section start -->
                    <div class="our-faq-section">
                        <div class="section-title">
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Frequently asked questions</h2>
                        </div>
                        <!-- FAQ Accordion Start -->
                        <div class="faq-accordion" id="accordion">
                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp">
                                <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        What services do you offer?
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->
            
                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        How do I know if I need a financial consultant?
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <p>If yo're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->
            
                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                                <h2 class="accordion-header" id="heading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                        What can I expect from an initial consultation?
                                    </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->
            
                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                                <h2 class="accordion-header" id="heading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        Are my consultations confidential?
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->

                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                                <h2 class="accordion-header" id="heading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                        What kind of clients do you work with?
                                    </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->
                        </div>
                        <!-- FAQ Accordion End -->
                    </div>
                    <!-- Our FAQs section End -->
                </div>
                <!-- Case Study Single Content End -->
            </div>
        </div>
    </div>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let limit = 5;

        function loadIndustries() {
            fetch(`/get-industries?limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    const industryList = document.getElementById('industry-list');
                    industryList.innerHTML = '';

                    data.forEach(industry => {
                        const industryUrl = `/industries/${industry.slug}`;
                        industryList.innerHTML += `<li><a href="${industryUrl}">${industry.industries_name}</a></li>`;
                    });

                    if (data.length < limit) {
                        document.getElementById('loadMore').style.display = 'none';
                    } else {
                        document.getElementById('loadMore').style.display = 'inline-block';
                    }
                });
        }

        loadIndustries(); // Call correct function

        document.getElementById('loadMore').addEventListener('click', function () {
            limit += 5;
            loadIndustries(); // Call correct function
        });
    });
</script>
@endsection