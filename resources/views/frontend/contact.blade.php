@extends('frontend.layouts.header')
@section('title', "Contact Us")
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
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Contact us</h1>
                        <!-- <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">contact us</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Conatct Info Item Start -->
                    <div class="contact-info-item wow fadeInUp">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/contact-info-img-1.jpg" alt="">
                            </figure>
                        </div>
                        <div class="contact-info-body">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-phone.svg" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>call us any time!</h3>
                                <p>+91 - 123 456 789</p>
                                <p>+(91)- 178 456 129</p>
                            </div>
                        </div>
                    </div>
                    <!-- Conatct Info Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Conatct Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/contact-info-img-2.jpg" alt="">
                            </figure>
                        </div>
                        <div class="contact-info-body">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-mail.svg" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>send us e-mail</h3>
                                <p>sales@domainname.com</p>
                                <p>info@domainname.com</p>
                            </div>
                        </div>
                    </div>
                    <!-- Conatct Info Item End -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <!-- Conatct Info Item Start -->
                    <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="contact-info-img">
                            <figure class="image-anime">
                                <img src="{{ asset('assets') }}/images/contact-info-img-1.jpg" alt="">
                            </figure>
                        </div>
                        <div class="contact-info-body">
                            <div class="icon-box">
                                <img src="{{ asset('assets') }}/images/icon-location.svg" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>finance office address</h3>
                                <p>123 High Street London WC1A 1AA United Kingdom</p>
                            </div>
                        </div>
                    </div>
                    <!-- Conatct Info Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Contact Us End -->    

    <!-- Contact Form Section Start -->
     <div class="contact-form-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Contact Form Image Start -->
                    <div class="contact-form-img">
                        <figure class="image-anime reveal">
                            <img src="{{ asset('assets') }}/images/contact-us-img.jpg" alt="">
                        </figure>
                    </div>
                    <!-- Contact Form Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">contact us</h3>
                        <h2 class="text-anime-style-2" data-cursor="-opaque">Get in Touch <span>with Us</span></h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Have questions or need assistance? Reach out to us today! We're here to provide expert solutions and friendly support.</p>
                    </div>
                    <!-- Section Title End -->
                    <div class="contact-form">
                        <!-- Contact Form Start -->
                        <form action="{{ route('enquiry.store') }}" method="POST" class="wow fadeInUp" data-wow-delay="0.4s">
                            @csrf
                            <input type="hidden" name="page_url" value="{{ url()->current() }}">
                            <input type="hidden" name="page_name" value="{{ Route::currentRouteName() }}">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="name" id="name" class="form-control" required data-error="Please Enter Your Name" placeholder="Name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="contact" id="contact" class="form-control" required placeholder="Phone Number">
                                </div>

                                <div class="form-group col-md-12 mb-4">
                                    <input type="email" name="email" id="email" class="form-control" required data-error="Please Enter Your Email" placeholder="Email">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="8" data-error="Write your message" placeholder="Your Message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">send message</button>
                                    <div id="msgSubmit" class="h3 hidden"></div>
                                </div>
                            </div>
                        </form>
                        <!-- Contact Form End -->
                    </div>
                </div>
            </div>
        </div>
     </div>
    <!-- Contact Form Section End -->

    <!-- Google Map Start -->
    <div class="google-map">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Google Map Start -->
                    <div class="google-map-iframe">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96737.10562045308!2d-74.08535042841811!3d40.739265258395164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1703158537552!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- Google Map End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map End -->  

@endsection