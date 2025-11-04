@extends('frontend.layouts.header')

@section('title', 'M2 Square Consultancy - All Reports')
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
                        <ul id="industry-list" class="mb-3" @if(isset($query) && $query) style="pointer-events: none; opacity: 0.5;" @endif>

                        @if(!isset($query) || !$query)
                            <button id="loadMore" class="btn btn-primary">Load More</button>
                        @endif
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
                    <div id="reports-container">
          @include('frontend.reports.ajax-reports-list', ['reports' => $reports])
        </div>

                    
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

    

    // Initial load
    loadIndustries();

    @if(!isset($query) || !$query)
        loadReportsByIndustry(activeIndustryId); // Load default "all" reports only if not a search
    @endif

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
<!-- ✅ AJAX Pagination (for All Reports page only) -->
<script>
$(document).on('click', '#reports-pagination a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');
    if (!url) return;

    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function() {
            $('#reports-container').css('opacity', '0.6');
        },
        success: function(response) {
            // Replace only inner elements to keep layout + CSS
            var newList = $(response).find('#reports-list').html();
            var newPag  = $(response).find('#reports-pagination').html();

            $('#reports-list').html(newList);
            $('#reports-pagination').html(newPag);
        },
        complete: function() {
            $('#reports-container').css('opacity', '1');
        },
        error: function() {
            alert('Failed to load next page.');
        }
    });
});
</script>



<!-- Load jQuery if not already loaded (remove if you load it globally in layout) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX & Pagination script -->
<script>
(function($){
  // Ensure code runs after DOM ready
  $(function(){

    // Delegated click handler for pagination links inside #reports-container
    $(document).on('click', '#reports-container .pagination a', function(e){
      e.preventDefault();

      var url = $(this).attr('href');
      if (!url) {
        console.warn('Pagination link has no href');
        return;
      }

      // Visual loader
      $('#reports-container').css('opacity', 0.6);

      $.ajax({
        url: url,
        type: 'GET',
        cache: false,
        success: function(response) {
          // response should contain our partial that has #reports-list and #reports-pagination
          var $res = $(response);

          var newList = $res.find('#reports-list').html();
          var newPag  = $res.find('#reports-pagination').html();

          if (typeof newList !== 'undefined') {
            $('#reports-list').html(newList);
          } else {
            console.warn('AJAX response missing #reports-list — replacing entire container as fallback');
            $('#reports-container').html(response);
            return;
          }

          if (typeof newPag !== 'undefined') {
            $('#reports-pagination').html(newPag);
          } else {
            console.warn('AJAX response missing #reports-pagination');
          }

          // ensure any JS that needs to re-run (e.g., lazy load, animations) can be invoked here
        },
        error: function(xhr, status, err) {
          console.error('AJAX pagination error', status, err);
          alert('Failed to load page — check console for details.');
        },
        complete: function() {
          $('#reports-container').css('opacity', 1);
        }
      });
    });

    // Industry filter logic (delegated in case list changes)
    $(document).on('click', '.industry-link', function(e){
      e.preventDefault();
      var industryId = $(this).data('id') ?? 'all';
      loadReportsByIndustry(industryId, 1);
      // toggle active class
      $('.industry-link').removeClass('active');
      $(this).addClass('active');
    });

    // helper to load by industry and page (used by industry click and programmatically)
    window.loadReportsByIndustry = function(industryId, page){
      page = page || 1;
      var url = '/get-reports-by-industry/' + industryId + '?page=' + page;

      $('#reports-container').css('opacity', 0.6);

      $.ajax({
        url: url,
        type: 'GET',
        cache: false,
        success: function(response){
          // response should be partial HTML (ajax-reports-list) containing #reports-list & #reports-pagination
          var $res = $(response);
          var newList = $res.find('#reports-list').html();
          var newPag  = $res.find('#reports-pagination').html();

          if (typeof newList !== 'undefined') {
            $('#reports-list').html(newList);
          } else {
            $('#reports-container').html(response); // fallback
            return;
          }

          if (typeof newPag !== 'undefined') {
            $('#reports-pagination').html(newPag);
          }
        },
        error: function(xhr, status, err){
          console.error('Error loading reports by industry', err);
        },
        complete: function(){ $('#reports-container').css('opacity', 1); }
      });
    };

  });
})(jQuery);
</script>

@endsection
