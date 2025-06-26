@extends('frontend.layouts.header')
@section('title', "Abhishek Market")
@section('description', "")
@section('keywords', "")

@section('content')

    @php
        $banners = App\Models\Banner::latest()->take(2)->get(); // Fetch latest 3 banners
    @endphp
    <!-- Hero Section Start -->
    <div class="hero hero-bg-image hero-slider-layout">
        <div class="swiper">
            @if ($banners->count())
                <div class="swiper-wrapper">
                    @foreach ($banners as $index => $banner)
                        <div class="swiper-slide">
                            <div class="hero-slide">
                                <!-- Slider Image Start -->
                                <div class="hero-slider-image">
                                    <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title ?? 'Banner Image' }}">
                                </div>
                                <!-- Slider Image End -->

                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12">
                                            <!-- Hero Content Start -->
                                            <div class="hero-content">
                                                <!-- Section Title Start -->
                                                <div class="section-title dark-section">
                                                    <h3 class="wow fadeInUp">Welcome to JFinMate</h3>
                                                    <h1 class="text-anime-style-2" data-cursor="-opaque">
                                                        {{ $banner->title ?? 'Empowering your Research success journey' }}
                                                    </h1>
                                                </div>
                                                <!-- Section Title End -->
                            
                                                <!-- Hero Content Body Start -->
                                                <div class="hero-content-body wow fadeInUp" data-wow-delay="0.4s">
                                                    <!-- Hero Button Start -->
                                                    <div class="hero-btn">
                                                        <a href="{{ url('/contact') }}" class="btn-default">Get Started</a>
                                                    </div>
                                                    <!-- Hero Button End -->
                                                </div>
                                                <!-- Hero Content Body End -->
                                            </div>
                                            <!-- Hero Content End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="hero-pagination"></div>
        </div>        
    </div>
    <!-- Hero Section End -->
     <!-- What's New Section Start -->
<div class="whats-new-section py-5">
    <div class="container text-center">
        <h3 class="section-title mb-5" style="font-weight: 600;">WHAT'S NEW</h3>

        <div class="row justify-content-center">
            @foreach($latestNews as $news)
                <div class="col-md-6 col-lg-5 mb-4">
                    <div class="news-box text-start p-3 border rounded h-100">
                        @if($news->image)
                            <div class="news-image mb-3">
                                <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid w-100" alt="{{ $news->title }}">
                            </div>
                        @endif

                        <h5 class="news-title mb-3" style="font-weight: 500;">{{ $news->title }}</h5>

                        <a href="#" class="btn btn-outline-dark px-4 py-2">View more</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- What's New Section End -->
