@extends('frontend.layouts.header')
@section('title', "Market Research Services - M2 Square Consultancy")
@section('description', "M2 Square Consultancy offers Market Research Services and Industry Analysis across 800+ technologies in 50 countries, delivering insights on emerging markets.")
@section('keywords', "Market Research Services, Industry analysis, market reports , market research")

@section('content')
    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Our Capabilities</h1>
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
                            <h3 class="wow fadeInUp">Capabilities</h3>
                            <h2 class="text-anime-style-2" data-cursor="-opaque">Capabilities <span>We Serve</span></h2>
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
    <!-- Page Services Section Start -->
<div class="page-services">
    <div class="container">
        <div class="row">
            @foreach($allServices as $index => $service)
                @php
                    $serviceName = $service->service_name;
                    $slug = $service->slug;
                    $iconImage = asset('assets/images/' . $slug . '.svg');
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 {{ $index >= 8 ? 'extra-industry d-none' : '' }}">
                    <a href="{{ route('service.details', ['slug' => $slug]) }}" class="industry-card">
                        <div class="icon-wrap text-center">
                            <img src="{{ $iconImage }}" alt="{{ $serviceName }} icon" loading="lazy">
                        </div>
                        <div class="industry-name text-center mt-2">
                            <span>{{ $serviceName }}</span>
                            <div class="underline"></div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if(count($allServices) > 8)
            <div class="what-we-do-btn wow fadeInUp" data-wow-delay="0.6s">
            <a href="javascript:void(0);" class="btn-default" id="loadMoreBtn">Load More</a>
        </div>
        @endif
        
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loadMoreBtn = document.getElementById("loadMoreBtn");
        const extraItems = document.querySelectorAll(".extra-industry");

        loadMoreBtn.addEventListener("click", function () {
            extraItems.forEach(function (item) {
                item.classList.remove("d-none");
            });

            loadMoreBtn.classList.add("d-none"); // hide load more button
        });
    });
</script>

    
@endsection