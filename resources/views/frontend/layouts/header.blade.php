<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="Keywords" content="@yield('keywords')">
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
	<!-- Google Fonts Css-->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;display=swap" rel="stylesheet">
	<!-- Bootstrap Css -->
	<link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- SlickNav Css -->
	<link href="{{ asset('assets') }}/css/slicknav.min.css" rel="stylesheet">
	<!-- Swiper Css -->
	<link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css">
	<!-- Font Awesome Icon Css-->
	<link href="{{ asset('assets') }}/css/all.min.css" rel="stylesheet" media="screen">
	<!-- Animated Css -->
	<link href="{{ asset('assets') }}/css/animate.css" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
	<link rel="stylesheet" href="{{ asset('assets') }}/css/magnific-popup.css">
	<!-- Mouse Cursor Css File -->
	<link rel="stylesheet" href="{{ asset('assets') }}/css/mousecursor.css">
	<!-- Main Custom Css -->
	<link href="{{ asset('assets') }}/css/custom.css" rel="stylesheet" media="screen">
</head>
<body>

    <!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('assets') }}/images/loader.svg" alt=""></div>
		</div>
	</div>
	<!-- Preloader End -->

    <!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="index.html">
						<img src="{{ asset('assets') }}/images/logo.svg" alt="Logo">
					</a>
					<!-- Logo End -->

					<!-- Main Menu Start -->
					<div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item submenu"><a class="nav-link" href="index.html">Home</a>
                                    <ul>
                                        <li class="nav-item"><a class="nav-link" href="index-2.html">Home - Main</a></li>
                                        <li class="nav-item"><a class="nav-link" href="index-image.html">Home - Image</a></li>
                                        <li class="nav-item"><a class="nav-link" href="index-video.html">Home - Video</a></li>
                                        <li class="nav-item"><a class="nav-link" href="index-slider.html">Home - Slider</a></li>
                                    </ul>
                                </li>                                
                                <li class="nav-item"><a class="nav-link" href="about.html">About Us</a>
                                <li class="nav-item"><a class="nav-link" href="services.html">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                <li class="nav-item submenu"><a class="nav-link" href="#">Pages</a>
                                    <ul>                                        
                                        <li class="nav-item"><a class="nav-link" href="service-single.html">Service Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="blog-single.html">Blog Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="team.html">Our Team</a></li>
                                        <li class="nav-item"><a class="nav-link" href="team-single.html">Team Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="pricing.html">Pricing Plan</a></li>
                                        <li class="nav-item"><a class="nav-link" href="clients.html">Clients</a></li>
                                        <li class="nav-item"><a class="nav-link" href="testimonial.html">Testimonials</a></li>
                                        <li class="nav-item"><a class="nav-link" href="image-gallery.html">Image Gallery</a></li>
                                        <li class="nav-item"><a class="nav-link" href="video-gallery.html">Video Gallery</a></li>
                                        <li class="nav-item"><a class="nav-link" href="faqs.html">FAQs</a></li>
                                        <li class="nav-item"><a class="nav-link" href="404.html">404</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item highlighted-menu"><a class="nav-link" href="contact.html">Contact Us</a></li>                           
                            </ul>
                        </div>
                        <!-- Header Btn Start -->
                        <div class="header-btn d-inline-flex">
                            <a href="contact.html" class="btn-default btn-highlighted">contact us</a>
                        </div>
                        <!-- Header Btn End -->
					</div>
					<!-- Main Menu End -->
					<div class="navbar-toggle"></div>
				</div>
			</nav>
			<div class="responsive-menu"></div>
		</div>
	</header>
	<!-- Header End -->

    {{-- main content --}}
    <div class="main-content">
        @yield('content')
    </div>
    {{-- end main content --}}

    @include('frontend.layouts.footer')
</body>
</html>