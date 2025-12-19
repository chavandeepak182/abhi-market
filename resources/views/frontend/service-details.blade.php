@extends('frontend.layouts.header')
@section('title', $service->meta_title)
@section('description', $service->meta_description)
@section('keywords', $service->meta_keywords)

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    @php
                        $words = explode(' ', $service->service_name);
                    @endphp
                    
                    <h1 class="text-anime-style-2" data-cursor="-opaque">
                        <span>{{ $words[0] }}</span>
                        {{ implode(' ', array_slice($words, 1)) }}
                    </h1>
                    <!-- <nav class="wow fadeInUp">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">home</a></li>
                            <li class="breadcrumb-item"><a href="services.html">services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Investment management</li>
                        </ol>
                    </nav> -->
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Page Service Single Start -->
<div class="page-service-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Service Sidebar Start -->
                <div class="service-sidebar">
                    <!-- Service Category List Start -->
                    <div class="service-catagery-list wow fadeInUp">
                        <h3>Our Services</h3>
                        <ul id="service-list" class="mb-3">
                            {{-- Services will be loaded here via AJAX --}}
                        </ul>
                        <button id="loadMore" class="btn btn-primary">Load More</button>
                    </div>
                    <!-- Service Category List End -->

                    <!-- Sidebar Cta Box Start -->
                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.25s">
                        <!-- CTA Contact Content Start -->
                        <div class="cta-box-content">
                            <h3>Need Help? We Are Here To Help You</h3>
                        </div>
                        <!-- CTA Contact Content End -->

                        <!-- CTA Contact Info Start -->
                        <div class="cta-contact-info">
                            <!-- CTA Info Item Start -->
                            <div class="cta-info-item">
                                <form id="enquiryctForm" action="{{ route('enquiry.store') }}" method="POST" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required data-error="Please Enter Your Name">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group col-md-12 mb-4">
                                            <input type="text" name="contact" id="contact" class="form-control" placeholder="Phone Number" required>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group col-md-12 mb-4">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Official Email" required>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn-default py-2">send</button>
                                            <div id="msgSubmit" class="h3 hidden"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- CTA Info Item End -->
                        </div>
                        <!-- CTA Contact Info End -->
                    </div>
                    <!-- Sidebar Cta Box End -->
                </div>
                <!-- Service Sidebar End -->
            </div>

            <div class="col-lg-8">
                <!-- Case Study Single Content Start -->
                <div class="service-single-content">
                    <!-- Case Study Image Start -->
                    <div class="service-featured-image">
                        <figure class="image-anime reveal">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" alt="{{ $service->service_name }}">
                            @else
                                <img src="{{ asset('assets/images/default-service.jpg') }}" alt="Default Image">
                            @endif
                        </figure>
                    </div>
                    <!-- Case Study Image End -->

                    <!-- Case Study Entry Start -->
                    <div class="service-entry">
                        <p class="wow fadeInUp">{!! $service->description !!}</p>

                        

                       
                        

                        
                    </div>
                    <!-- Case Study Entry End -->

                   
                </div>
                <!-- Case Study Single Content End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Service Single End -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let limit = 5;

        function loadServices() {
            fetch(`/get-services?limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    const serviceList = document.getElementById('service-list');
                    serviceList.innerHTML = '';

                    data.forEach(service => {
                        const serviceUrl = `/services/${service.slug}`;
                        serviceList.innerHTML += `<li><a href="${serviceUrl}">${service.service_name}</a></li>`;
                    });

                    if (data.length < limit) {
                        document.getElementById('loadMore').style.display = 'none';
                    }
                });
        }

        loadServices();

        document.getElementById('loadMore').addEventListener('click', function () {
            limit += 5;
            loadServices();
        });
    });
</script>
@endsection