<!-- How It Work Section Start -->
    <div class="how-it-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- How It Work Content Start -->
                    <div class="how-it-work-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <!-- <h3 class="wow fadeInUp">how it work</h3> -->
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Who <span>We Are</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We are a purpose-driven market research and consulting company passionate about turning data into direction. Founded in 2023, we bring together researchers, strategists, and data scientists who believe that intelligence isn’t just about numbers, it’s about insight that sparks progress.
</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- How It Work Button Start -->
                        <div class="how-it-work-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="contact.html" class="btn-default">learn more</a>
                        </div>
                        <!-- How It Work Button End -->
                    </div>
                    <!-- How It Work Content End -->
                </div>
                
                <div class="col-lg-6">
                    <!-- Work Steps Box Start -->
                    <div class="work-steps-box">
                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp">
                            <div class="work-step-item-content">
                                <h3>Integrity</h3>
                                <!-- <h2>Integrity</h2> -->
                                <p>We act with honesty and transparency, upholding ethical standards in all our actions to build lasting trust.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>01</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->

                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="work-step-item-content">
                                <h3>Innovation</h3>
                                <!-- <h2>Innovation</h2> -->
                                <p>We embrace emerging technologies to deliver sharper, faster, and smarter insights.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>02</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->

                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="work-step-item-content">
                                <h3>Collaboration</h3>
                                <!-- <h2>Collaboration</h2> -->
                                <p>We work hand-in-hand with clients and partners to co-create value.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>03</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->
                          <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="work-step-item-content">
                                <h3>Customer Focus</h3>
                                <!-- <h2>Customer Focus</h2> -->
                                <p>We deeply understand your needs, turning your challenges into opportunities for impactful solutions. Your success drives our purpose and priorities.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>04</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->
                          <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="work-step-item-content">
                                <h3>Quality</h3>
                                <!-- <h2>Quality</h2> -->
                                <p> We ensure every insight delivered is data-driven and decision-ready.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>05</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->
                    </div>
                    <!-- Work Steps Box End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Our Services Section Start -->
    <div class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Service Content Start -->
                    <div class="our-service-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">services</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Expert Market Research <span>& Growth Strategies</span></h2>
                        </div>
                        <!-- Section Title End -->
                        
                        <!-- Section content Button Start -->
                        <div class="service-content-btn wow fadeInUp" data-wow-delay="0.25s">
                            <a href="{{ url('/services') }}" class="btn-default">all services</a>
                        </div>
                        <!-- Section content Button End -->
                    </div>
                    <!-- Service Content End -->
                </div>

                <div class="col-lg-8">
                    <!-- Our Service List Start -->
                    <div class="our-service-list">
                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>01</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-1.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Industry & Market Analysis</h3>
                                    <p>In-depth research on market trends, opportunities, and competitive landscapes.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>02</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-2.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Consumer Insights & Behavior Analysis</h3>
                                    <p>Understanding customer preferences, buying habits, and pain points.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>03</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-3.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Competitive Intelligence</h3>
                                    <p>Benchmarking competitors, identifying strengths, and spotting market gaps.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>04</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-4.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Brand Perception & Positioning</h3>
                                    <p>Measuring brand awareness, reputation, and market positioning.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>05</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-5.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Product & Service Feasibility Studies</h3>
                                    <p>Assessing market demand and potential for new offerings.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->

                        <!-- Service Item Start -->
                        <div class="service-item">
                            <div class="service-no">
                                <h2>06</h2>
                            </div>
                            <div class="service-content-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-service-6.svg" alt="">
                                </div>
    
                                <div class="service-item-content">
                                    <h3>Segmentation & Targeting Analysis</h3>
                                    <p>Identifying key customer segments for focused marketing strategies.</p>
                                    <a href="#" class="service-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!-- Service Item End -->
                    </div>
                    <!-- Our Service List End -->

                    <!-- Service Footer Start -->
                    <div class="service-footer wow fadeInUp" data-wow-delay="0.8s">
                        <p>Let's make something great work together. <a href="{{ url('/contact') }}">Discuss Now</a></p>
                    </div>
                    <!-- Service Footer End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Services Section End -->

    <!-- Why Choose Us Section Start -->
    <div class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Why Choose Content Start -->
                    <div class="why-choose-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">why choose us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Why Trust Us <span>for Market Insights?</span></h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Why Choose Box List Start -->
                        <div class="why-choose-box-list">
                            <!-- Why Choose Box Start -->
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-1.svg" alt="">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>Market Strategies</h3>
                                    <p>Customized Insights for Your Business Growth and Success.</p>
                                </div>
                            </div>
                            <!-- Why Choose Box End -->

                            <!-- Why Choose Box Start -->
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-2.svg" alt="">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>Market Analysis & Strategy</h3>
                                    <p>Tailored Market Insights & Strategies for Sustainable Business Growth</p>
                                </div>
                            </div>
                            <!-- Why Choose Box End -->
                        </div>
                        <!-- Why Choose Box List End -->

                        <!-- Why Choose List Start -->
                        <div class="why-choose-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Data-Driven Market Insights</li>
                                <li>Customized Growth Strategies</li>
                            </ul>
                        </div>
                        <!-- Why Choose List End -->
                    </div>
                    <!-- Why Choose Content End -->
                </div>

                <div class="col-lg-6">
                    <!-- Why Choose Image Start -->
                    <div class="why-choose-image">
                        <!-- Why Choose Image 1 Start -->
                        <div class="why-choose-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/why-choose-img-1.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Why Choose Image 1 End -->

                        <!-- Why Choose Image 2 Start -->
                        <div class="why-choose-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/why-choose-img-2.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Why Choose Image 2 End -->

                        <!-- Why Choose Contact Circle Start -->
                        <div class="why-choose-contact-circle">
                            <img src="{{ asset('assets') }}/images/contact-us-img.svg" alt="">
                        </div>
                        <!-- Why Choose Contact Circle Start -->
                    </div>
                    <!-- Why Choose Image End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Why Choose Us Section End -->

    <!-- Our Feature Section Stat -->
    <div class="our-feature">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title dark-section">
                        <h3 class="wow fadeInUp">our feature</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Key Features of Our Market Research <span>and Consulting</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-6">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/contact') }}" class="btn-default">contact now</a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Our Feature List Start -->
                    <div class="our-feature-list">
                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-1.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Data-Driven Insights</h3>
                                <p>Leverage accurate market data to make informed business decisions and drive growth.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-2.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Competitor Analysis</h3>
                                <p>Identify market gaps, strengths, and opportunities by analyzing competitors’ strategies and positioning.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-3.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Consumer Behavior Research</h3>
                                <p>Understand customer preferences, trends, and buying patterns to enhance targeting and engagement.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-4.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Market Trend Forecasting</h3>
                                <p>Predict future industry shifts and emerging opportunities for proactive business strategies.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-5.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Customized Growth Strategies</h3>
                                <p>Develop tailored research-backed plans aligned with your business goals and market landscape.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="our-feature-item wow fadeInUp" data-wow-delay="1s">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-feature-6.svg" alt="">
                            </div>
                            <div class="feature-item-content">
                                <h3>Brand Perception Analysis</h3>
                                <p>Evaluate market sentiment and brand positioning to enhance reputation and competitive advantage.</p>
                            </div>
                        </div>
                        <!-- Feature Item End -->
                    </div>
                    <!-- Our Feature List End -->
                </div>

                <div class="col-lg-12">
                    <!-- Our Featured Footer Start -->
                    <!-- <div class="our-feature-footer wow fadeInUp" data-wow-delay="1.2s">
                        <p><span>Free</span> Let's make something great work together. <a href="contact.html">Get Free Quote</a></p>
                    </div> -->
                    <!-- Our Featured Footer End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Feature Section End -->

    <!-- Some Fact Section Start -->
    <div class="fact-counter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Fact Counter Image Start -->
                    <div class="fact-counter-image">
                        <!-- Fact Counter img Start -->
                        <div class="fact-counter-img">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/fact-counter-img.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Fact Counter img End -->

                        <!-- Fact Counter Skillbar Start -->
                        <!-- <div class="fact-counter-skillbar">
                            <img src="{{ asset('assets') }}/images/fact-counter-skillbar-img.png" alt="">
                        </div> -->
                        <!-- Fact Counter Skillbar End -->
                    </div>
                    <!-- Fact Counter Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- Fact Counter Content Start -->
                    <div class="fact-counter-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">some facts</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Core Expertise & <span>Key Insights</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our expertise is built on years of industry experience, proven financial strategies and a commitment to client success.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Fact Counter Box List Start -->
                        <div class="fact-counter-box-list">
                            <!-- Fact Counter Box Start -->
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-1.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">25</span>+</h2>
                                    <p>Years of experience</p>
                                </div>
                            </div>
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-2.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">80</span>%+</h2>
                                    <p>Client success rate</p>
                                </div>
                            </div>
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-3.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">20</span>+</h2>
                                    <p>global research</p>
                                </div>
                            </div>
                            <!-- Fact Counter Box End -->
                        </div>
                        <!-- Fact Counter Box List End -->

                        <!-- Fact Counter List Start -->
                        <div class="fact-counter-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Competitive Landscape Analysis</li>
                                <li>Targeted Business Intelligence</li>
                            </ul>
                        </div>
                        <!-- Fact Counter List End -->
                    </div>
                    <!-- Fact Counter Content End -->
                </div>
            </div>
        </div>
     </div>
    <!-- Some Fact Section End -->

    <!-- What We Do Section Start -->
    <div class="what-we-do">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- What We Do Content Start -->
                    <div class="what-we-do-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">what we do</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Driving Market Growth & <span>Competitive Success</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We provide expert market research and consulting solutions designed to unlock opportunities, enhance decision-making, and drive sustainable business growth.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- What We Do List Start -->
                        <div class="what-we-do-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Strategic Market Analysis</li>
                                <li>Consumer Insights & Behavior</li>
                                <li>Competitive Intelligence</li>
                                <li>Risk Assessment & Strategies</li>
                            </ul>
                        </div>
                        <!-- What We Do List End -->

                        <!-- What We Do Button Start -->
                        <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="{{ url('/contact') }}" class="btn-default">contact now</a>
                        </div>
                        <!-- What We Do Button End -->
                    </div>
                    <!-- What We Do Content End -->
                </div>
                
                <div class="col-lg-6">
                    <!-- What We Do Images Start -->
                    <div class="what-we-do-images">
                        <!-- What We Do Image 1 Start -->
                        <div class="what-do-we-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/what-we-do-img-1.jpg" alt="">
                            </figure>
                        </div>
                        <!-- What We Do Image 1 End -->

                        <!-- What We Do Image 2 Start -->
                        <div class="what-do-we-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/what-we-do-img-2.jpg" alt="">
                            </figure>
                        </div>
                        <!-- What We Do Image 2 End -->
                    </div>
                    <!-- What We Do Images End -->
                </div>
            </div>
        </div>
    </div>
    <!-- What We Do Section End -->

    <!-- How It Work Section Start -->
    <div class="how-it-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!-- How It Work Content Start -->
                    <div class="how-it-work-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">how it work</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Our Process for <span>Success</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our process is designed to guide you every step of the way. From initial consultation to personalized strategy development.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- How It Work Button Start -->
                        <div class="how-it-work-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="{{ url('/about') }}" class="btn-default">learn more</a>
                        </div>
                        <!-- How It Work Button End -->
                    </div>
                    <!-- How It Work Content End -->
                </div>
                
                <div class="col-lg-6">
                    <!-- Work Steps Box Start -->
                    <div class="work-steps-box">
                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp">
                            <div class="work-step-item-content">
                                <h3>step</h3>
                                <h2>initial consultation</h2>
                                <p>We begin with a one-on-one consultation to understand your financial goals, challenges, and priorities.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>01</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->

                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="work-step-item-content">
                                <h3>step</h3>
                                <h2>success pathway</h2>
                                <p>We begin with a one-on-one consultation to understand your financial goals, challenges, and priorities.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>02</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->

                        <!-- Work Steps Item Start -->
                        <div class="work-step-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="work-step-item-content">
                                <h3>step</h3>
                                <h2>growth strategy</h2>
                                <p>We begin with a one-on-one consultation to understand your financial goals, challenges, and priorities.</p>
                            </div>
                            <div class="work-step-item-no">
                                <h2>03</h2>
                            </div>
                        </div>
                        <!-- Work Steps Item End -->
                    </div>
                    <!-- Work Steps Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- How It Work Section End -->

    <!-- Our Pricing Section Start -->
    <div class="our-pricing">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-5">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">pricing plan</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">We've Flexible Plan</h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-7">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/contact') }}" class="btn-default">contact now</a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Pricing Box Start -->
                    <div class="pricing-box wow fadeInUp">
                        <!-- Pricing Header Start -->
                        <div class="pricing-header">
                            <h3>personal plan</h3>
                            <h2><sup>$</sup>29.00<sub>/per month</sub></h2>
                        </div>
                        <!-- Pricing Header End -->

                        <!-- Pricing Box Body Start -->
                        <div class="pricing-body">
                            <!-- Pricing List Title Start -->
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                            <!-- Pricing List Title End -->

                            <!-- Pricing List Start -->
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                            <!-- Pricing List End -->
                        </div>
                        <!-- Pricing Box Body End -->

                        <!-- Pricing Button Start -->
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                        <!-- Pricing Button End -->
                    </div>
                    <!-- Pricing Box End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Pricing Box Start -->
                    <div class="pricing-box highlighted-box wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Pricing Header Start -->
                        <div class="pricing-header">
                            <h3>business plan</h3>

                            <h2><sup>$</sup>39.00<sub>/per month</sub></h2>
                        </div>
                        <!-- Pricing Header End -->

                        <!-- Pricing Box Body Start -->
                        <div class="pricing-body">
                            <!-- Pricing List Title Start -->
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                            <!-- Pricing List Title End -->

                            <!-- Pricing List Start -->
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                            <!-- Pricing List End -->
                        </div>
                        <!-- Pricing Box Body End -->

                        <!-- Pricing Button Start -->
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                        <!-- Pricing Button End -->
                    </div>
                    <!-- Pricing Box End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Pricing Box Start -->
                    <div class="pricing-box wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Pricing Header Start -->
                        <div class="pricing-header">
                            <h3>advance plan</h3>

                            <h2><sup>$</sup>49.00<sub>/per month</sub></h2>
                        </div>
                        <!-- Pricing Header End -->

                        <!-- Pricing Box Body Start -->
                        <div class="pricing-body">
                            <!-- Pricing List Title Start -->
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                            <!-- Pricing List Title End -->

                            <!-- Pricing List Start -->
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                            <!-- Pricing List End -->
                        </div>
                        <!-- Pricing Box Body End -->

                        <!-- Pricing Button Start -->
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                        <!-- Pricing Button End -->
                    </div>
                    <!-- Pricing Box End -->
                </div>

                <div class="col-lg-12">
                    <!-- Pricing Benifit List Start -->
                    <div class="pricing-benefit-list wow fadeInUp" data-wow-delay="0.6s">
                        <ul>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-1.svg" alt="">Get 30 day free trial</li>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-2.svg" alt="">No any hidden fees pay</li>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-3.svg" alt="">You can cancel anytime </li>
                        </ul>
                    </div>
                    <!-- Pricing Benifit List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Pricing Section End -->

    <!-- Our FAQs Section Start-->
    <div class="our-faqs">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">faqs</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Your Most Frequently Asked <span>Questions Answered</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-6">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="faqs.html" class="btn-default">view all FAQs</a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Our FAQs Image Start -->
                    <div class="our-faqs-image">
                        <!-- Our FAQs Img Start -->
                        <div class="our-faqs-img">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/faqs-img.jpg" alt="">
                            </figure>
                        </div>
                        <!-- Our FAQs Img End -->

                        <!-- Client Review Box Start -->
                        <div class="client-review-box">
                            <!-- Client Review Box Content Start -->
                            <div class="client-review-box-content">
                                <p>100+ Client <span><i class="fa-solid fa-star"></i> 5.0 (250 Reviews)</span></p>
                            </div>
                            <!-- Client Review Box Content End -->

                            <!-- Client Review Images Start -->
                            <div class="client-review-images">
                                <!-- Client Image Start -->
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-1.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- Client Image End -->

                                <!-- Client Image Start -->
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-2.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- Client Image End -->

                                <!-- Client Image Start -->
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-3.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- Client Image End -->

                                <!-- Client Image Start -->
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-4.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- Client Image End -->

                                <!-- Client Image Start -->
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-5.jpg" alt="">
                                    </figure>
                                </div>
                                <!-- Client Image End -->

                                <!-- Add More Client Image Start -->
                                <div class="client-image add-more">
                                    <p><span class="counter">30</span>+</p>
                                </div>
                                <!-- Add More Client Image End -->
                            </div>
                            <!-- Client Review Images End -->
                        </div>
                        <!-- Client Review Box End -->
                    </div>
                    <!-- Our FAQs Image End -->
                </div>
                
                <div class="col-lg-6">
                    <!-- Our FAQ Section Start -->
                    <div class="our-faq-section">
                        <!-- FAQ Accordion Start -->
                        <div class="faq-accordion" id="faqaccordion">
                            <!-- Accordion Item Start -->
                            <div class="accordion-item wow fadeInUp">
                                <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        What services do you offer?
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item End -->

                            <!-- Accordion Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        How do I know if I need a financial consultant?
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="heading2" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item End -->

                            <!-- Accordion Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                                <h2 class="accordion-header" id="heading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                        What can I expect from an initial consultation?
                                    </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item End -->    

                            <!-- Accordion Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                                <h2 class="accordion-header" id="heading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        Are my consultations confidential?
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item End --> 
                             
                            <!-- Accordion Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                                <h2 class="accordion-header" id="heading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                        What kind of clients do you work with?
                                    </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>If you're uncertain about managing investments, planning for retirement, or structuring your finances, consulting a financial professional can help. Our team assists in clarifying your goals, optimizing your strategies.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion Item End --> 
                        </div>
                        <!-- FAQ Accordion End -->
                    </div>
                    <!-- Our FAQ Section End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our FAQs Section End-->

    <!-- Our Testimonial Section Start -->
    <div class="our-testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <!-- Testimonial Content Start -->
                    <div class="testimonial-content">
                        <!-- Section Title Start -->
                        <div class="section-title dark-section">
                            <h3 class="wow fadeInUp">our testimonial</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">What Customer Says <span>About JFinMate</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">With over 1,250 satisfied clients, our finance and consulting services have earned praise for reliability, personalized guidance, and impactful results.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Testimonial Button Start -->
                        <div class="testimonial-btn">
                            <a href="contact.html" class="btn-default">contact now</a>
                        </div>
                        <!-- Testimonial Button End -->
                    </div>
                    <!-- Testimonial Content End -->
                </div>

                <div class="col-lg-7">
                    <!-- Testimonial Slider Box Start -->
                    <div class="testimonial-slider-box">
                        <!-- Testimonial Slider Start -->
                        <div class="testimonial-slider">
                            <div class="swiper">
                                <div class="swiper-wrapper" data-cursor-text="Drag">
                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <!-- Testimonial Item Start -->
                                        <div class="testimonial-item">
                                            <!-- Testimonial Header Start -->
                                            <div class="testimonial-header">
                                                <!-- Customer Logo Start -->
                                                <div class="customer-logo">
                                                    <img src="{{ asset('assets') }}/images/customer-logo.svg" alt="">
                                                </div>
                                                <!-- Customer Logo End -->

                                                <!-- Testimonial Quotes Start -->
                                                <div class="testimonial-quotes">
                                                    <img src="{{ asset('assets') }}/images/testimonial-quotes.svg" alt="">
                                                </div>
                                                <!-- Testimonial Quotes End -->
                                            </div>
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"The guidance we received has transformed our financial outlook. Our consultant was patient, knowledgeable, and crafted a plan that aligned perfectly with our goals. Thanks to their strategic advice, optimistic about our future!"</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-1.jpg" alt="">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>sarah t. / <span>entrepreneur</span></h3>
                                                </div>
                                                <!-- Author Content End -->
                                            </div>
                                            <!-- Testimonial Author End -->
                                        </div>
                                        <!-- Testimonial Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <!-- Testimonial Item Start -->
                                        <div class="testimonial-item">
                                            <!-- Testimonial Header Start -->
                                            <div class="testimonial-header">
                                                <!-- Customer Logo Start -->
                                                <div class="customer-logo">
                                                    <img src="{{ asset('assets') }}/images/customer-logo.svg" alt="">
                                                </div>
                                                <!-- Customer Logo End -->

                                                <!-- Testimonial Quotes Start -->
                                                <div class="testimonial-quotes">
                                                    <img src="{{ asset('assets') }}/images/testimonial-quotes.svg" alt="">
                                                </div>
                                                <!-- Testimonial Quotes End -->
                                            </div>
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"The guidance we received has transformed our financial outlook. Our consultant was patient, knowledgeable, and crafted a plan that aligned perfectly with our goals. Thanks to their strategic advice, optimistic about our future!"</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-2.jpg" alt="">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>ellyse p. / <span>finance manager</span></h3>
                                                </div>
                                                <!-- Author Content End -->
                                            </div>
                                            <!-- Testimonial Author End -->
                                        </div>
                                        <!-- Testimonial Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->

                                    <!-- Testimonial Slide Start -->
                                    <div class="swiper-slide">
                                        <!-- Testimonial Item Start -->
                                        <div class="testimonial-item">
                                            <!-- Testimonial Header Start -->
                                            <div class="testimonial-header">
                                                <!-- Customer Logo Start -->
                                                <div class="customer-logo">
                                                    <img src="{{ asset('assets') }}/images/customer-logo.svg" alt="">
                                                </div>
                                                <!-- Customer Logo End -->

                                                <!-- Testimonial Quotes Start -->
                                                <div class="testimonial-quotes">
                                                    <img src="{{ asset('assets') }}/images/testimonial-quotes.svg" alt="">
                                                </div>
                                                <!-- Testimonial Quotes End -->
                                            </div>
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"The guidance we received has transformed our financial outlook. Our consultant was patient, knowledgeable, and crafted a plan that aligned perfectly with our goals. Thanks to their strategic advice, optimistic about our future!"</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-3.jpg" alt="">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>robert t. / <span>accounts manager</span></h3>
                                                </div>
                                                <!-- Author Content End -->
                                            </div>
                                            <!-- Testimonial Author End -->
                                        </div>
                                        <!-- Testimonial Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                </div>
                                <div class="testimonial-pagination"></div>
                            </div>
                        </div>
                        <!-- Testimonial Slider End -->

                        <!-- Customer Rating Boxes Start -->
                        <div class="customer-rating-boxes">
                            <!-- Customer Rating Box Start -->
                            <div class="customer-rating-box">
                                <!-- Customer Rating Image Start -->
                                <div class="customer-rating-image">
                                    <img src="{{ asset('assets') }}/images/icon-google.svg" alt="">
                                </div>
                                <!-- Customer Rating Image End -->

                                <!-- Customer Rating Content Start -->
                                <div class="customer-rating-content">
                                    <p>google rating</p>
                                    <div class="customer-rating-counter">
                                        <h3><span class="counter">5.0</span></h3>
                                        <div class="customer-rating-star">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Customer Rating Content End -->
                            </div>
                            <!-- Customer Rating Box End -->

                            <!-- Customer Rating Box Start -->
                            <div class="customer-rating-box">
                                <!-- Customer Rating Counter Start -->
                                <div class="customer-rating-counter">
                                    <p><span class="counter">5.0</span> rated</p>
                                </div>
                                <!-- Customer Rating Counter End -->

                                <!-- Customer Rating Counter Start -->
                                <div class="customer-rating-star-box">
                                    <div class="customer-rating-star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>

                                    <div class="star-rating-img">
                                        <img src="{{ asset('assets') }}/images/customer-rating-img.svg" alt="">
                                    </div>
                                </div>
                                <!-- Customer Rating Counter End -->
                            </div>
                            <!-- Customer Rating Box End -->

                            <!-- Customer Rating Content Start -->
                            <div class="customer-rating-box customer-rating-content">
                                <P>Total rating <span class="counter">5.0</span> base on 1250+ review</P>
                            </div>
                            <!-- Customer Rating Content End -->
                        </div>
                        <!-- Customer Rating Boxes End -->
                    </div>
                    <!-- Testimonial Slider Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonial Section End -->

    <!-- Our Blog Section Start -->
    <div class="our-blog">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">blog / post</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Market Insights, Updates <span>& Latest Trends</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-6">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="blog.html" class="btn-default">view all post</a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="blog-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/post-1.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Tag Start -->
                            <div class="post-item-meta">
                                <ul>
                                    <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                                </ul>
                            </div>
                            <!-- Post Item Tag End -->

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="blog-single.html">10 Essential Steps to Create Foolproof Financial Plan for Long-Term Stability</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="blog-single.html" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>

                <div class="col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="blog-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/post-2.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Tag Start -->
                            <div class="post-item-meta">
                                <ul>
                                    <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                                </ul>
                            </div>
                            <!-- Post Item Tag End -->

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="blog-single.html">Top 10 Financial Mistakes Individuals and Businesses Should Avoid in 2024</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="blog-single.html" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>

                <div class="col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" data-wow-delay="0.4s">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="blog-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/post-3.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Tag Start -->
                            <div class="post-item-meta">
                                <ul>
                                    <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                                </ul>
                            </div>
                            <!-- Post Item Tag End -->

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="blog-single.html">Mastering Budgeting Practical Steps to Ensure Your Financial Success</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="blog-single.html" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>

                <div class="col-md-6">
                    <!-- Post Item Start -->
                    <div class="post-item wow fadeInUp" data-wow-delay="0.6s">
                        <!-- Post Featured Image Start-->
                        <div class="post-featured-image">
                            <a href="blog-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets') }}/images/post-4.jpg" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Post Featured Image End -->

                        <!-- Post Item Body Start -->
                        <div class="post-item-body">
                            <!-- Post Item Tag Start -->
                            <div class="post-item-meta">
                                <ul>
                                    <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                                </ul>
                            </div>
                            <!-- Post Item Tag End -->

                            <!-- Post Item Content Start -->
                            <div class="post-item-content">
                                <h2><a href="blog-single.html">Understanding Cash Flow Key to Healthy Busines and Financial Stability</a></h2>
                            </div>
                            <!-- Post Item Content End -->

                            <!-- Post Item Readmore Button Start-->
                            <div class="post-item-btn">
                                <a href="blog-single.html" class="readmore-btn">read more</a>
                            </div>
                            <!-- Post Item Readmore Button End-->
                        </div>
                        <!-- Post Item Body End -->
                    </div>
                    <!-- Post Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Blog Section End  -->
@endsection