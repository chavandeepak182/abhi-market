@extends('frontend.layouts.header')

@section('title', 'About US - M2square consultancy | Expert Market Research Firm')

@section('description', 'Grow your business with expert market research and consulting services from m2square consultancy. Data-driven insights and tailored strategies for every industry.')

@section('keywords', 'market research services, business consulting, m2square consultancy, data-driven insights, strategic business solutions, market analysis, consulting firm')

@section('content')
    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">About us</h1>
                        <!-- <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">about us</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
 <!-- How It Work Section Start -->
       <section class="who-we-are-carousel">
  <div class="container">
    <div class="section-title">
      <h2>Who <span>We Are</span></h2>
      <p>We’re a purpose-driven market research company that transforms data into actionable insights.</p>
    </div>

    <div class="swiper">
      <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide value-card">
          <span class="value-number">01</span>
          <h3>Integrity</h3>
          <p>We act with honesty and uphold ethical standards to build lasting trust.</p>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide value-card">
          <span class="value-number">02</span>
          <h3>Innovation</h3>
          <p>We embrace emerging tech to deliver sharper and faster insights.</p>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide value-card">
          <span class="value-number">03</span>
          <h3>Collaboration</h3>
          <p>We work closely with clients and partners to co-create value.</p>
        </div>

        <!-- Slide 4 -->
        <div class="swiper-slide value-card">
          <span class="value-number">04</span>
          <h3>Customer Focus</h3>
          <p>We understand client needs deeply and transform challenges into solutions.</p>
        </div>

        <!-- Slide 5 -->
        <div class="swiper-slide value-card">
          <span class="value-number">05</span>
          <h3>Quality</h3>
          <p>We ensure every insight delivered is data-driven and decision-ready.</p>
        </div>

      </div>
    </div>
  </div>
</section>



