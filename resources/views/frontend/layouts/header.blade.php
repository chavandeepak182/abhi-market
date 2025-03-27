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
        <header class="header">
            <div class="container">
                <div class="row v-center align-items-center">
                <div class="header-item item-left">
                    <div class="logo">
                        <a href="{{ url('/') }}">logo</a>
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
                                    <a href="{{ url('/insights') }}">Insights <i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        <div class="list-item">
                                            <h4 class="title">Men's Fashion</h4>
                                            <ul>
                                                <li><a href="#">T-Shirts</a></li>
                                                <li><a href="#">Jeans</a></li>
                                                <li><a href="#">Suit</a></li>
                                                <li><a href="#">Kurta</a></li>
                                                <li><a href="#">Watch</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Women's Fashion</h4>
                                            <ul>
                                                <li><a href="#">Sarees</a></li>
                                                <li><a href="#">Sandals</a></li>
                                                <li><a href="#">Watchs</a></li>
                                                <li><a href="#">Shoes</a></li>
                                            </ul>
                                            <h4 class="title">Furniture</h4>
                                            <ul>
                                                <li><a href="#">Chairs</a></li>
                                                <li><a href="#">Tables</a></li>
                                                <li><a href="#">Doors</a></li>
                                                <li><a href="#">Bed</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Home, Kitchen</h4>
                                            <ul>
                                                <li><a href="#">Kettle</a></li>
                                                <li><a href="#">Toaster</a></li>
                                                <li><a href="#">Dishwasher</a></li>
                                                <li><a href="#">Microwave oven</a></li>
                                                <li><a href="#">Pitcher</a></li>
                                                <li><a href="#">Blender</a></li>
                                                <li><a href="#">Colander</a></li>
                                                <li><a href="#">Tureen</a></li>
                                                <li><a href="#">Cookware</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <img src="https://images.unsplash.com/photo-1549497538-303791108f95?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80" alt="Chair"/>
                                        </div>
                                    </div>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="{{ url('/industries') }}">Industries <i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        <div class="list-item">
                                            <h4 class="title">Men's Fashion</h4>
                                            <ul>
                                                <li><a href="#">T-Shirts</a></li>
                                                <li><a href="#">Jeans</a></li>
                                                <li><a href="#">Suit</a></li>
                                                <li><a href="#">Kurta</a></li>
                                                <li><a href="#">Watch</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Women's Fashion</h4>
                                            <ul>
                                                <li><a href="#">Sarees</a></li>
                                                <li><a href="#">Sandals</a></li>
                                                <li><a href="#">Watchs</a></li>
                                                <li><a href="#">Shoes</a></li>
                                            </ul>
                                            <h4 class="title">Furniture</h4>
                                            <ul>
                                                <li><a href="#">Chairs</a></li>
                                                <li><a href="#">Tables</a></li>
                                                <li><a href="#">Doors</a></li>
                                                <li><a href="#">Bed</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Home, Kitchen</h4>
                                            <ul>
                                                <li><a href="#">Kettle</a></li>
                                                <li><a href="#">Toaster</a></li>
                                                <li><a href="#">Dishwasher</a></li>
                                                <li><a href="#">Microwave oven</a></li>
                                                <li><a href="#">Pitcher</a></li>
                                                <li><a href="#">Blender</a></li>
                                                <li><a href="#">Colander</a></li>
                                                <li><a href="#">Tureen</a></li>
                                                <li><a href="#">Cookware</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <img src="https://images.unsplash.com/photo-1549497538-303791108f95?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80" alt="Chair"/>
                                        </div>
                                    </div>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="{{ url('/services') }}">Services <i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        <div class="list-item">
                                            <h4 class="title">Men's Fashion</h4>
                                            <ul>
                                                <li><a href="#">T-Shirts</a></li>
                                                <li><a href="#">Jeans</a></li>
                                                <li><a href="#">Suit</a></li>
                                                <li><a href="#">Kurta</a></li>
                                                <li><a href="#">Watch</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                            <h4 class="title">Beauty</h4>
                                            <ul>
                                                <li><a href="#">Moisturizer</a></li>
                                                <li><a href="#">Face powder</a></li>
                                                <li><a href="#">Lipstick</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Women's Fashion</h4>
                                            <ul>
                                                <li><a href="#">Sarees</a></li>
                                                <li><a href="#">Sandals</a></li>
                                                <li><a href="#">Watchs</a></li>
                                                <li><a href="#">Shoes</a></li>
                                            </ul>
                                            <h4 class="title">Furniture</h4>
                                            <ul>
                                                <li><a href="#">Chairs</a></li>
                                                <li><a href="#">Tables</a></li>
                                                <li><a href="#">Doors</a></li>
                                                <li><a href="#">Bed</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <h4 class="title">Home, Kitchen</h4>
                                            <ul>
                                                <li><a href="#">Kettle</a></li>
                                                <li><a href="#">Toaster</a></li>
                                                <li><a href="#">Dishwasher</a></li>
                                                <li><a href="#">Microwave oven</a></li>
                                                <li><a href="#">Pitcher</a></li>
                                                <li><a href="#">Blender</a></li>
                                                <li><a href="#">Colander</a></li>
                                                <li><a href="#">Tureen</a></li>
                                                <li><a href="#">Cookware</a></li>
                                            </ul>
                                        </div>
                                        <div class="list-item">
                                            <img src="https://images.unsplash.com/photo-1549497538-303791108f95?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80" alt="Chair"/>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <a href="{{ url('/about') }}">About Us</a>
                                </li>                                
                            </ul>
                        </nav>
                    </div>
                    <!-- menu end here -->
                    <div class="header-item item-right">
                        <!-- Header Btn Start -->
                        <div class="header-btn d-inline-flex">
                            <a href="{{ url('/contact') }}" class="btn-default btn-highlighted">contact us</a>
                        </div>
                        <!-- Header Btn End -->
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

        @include('frontend.layouts.footer')

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
    </body>
</html>