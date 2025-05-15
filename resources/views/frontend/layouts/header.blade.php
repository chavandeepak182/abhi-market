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
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img alt="JFinMate" src="{{ asset('assets') }}/images/logo.png" width="150" height="auto">
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
                                    <a href="#">Insights <i class="fas fa-plus"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        @foreach($insightMenuData as $category)
                                            <div class="list-item">
                                                <h4 class="title"><a href="#">{{ $category['category_name'] }}</a></h4>
                                                <ul>
                                                    @foreach($category['insights'] as $insight)
                                                        <li><a href="{{ url('/insights/'.$insight['slug']) }}">{{ $insight['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                        <a class="title" href="{{ url('/insights') }}">View All</a>
                                    </div>
                                </li>


                                <li class="menu-item-has-children">
                                    <a href="#">Industries <i class="fas fa-plus"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        @php
                                            $chunks = $industriesMenuData->chunk(ceil($industriesMenuData->count() / 4));
                                        @endphp

                                        @foreach($chunks as $chunk)
                                            <div class="list-item">
                                                @foreach($chunk as $category)
                                                    <h4 class="title"><a href="#">{{ $category['category_name'] }}</a></h4>
                                                    <ul>
                                                        @foreach($category['industries'] as $industry)
                                                            <li><a href="{{ url('/industries/'.$industry['slug']) }}">{{ $industry['name'] }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </div>
                                        @endforeach
                                        <a class="title" href="{{ url('/industries') }}">View All</a>
                                    </div>
                                </li>


                                <li class="menu-item-has-children">
                                    <a href="#">Services <i class="fas fa-plus"></i></a>
                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                        @if(isset($serviceMenuData) && count($serviceMenuData))
                                            @foreach($serviceMenuData->chunk(3) as $chunk)
                                                <div class="list-item">
                                                    @foreach($chunk as $category)
                                                        <h4 class="title">{{ $category['category_name'] }}</h4>
                                                        <ul>
                                                            @foreach($category['services'] as $service)
                                                                <li><a href="{{ url('/services/'.$service['slug']) }}">{{ $service['name'] }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                        <a class="title" href="{{ url('/services') }}">View All</a>
                                    </div>
                                </li>


                                <li>
                                    <a href="{{ url('/about') }}">About Us</a>
                                </li>
                                
                                <div class="header-item float-end">
                                    <!-- Header Btn Start -->
                                    <div class="header-btn d-inline-flex">
                                        <a href="{{ url('/contact') }}" class="btn-default btn-highlighted">contact us</a>
                                    </div>
                                    <!-- Header Btn End -->
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

        <a data-bs-toggle="modal" href="#addUserView" class="whatsapp-icon">
            <i class="fas fa-envelope"></i>
        </a>

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