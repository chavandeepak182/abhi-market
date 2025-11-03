@extends('frontend.layouts.header')

@section('title', 'M2 Square Consultancy - Market Research Growth Advisory Firm')

@section('description', 'M2 Square Consultancy is a leading market research growth advisory firm offering syndicated research and insights among top market research companies')

@section('keywords', 'market research companies, market research agency, marketing research companies, b2b market research companies, market research survey, market research for small business, market research services, market research for startups')
{{-- Robots --}}
@section('robots')
    <meta name="robots" content="index, follow">
@endsection
@section('meta')
    <meta property="og:title" content="M2 Square Consultancy - Market Research Growth Advisory Firm" />
    <meta property="og:description" content="M2 Square Consultancy is a leading market research growth advisory firm offering syndicated research and insights among top market research companies" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('assets/img/og-image.jpg') }}" />
    <meta property="og:site_name" content="M2 Square Consultancy" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="M2 Square Consultancy - Market Research Growth Advisory Firm" />
    <meta name="twitter:description" content="M2 Square Consultancy is a leading market research growth advisory firm offering syndicated research and insights among top market research companies" />
    <meta name="twitter:image" content="{{ asset('assets/img/og-image.jpg') }}" />
@endsection

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

    <!-- Our Industries Section Start -->
    <style>
        .our-industries h2 {
    text-align: center;
    font-weight: 700;
}

.industry-card {
    padding: 25px;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.industry-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.industry-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 10px;
}

.section-btn {
    text-align: center;
    margin-top: 40px;
}


.btn-default:hover {
    background: var(--secondary-color);
}
    </style>
    <!-- Our Industries Section Start -->
    <div class="our-industries py-5">
        <div class="container">
            
            <!-- Section Heading -->
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="mb-4 text-anime-style-2" data-cursor="-opaque">
                        Our <span>Industries</span>
                    </h2>
                </div>
            </div>

            <!-- Industry Grid -->
            <div class="row justify-content-center mt-4">
                @foreach($allIndustries as $industry)
                    @php
                        $imagePath = $industry->image;

                        // ✅ Prevent duplicate /uploads/industries path
                        if (!Str::startsWith($imagePath, 'uploads/industries/')) {
                            $imagePath = 'uploads/industries/' . $imagePath;
                        }

                        $imagePath = asset($imagePath);
                    @endphp

                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="industry-card h-100 wow fadeInUp" data-wow-delay="0.1s">
                            
                            <!-- Image -->
                            <div class="industry-image mb-3">
                                <img src="{{ $imagePath }}" alt="{{ $industry->industries_name }}" class="img-fluid rounded">
                            </div>

                            <!-- Title -->
                            <h4>{{ $industry->industries_name }}</h4>

                            <!-- Description -->
                            <p>{{ Str::limit(strip_tags($industry->description), 80) }}</p>

                            <!-- Learn More Button -->
                            <a href="{{ route('industries.details', ['slug' => $industry->slug]) }}" class="learn-more-btn">
                                Learn More →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button (Below the Section) -->
            <div class="row justify-content-center text-center mt-5">
                <div class="col-auto">
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/industries') }}" class="btn-default">View All Industries</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Our Industries Section End -->

    <!-- Our Industries Section End -->

    <!-- Our Industries Section End -->

    
    <!-- Our Feature Section Start -->
    <div class="our-feature">
        <div class="container">
            
            <!-- Section Heading Centered -->
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="text-anime-style-2" data-cursor="-opaque">
                            Our <span>Capabilities</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Feature List -->
            <div class="row mt-4">      
                <div class="col-lg-12">
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

                            <!-- Feature Item -->
                            <div class="our-feature-item wow fadeInUp" data-wow-delay="{{ $delay }}s"
                                style="min-height: 320px; display: flex; flex-direction: column; justify-content: space-between; padding: 20px;">
                                <div class="icon-box">
                                    <img src="{{ $iconImage }}" alt="{{ $serviceName }}">
                                </div>
                                <div class="feature-item-content">
                                    <h3 style="color: {{ $textColor }};">{{ $serviceName }}</h3>
                                    <p style="color: {{ $textColor }};">{!! $shortDescription !!}</p>
                                    <a href="{{ route('service.details', ['slug' => $slug]) }}" class="service-btn">
                                        <img src="{{ asset('assets/images/arrow-white.svg') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>            
            </div>

            <!-- Button Below the Section -->
            <div class="row justify-content-center text-center mt-5">
                <div class="col-auto">
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ url('/services') }}" class="btn-default"> All Capabilities </a>
                    </div>
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
                       
                    </div>
                  
                </div>
            </div>
        </div>
    </div>

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