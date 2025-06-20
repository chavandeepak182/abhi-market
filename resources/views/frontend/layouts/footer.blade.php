<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- Footer Newsletter Box Start -->
                <div class="footer-newsletter-box">
                    <!-- Footer Newsletter Title Start -->
                    <div class="footer-newsletter-title">
                        <h3>JFINMATE</h3>
                    </div>
                    <!-- Footer Newsletter Title End -->

                    <!-- Newsletter Form start -->
                    <!-- <div class="newsletter-form">
                        <form id="newsletterForm" action="#" method="POST">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="mail" placeholder="Enter Your Email" required="">
                                <button type="submit" class="newsletter-btn"><img src="{{ asset('assets') }}/images/arrow-white.svg" alt=""></button>
                            </div>
                        </form>
                    </div> -->
                    <!-- Newsletter Form end -->
                </div>
                <!-- Footer Newsletter Box End -->
            </div>
            
            <div class="col-md-2 col-6">
                <!-- Footer Links Start -->
                <div class="footer-links">
                    <h3 class="mb-3">Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <!-- <li><a href="{{ url('/insights') }}">insights</a></li> -->
                        <li><a href="{{ url('/industries') }}">industries</a></li>
                        <li><a href="{{ url('/services') }}">services</a></li>
                        <li><a href="{{ url('/about') }}">about Us</a></li>
                        <li><a href="{{ url('/contact') }}">contact</a></li>
                    </ul>
                </div>
                <!-- Footer Links End -->
            </div>

            <div class="col-md-2 col-6">
                
                <div class="footer-links">
                    <h3 class="mb-3">Industries</h3>
                    <ul>
                        @foreach($allIndustries as $industry)
                            <li>{{ $industry->industries_name }}</li>
                        @endforeach
                    </ul>
                </div>
                <!-- Footer Links End -->
            </div>

            <div class="col-md-2">
                <!-- Footer Links Start -->
                <div class="footer-links">
                    <h3 class="mb-3">service</h3>
                    <ul>
                        @foreach($allServices as $service)
                            <li><a href="{{ url('service-details/'.$service->id) }}">{{ $service->service_name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Footer Links End -->
            </div>

            <div class="col-lg-12">
                <!-- About Footer Start -->
                
                <!-- About Footer End -->
            </div>
        </div>

        <!-- Footer Copyright Section Start -->
        <div class="footer-copyright">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <!-- Footer Copyright Start -->
                    <div class="footer-copyright-text">
                        <p>Copyright © 2024 All Rights Reserved.</p>
                    </div>
                    <!-- Footer Copyright End -->
                </div>

                <div class="col-md-7">
                    <!-- Footer Menu Start -->
                    <div class="footer-menu">
                        <ul>                            
                            <li><a href="#">LinkedIn</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                        </ul>
                    </div>
                    <!-- Footer Menu End -->
                </div>
            </div>
        </div>
        <!-- Footer Copyright Section End -->
    </div>
</footer>
<!-- Footer Section End -->

<!-- Jquery Library File -->
<script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js"></script>
<!-- Bootstrap js file -->
<script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
<!-- Validator js file -->
<script src="{{ asset('assets') }}/js/validator.min.js"></script>
<!-- SlickNav js file -->
<script src="{{ asset('assets') }}/js/jquery.slicknav.js"></script>
<!-- Swiper js file -->
<script src="{{ asset('assets') }}/js/swiper-bundle.min.js"></script>
<!-- Counter js file -->
<script src="{{ asset('assets') }}/js/jquery.waypoints.min.js"></script>
<script src="{{ asset('assets') }}/js/jquery.counterup.min.js"></script>
<!-- Magnific js file -->
<script src="{{ asset('assets') }}/js/jquery.magnific-popup.min.js"></script>
<!-- SmoothScroll -->
<script src="{{ asset('assets') }}/js/SmoothScroll.js"></script>
<!-- Parallax js -->
<script src="{{ asset('assets') }}/js/parallaxie.js"></script>
<!-- MagicCursor js file -->
<script src="{{ asset('assets') }}/js/gsap.min.js"></script>
<script src="{{ asset('assets') }}/js/magiccursor.js"></script>
<!-- Text Effect js file -->
<script src="{{ asset('assets') }}/js/SplitText.js"></script>
<script src="{{ asset('assets') }}/js/ScrollTrigger.min.js"></script>
<!-- YTPlayer js File -->
<script src="{{ asset('assets') }}/js/jquery.mb.YTPlayer.min.js"></script>
<!-- Wow js file -->
<script src="{{ asset('assets') }}/js/wow.min.js"></script>
<!-- Main Custom js file -->
<script src="{{ asset('assets') }}/js/function.js"></script>