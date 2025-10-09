@extends('frontend.layouts.header')
@section('title', "M2 Square Consultancy")
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <!-- बाकी CSS -->
</head>

@section('description', "M2 Square Consultancy is a leading market research growth advisory firm offering syndicated research and insights among top market research companies")
@section('keywords', "market research companies, market research agency, marketing research companies, b2b market research companies, market research survey, market research for small business, market research services, market research for startups")

@section('content')

    @php
        $banners = App\Models\Banner::latest()->take(2)->get(); // Fetch latest 3 banners
    @endphp
    <!-- Hero Section Start -->
        <div class="jfin-hero-wrapper">
            <div class="swiper jfin-swiper">
                @if ($banners->count())
                    <div class="swiper-wrapper">
                        @foreach ($banners as $banner)
                            <div class="swiper-slide">
                                <div class="hero-slider-image">
                                    <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
                                </div>
                                <div class="jfin-hero-content">
                                    <!-- <h1>{{ $banner->title}}</h1> -->
                                    <!-- <a href="{{ url('/contact') }}" class="jfin-hero-btn">Get Started</a> -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="swiper-pagination jfin-hero-pagination"></div>
            </div>
        </div>
    <!-- Hero Section End -->
          
   <!-- What's New Section Start -->
        <div class="how-it-work">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Section Title Start -->
                        <div class="how-it-work-content">
                            <div class="section-title text-center mb-5">
                                <h1 class="text-anime-style-2" data-cursor="-opaque">Latest <span>News</span></h1>
                                <p class="wow fadeInUp" data-wow-delay="0.2s">
                                    We are a purpose-driven market research and consulting company passionate about turning data into direction.
                                    Founded in 2023, we bring together researchers, strategists, and data scientists who believe that intelligence isn’t just about numbers—it's about insight that sparks progress.
                                </p>
                            </div>

                            <div class="container py-5">
                                <div class="row g-4 justify-content-center">
                                    @foreach($latestNews as $news)
                                        <div class="col-md-4">
                                            <div class="webinar-card">
                                                @if($news->image)
                                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                                                @endif

                                                <div class="webinar-content">
                                                    <span class="text-muted mb-2">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</span>
                                                    <h5>{{ $news->title }}</h5>
                                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->description), 100, '...') }}</p>
                                                    <div class="read-more">
                                                        <a href="{{ route('news.show', $news->id) }}">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- What's New Section End -->

<!-- Growth staragy start -->
 <!-- Section Title -->
    <div class="container-section-title">
    <div class="container section-title">
        
        <div class="section-title">
        <h3 class="wow fadeInUp"> Market Insights</h3>
        <h2 class="text-anime-style-2" data-cursor="-opaque">Success Delivered  <span>Through Market Insights  </span></h2>
        <p>At our core, we don’t just analyze markets, we help shape success stories. Our insights are born from rigorous research, real-time trends, and an obsession with uncovering untapped potential. Here’s how we empower businesses to move with clarity and confidence:</p>                     
        </div>

        <!-- Zig-Zag Insights Section -->
        <section class="top-reports-points">
            <div class="container">
                <div class="report-section">
                    <!-- Left Column -->
                    <div class="report-column">
                        <div class="report-block">
                            <img src="{{ asset('assets/images/Unlock-Growth-Opportunities.png') }}" alt="Discover" class="icon">
                            <div>
                                <h5>Unlock Growth Opportunities</h5>
                                <p>From niche markets to global giants, we identify high-value spaces where your business can grow, innovate, and lead, no matter your starting point.</p>
                            </div>
                        </div>
                        <div class="report-block">
                            <img src="{{ asset('assets/images/Strategy-Focused.png') }}" alt="Discover" class="icon">
                            <div>
                                <h5>Insight-Led, Strategy-Focused</h5>
                                <p>In a world full of data, we deliver direction. Our research-driven insights turn complexity into clarity, helping you shape strategies that drive real-world results.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Zig-Zag SVG Line -->
                    <!-- <div class="zigzag-line">
                        <img src="{{ asset('assets/images/Zig-zag.svg') }}" alt="Zig Zag Line" style="width: 1180px; height: 1189px;">
                    </div> -->

                    <!-- Right Column -->
                    <div class="report-column">
                        <div class="report-block">
                            <img src="{{ asset('assets/images/Market-Entry-&-Expansion.png') }}" alt="Business" class="icon" style="width: 50px; height: auto;">
                            <div>
                                <h5>Smarter Market Entry & Expansion</h5>
                                <p>Planning a launch or new market entry? We equip you with feasibility insights, competitor intelligence, and trend forecasts to ensure a smooth, informed move.</p>
                            </div>
                        </div>
                        <div class="report-block">
                            <img src="{{ asset('assets/images/Confident,-Future-Ready-Decisions.png') }}" alt="Launch" class="icon" style="width: 50px; height: auto;">
                            <div>
                                <h5>Confident, Future-Ready Decisions</h5>
                                <p>Our foresight-first approach ensures your strategies aren’t just reactive, they’re resilient. We help you anticipate market shifts and build long-term success.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>


