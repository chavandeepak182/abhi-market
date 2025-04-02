<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Title -->
        <title>Sign Up</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/images/logo/favicon.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/bootstrap.min.css">
        <!-- file upload -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/file-upload.css">
        <!-- file upload -->
        <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/plyr.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../../cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
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
    </head> 
    <body>
        <div class="preloader">
            <div class="loader"></div>
        </div>

        <div class="side-overlay"></div>

        <section class="auth d-flex">
            <div class="auth-left bg-main-50 flex-center p-24">
                <img src="{{ asset('dashboard') }}/assets/images/thumbs/auth-img1.png" alt="">
            </div>
            <div class="auth-right py-40 px-24 flex-center flex-column">
                <div class="auth-right__inner mx-auto w-100">
                    <a href="#" class="mb-32">
                        <img src="{{ asset('assets') }}/images/logo.png" alt="">
                    </a>
                    <h2 class="mb-8">Welcome to Back! &#128075;</h2>
                    <p class="text-gray-600 text-15 mb-32">Please sign in to your account and start the adventure</p>

                    <form action="{{Route('userLogin')}}" method="post">
                        @csrf
                        <div class="mb-24">
                            <label for="fname" class="form-label mb-8 h6">Email</label>
                            <div class="position-relative">
                                <input type="email" name="email" class="form-control py-11 ps-40" id="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-user"></i></span>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-24">
                            <label for="current-password" class="form-label mb-8 h6">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="form-control py-11 ps-40" id="password" placeholder="Enter Password">
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash" id="#current-password"></span>
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-lock"></i></span>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-32 flex-between flex-wrap gap-8">
                            <div class="form-check mb-0 flex-shrink-0">
                                <input class="form-check-input flex-shrink-0 rounded-4" type="checkbox" value="" id="remember">
                                <label class="form-check-label text-15 flex-grow-1" for="remember">Remember Me </label>
                            </div>
                            <a href="{{ url('/reset') }}" class="text-main-600 hover-text-decoration-underline text-15 fw-medium">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-main rounded-pill w-100">Sign In</button>
                        <p class="mt-32 text-gray-600 text-center">New on our platform?
                            <a href="{{ url('/signup') }}" class="text-main-600 hover-text-decoration-underline">Create an account</a>
                        </p>                        
                    </form>
                </div>
            </div>
        </section>

        <!-- Jquery js -->
        <script src="{{ asset('dashboard') }}/assets/js/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap Bundle Js -->
        <script src="{{ asset('dashboard') }}/assets/js/boostrap.bundle.min.js"></script>
        <!-- Phosphor Js -->
        <script src="{{ asset('dashboard') }}/assets/js/phosphor-icon.js"></script>
        <!-- file upload -->
        <script src="{{ asset('dashboard') }}/assets/js/file-upload.js"></script>
        <!-- file upload -->
        <script src="{{ asset('dashboard') }}/assets/js/plyr.js"></script>
        <!-- dataTables -->
        <script src="{{ asset('dashboard') }}/assets../../cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
        <!-- full calendar -->
        <script src="{{ asset('dashboard') }}/assets/js/full-calendar.js"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('dashboard') }}/assets/js/jquery-ui.js"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('dashboard') }}/assets/js/editor-quill.js"></script>
        <!-- apex charts -->
        <script src="{{ asset('dashboard') }}/assets/js/apexcharts.min.js"></script>
        <!-- jvectormap Js -->
        <script src="{{ asset('dashboard') }}/assets/js/jquery-jvectormap-2.0.5.min.js"></script>
        <!-- jvectormap world Js -->
        <script src="{{ asset('dashboard') }}/assets/js/jquery-jvectormap-world-mill-en.js"></script>
        
        <!-- main js -->
        <script src="{{ asset('dashboard') }}/assets/js/main.js"></script>
    </body>
</html>