<!-- BEFORE </body> -->

    <!-- What We Do Section Start -->
    <div class="what-we-do">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- What We Do Content Start -->
                    <div class="what-we-do-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <!-- <h3 class="wow fadeInUp">what we do</h3> -->
                            <h2 class="text-anime-style-2" data-cursor="-opaque">What  <span>We Do</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We specialize in decoding complexity. From market forecasting to customer behavior analysis, our services are designed to bridge the gap between uncertainty and opportunity.</p>
                            <p>Our offerings span the entire insight lifecycle, including</p>
                            
                        </div>
                        <!-- Section Title End -->

                        <!-- What We Do List Start -->
                        <div class="what-we-do-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Consulting</li>
                                <li>Tailored Research</li>
                                <li> Syndicated Studies</li>
                                <li>Trend Tracking</li>
                                <li> Competitive Intelligence</li>
                                <li>Pricing and Channel analysis</li>
                                 <li>GTM Strategy</li>
                            </ul>
                        </div>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">and more. Using a blend of qualitative expertise and data science, we deliver bespoke solutions that inform bold business moves.
            Whether you’re entering a new geography, launching a product, or restructuring a business model, we help you understand the landscape before you leap.
            What makes us different is our obsession with relevance. We don’t deliver static reports, we craft stories backed by evidence, customized for your strategic needs. Our advanced data visualization capabilities bring research to life, turning complexity into clarity.
            In less than two years, we’ve worked with over 150 organizations across sectors like healthcare, ICT, finance, energy, and consumer goods, proving our commitment to impact, not just insight.
            We don’t just inform; we empower.</p>
                        <!-- What We Do List End -->

                        <!-- What We Do Button Start -->
                        <!-- <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="contact.html" class="btn-default">contact now</a>
                        </div> -->
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

                        <!-- Experience Counter Box Start -->
                        <!-- <div class="experience-counter-box">
                            <div class="experience-counter-no">
                                <h2><span class="counter">25</span>+</h2>
                            </div>
                            <div class="experience-counter-content">
                                <p>Years of experience in finance</p>
                            </div>
                        </div> -->
                        <!-- Experience Counter Box Start End -->
                    </div>
                    <!-- What We Do Images End -->
                </div>
            </div>
        </div>
    </div>
    <!-- What We Do Section End -->
    <!-- How It Work Section End -->
    <!-- About Us Section Start -->
    <!-- <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    
                    <div class="about-us-images">
                       
                        <div class="about-img-1">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/about-img-1.jpg" alt="">
                            </figure>
                        </div>
                       

                      
                        <div class="about-img-2">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('assets') }}/images/about-img-2.jpg" alt="">
                            </figure>
                        </div>
                       

                        
                        <div class="contact-circle">
                            <img src="{{ asset('assets') }}/images/contact-us-img.svg" alt="">
                        </div>
                        
                    </div>
                 
                </div>
                
                <div class="col-lg-6">
                   
                    <div class="about-us-content">
                       
                        <div class="section-title">
                            <h3 class="wow fadeInUp">about us</h3>
                            <h2 class="text-anime-style-2">Trusted guidance for <span>financial growth</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">With years of expertise in finance and consulting, we provide tailored strategies to help you achieve sustainable growth. Our commitment is to guide you  integrity, insight, and a personalized approach.</p>
                        </div>
                    

                       
                        <div class="about-content-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                   
                                    <div class="about-content-info">
                                      
                                        <div class="about-goal-box wow fadeInUp" data-wow-delay="0.4s">
                                            <div class="icon-box">
                                                <img src="{{ asset('assets') }}/images/icon-financial-strategies.svg" alt="">
                                            </div>
            
                                            <div class="about-goal-box-content">
                                                <h3>financial strategies</h3>
                                                <p>Tailored plans to meet your unique financial needs and goals.</p>
                                            </div>
                                        </div>
                                    
                
                                      
                                        <div class="about-contact-box wow fadeInUp" data-wow-delay="0.6s">
                                            <div class="icon-box">
                                                <img src="{{ asset('assets') }}/images/icon-phone.svg" alt="">
                                            </div>

                                            <div class="about-contact-content">
                                                <p><a href="tel:658456975">+(658) 456-975</a></p>
                                            </div>
                                        </div>
                                     
                                    </div>
                               
                                </div>

                                <div class="col-md-6">
                                 
                                    <div class="about-author-box wow fadeInUp" data-wow-delay="0.4s">
                                       
                                        <div class="about-info-box">
                                            <figure class="image-anime reveal">
                                                <img src="{{ asset('assets') }}/images/amit-sharma.jpg" alt="">
                                            </figure>
            
                                            <div class="about-author-content">
                                                <h3>Sarah T.</h3>
                                                <p>Co. founder</p>
                                            </div>
                                        </div>
                                      
                                        <div class="about-info-list">
                                            <ul>
                                                <li>risk management</li>
                                                <li>communication</li>
                                                <li>24/7 support</li>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                  
                    </div>
                   
                </div>
            </div>
        </div>
    </div> -->
    <!-- About Us Section End -->

   

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
                        
                    </div>
                    
                </div>

                <div class="col-lg-6">
                    <!-- Fact Counter Content Start -->
                    <div class="fact-counter-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">some facts</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Diversity & <span>Inclusion</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">At the heart of our culture is a simple belief: diversity powers insight. When people from different backgrounds, experiences, and identities come together, they bring perspectives that spark innovation.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We are committed to fostering a workplace where everyone feels valued, heard, and empowered. Our approach to diversity is not a checklist; it’s a mindset that influences how we hire, how we collaborate, and how we deliver research.
                            We promote equity through inclusive policies, mentorship programs, and a culture of openness. Our teams are encouraged to bring their whole selves to work, and our leadership is dedicated to continuous learning and progress.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Diversity also strengthens the work we do for our clients. It enables us to research complex, multicultural markets with authenticity and accuracy. It helps us understand behaviors, not just numbers.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Ultimately, inclusion isn’t just a value; it’s a strategy. It’s how we build stronger teams, develop better insights, and deliver impact that reflects the world we live in.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Fact Counter Box List Start -->
                        <div class="fact-counter-box-list">
                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-1.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">25</span>+</h2>
                                    <p>Years of experience</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-2.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">80</span>%+</h2>
                                    <p>Client success rate</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-3.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">20</span>+</h2>
                                    <p>global research</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->
                        </div>
                        <!-- Fact Counter Box List End -->

                        <!-- Fact Counter List Start -->
                        <!-- <div class="fact-counter-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Competitive Landscape Analysis</li>
                                <li>Targeted Business Intelligence</li>
                            </ul>
                        </div> -->
                        <!-- Fact Counter List End -->
                    </div>
                    <!-- Fact Counter Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Some Fact Section End -->
 <!-- Our Approach Section Start -->
    <div class="our-approach">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">our Mission & Vision</h3>
                        <h2 class="wow fadeInUp" data-wow-delay="0.2s">Mission <span>& vision</span></h2> 
                    </div>
                    <!-- Section Title End -->

                </div>
                
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <!-- Mission Vision Item Start -->
                    <div class="mission-vission-item wow fadeInUp">
                        <!-- Mission Vision Header Start -->
                        <div class="mission-vission-header">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-mission.svg" alt="">
                            </div>

                            <div class="mission-vission-content">
                                <h3>our mission</h3>
                                <p>Our mission is to leverage data and technology to create a meaningful impact on business, society, and beyond.</p>
                                <p>We see ourselves as enablers of progress. With every research brief, strategic roadmap, or market model we deliver, our goal is to drive measurable outcomes that matter. Whether it’s helping a company scale sustainably or supporting a non-profit in understanding its stakeholders, we operate with purpose.
                                We bring together domain knowledge, modern analytics, and a deep understanding of human behavior to craft insights that don’t just inform, they ignite transformation.
                                </p>
                                <p>But our mission goes beyond profit. We recognize the role data can play in solving societal challenges, from improving access to healthcare insights to helping governments plan smarter urban ecosystems. That’s why we align our work with broader goals of responsibility, equity, and inclusion.</p>
                                <p>By combining smart tools with ethical intent, we aim to turn every insight into an opportunity for business and the world.</p>
                            </div>
                        </div>
                        <!-- Mission Vision Header End -->

                        <!-- Mission Vision Image Start -->
                        <!-- <div class="mission-vission-image">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/our-mission-img.jpg" alt="">
                            </figure>
                        </div> -->
                        <!-- Mission Vision Image End -->
                    </div>
                    <!-- Mission Vision Item End -->
                </div>

                <div class="col-lg-6 col-md-6">
                    <!-- Mission Vision Item Start -->
                    <div class="mission-vission-item wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Mission Vision Header Start -->
                        <div class="mission-vission-header">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-our-vision.svg" alt="">
                            </div>

                            <div class="mission-vission-content">
                                <h3>our vision</h3>
                                <p>Our vision is to become a globally trusted data provider, a name that stands for reliability, innovation, and clarity in an increasingly uncertain world.</p>
                                <p>In an era of information overload, we aim to be the filter that brings focus. While many organizations collect data, we specialize in converting it into foresight, insight that fuels strategy, innovation, and growth.</p>
                                <p>Being “trusted” means more than just being accurate. It means being timely, relevant, ethical, and transparent. We strive to be the first choice for decision-makers when it comes to solving business challenges and uncovering growth opportunities.</p>
                                <p>This vision also pushes us to continuously evolve, adopting smarter tools, building diverse teams, and expanding our reach across industries and geographies.
                                </p>
                                <p>We don’t just want to be another data firm; we want to redefine how data guides the future.</p>
                            </div>
                        </div>
                        <!-- Mission Vision Header End -->

                        <!-- Mission Vision Image Start -->
                        <!-- <div class="mission-vission-image">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/our-vision-img.jpg" alt="">
                            </figure>
                        </div> -->
                        <!-- Mission Vision Image End -->
                    </div>
                    <!-- Mission Vision Item End -->
                </div>

                
            </div>
        </div>
    </div>
    <!-- Our Approach Section End -->


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
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Me<span>dia</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Our media presence reflects not just what we do, but how we think. Through articles, thought leadership content, interviews, and curated reports, we aim to make meaningful contributions to global business conversations.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">This space is a window into our world, showcasing the voices of our analysts, spotlighting our partnerships, and highlighting real-world impact. From industry predictions and case studies to press features and whitepapers, we bring fresh ideas and data-backed opinions that matter.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">You’ll find regular updates on major project outcomes, trend forecasts, and innovations in analytics, all designed to inform, engage, and inspire. Our team members also frequently participate in forums, webinars, and academic panels, contributing to the larger ecosystem of research and strategy.</p>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We believe good insights are meant to be shared. That’s why we use our media platforms to amplify both our expertise and the voices of our clients, collaborators, and community.
                            This is where knowledge meets momentum, and where ideas grow into action.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Fact Counter Box List Start -->
                        <div class="fact-counter-box-list">
                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-1.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">25</span>+</h2>
                                    <p>Years of experience</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-2.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">80</span>%+</h2>
                                    <p>Client success rate</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->

                            <!-- Fact Counter Box Start -->
                            <!-- <div class="fact-counter-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-fact-counter-3.svg" alt="">
                                </div>

                                <div class="fact-counter-box-content">
                                    <h2><span class="counter">20</span>+</h2>
                                    <p>global research</p>
                                </div>
                            </div> -->
                            <!-- Fact Counter Box End -->
                        </div>
                        <!-- Fact Counter Box List End -->

                        <!-- Fact Counter List Start -->
                        <!-- <div class="fact-counter-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Competitive Landscape Analysis</li>
                                <li>Targeted Business Intelligence</li>
                            </ul>
                        </div> -->
                        <!-- Fact Counter List End -->
                    </div>
                    <!-- Fact Counter Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Some Fact Section End -->
     <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.swiper', {
    slidesPerView: 1.2,
    spaceBetween: 20,
    loop: true, // ✅ looping enabled
    grabCursor: true,
    autoplay: {
      delay: 3000, // ✅ 3 seconds between slides
      disableOnInteraction: false, // autoplay won't stop after interaction
    },
    speed: 800, // ✅ 0.8 sec transition animation
    breakpoints: {
      768: {
        slidesPerView: 2.2,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });
</script>
    

@endsection