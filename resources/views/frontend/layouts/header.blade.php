<!DOCTYPE html>
<html lang="en">
<head>
    <script 
        src="https://www.paypal.com/sdk/js?client-id=BAA7qbjGHxnIpeIxf8a_2LH0VFXDc2c6mSOP55nXnPcbklSJhJI4wnNtIA313kdOfWBFjGGiT_ST0kwDqs&components=hosted-buttons&disable-funding=venmo&currency=USD">
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MZLT9HCR');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    @yield('meta')
    @yield('og_tags')
    <!-- Site Verification & SEO -->
    <meta name="google-site-verification" content="uN04EA4cj2RgC0pa0CaC8GI-bo26iFW8E73I-f2Z9Y8">
    <meta name="document-type" content="Public">
    <meta name="Page-Topic" content="Market Research Reports">
    <meta name="copyright" content="M2Square Consultancy, https://m2squareconsultancy.com/, 2025 All Rights Reserved">
    <meta name="classification" content="Market Research Reports">
    <meta name="document-classification" content="Market Research Reports and Consulting Services">
    <meta name="distribution" content="global">
    <meta name="coverage" content="global">
    <meta name="abstract" content="market research reports, syndicated research, industry analysis, Industry Insights, consulting services">
    <meta name="author" content="M2Square Consultancy, https://m2squareconsultancy.com/">
    <meta name="Audience" content="All, Market Research, Research Reports, Business, Market Study Report, Management, Research, Services, consulting">
    <!-- ✅ Schema Markup -->
    @yield('schema_markup')
    @yield('alternate_links')
    @yield('robots')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/slicknav.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/mousecursor.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" media="screen">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- External Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </script>
    </main>
      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "M2 Square Consultancy",
        "url": "https://m2squareconsultancy.com/",
        "logo": "https://m2squareconsultancy.com/assets/images/logo1.png",
        "sameAs": [
          "#",
          "#",
          "#"
        ]
      }
      </script>

      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://m2squareconsultancy.com/",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://m2squareconsultancy.com/reports?query={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      }
      </script>
</head>



