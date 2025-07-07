@extends('frontend.layouts.header')
@section('title', $report->meta_title)
@section('description', $report->meta_description)
@section('keywords', $report->meta_keywords)

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    @php
                        $words = explode(' ', $report->report_name);
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
        

                            <div class="report-card">
                                <h3>📊 Our Reports</h3>
                                <p>Explore industry insights and stay ahead in the market.</p>
                                                   <a href="{{ url('/purchase') }}" class="btn-default py-2">Buy Now</a>

                                                        <div id="msgSubmit" class="h3 hidden"></div> 
                                                    
                                                                
                            </div>  
                                
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
                        <!-- <figure class="image-anime reveal">
                            @if($report->image)
                                <img src="{{ asset($report->image) }}" alt="{{ $report->report_name }}">
                            @else
                                <img src="{{ asset('assets/images/default-service.jpg') }}" alt="Default Image">
                            @endif
                        </figure> -->
                    </div>
                    <!-- Case Study Image End -->

                    <!-- Case Study Entry Start -->
                    <div class="service-entry">
                        <h1 class="wow fadeInUp">{!! $report->report_title !!}</h1>
                        <br>

                        
                <div class="tabs">
                  @if(!empty($report->description))
                    <button class="tab-button active" data-tab="desc">Description</button>
                  @endif

                  @if(!empty($report->toc))
                    <button class="tab-button {{ empty($report->description) ? 'active' : '' }}" data-tab="toc">Table Of Contents</button>
                  @endif

                  {{-- Static Tabs --}}
                  <button class="tab-button {{ empty($report->description) && empty($report->toc) ? 'active' : '' }}" data-tab="method">Research Methodology</button>
                  <!-- <button class="tab-button" data-tab="sample">Request Free Sample PDF</button> -->
                </div>

                  <div class="tab-content-wrapper">
                    @if(!empty($report->description))
                      <div class="tab-content active" id="desc">
                        <h2>Description</h2>
                        <p class="wow fadeInUp">{!! $report->description !!}</p>
                      </div>
                    @endif

                  @if(!empty($report->toc))
                    <div class="tab-content {{ empty($report->description) ? 'active' : '' }}" id="toc">
                      <!-- <h2>Table Of Contents</h2> -->
                      <div class="wow fadeInUp">{!! $report->toc !!}</div>
                    </div>
                  @endif



                    {{-- Static Tab Contents --}}
                    <div class="tab-content {{ empty($report->description) && empty($report->toc) ? 'active' : '' }}" id="method">
                      <h2>Research Methodology</h2>
                      <p class="wow fadeInUp">This is the Research Methodology content.</p>
                    </div>

                    <!-- <div class="tab-content" id="sample">
                      <h2>Request Free Sample PDF</h2>
                      <p class="wow fadeInUp">This is the sample request section.</p>
                    </div> -->
                  </div>

                </div><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                  document.addEventListener("DOMContentLoaded", function () {
                    const tabButtons = document.querySelectorAll(".tab-button");
                    const tabContents = document.querySelectorAll(".tab-content");

                    tabButtons.forEach((button) => {
                      button.addEventListener("click", () => {
                        const target = button.getAttribute("data-tab");

                        // Remove active class from all buttons and contents
                        tabButtons.forEach((btn) => btn.classList.remove("active"));
                        tabContents.forEach((content) => content.classList.remove("active"));

                        // Add active class to clicked button and corresponding content
                        button.classList.add("active");
                        document.getElementById(target).classList.add("active");
                      });
                    });
                  });
                </script>





   
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

        function loadReports() {
            fetch(`/get-reports?limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    const reportList = document.getElementById('report-list');
                    reportList.innerHTML = '';

                    data.forEach(report => {
                        const reportUrl = `/reports/${report.slug}`;
                        reportList.innerHTML += `<li><a href="${reportUrl}">${report.report_name}</a></li>`;
                    });

                    if (data.length < limit) {
                        document.getElementById('loadMore').style.display = 'none';
                    }
                });
        }

        loadReports();

        document.getElementById('loadMore').addEventListener('click', function () {
            limit += 5;
            loadReports();
        });
    });
</script>
@endsection