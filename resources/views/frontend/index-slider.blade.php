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
        $banners = App\Models\Banner::latest()->take(3)->get(); // Fetch latest 3 banners
    @endphp
    <!-- Hero Section Start -->
     <style>
.jfin-hero-wrapper {
  position: relative;
  overflow: hidden;
}

.jfin-hero-pagination {
  position: absolute;
  bottom: 20px; 
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
}


.jfin-hero-wrapper + .jfin-hero-pagination {
  position: relative;
  bottom: 0;
  margin-top: 15px; 
  text-align: center;
}
</style>
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
                
            </div>
           
        </div>
         <div class="swiper-pagination jfin-hero-pagination"></div>
        
    <!-- Hero Section End -->

<!-- who we are start -->
<style>

  .who-we-are-section {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 80px;
    overflow: hidden;
    background: #fff;
  }

  .who-we-are-section::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width:50%;
    height:100%;
    background: url('{{ asset('assets') }}/images/who_we_are.webp') center/cover no-repeat;
    filter: blur(0px);
  }

  .who-we-are-content {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 1200px;
    z-index: 1;
  }

  .who-we-are-left {
    position: relative;
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .growth-box {
    position: absolute;
    background-color:#519bb8;
    color: #fff;
    text-align: center;
    padding: 40px 60px;
    font-size: 2rem;
    font-weight: 600;
    border-radius: 4px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    margin-left: 489px;
    margin-bottom: -92px;
  }

  .growth-box span {
    display: block;
    color: #fff;
    font-size: 1rem;
    margin-top: 8px;
  }

  .who-we-are-right {
    width: 50%;
    padding-left: 60px;
  }

  .who-we-are-right h2 {
    font-size: 2rem;
    color: #222;
    margin-bottom: 15px;
  }

  .who-we-are-right p {
    color: #555;
    line-height: 1.6;
    max-width: 500px;
  }

  .wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
  }

  .wave svg {
    display: block;
    width: 100%;
    height: 80px;
  }

  @media (max-width: 900px) {
    .who-we-are-section {
      flex-direction: column;
      padding: 40px 20px;
    }

    .who-we-are-section::before {
      width: 100%;
      height: 250px;
    }

    .who-we-are-content {
      flex-direction: column;
      text-align: center;
    }

    .who-we-are-left,
    .who-we-are-right {
      width: 100%;
    }

    .growth-box {
      position: relative;
      margin: 20px auto;
    }

    .who-we-are-right {
      padding-left: 0;
      margin-top: 20px;
    }
  }
</style>

<section class="who-we-are-section">
  <div class="who-we-are-content">
    <div class="who-we-are-left">
      <div class="growth-box">
        +790
        <span>Growth</span>
      </div>
    </div>
    <div class="who-we-are-right">
      
                             <div class="section-title"> 
                        <h2 class="text-anime-style-2" data-cursor="-opaque">
                           The Minds Behind<span>Market Intelligence</span>
                        </h2>
                    </div>
      <p>At M2Square, we don’t just study markets — we decode them.
Founded in 2023, we are a dynamic market research and business intelligence firm empowering organizations to make smarter, faster, and data-driven decisions. Our expertise spans across diverse industries, helping clients navigate complex markets, identify emerging opportunities, and stay ahead of evolving consumer and business trends.</p>
<p>With a team of passionate researchers, analysts, and strategists, we turn numbers into narratives and insights into action. Whether it’s understanding market shifts, measuring brand performance, or exploring the next big trend — M2Square delivers clarity where it matters most.</p>
<p>Because in a world driven by change, insight is your greatest advantage.</p>
    </div>
  </div>

  <!-- Wave Shape -->
  <div class="wave">
    <svg viewBox="0 0 1440 320">
      <path fill="#f8f8f8" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,208C384,192,480,192,576,208C672,224,768,256,864,256C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128V320H0Z"></path>
    </svg>
  </div>
</section>
<!-- who we are End -->


          
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
                                                        <a href="{{ route('news.show', $news->slug) }}">Read More</a>

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
                  
                     <div class="section-title">
                        <h2 class="text-anime-style-2" data-cursor="-opaque">
                            Our <span>Industries</span>
                        </h2>
                    </div>
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
                                Read More →
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

    

    <style>
    .read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--accent-color);; /* Primary blue color */
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    border-radius: 30px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.read-more-btn img {
    width: 18px;
    height: 18px;
    transition: transform 0.3s ease;
}

.read-more-btn:hover {
    background: #0056b3;
}

.read-more-btn:hover img {
    transform: translateX(5px);
}