<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZLT9HCR"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Header Start -->
    <header class="header">
        <div class="container">
            <div class="row v-center align-items-center">
            <div class="header-item item-left">
                <div class="logo">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img alt="m2square" src="{{ asset('assets') }}/images/logo1.png" width="150" height="auto">
                    </a>
                </div>
            </div>
            <!-- menu start here -->
            <div class="header-item item-center">
                <div class="menu-overlay"></div>
                    <nav class="menu">
                        <div class="mobile-menu-head">
                            <div class="go-back"><i class="fa fa-angle-left"></i></div>
                            <div class="current-menu-title"></div>
                            <div class="mobile-menu-close">&times;</div>
                        </div>
                        <ul class="menu-main mb-0">
                            
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                                
                            </li>

                                <li class="menu-item-has-children">
                                <a href="{{ url('/industries') }}">Industries <i class="fas fa-plus"></i></a>
                                <div class="sub-menu industries-two-column">
                                    @php
                                        $chunks = $industriesMenuData->chunk(ceil($industriesMenuData->count() / 2));
                                        $leftItems = $chunks[0] ?? collect();
                                        $rightItems = $chunks[1] ?? collect(); // in case only 1 chunk
                                    @endphp

                                    <div class="industries-column">
                                        <div class="industry-list">
                                            @foreach($leftItems as $category)
                                                @if(!empty($category['industries']) && isset($category['industries'][0]['slug']))
                                                    <a href="{{ route('industries.details', ['slug' => $category['industries'][0]['slug']]) }}">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>

                                        <div class="divider-vertical"></div>

                                        <div class="industry-list">
                                            @foreach($rightItems as $category)
                                                @if(!empty($category['industries']) && isset($category['industries'][0]['slug']))
                                                    <a href="{{ route('industries.details', ['slug' => $category['industries'][0]['slug']]) }}">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="view-all-link">
                                        <a href="{{ url('/industries') }}">View All</a>
                                    </div>
                                </div>
                            </li>

                            <li class="menu-item-has-children">
                                <a href="{{ url('/services') }}">Capabilities <i class="fas fa-plus"></i></a>
                                <div class="sub-menu capabilities-two-column">
                                    @if(isset($serviceMenuData) && count($serviceMenuData))
                                        @php
                                            $chunks = $serviceMenuData->chunk(ceil($serviceMenuData->count() / 2));
                                            $leftItems = $chunks[0];
                                            $rightItems = $chunks[1] ?? collect();
                                        @endphp

                                        <div class="capabilities-columns">
                                            <div class="capability-list">
                                                @foreach($leftItems as $category)
                                                    <a href="{{ route('service.details', ['slug' => $category['services'][0]['slug'] ?? '#']) }}">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @endforeach
                                            </div>

                                            <div class="divider-vertical"></div>

                                            <div class="capability-list">
                                                @foreach($rightItems as $category)
                                                    <a href="{{ route('service.details', ['slug' => $category['services'][0]['slug'] ?? '#']) }}">
                                                        {{ $category['category_name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="view-all-link">
                                        <a href="{{ url('/services') }}">View All</a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a href="{{ url('/get-reports') }}">Reports</a>
                            </li>
                            

                            <li>
                                <a href="{{ url('/about') }}">About Us</a>
                            </li>
                            <li class="menu-item-has-children">
                            <a href="#">Resources <i class="fas fa-plus"></i></a>
                            <div class="sub-menu capabilities-two-column">
                                <div class="capabilities-columns">
                                    <div class="capability-list">
                                        <a href="{{ url('/press-releases') }}">Press Release</a>
                                        <a href="{{ url('/news') }}">News</a>
                                        <a href="{{ url('/blogs') }}">Blogs</a>
                                        
                                    </div>
                                </div>
                               
                            </div>
                        </li>
                            <!-- <li><a href="{{ url('/blogs') }}">Blogs</a></li> -->
                            <li><a href="{{ url('/contact') }}">Contact</a></li>

                            <li class="nav-item search-item">
                                <form action="{{ route('reports.search') }}" method="GET" class="search-form">
                                    <input 
                                        type="text" 
                                        name="query" 
                                        class="search-input" 
                                        placeholder="Search Reports" 
                                        value="{{ request('query') }}"
                                        required
                                    >
                                    <button type="submit" class="search-btn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </li>                       
                            </div>
                        </ul>                            
                    </nav>
                </div>
                <!-- menu end here -->
                <div class="header-item item-right">
                    <!-- mobile menu trigger -->
                    <div class="mobile-menu-trigger">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    {{-- main content --}}
    <div class="main-content">
        @yield('content')
    </div>
    {{-- end main content --}}

    <!-- <a data-bs-toggle="modal" href="#addUserView" class="whatsapp-icon">
        <i class="fas fa-envelope"></i>
    </a> -->

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">We're Here for You</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user" id="addUser" method="post">
                        @csrf   
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="recipient-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="recipient-name" class="col-form-label">Mobile Number:</label>
                                <input type="tel" class="form-control" id="mobile_no" name="mobile_no" required>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="recipient-name" class="col-form-label">Email ID:</label>
                                <input type="email" class="form-control" id="email_id" name="email_id" required>
                            </div>

                            <div class="modal-footer mt-30">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
    <script src="//code.tidio.co/qyr53x6ecvh8koeaohwzoqijnioq4yqk.js" async></script>
    <script>
        const menu = document.querySelector(".menu");
        const menuMain = menu.querySelector(".menu-main");
        const goBack = menu.querySelector(".go-back");
        const menuTrigger = document.querySelector(".mobile-menu-trigger");
        const closeMenu = menu.querySelector(".mobile-menu-close");
        let subMenu;
        menuMain.addEventListener("click", (e) =>{
        if(!menu.classList.contains("active")){
            return;
        }
        if(e.target.closest(".menu-item-has-children")){
            const hasChildren = e.target.closest(".menu-item-has-children");
            showSubMenu(hasChildren);
            }
        });
        goBack.addEventListener("click",() =>{
            hideSubMenu();
        })
        menuTrigger.addEventListener("click",() =>{
            toggleMenu();
        })
        closeMenu.addEventListener("click",() =>{
            toggleMenu();
        })
        document.querySelector(".menu-overlay").addEventListener("click",() =>{
            toggleMenu();
        })
        function toggleMenu(){
            menu.classList.toggle("active");
            document.querySelector(".menu-overlay").classList.toggle("active");
        }
        function showSubMenu(hasChildren){
            subMenu = hasChildren.querySelector(".sub-menu");
            subMenu.classList.add("active");
            subMenu.style.animation = "slideLeft 0.5s ease forwards";
            const menuTitle = hasChildren.querySelector("i").parentNode.childNodes[0].textContent;
            menu.querySelector(".current-menu-title").innerHTML=menuTitle;
            menu.querySelector(".mobile-menu-head").classList.add("active");
        }

        function  hideSubMenu(){  
            subMenu.style.animation = "slideRight 0.5s ease forwards";
            setTimeout(() =>{
                subMenu.classList.remove("active");  
            },300); 
            menu.querySelector(".current-menu-title").innerHTML="";
            menu.querySelector(".mobile-menu-head").classList.remove("active");
        }
        
        window.onresize = function(){
            if(this.innerWidth >991){
            if(menu.classList.contains("active")){
                toggleMenu();
            }

            }
        }
    </script>
        <script>
        const menu = document.querySelector(".menu");
        const menuMain = menu.querySelector(".menu-main");
        const goBack = menu.querySelector(".go-back");
        const menuTrigger = document.querySelector(".mobile-menu-trigger");
        const closeMenu = menu.querySelector(".mobile-menu-close");
        let subMenu;
        menuMain.addEventListener("click", (e) =>{
        if(!menu.classList.contains("active")){
            return;
        }
        if(e.target.closest(".menu-item-has-children")){
            const hasChildren = e.target.closest(".menu-item-has-children");
            showSubMenu(hasChildren);
            }
        });
        goBack.addEventListener("click",() =>{
            hideSubMenu();
        })
        menuTrigger.addEventListener("click",() =>{
            toggleMenu();
        })
        closeMenu.addEventListener("click",() =>{
            toggleMenu();
        })
        document.querySelector(".menu-overlay").addEventListener("click",() =>{
            toggleMenu();
        })
        function toggleMenu(){
            menu.classList.toggle("active");
            document.querySelector(".menu-overlay").classList.toggle("active");
        }
        function showSubMenu(hasChildren){
            subMenu = hasChildren.querySelector(".sub-menu");
            subMenu.classList.add("active");
            subMenu.style.animation = "slideLeft 0.5s ease forwards";
            const menuTitle = hasChildren.querySelector("i").parentNode.childNodes[0].textContent;
            menu.querySelector(".current-menu-title").innerHTML=menuTitle;
            menu.querySelector(".mobile-menu-head").classList.add("active");
        }

        function  hideSubMenu(){  
            subMenu.style.animation = "slideRight 0.5s ease forwards";
            setTimeout(() =>{
                subMenu.classList.remove("active");  
            },300); 
            menu.querySelector(".current-menu-title").innerHTML="";
            menu.querySelector(".mobile-menu-head").classList.remove("active");
        }
        
        window.onresize = function(){
            if(this.innerWidth >991){
            if(menu.classList.contains("active")){
                toggleMenu();
            }

            }
        }
    </script>


    <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const menuItem = document.querySelector(".menu-item-has-children > a");
                                        let clickedOnce = false;

                                        menuItem.addEventListener("click", function (e) {
                                            const isMobile = window.innerWidth < 768;
                                            if (isMobile) {
                                                if (!clickedOnce) {
                                                    e.preventDefault(); // prevent link
                                                    clickedOnce = true;

                                                    // Toggle sub-menu
                                                    const submenu = this.nextElementSibling;
                                                    submenu.classList.toggle("show-submenu");

                                                    // Optional: Close when clicking elsewhere
                                                    document.addEventListener("click", function handleOutsideClick(event) {
                                                        if (!submenu.contains(event.target) && event.target !== menuItem) {
                                                            submenu.classList.remove("show-submenu");
                                                            clickedOnce = false;
                                                            document.removeEventListener("click", handleOutsideClick);
                                                        }
                                                    });
                                                } else {
                                                    // second click - allow navigation
                                                    window.location.href = menuItem.href;
                                                }
                                            }
                                        });
                                    });
    </script>
</body>
</html>