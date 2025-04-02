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
                <img src="{{ asset('dashboard') }}/assets/images/thumbs/auth-img3.png" alt="">
            </div>
            <div class="auth-right py-40 px-24 flex-center flex-column">
                <div class="auth-right__inner mx-auto w-100">
                    <a href="{{ url('/') }}" class="mb-30">
                        <img src="{{ asset('assets') }}/images/logo.png" alt="">
                    </a>
                    <h2 class="mb-8">Reset Password</h2>
                    <p class="text-gray-600 text-15 mb-32">For <span class="fw-medium"> &lt;exampleinfo@mail.com&gt;</span> </p>

                    <form action="#">
                        
                        <div class="mb-24">
                            <label for="new-password" class="form-label mb-8 h6">New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control py-11 ps-40" id="new-password" placeholder="Enter New Password" value="password">
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-lock"></i></span>
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash" id="#current-password"></span>
                            </div>
                        </div>
                        <div class="mb-24">
                            <label for="confirm-password" class="form-label mb-8 h6">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control py-11 ps-40" id="confirm-password" placeholder="Enter Confirm Password" value="password">
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-lock"></i></span>
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash" id="#confirm-password"></span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-main rounded-pill w-100">Set New Password</button>

                        <a href="{{ url('/login') }}" class="mt-24 text-main-600 flex-align gap-8 justify-content-center"> <i class="ph ph-arrow-left d-flex"></i> Back To Login</a>
                        
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
        <script src="../../cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
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