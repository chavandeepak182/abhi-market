@extends('frontend.layouts.header')
@section('title', "Industries")
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
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Industries</h1>
                        <!-- <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">our services</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
     <!-- What We Do Section Start -->
    <div class="what-we-do">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- What We Do Content Start -->
                    <div class="what-we-do-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Industries</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Industries <span>We Serve</span></h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">We cater to a wide range of industries by delivering customized solutions, strategic insights, and innovative support that help organizations grow, adapt, and lead in their respective sectors. Here’s a brief overview of key industries we work with.</p>
                        </div>
                        <!-- Section Title End -->

                        


                    </div>
                    <!-- What We Do Content End -->
                </div>
                
               
            </div>
        </div>
    </div>
    <!-- What We Do Section End -->
             <!-- industry start -->
<div class="container">
    <div class="row industries-grid">
        @foreach($allIndustries as $index => $industry)
            @php
                $industryName = $industry->industries_name;
                $slug = $industry->slug;
                $iconImage = asset('assets/images/' . $slug . '.svg');
            @endphp
                
            <div class="industry-column {{ $index >= 8 ? 'extra-industry d-none' : '' }}">
                <a href="{{ route('industries.details', ['slug' => $slug]) }}" class="industry-card">
                    <div class="icon-wrap">
                        <img src="{{ $iconImage }}" alt="{{ $industryName }} icon" loading="lazy">
                    </div>
                    <div class="industry-name">
                        <span>{{ $industryName }}</span>
                        <div class="underline"></div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if(count($allIndustries) > 8)
        <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
            <a href="javascript:void(0);" class="btn-default" id="loadMoreBtn">Load More</a>
        </div>
    @endif
</div>
<!-- industry end -->
 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const loadMoreBtn = document.getElementById("loadMoreBtn");
        const extraIndustries = document.querySelectorAll(".extra-industry");
        const contactNowBtn = document.getElementById("contactNowBtn");

        loadMoreBtn.addEventListener("click", function () {
            extraIndustries.forEach(function (item) {
                item.classList.remove("d-none");
            });

            loadMoreBtn.classList.add("d-none");
            contactNowBtn.classList.remove("d-none");
        });
    });
</script>


                            

<br> <br>  <br>                         

@endsection