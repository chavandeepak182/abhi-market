@extends('frontend.layouts.header')

@section('title', 'All Reports')
@section('description', 'Explore the latest market research reports across industries.')
@section('keywords', 'market reports, industry analysis, research insights')

@section('content')

<!-- Hero Section Start -->
<div class="hero p-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <div class="section-title dark-section">
                        <p class="wow fadeInUp text-white">
                            <a href="{{ url('/') }}" class="text-white">Home</a> / <a href="#" class="text-white">Reports</a>
                        </p>
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Latest Reports</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Reports Section Start -->
<div class="page-service-single">
    <div class="container">
        <div class="row">

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <div class="service-sidebar">

                    <!-- Industry AJAX List -->
                    <div class="service-catagery-list wow fadeInUp">
                        <h3>Our Industries</h3>
                        <ul id="industry-list" class="mb-3">
                            {{-- Industries will load here via AJAX --}}
                        </ul>
                        <button id="loadMore" class="btn btn-primary">Load More</button>
                    </div>


                    <!-- Inquiry CTA -->
                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.25s">
                        <div class="cta-box-content">
                            <h3>Need Help? We Are Here To Help You</h3>
                        </div>
                        <div class="cta-contact-info">
                            <div class="cta-info-item">
                                <form action="{{ route('enquiry.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" name="contact" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                    <button type="submit" class="btn-default py-2">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Sidebar End -->

            <!-- Reports List Start -->
            <div class="col-lg-8">
                <h3 class="mb-4">All Reports</h3>
                <div id="reports-container">
                    @foreach($reports as $report)
                        @include('frontend.reports.reports-card', ['report' => $report])
                    @endforeach
                </div>
            </div>
            <!-- Reports List End -->

        </div>
    </div>
</div>

<!-- Industries AJAX Script -->
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
                    industryList.innerHTML += `<li><a href="#" class="industry-link" data-id="${industry.id}">${industry.industries_name}</a></li>`;
                });

                document.getElementById('loadMore').style.display = (data.length < limit) ? 'none' : 'inline-block';
            });
    }

    loadIndustries();

    document.getElementById('loadMore').addEventListener('click', function () {
        limit += 5;
        loadIndustries();
    });
});
</script>
<script>
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("industry-link")) {
        e.preventDefault();
        const industryId = e.target.dataset.id;

        fetch(`/get-reports-by-industry/${industryId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById("reports-container").innerHTML = html;
            });
    }
});
</script>

@endsection
