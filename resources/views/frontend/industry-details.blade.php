@extends('frontend.layouts.header')
@section('title', $industries->meta_title)
@section('description', $industries->meta_description)
@section('keywords', $industries->meta_keywords)

@section('content')
<!-- Hero Section Start -->
<div class="hero p-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <!-- Hero Content Start -->
                <div class="hero-content">
                    <!-- Section Title Start -->
                    <div class="section-title dark-section">
                        <p class="wow fadeInUp text-white"><a href="{{ url('/') }}" class="text-white">Home</a> / <a href="#" class="text-white">{{ $industries->industries_name }}</a></p>
                       @php
                            $words = explode(' ', $industries->industries_name);
                        @endphp
                        <h1 class="text-anime-style-2" data-cursor="-opaque" style="white-space: nowrap;">
                            <span>{{ $words[0] }}</span> {{ implode(' ', array_slice($words, 1)) }}
                        </h1>

                    </div>
                    <!-- Section Title End -->
                </div>
                <!-- Hero Content End -->
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Overview Section Start -->
<div class="page-service-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Service Sidebar Start -->
                <div class="service-sidebar">
                    <!-- Service Category List Start -->
                    <div class="service-catagery-list wow fadeInUp">
                        <h3>Our Industries</h3>
                        <ul id="industry-list" class="mb-3">
                            {{-- Insights will be loaded here via AJAX --}}
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
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" required>
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
                            @if(!empty($industries->image) && file_exists(public_path($industries->image)))
                                <img src="{{ asset($industries->image) }}" alt="{{ $industries->industries_name }}">
                            @else
                                <img src="{{ asset('assets/images/default-service.jpg') }}" alt="Default Image">
                            @endif
                        </figure>
                    </div>
                    <!-- Case Study Image End -->
                    <div class="service-entry">
                        <p class="wow fadeInUp">{!! $industries->description !!}</p>

                        <!-- Case Study List Video Start -->
                        <div class="service-list-video">
                            <!-- Case Study List Start -->
                            <div class="service-entry-list wow fadeInUp" data-wow-delay="0.2s">
                                
                            </div>
                            <!-- Case Study List End -->
                        </div>
                        <!-- Case Study List Video End -->
                    </div>
                    <!-- Case Study Entry End -->
                </div>
                <!-- Case Study Single Content End -->
            </div>
            @if($reports->count())
                <div class="mt-5">
                    <h3 class="mb-4">Related Reports</h3>

                    @foreach($reports as $report)
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <a href="{{ route('reports.details', $report->slug) }}" class="text-decoration-none text-dark">
                                        {{ $report->report_title }}
                                    </a>
                                </h5>

                                <p class="card-text">
                                    {!! Str::limit(strip_tags($report->description), 200) !!} 
                                    <a href="{{ route('reports.details', $report->slug) }}" class="text-info">Read More <i class="fa fa-external-link-alt"></i></a>
                                </p>

                                <p class="small text-muted mb-3">
                                    {{ \Carbon\Carbon::parse($report->publish_date)->format('F, Y') }} |
                                    Base Year: {{ date('Y', strtotime($report->publish_date . ' -1 year')) }} 
                                </p>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('request.sample', ['slug' => $report->slug, 'id' => $report->id]) }}" class="btn btn-sm btn-info">Request Sample</a>
                                    <!-- <a href="{{ url('/purchase') }}" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart me-1"></i> Buy Now</a> -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Overview Section end -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let limit = 5;

        function loadIndustries() {
            fetch(`/get-industries?limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    const industryList = document.getElementById('industry-list');
                    industryList.innerHTML = '';

                    data.forEach(industry => {
                        const industryUrl = `/industries/${industry.slug}`;
                        industryList.innerHTML += `<li><a href="${industryUrl}">${industry.industries_name}</a></li>`;
                    });

                    if (data.length < limit) {
                        document.getElementById('loadMore').style.display = 'none';
                    } else {
                        document.getElementById('loadMore').style.display = 'inline-block';
                    }
                });
        }

        loadIndustries(); // Call correct function

        document.getElementById('loadMore').addEventListener('click', function () {
            limit += 5;
            loadIndustries(); // Call correct function
        });
    });
</script>


  <div class="custom-pagination-wrapper mt-4">
    {{ $reports->links('vendor.pagination.custom') }}
   </div>

    


@endsection