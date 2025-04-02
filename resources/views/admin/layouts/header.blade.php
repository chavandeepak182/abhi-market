<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Title -->
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/images/logo/favicon.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/bootstrap.min.css">
        <!-- file upload -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/file-upload.css">
        <!-- file upload -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/plyr.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
        <!-- full calendar -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/full-calendar.css">
        <!-- jquery Ui -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/jquery-ui.css">
        <!-- editor quill Ui -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/editor-quill.css">
        <!-- apex charts Css -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/apexcharts.css">
        <!-- calendar Css -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/calendar.css">
        <!-- jvector map Css -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/jquery-jvectormap-2.0.5.css">
        <!-- Main css -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/main.css">
        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head> 
    <body>
        <div class="preloader">
            <div class="loader"></div>
        </div>

        <div class="side-overlay"></div>
        
        <aside class="sidebar">
            <!-- sidebar close btn -->
            <button type="button" class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i class="ph ph-x"></i></button>
            <!-- sidebar close btn -->
            
            <a href="{{ url('/') }}" class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
                <img src="{{ asset('assets') }}/images/logo.png" alt="Logo" width="120" height="20">
            </a>

            <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
                <div class="p-20 pt-10">
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu__item {{ Request::is('admin/dashboard') ? 'activePage' : '' }}">
                            <a href="{{ url('admin/dashboard') }}" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-squares-four"></i></span>
                                <span class="text">Dashboard</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-menu__item has-dropdown {{ Request::is('admin/allUsers') ? 'activePage' : '' }}">
                            <a href="javascript:void(0)" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-graduation-cap"></i></span>
                                <span class="text">Users</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li class="sidebar-submenu__item {{ Request::is('admin/allUsers') ? 'activePage' : '' }}">
                                    <a href="{{ url('admin/allUsers') }}" class="sidebar-submenu__link"> All Users </a>
                                </li>
                                <li class="sidebar-submenu__item {{ Request::is('admin/addUser') ? 'activePage' : '' }}">
                                    <a href="{{ url('admin/addUser') }}" class="sidebar-submenu__link"> Add New User </a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="#" class="sidebar-submenu__link"> Create Course </a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="sidebar-menu__item {{ Request::is('admin/allUsers') ? 'activePage' : '' }}">
                            <a href="{{ url('admin/allUsers') }}" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-users-three"></i></span>
                                <span class="text">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item {{ Request::is('admin/enquiries') ? 'activePage' : '' }}">
                            <a href="{{ url('admin/enquiries') }}" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-clipboard-text"></i></span>
                                <span class="text">All Enquiries</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-users"></i></span>
                                <span class="text">Mentors</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-bookmarks"></i></span>
                                <span class="text">Resources</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-chats-teardrop"></i></span>
                                <span class="text">Messages</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-chart-bar"></i></span>
                                <span class="text">Analytics</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-calendar-dots"></i></span>
                                <span class="text">Events</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-books"></i></span>
                                <span class="text">Library</span>
                            </a>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="#" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-coins"></i></span>
                                <span class="text">Pricing</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-menu__item">
                            <span class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Settings</span>
                        </li>
                        <li class="sidebar-menu__item">
                            <a href="setting.html" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-gear"></i></span>
                                <span class="text">Account Settings</span>
                            </a>
                        </li>

                        <li class="sidebar-menu__item has-dropdown">
                            <a href="javascript:void(0)" class="sidebar-menu__link">
                                <span class="icon"><i class="ph ph-shield-check"></i></span>
                                <span class="text">Authetication</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li class="sidebar-submenu__item">
                                    <a href="sign-in.html" class="sidebar-submenu__link">Sign In</a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="sign-up.html" class="sidebar-submenu__link">Sign Up</a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="forgot-password.html" class="sidebar-submenu__link">Forgot Password</a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="reset-password.html" class="sidebar-submenu__link">Reset Password</a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="verify-email.html" class="sidebar-submenu__link">Verify Email</a>
                                </li>
                                <li class="sidebar-submenu__item">
                                    <a href="two-step-verification.html" class="sidebar-submenu__link">Two Step Verification</a>
                                </li>
                            </ul>
                        </li>  -->                      
                    </ul>
                </div>
                <!-- <div class="p-20 pt-80">
                    <div class="bg-main-50 p-20 pt-0 rounded-16 text-center mt-74">
                        <span class="border border-5 bg-white mx-auto border-primary-50 w-114 h-114 rounded-circle flex-center text-success-600 text-2xl translate-n74">
                            <img src="{{ asset('dashboard') }}/assets/images/icons/certificate.png" alt="" class="centerised-img">
                        </span>
                        <div class="mt-n74">
                            <h5 class="mb-4 mt-22">Get Pro Certificate</h5>
                            <p class="">Explore 400+ courses with lifetime members</p>
                            <a href="pricing-plan.html" class="btn btn-main mt-16 rounded-pill">Get Access</a>
                        </div>
                    </div>
                </div> -->
            </div>
        </aside> 

        <div class="dashboard-main-wrapper">
            <div class="top-navbar flex-between gap-16">
                <div class="flex-align gap-16">
                    <!-- Toggle Button Start -->
                    <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i class="ph ph-list"></i></button>
                    <!-- Toggle Button End -->
                    
                    <form action="#" class="w-350 d-sm-block d-none">
                        <div class="position-relative">
                            <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none"><i class="ph ph-magnifying-glass"></i></button> 
                            <input type="text" class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15" placeholder="Search...">
                        </div>
                    </form>
                </div>

                <div class="flex-align gap-16">
                    <div class="flex-align gap-8">
                        <!-- Notification Start -->
                        <div class="dropdown">
                            <button class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="position-relative">
                                    <i class="ph ph-bell"></i>
                                    <span class="alarm-notify position-absolute end-0"></span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                                <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
                                    <div class="card-body p-0">
                                        <div class="py-8 px-24 bg-main-600">
                                            <div class="flex-between">
                                                <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                                                <div class="flex-align gap-12">
                                                    <button type="button" class="bg-white rounded-6 text-sm px-8 py-2 hover-text-primary-600"> New </button>
                                                    <button type="button" class="close-dropdown hover-scale-1 text-xl text-white"><i class="ph ph-x"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-24 max-h-270 overflow-y-auto scroll-sm">
                                            <div class="d-flex align-items-start gap-12">
                                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/notification-img1.png" alt="" class="w-48 h-48 rounded-circle object-fit-cover">
                                                <div class="border-bottom border-gray-100 mb-24 pb-24">
                                                    <div class="flex-align gap-4">
                                                        <a href="#" class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600 text-line-2">Ashwin Bose is requesting access to Design File - Final Project. </a>
                                                        <!-- Three Dot Dropdown Start -->
                                                        <div class="dropdown flex-shrink-0">
                                                            <button class="text-gray-200 rounded-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ph-fill ph-dots-three-outline"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu--md border-0 bg-transparent p-0">
                                                                <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                                                    <div class="card-body p-12">
                                                                        <div class="max-h-200 overflow-y-auto scroll-sm pe-8">
                                                                            <ul>
                                                                                <li class="mb-0">
                                                                                    <a href="#" class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                        <span class="text">Mark as read</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="mb-0">
                                                                                    <a href="#" class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                        <span class="text">Delete Notification</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="mb-0">
                                                                                    <a href="#" class="py-6 text-15 px-8 hover-bg-gray-50 text-gray-300 rounded-8 fw-normal text-xs d-block">
                                                                                        <span class="text">Report</span>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Three Dot Dropdown End -->
                                                    </div>
                                                    <div class="flex-align gap-6 mt-8">
                                                        <img src="{{ asset('dashboard') }}/assets/images/icons/google-drive.png" alt="">
                                                        <div class="flex-align gap-4">
                                                            <p class="text-gray-900 text-sm text-line-1">Design brief and ideas.txt</p>
                                                            <span class="text-xs text-gray-200 flex-shrink-0">2.2 MB</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-16 flex-align gap-8">
                                                        <button type="button" class="btn btn-main py-8 text-15 fw-normal px-16">Accept</button>
                                                        <button type="button" class="btn btn-outline-gray py-8 text-15 fw-normal px-16">Decline</button>
                                                    </div>
                                                    <span class="text-gray-200 text-13 mt-8">2 mins ago</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-12">
                                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/notification-img2.png" alt="" class="w-48 h-48 rounded-circle object-fit-cover">
                                                <div class="">
                                                    <a href="#" class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600 text-line-2">Patrick added a comment on Design Assets - Smart Tags file:</a>
                                                    <span class="text-gray-200 text-13">2 mins ago</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline"> View All </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notification Start -->
                    </div>

                    <!-- User Profile Start -->
                    <div class="dropdown">
                        <button class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="position-relative">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/user-img.png" alt="Image" class="h-32 w-32 rounded-circle">
                                <span class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                                <div class="card-body">
                                    <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                        <img src="{{ asset('dashboard') }}/assets/images/thumbs/user-img.png" alt="" class="w-54 h-54 rounded-circle">
                                        <div class="">
                                            <h4 class="mb-0">Michel John</h4>
                                            <p class="fw-medium text-13 text-gray-200">examplemail@mail.com</p>
                                        </div>
                                    </div>
                                    <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                        <li class="mb-4">
                                            <a href="{{ url('/logout') }}" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                                <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-door-open"></i></span>
                                                <span class="text">Logout</span>
                                            </a>
                                        </li>
                                        <li class="mb-4">
                                            <a href="{{ url('/reset') }}" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                                <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-pen"></i></span>
                                                <span class="text">Reset Password</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- User Profile Start -->
                </div>
            </div>

            @yield('content')

            @include('admin.layouts.footer')  
    </body>
</html>