<!-- Growth Staragy End -->

<!-- How It Work Section Start -->
   

    <!-- Our Services Section Start -->
    <div class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Service Content Start -->
                    <div class="our-service-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp"> Our Industries</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Our  <span>Industries</span></h2>
                        </div>
                        <!-- Section Title End -->
                        
                        <!-- Section content Button Start -->
                        <div class="service-content-btn wow fadeInUp" data-wow-delay="0.25s">
                            <a href="{{ url('/industries') }}" class="btn-default">all Industries</a>
                        </div>
                        <!-- Section content Button End -->
                    </div>
                    <!-- Service Content End -->
                </div>

                <div class="col-lg-8">
   
                    <div class="our-service-list">
                            @foreach($allIndustries as $index => $industry)
                                @php
                                    $industryName = $industry->industries_name;
                                    $slug = $industry->slug;
                                    $description = Str::limit(strip_tags($industry->description), 120);
                                    $iconImage = asset('assets/images/' . $slug . '.svg');
                                @endphp

                                <!-- Service Item Start -->
                                <div class="service-item">
                                    <div class="service-no">
                                        <h2>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h2>
                                    </div>
                                    <div class="service-content-box">
                                        <div class="icon-box">
                                            <img src="{{ $iconImage }}" alt="{{ $industryName }} Icon">
                                        </div>

                                        <div class="service-item-content">
                                            <h3>{{ $industryName }}</h3>
                                            <p>{{ $description }}</p>
                                            <a href="{{ route('industries.details', ['slug' => $slug]) }}" class="service-btn">
                                                <img src="{{ asset('assets/images/arrow-white.svg') }}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Service Item End -->
                            @endforeach
                </div>

    
            </div>

            </div>
        </div>
    </div>
    <!-- Our Services Section End -->

    
    <!-- Our Feature Section Stat -->
    <div class="our-feature">
        <div class="container">
            
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    
                     <div class="section-title">
                        <h3 class="wow fadeInUp">Our Capabilities</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Our <span>Capabilities</span></h2>
                    </div>
                    <!-- Section Title End -->
                     

                </div>


                <div class="col-lg-6">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/services') }}" class="btn-default"> All Capabilities </a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

    <div class="row">      
        <div class="col-lg-12">
            <!-- Our Feature List Start -->
            <div class="our-feature-list">
                @foreach($allServices as $index => $service)
                    @php
                        $serviceName = $service->service_name;
                        $slug = $service->slug;
                        $iconImage = asset('assets/images/' . $slug . '.svg');
                        $delay = $index * 0.2;
                        $shortDescription = \Illuminate\Support\Str::words(strip_tags($service->description), 25, '...');
                        $textColor = $index % 2 == 0 ? 'var(--white-color)' : '#040303';
                    @endphp

                    <!-- Feature Item Start -->
                    <div class="our-feature-item wow fadeInUp" data-wow-delay="{{ $delay }}s" style="min-height: 320px; display: flex; flex-direction: column; justify-content: space-between; padding: 20px;">
                        <div class="icon-box">
                            <img src="{{ $iconImage }}" alt="{{ $serviceName }}">
                        </div>
                        <div class="feature-item-content">
                            <h3 style="color: {{ $textColor }};">{{ $serviceName }}</h3>

                            <p style="color: {{ $textColor }};">
                                {!! $shortDescription !!}
                            </p>

                            <a href="{{ route('service.details', ['slug' => $slug]) }}" class="service-btn">
                                <img src="{{ asset('assets/images/arrow-white.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- Feature Item End -->
                @endforeach
            </div>
            <!-- Our Feature List End -->
        </div>
                      
    </div>

        </div>
    </div>
    <!-- Our Feature Section End -->
     <!-- Our Testimonial Section Start -->
    <div class="our-testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <!-- Testimonial Content Start -->
                    <div class="testimonial-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">our testimonial</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">What Customer Says <span>About M2square</span></h2>
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
                                                <!-- <div class="testimonial-quotes">
                                                    <img src="{{ asset('assets') }}/images/testimonial-quotes.svg" alt="">
                                                </div> -->
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
                                                <!-- <div class="testimonial-quotes">
                                                    <img src="{{ asset('assets') }}/images/testimonial-quotes.svg" alt="">
                                                </div> -->
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
     <!-- Why Choose Us Section Start -->
    <div class="why-choose-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                  
                    <div class="why-choose-content">
                        
                        <div class="section-title">
                            <h3 class="wow fadeInUp">why choose us</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Why Trust Us <span>for Market Insights?</span></h2>
                        </div>
                        

                       
                        <div class="why-choose-box-list">
                         
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-1.svg" alt="">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>Market Strategies</h3>
                                    <p>Customized Insights for Your Business Growth and Success.</p>
                                </div>
                            </div>
                          

                      
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-2.svg" alt="">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>Market Analysis & Strategy</h3>
                                    <p>Tailored Market Insights & Strategies for Sustainable Business Growth</p>
                                </div>
                            </div>
                           
                        </div>
                        

                     
                        <div class="why-choose-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Data-Driven Market Insights</li>
                                <li>Customized Growth Strategies</li>
                            </ul>
                        </div>
                      
                    </div>
                 
                </div>

                <div class="col-lg-6">
                
                    <div class="why-choose-image">
                        
                        <div class="why-choose-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/why-choose-img-1.jpg" alt="">
                            </figure>
                        </div>
                      

                    
                        <div class="why-choose-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/why-choose-img-2.jpg" alt="">
                            </figure>
                        </div>
                       

                     
                        <!-- <div class="why-choose-contact-circle">
                            <img src="{{ asset('assets') }}/images/contact-us-img.svg" alt="">
                        </div>
                        -->
                    </div>
                  
                </div>
            </div>
        </div>
    </div>

    
  


  


     <!-- Our FAQs Section Start-->
    <!-- <div class="our-faqs">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                   
                    <div class="section-title">
                        <h3 class="wow fadeInUp">faqs</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Your Most Frequently Asked <span>Questions Answered</span></h2>
                    </div>
                   
                </div>

                <div class="col-lg-6">
                   
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="faqs.html" class="btn-default">view all FAQs</a>
                    </div>
                  
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                   
                    <div class="our-faqs-image">
                       
                        <div class="our-faqs-img">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/faqs-img.jpg" alt="">
                            </figure>
                        </div>
                       
                        
                        <div class="client-review-box">
                            
                            <div class="client-review-box-content">
                                <p>100+ Client <span><i class="fa-solid fa-star"></i> 5.0 (250 Reviews)</span></p>
                            </div>
                            

                            
                            <div class="client-review-images">
                                
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-1.jpg" alt="">
                                    </figure>
                                </div>
                                

                                
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-2.jpg" alt="">
                                    </figure>
                                </div>
                                
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-3.jpg" alt="">
                                    </figure>
                                </div>
                                
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-4.jpg" alt="">
                                    </figure>
                                </div>
                                
                                <div class="client-image">
                                    <figure class="image-anime">
                                        <img src="{{ asset('assets') }}/images/satisfy-client-img-5.jpg" alt="">
                                    </figure>
                                </div>
                                
                                <div class="client-image add-more">
                                    <p><span class="counter">30</span>+</p>
                                </div>
                               
                            </div>
                            
                        </div>
                       
                    </div>
                    
                </div>
                
                <div class="col-lg-6">
                    
                    <div class="our-faq-section">
                        
                        <div class="faq-accordion" id="faqaccordion">
                           
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
                            
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- Our FAQs Section End-->

    

    <!-- Some Fact Section Start -->
    <!-- <div class="fact-counter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    
                    <div class="fact-counter-image">
                        
                        <div class="fact-counter-img">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/fact-counter-img.jpg" alt="">
                            </figure>
                        </div>
                       
                        <div class="fact-counter-skillbar">
                            <img src="{{ asset('assets') }}/images/fact-counter-skillbar-img.png" alt="">
                        </div>
                        
                    </div>
                  
                </div>

                <div class="col-lg-6">
                    
                    <div class="fact-counter-content">
                       
                        <div class="section-title">
                            <h3 class="wow fadeInUp">some facts</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Core Expertise & <span>Key Insights</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our expertise is built on years of industry experience, proven financial strategies and a commitment to client success.</p>
                        </div>
                      

                        
                        <div class="fact-counter-box-list">
                            
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-1.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">25</span>+</h2>
                                    <p>Years of experience</p>
                                </div>
                            </div>
                            
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-2.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">80</span>%+</h2>
                                    <p>Client success rate</p>
                                </div>
                            </div>
                            
                            <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-3.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">20</span>+</h2>
                                    <p>global research</p>
                                </div>
                            </div>
                          
                        </div>
                        
                        <div class="fact-counter-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Competitive Landscape Analysis</li>
                                <li>Targeted Business Intelligence</li>
                            </ul>
                        </div>
                        <
                    </div>
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- Some Fact Section End -->

    <!-- What We Do Section Start -->
    <!-- <div class="what-we-do">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                   
                    <div class="what-we-do-content">
                        
                        <div class="section-title">
                            <h3 class="wow fadeInUp">what we do</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Driving Market Growth & <span>Competitive Success</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We provide expert market research and consulting solutions designed to unlock opportunities, enhance decision-making, and drive sustainable business growth.</p>
                        </div>
                        

                        
                        <div class="what-we-do-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Strategic Market Analysis</li>
                                <li>Consumer Insights & Behavior</li>
                                <li>Competitive Intelligence</li>
                                <li>Risk Assessment & Strategies</li>
                            </ul>
                        </div>
                        
                        <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="{{ url('/contact') }}" class="btn-default">contact now</a>
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-lg-6">
                    
                    <div class="what-we-do-images">
                        
                        <div class="what-do-we-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/what-we-do-img-1.jpg" alt="">
                            </figure>
                        </div>
                        

                        
                        <div class="what-do-we-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/what-we-do-img-2.jpg" alt="">
                            </figure>
                        </div>
                        
                   >
                </div>
            </div>
        </div>
    </div> -->
    <!-- What We Do Section End -->

    <!-- How It Work Section Start -->
    <!-- <div class="how-it-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                   
                    <div class="how-it-work-content">
                     
                        <div class="section-title">
                            <h3 class="wow fadeInUp">how it work</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Our Process for <span>Success</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our process is designed to guide you every step of the way. From initial consultation to personalized strategy development.</p>
                        </div>
                        
                        <div class="how-it-work-btn wow fadeInUp" data-wow-delay="0.4s">
                            <a href="{{ url('/about') }}" class="btn-default">learn more</a>
                        </div>
                        
                    </div>
                   
                </div>
                
                <div class="col-lg-6">
                    
                    <div class="work-steps-box">
                       
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
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- How It Work Section End -->

    <!-- Our Pricing Section Start -->
    <!-- <div class="our-pricing">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-5">
                   
                    <div class="section-title">
                        <h3 class="wow fadeInUp">pricing plan</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">We've Flexible Plan</h2>
                    </div>
                 
                </div>

                <div class="col-lg-7">
                   
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/contact') }}" class="btn-default">contact now</a>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                
                    <div class="pricing-box wow fadeInUp">
                       
                        <div class="pricing-header">
                            <h3>personal plan</h3>
                            <h2><sup>$</sup>29.00<sub>/per month</sub></h2>
                        </div>
                        
                        <div class="pricing-body">
                            
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                            
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                           
                        </div>
                        
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                        
                    </div>
                   
                </div>

                <div class="col-lg-4 col-md-6">
                    <
                    <div class="pricing-box highlighted-box wow fadeInUp" data-wow-delay="0.2s">
                        
                        <div class="pricing-header">
                            <h3>business plan</h3>

                            <h2><sup>$</sup>39.00<sub>/per month</sub></h2>
                        </div>
                       
                        <div class="pricing-body">
                           
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                            
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                            
                        </div>
                        

                       
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                        
                    </div>
                    
                </div>

                <div class="col-lg-4 col-md-6">
                   >
                    <div class="pricing-box wow fadeInUp" data-wow-delay="0.4s">
                        >
                        <div class="pricing-header">
                            <h3>advance plan</h3>

                            <h2><sup>$</sup>49.00<sub>/per month</sub></h2>
                        </div>
                        
                        <div class="pricing-body">
                           
                            <div class="pricing-list-title">
                                <h3>What's included?</h3>
                            </div>
                          
                            <div class="pricing-list">
                                <ul>
                                    <li>comprehensive financial analysis</li>
                                    <li>tax strategy optimization</li>
                                    <li>regular progress reports</li>
                                    <li>ongoing support and guidance</li>
                                </ul>
                            </div>
                            
                        </div>
                     
                        <div class="pricing-btn">
                            <a href="#" class="btn-default btn-highlighted">Select this package</a>
                        </div>
                      
                    </div>
                   
                </div>

                <div class="col-lg-12">
                    
                    <div class="pricing-benefit-list wow fadeInUp" data-wow-delay="0.6s">
                        <ul>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-1.svg" alt="">Get 30 day free trial</li>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-2.svg" alt="">No any hidden fees pay</li>
                            <li><img src="{{ asset('assets') }}/images/icon-pricing-benefit-3.svg" alt="">You can cancel anytime </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- Our Pricing Section End -->

    

    

    <!-- Our Blog Section Start -->
   <!-- <div class="our-blog">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h3 class="wow fadeInUp">blog / post</h3>
                    <h2 class="text-anime-style-2" data-cursor="-opaque">Market Insights, Updates <span>& Latest Trends</span></h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                    <a href="blog.html" class="btn-default">view all post</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="post-item wow fadeInUp">
                    <div class="post-featured-image">
                        <a href="blog-single.html" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/post-1.jpg" alt="">
                            </figure>
                        </a>
                    </div>
                    <div class="post-item-body">
                        <div class="post-item-meta">
                            <ul>
                                <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                            </ul>
                        </div>
                        <div class="post-item-content">
                            <h2><a href="blog-single.html">10 Essential Steps to Create Foolproof Financial Plan for Long-Term Stability</a></h2>
                        </div>
                        <div class="post-item-btn">
                            <a href="blog-single.html" class="readmore-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="post-item wow fadeInUp" data-wow-delay="0.2s">
                    <div class="post-featured-image">
                        <a href="blog-single.html" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/post-2.jpg" alt="">
                            </figure>
                        </a>
                    </div>
                    <div class="post-item-body">
                        <div class="post-item-meta">
                            <ul>
                                <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                            </ul>
                        </div>
                        <div class="post-item-content">
                            <h2><a href="blog-single.html">Top 10 Financial Mistakes Individuals and Businesses Should Avoid in 2024</a></h2>
                        </div>
                        <div class="post-item-btn">
                            <a href="blog-single.html" class="readmore-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="post-item wow fadeInUp" data-wow-delay="0.4s">
                    <div class="post-featured-image">
                        <a href="blog-single.html" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/post-3.jpg" alt="">
                            </figure>
                        </a>
                    </div>
                    <div class="post-item-body">
                        <div class="post-item-meta">
                            <ul>
                                <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                            </ul>
                        </div>
                        <div class="post-item-content">
                            <h2><a href="blog-single.html">Mastering Budgeting Practical Steps to Ensure Your Financial Success</a></h2>
                        </div>
                        <div class="post-item-btn">
                            <a href="blog-single.html" class="readmore-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="post-item wow fadeInUp" data-wow-delay="0.6s">
                    <div class="post-featured-image">
                        <a href="blog-single.html" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/post-4.jpg" alt="">
                            </figure>
                        </a>
                    </div>
                    <div class="post-item-body">
                        <div class="post-item-meta">
                            <ul>
                                <li><i class="fa-solid fa-calendar-days"></i> 15 sep, 2024</li>
                            </ul>
                        </div>
                        <div class="post-item-content">
                            <h2><a href="blog-single.html">Understanding Cash Flow Key to Healthy Busines and Financial Stability</a></h2>
                        </div>
                        <div class="post-item-btn">
                            <a href="blog-single.html" class="readmore-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

    <!-- Our Blog Section End  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
    new Swiper('.jfin-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.jfin-hero-pagination',
            clickable: true,
        },
    });
</script>
@endsection