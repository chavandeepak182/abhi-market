@extends('backend.layouts.header')
@section('title', "User Management")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="index.html" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Students</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="position-relative text-gray-500 flex-align gap-4 text-13">
                <span class="text-inherit">Sort by: </span>
                <div class="flex-align text-gray-500 text-13 border border-gray-100 rounded-4 ps-20 focus-border-main-600 bg-white">
                    <span class="text-lg"><i class="ph ph-funnel-simple"></i></span>
                    <select class="form-control ps-8 pe-20 py-16 border-0 text-inherit rounded-4 text-center">
                        <option value="1" selected>Popular</option>
                        <option value="1">Latest</option>
                        <option value="1">Trending</option>
                        <option value="1">Matches</option>
                    </select>
                </div>
            </div>
            <div class="flex-align text-gray-500 text-13 border border-gray-100 rounded-4 ps-20 focus-border-main-600 bg-white">
                <span class="text-lg"><i class="ph ph-layout"></i></span>
                <select class="form-control ps-8 pe-20 py-16 border-0 text-inherit rounded-4 text-center" id="exportOptions">
                    <option value="" selected disabled>Export</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                </select>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>
    

    <div class="card overflow-hidden">
        <div class="card-body p-0 overflow-x-auto">
            <table id="studentTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th class="h6 text-gray-300">Students</th>
                        <th class="h6 text-gray-300">Email ID</th>
                        <th class="h6 text-gray-300">Courses</th>
                        <th class="h6 text-gray-300">Certificates Earned</th>
                        <th class="h6 text-gray-300">Status</th>
                        <th class="h6 text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img1.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Jane Cooper</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">12</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">10</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img2.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Guy Hawkins</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">18</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">12</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img3.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Dianne Russell</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">10</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">08</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img4.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Dianne Russell</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">08</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">09</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img5.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Ronald Richards</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">15</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">08</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                Completed
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img2.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Jenny Wilson</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">18</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">09</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                Completed
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img3.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Devon Lane</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">22</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">12</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img4.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Eleanor Pena</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">07</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">08</span>
                        </td>
                        <td>
                                <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                Completed
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img5.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Robert Fox</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">10</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">02</span>
                        </td>
                        <td>
                                <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                Completed
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img1.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Ronald Richards</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">09</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">01</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img2.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Jacob Jones</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">08</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">05</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="flex-align gap-8">
                                <img src="{{ asset('dashboard') }}/assets/images/thumbs/student-img1.png" alt="" class="w-40 h-40 rounded-circle">
                                <span class="h6 mb-0 fw-medium text-gray-300">Ronald Richards</span>
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">example10mail.com</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">09</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">01</span>
                        </td>
                        <td>
                            <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                In Progress
                            </span>
                        </td>
                        <td>
                            <a href="#" class="bg-main-50 text-main-600 py-2 px-14 rounded-pill hover-bg-main-600 hover-text-white">View More</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer flex-between flex-wrap">
            <span class="text-gray-900">Showing 1 to 10 of 12 entries</span>
            <ul class="pagination flex-align flex-wrap">
                <li class="page-item active">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">8</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">9</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">10</a>
                </li>
            </ul>
        </div>
    </div>    
</div>
@endsection