/* ✅ MOBILE VIEW ONLY - Stack cards vertically */
@media (max-width: 768px) {

    .business-section .swiper {
        overflow: visible !important;
    }

    /* Stack vertically instead of horizontal scroll */
    .business-section .swiper-wrapper {
        display: flex !important;
        flex-direction: column !important;
        gap: 20px !important;
        padding: 0 !important;
        transform: none !important; /* remove swiper transform */
    }

    .business-section .swiper-slide {
        width: 100% !important;
        max-width: 100% !important;
        flex: 1 1 auto !important;
        margin: 0 !important;
    }

    .business-section .card {
        width: 100%;
        background: #fff;
        border-radius: 15px;
        padding: 25px 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .business-section .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .business-section .card .icon img {
        width: 60px;
        height: 60px;
        margin-bottom: 10px;
    }

    .business-section .card h3 {
        font-size: 18px;
        font-weight: 600;
        margin-top: 10px;
    }

    .business-section .card p {
        font-size: 14px;
        line-height: 1.5;
        margin: 10px 0 15px;
    }

    .learn-more-btn,
    .read-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--accent-color);
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 30px;
        padding: 8px 18px;
        transition: all 0.3s ease;
    }

    .learn-more-btn:hover,
    .read-more-btn:hover {
        background: #0056b3;
    }

    .learn-more-btn img,
    .read-more-btn img {
        width: 16px;
        height: 16px;
        transition: transform 0.3s ease;
    }

    .learn-more-btn:hover img,
    .read-more-btn:hover img {
        transform: translateX(5px);
    }
}
</style>




</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth <= 768) {
        // ✅ Destroy Swiper instance on mobile
        if (typeof swiper !== 'undefined' && swiper && swiper.destroy) {
            try { swiper.destroy(true, true); } catch (e) {}
        }

        // ✅ Convert swiper layout to stacked layout
        const wrapper = document.querySelector('.business-section .swiper-wrapper');
        if (wrapper) {
            wrapper.style.display = 'flex';
            wrapper.style.flexDirection = 'column';
            wrapper.style.gap = '20px';
            wrapper.style.transform = 'none';
        }
    }
});
</script>

   
<div class="our-industries py-5">
        <div class="container">
            
                        <section class="business-section">
                        <div class="row justify-content-center text-center">
                                        <div class="col-lg-8">
                                            <div class="section-title">
                                                <h2 class="text-anime-style-1" data-cursor="-opaque">
                                                    Our <span>Capabilities</span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>

                        <div class="swiper business-slider">
                            <div class="swiper-wrapper">
                            @foreach($allServices as $index => $service)
                                @php
                                $serviceName = $service->service_name;
                                $slug = $service->slug;
                                $iconImage = asset('assets/images/' . $slug . '.svg');
                                $delay = $index * 0.2;

                                // Fixed character limit for uniform text
                                $plainText = strip_tags($service->description);
                                $maxChars = 120; // You can adjust this number (100–130 works best)
                                $shortDescription = strlen($plainText) > $maxChars
                                    ? substr($plainText, 0, $maxChars) . '...'
                                    : $plainText;

                                $colors = ['orange', 'green', 'teal', 'blue'];
                                $colorClass = $colors[$index % count($colors)];
                                @endphp

                                <div class="swiper-slide">
                                <div class="card {{ $colorClass }} wow fadeInUp" data-wow-delay="{{ $delay }}s">
                                    <div class="icon">
                                    <img src="{{ $iconImage }}" alt="{{ $serviceName }}">
                                    </div>
                                    <h3>{{ $serviceName }}</h3>
                                    <p>{{ $shortDescription }}</p>
                                    
                                     <a href="{{ route('service.details', ['slug' => $slug]) }}" class="learn-more-btn">
                                Read More →
                            </a>
                                </div>
                                </div>
                            @endforeach
                            </div>

                            <!-- Dots only -->
                            
                        </div>
                        </section>




            <div class="row justify-content-center text-center mt-5">
                <div class="col-auto">
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s" style="margin-left: 50px;margin-top: -19px;">
                        <a href="{{ url('/services') }}" class="btn-default"> All Capabilities </a>
                    </div>
                </div> </div>
          

        </div>
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
.business-section {
  text-align: center;
  width: 90%;
  max-width: 1100px;
  margin: 0 auto;
}

.business-section h2 {
  font-size: 26px;
  color: #333;
  margin-bottom: 40px;
  font-weight: 600;
}

.business-slider {
  padding-bottom: 40px;
}

.card {
  background: #fff;
  border-radius: 10px;
  padding: 30px 20px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  text-align: center;
  transition: 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 330px;
}

