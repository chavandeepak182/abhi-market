@extends('frontend.layouts.header')
@section('title', "Services")
@section('description', "")
@section('keywords', "")

@section('content')
    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Our services</h1>
                        <!-- <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">our services</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Services Section Start -->
    <div class="page-services">
        <div class="container">
            <div class="row">
                @foreach($allServices as $service)
                    <?php 
                        $img = env('baseURL'). "/" . $service->image;
                        $serviceName = $service->service_name;
                        $description = $service->description;
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <!-- Service Item Start -->
                        <div class="service-item wow fadeInUp">
                            <div class="icon-box">
                                <img src="{{ $img }}" alt="{{ $serviceName }}">
                            </div>

                            <div class="service-item-content">
                                <h3>{{ $serviceName }}</h3>
                                <p>{{ $description }}</p>
                                <a href="{{ url('service-details/'.$service->id) }}" class="service-btn">
                                    <img src="{{ asset('assets/images/arrow-white.svg') }}" alt="View Details">
                                </a>
                            </div>
                        </div>
                        <!-- Service Item End -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Page Services Section End -->

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
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Driving financial growth <span>and success</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We provide expert financial and consulting solutions designed to foster growth, stability, and long-term success.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- What We Do List Start -->
                        <div class="what-we-do-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>strategic financial planning</li>
                                <li>expert investment advisory</li>
                                <li>risk assessment & mitigation</li>
                                <li>retirement & future planning</li>
                            </ul>
                        </div>
                        <!-- What We Do List End -->

                        <!-- What We Do Button Start -->
                        <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
                            <a href="contact.html" class="btn-default">contact now</a>
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

                        <!-- Experience Counter Box Start -->
                        <div class="experience-counter-box">
                            <div class="experience-counter-no">
                                <h2><span class="counter">25</span>+</h2>
                            </div>
                            <div class="experience-counter-content">
                                <p>Years of experience in finance</p>
                            </div>
                        </div>
                        <!-- Experience Counter Box Start End -->
                    </div>
                    <!-- What We Do Images End -->
                </div>
            </div>
        </div>
    </div>
    <!-- What We Do Section End -->

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
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Why trust us <span>our finances</span></h2>
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
                                    <h3>financial strategies</h3>
                                    <p>Tailored plans to meet your unique financial needs and goals.</p>
                                </div>
                            </div>
                            <!-- Why Choose Box End -->

                            <!-- Why Choose Box Start -->
                            <div class="why-choose-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="{{ asset('assets') }}/images/icon-why-choose-2.svg" alt="">
                                </div>

                                <div class="why-choose-box-content">
                                    <h3>tax optimization</h3>
                                    <p>Tailored plans to meet your unique financial needs and goals.</p>
                                </div>
                            </div>
                            <!-- Why Choose Box End -->
                        </div>
                        <!-- Why Choose Box List End -->

                        <!-- Why Choose List Start -->
                        <div class="why-choose-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>strategic financial planning</li>
                                <li>expert investment advisory</li>
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
                            <h2 class="text-anime-style-2" data-cursor="-opaque">1250+ customer say <span>about our finance</span></h2>
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

    <!-- Our FAQs Section Start-->
    <div class="our-faqs">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">faqs</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Your most frequently asked <span>questions answered</span></h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-lg-6">
                    <!-- Section Button Start -->
                    <div class="section-btn">
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

@endsection