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
        <div class="custom-pagination-wrapper mt-4" style="display: flex; justify-content: flex-end; padding-right: 20px;">
             {{ $reports->links('vendor.pagination.custom') }}
       </div>



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
                 <h3 class="mb-4">
                    @if(isset($query) && $query)
                        Search Results for: <em>"{{ $query }}"</em>
                    @else
                        All Reports
                    @endif
                </h3>
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
    let activeIndustryId = 'all'; // Default selected industry

    function loadIndustries() {
        fetch(`/get-industries?limit=${limit}`)
            .then(response => response.json())
            .then(data => {
                const industryList = document.getElementById('industry-list');
                industryList.innerHTML = '';

                // Add "All" link
                industryList.innerHTML += `<li><a href="#" class="industry-link ${activeIndustryId === 'all' ? 'active' : ''}" data-id="all">All</a></li>`;

                data.forEach(industry => {
                    const isActive = (activeIndustryId == industry.id) ? 'active' : '';
                    industryList.innerHTML += `<li><a href="#" class="industry-link ${isActive}" data-id="${industry.id}">${industry.industries_name}</a></li>`;
                });

                document.getElementById('loadMore').style.display = (data.length < limit) ? 'none' : 'inline-block';
            });
    }

    function loadReportsByIndustry(industryId) {
        fetch(`/get-reports-by-industry/${industryId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById("reports-container").innerHTML = html;
            });
    }

    // Initial load
    loadIndustries();
    loadReportsByIndustry(activeIndustryId); // Load default "all" reports

    // Load more industries
    document.getElementById('loadMore').addEventListener('click', function () {
        limit += 5;
        loadIndustries();
    });

    // Handle industry tab click (load industries + reports)
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('industry-link')) {
            e.preventDefault();
            activeIndustryId = e.target.dataset.id;
            loadIndustries(); // Re-render the industry list with correct active class
            loadReportsByIndustry(activeIndustryId); // Load the reports
        }
    });
});
</script>
 <div class="custom-pagination-wrapper mt-4" style="padding-bottom: 20px;">
             {{ $reports->links('vendor.pagination.custom') }}
       </div>

@endsection