.card:hover {
  transform: translateY(-8px);
}

.icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 15px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.icon img {
  width: 30px;
  height: 30px;
  filter: brightness(0) invert(1);
}

.card h3 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 10px;
}

.card p {
  font-size: 14px;
  color: #555;
  line-height: 1.5;
  margin-bottom: 15px;
  min-height: 60px; /* makes height uniform for all descriptions */
}

/* Color Variations */
.orange .icon { background: #ff7b00; }
.green .icon { background: #6ecb63; }
.teal .icon { background: #00bcd4; }
.blue .icon { background: #007bff; }

.orange h3 { color: #ff7b00; }
.green h3 { color: #6ecb63; }
.teal h3 { color: #00bcd4; }
.blue h3 { color: #007bff; }

/* Read More Button */
.read-more-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
  transition: color 0.3s ease;
  /* margin-left: 50px; */
}

.read-more-btn img {
  width: 12px;
  height: 12px;
  filter: brightness(0) saturate(100%) invert(31%) sepia(89%) saturate(1588%) hue-rotate(193deg) brightness(94%) contrast(99%);
}

.read-more-btn:hover {
  color: #ff7b00;
}

/* Pagination Dots */
.swiper-pagination {
  margin-top: 20px;
}
.swiper-pagination-bullet {
  background: #ccc;
  opacity: 1;
  width: 10px;
  height: 10px;
}
.swiper-pagination-bullet-active {
  background: #007bff;
}

/* Responsive */
@media (max-width: 992px) {
  .card { min-height: 360px; }
}
@media (max-width: 768px) {
  .card { min-height: 380px; }
}
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper(".business-slider", {
    slidesPerView: 4,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      1200: { slidesPerView: 4 },
      992: { slidesPerView: 3 },
      768: { slidesPerView: 2 },
      480: { slidesPerView: 1 },
    },
  });
</script>

    <!-- Our services Section End -->

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

                            <h2 class="text-anime-style-2" data-cursor="-opaque">Voices of Our <span>Valued Partners</span></h2> 

                            <p class="wow fadeInUp" data-wow-delay="0.2s">With over 1,250 satisfied clients, our finance and consulting services have earned praise for reliability, personalized guidance, and impactful results.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Testimonial Button Start -->
                        <div class="testimonial-btn" style="margin-left: 132px;">
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
                                            
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"Partnering with M2Square has transformed the way we make business decisions. Their market insights are not only data-rich but also action-oriented. The team truly understands industry dynamics and delivers clarity that drives growth."</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-1.jpg" alt="author-1">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>Amit Sharma<span>  Marketing Director, Sudarshan Industries Pvt. Ltd.</span></h3>
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
                                            
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"What sets M2Square apart is their commitment to understanding our unique business challenges. Their research helped us identify new market opportunities and refine our go-to-market strategy with confidence. Truly a reliable research partner!"</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-2.jpg" alt="author-2">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>Neha Patel,  / <span>Head of Strategy, Yes Capital</span></h3>
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
                                            
                                            <!-- Testimonial Header End -->

                                            <!-- Testimonial Body Start -->
                                            <div class="testimonial-body">
                                                <p>"We were impressed by M2Square’s attention to detail and their ability to turn complex data into simple, strategic insights. Their professionalism, speed, and accuracy make them an indispensable part of our decision-making process."</p>
                                            </div>
                                            <!-- Testimonial Body End -->

                                            <!-- Testimonial Author Start -->
                                            <div class="testimonial-author">
                                                <!-- Author Image Start -->
                                                <div class="author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('assets') }}/images/author-3.jpg" alt="author-3">
                                                    </figure>
                                                </div>
                                                <!-- Author Image End -->

                                                <!-- Author Content Start -->
                                                <div class="author-content">
                                                    <h3>Rahul Mehta <span>Chief Operating Officer, Ecoenergy Solutions</span></h3>
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
                                    <img src="{{ asset('assets') }}/images/icon-google.svg" alt="icon-google">
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
                                        <img src="{{ asset('assets') }}/images/customer-rating-img.svg" alt="customer-rating-img">
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
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-1.svg" alt="why choose us">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>Market Strategies</h3>
                                    <p>Customized Insights for Your Business Growth and Success.</p>
                                </div>
                            </div>
                          

                      
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-2.svg" alt="why choose us">
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
                                <img src="{{ asset('assets') }}/images/why-choose-img-1.jpg" alt="why choose us image">
                            </figure>
                        </div>
                      

                    
                        <div class="why-choose-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/why-choose-img-2.jpg" alt="why choose us image 2">
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