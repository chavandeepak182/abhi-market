@extends('frontend.layouts.header')

{{-- Page Meta --}}
@section('title', $report->meta_title)
@section('description', $report->meta_description)
@section('keywords', $report->meta_keywords)

{{-- Robots --}}
@section('robots')
    <meta name="robots" content="index, follow">
@endsection

{{-- Open Graph (Facebook / LinkedIn) --}}
@section('og_tags')
    <meta property="og:title" content="{{ $report->report_title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($report->description), 150) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($industry) && !empty($industry->image))
        <meta property="og:image" content="{{ url($industry->image) }}">
    @else
        <meta property="og:image" content="{{ url('images/default-og.jpg') }}">
    @endif

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $report->report_title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($report->description), 150) }}">
    <meta name="twitter:image" content="{{ !empty($industry->image) ? url('storage/industries/'.$industry->image) : url('images/default-og.jpg') }}">
@endsection

{{-- ✅ Schema Markup --}}
@section('schema_markup')
    @if(!empty($report->schema_markup))
        <script type="application/ld+json">
            {!! $report->schema_markup !!}
        </script>
    @endif
@endsection
@section('alternate_links')
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="zh-CN" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="fr" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="de" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ja" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="pt" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ru" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="es" href="{{ url()->current() }}">
@endsection

@section('content')
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    @php
                        $words = explode(' ', $report->report_title);
                    @endphp
                    
                    <h1 class="text-anime-style-2" data-cursor="-opaque">
                        <span>{{ $words[0] }}</span>
                        {{ implode(' ', array_slice($words, 1)) }}
                    </h1>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>



<div class="page-service-single">
    <div class="container">
        <div class="row">
           <!-- Make sure the parent col has no overflow issues -->
<div class="col-lg-4">
  <div id="stickySidebar" style="padding: 20px 10px;margin-left:-68px;">

    <div style="
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.06);
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    ">

      <!-- Image & Info Row -->
      <div style="display: flex; gap: 15px; align-items: flex-start;">
        <!-- Image -->
        <div style="flex-shrink: 0;">
          <img src="{{ asset('assets/images/books.png') }}" alt="Report Cover"
               style="width: 110px; border-radius: 10px;">
        </div>

        <!-- Info -->
        <div style="flex-grow: 1;">
          <p class="mb-1" style="font-size: 14px; color: #555;">
            <strong style="color: #0056b3;">PUBLISHED:</strong>
          </p>
          <p class="mb-2" style="font-size: 15px;">{!! $report->publish_date !!}</p>

          <p class="mb-1" style="font-size: 14px; color: #555;">
            <strong style="color: #0056b3;">CATEGORY NAME:</strong>
          </p>
          <p class="mb-0" style="font-size: 15px;">{!! $report->category_name !!}</p>
          
        </div>
      </div>

      <!-- Buttons Row -->
      <div style="display: flex; gap: 12px;">
        <a href="{{ route('purchase.page', $report->id) }}" class="btn w-100"
           style="background-color: #006186; color: white; font-size: 14px; padding: 10px 12px; border-radius: 8px; text-align: center;">
          Buy Now
        </a>

        <a href="{{ route('request.sample', $report->slug) }}" class="btn w-100"
           style="background-color: #8BC34A; color: white; font-size: 14px; padding: 10px 12px; border-radius: 8px; text-align: center;">
          Request Sample
        </a>
      </div>

    </div>

  </div>
</div>





           <div class="col-lg-8" id="mainContent">
                <!-- Case Study Single Content Start -->
                <div class="service-single-content">
                    <!-- Case Study Image Start -->
                    <div class="service-featured-image">
                       
                    </div>
                    <!-- Case Study Image End -->

                    <!-- Case Study Entry Start -->
                    <div class="service-entry">
                        <h1 class="wow fadeInUp custom-title">{!! $report->report_name !!}</h1>
                        <br>
                        
                        <div class="d-flex justify-content-start text-center" style="gap: 40px;">
                        <div>
                            <strong>PUBLISHED ON</strong><br>
                            <span>{!! $report->publish_date !!}</span>
                        </div>
                        <div>
                            <strong>CATEGORY NAME</strong><br>
                            <span>{!! $report->category_name !!}</span>
                        </div>
                        </div>



                        <br>

                            <div class="sticky-tabs-wrapper">       
                                <div class="tabs">
                                    @php
                                        $hasDesc = !empty($report->description);
                                        $hasToc = !empty($report->toc);
                                    @endphp

                                    @if($hasDesc)
                                        <button class="tab-button active" data-tab="desc">Description</button>
                                    @endif

                                    @if($hasToc)
                                        <button class="tab-button {{ !$hasDesc ? 'active' : '' }}" data-tab="toc">Table Of Contents</button>
                                    @endif

                                    {{-- Static Tab --}}
                                    <button class="tab-button {{ !$hasDesc && !$hasToc ? 'active' : '' }}" data-tab="method">
                                        Research Methodology
                                    </button>
                                </div>

                                    <div class="tab-content-wrapper">
                                     @if($hasDesc)
                                        <div class="tab-content active" id="desc">
                                            <h2>Description</h2>
                                           <div class="summernote-output">{!! $report->description !!}</div>

                                                {{-- FAQ Section --}}
                                                @php
                                                    $faqQues = explode('||', $report->faq_que ?? '');
                                                    $faqAns = explode('||', $report->faq_ans ?? '');
                                                @endphp

                                                @if (!empty($faqQues[0]) && !empty($faqAns[0]))
                                                    <div class="faq-section">
                                                        <h2 class="faq-title" style="text-align: center;">Frequently Asked Questions</h2>

                                                        <div class="accordion">
                                                            @foreach ($faqQues as $index => $question)
                                                                <div class="accordion-item" id="accordion-{{ $index }}">
                                                                    <button class="accordion-header" onclick="toggleFAQ({{ $index }})">
                                                                        {{ $question }}
                                                                        <span class="icon" id="icon-{{ $index }}">+</span>
                                                                    </button>
                                                                    <div class="accordion-body" id="faq-body-{{ $index }}">
                                                                        {{ $faqAns[$index] ?? '' }}
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                @endif
                                        </div>
                                            @endif


                                            @if($hasToc)
                                                <div class="tab-content {{ !$hasDesc ? 'active' : '' }}" id="toc">
                                                    <div class="wow fadeInUp">{!! $report->toc !!}</div>
                                                </div>
                                            @endif

                                        {{-- Static Content --}}
                                        <div class="tab-content {{ !$hasDesc && !$hasToc ? 'active' : '' }}" id="method">
                                            <div class="container py-5">
                                            <!-- Quality Assurance Process -->
                                            <h2 class="mb-3">Our Research Methodology</h2>
                                            <p> <strong>"Insight without rigor is just noise."</strong></p>
                                            <p>We follow a comprehensive, multi-phase research framework designed to deliver accurate, strategic, and decision-ready intelligence. Our process integrates <strong>primary and secondary research </strong>, both  <strong>quantitative and qualitative </strong>, along with dual modeling techniques ( <strong>top-down</strong> and  <strong>bottom-up</strong>) and a final layer of validation through our  <strong>proprietary in-house repository.</strong></p>

                                            <!-- <h4>Market Research Process</h4>
                                            <img src="{{ asset('assets') }}/images/download.png" alt="Market Research Process" class="img-fluid mb-4"> -->

                                            <p><strong>PRIMARY RESEARCH</strong></p>

                                            <p>Primary research captures  <strong>real-time, firsthand insights</strong> from the market to understand behaviors, motivations, and emerging trends.</p>
                                            <p> <strong>1. Quantitative Primary Research</strong></p>
                                            <p>Objective: Generate statistically significant data directly from market participants.</p>
                                             <strong>Approaches: </strong>
                                            <ul>
                                                <li>Structured surveys with customers, distributors, and field agents</li>
                                                <li>Mobile-based data collection for point-of-sale audits and usage behavior</li>
                                                <li>Phone-based interviews (CATI) for market sizing and product feedback</li>
                                                <li>Online polling around industry events and digital campaigns</li>
                                                
                                            </ul>
                                            <strong>Insights generated: </strong>
                                            <ul>
                                                <li>Purchase frequency by customer type</li>
                                                <li>Channel performance across geographies</li>
                                                <li>Feature demand by application or demographic</li>
                                                
                                                
                                            </ul>
                                            
                                            <p> <strong>2. Qualitative Primary Research</strong></p>
                                            <p>Objective: Explore decision-making drivers, pain points, and market readiness.</p>
                                             <strong>Approaches: </strong>
                                            <ul>
                                                <li>In-depth interviews (IDIs) with executives, product managers, and key decision-makers</li>
                                                <li>Focus groups among end users and early adopters</li>
                                                <li>Site visits and observational research for consumer products</li>
                                                <li>Informal field-level discussions for regional and cultural nuances</li>
                                                
                                            </ul>
                                            <!-- secondary reaserch -->
                                            <p><strong> SECONDARY RESEARCH</strong></p>

                                            <p>This phase helps establish a <strong>macro-to-micro understanding</strong> of market trends, size, regulation, and competitive dynamics, sourced from credible and public domain information.</p>
                                            <p> <strong>1. Quantitative Secondary  Research</strong></p>
                                            <p>Objective: Model market value and segment-level forecasts based on published data.</p>
                                             <strong>Sources include: </strong>
                                            <ul>
                                                <li>Financial reports and investor summaries</li>
                                                <li>Government trade data, customs records, and regulatory statistics</li>
                                                <li>Industry association publications and economic databases</li>
                                                <li>Channel performance and pricing data from marketplace listings</li>
                                                
                                            </ul>
                                            <strong>Key outputs: </strong>
                                            <ul>
                                                <li>Revenue splits, pricing trends, and CAGR estimates</li>
                                                <li>Supply-side capacity and volume tracking</li>
                                                <li>Investment analysis and funding benchmarks</li>
                                                
                                                
                                            </ul>
                                            
                                            <p> <strong>2. Qualitative Secondary  Research</strong></p>
                                            <p>Objective: Capture strategic direction, innovation signals, and behavioral trends.</p>
                                             <strong>Sources include:</strong>
                                            <ul>
                                                
                                                <li>Company announcements, roadmaps, and product pipelines</li>
                                                <li>Publicly available whitepapers, conference abstracts, and academic research</li>
                                                <li>Regulatory body publications and policy briefs</li>
                                                <li>Social and media sentiment scanning for early-stage shifts</li>
                                                
                                            </ul>
                                             <strong>Insights extracted:</strong>
                                            <ul>
                                                
                                                <li>Strategic shifts in market positioning</li>
                                                <li>Unmet needs and white spaces</li>
                                                <li>Regulatory triggers and compliance impact</li>
                                                
                                                
                                            </ul>
                                            
                                             <!-- <h4>Market Research Process</h4> -->
                                            <img src="{{ asset('assets') }}/images/research_methodlogy.png" alt="Market Research Process" class="img-fluid mb-4">

                                            <p><strong> DUAL MODELING: TOP-DOWN + BOTTOM-UP</strong></p>

                                            <p>To ensure robust market estimation, we apply two complementary sizing approaches:</p>
                                            
                                             <strong>Top-Down Modeling:</strong>
                                            <ul>
                                                <li>Start with broader industry value (e.g., global or regional TAM)</li>
                                                <li>Apply filters by segment, geography, end-user, or use case</li>
                                                <li>Adjust with primary insights and validation benchmarks</li>
                                                <li>Ideal for investor-grade market scans and opportunity mapping</li>
                                                
                                            </ul>
                                            <strong>  Bottom-Up Modeling</strong>
                                            <ul>
                                                <li>Aggregate from the ground up using sales volumes, pricing, and unit economics</li>
                                                <li>Use internal modeling templates aligned with stakeholder data</li>
                                                <li>Incorporate distributor-level or region-specific inputs</li>
                                                <li>Most accurate for emerging segments and granular sub-markets</li>
                                                
                                            </ul>
                                            <p><strong> DATA VALIDATION: IN-HOUSE REPOSITORY</strong></p>

                                            <p>We close the loop with <strong>proprietary data intelligence</strong> built from ongoing projects, industry monitoring, and historical benchmarking. This repository includes:</p>
                                            
                                            <ul>
                                                <li>Multi-sector market and pricing models</li>
                                                <li>Key trendlines from past interviews and forecasts</li>
                                                <li>Benchmarked adoption rates, churn patterns, and ROI indicators</li>
                                                <li>Industry-specific deviation flags and cross-check logic</li>
                                                
                                            </ul>
                                             <strong>Benefits:</strong>
                                            <ul>
                                                
                                                <li>Catches inconsistencies early</li>
                                                <li>Aligns projections across studies</li>
                                                <li>Enables consistent, high-trust deliverables</li>
                                                
                                                
                                            </ul>






                                            <!-- Case Study - Automotive Sector -->
                                            
                                            

                                            <!-- Case Study - ICT Sector -->
                                            
                                        </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                    </div>


                            



          
                            </div>

                </div>
                




   
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
<script>
    function toggleFAQ(index) {
        const item = document.getElementById('accordion-' + index);
        const icon = document.getElementById('icon-' + index);

        item.classList.toggle('active');

        icon.innerText = item.classList.contains('active') ? '–' : '+';
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
        document.addEventListener("DOMContentLoaded", function() {
        const tabContents = document.querySelectorAll(".tab-content");
        tabContents.forEach(tab => {
            const tables = tab.querySelectorAll("table");
            tables.forEach(table => {
            const wrapper = document.createElement("div");
            wrapper.style.overflowX = "auto";
            wrapper.style.width = "100%";
            wrapper.appendChild(table.cloneNode(true));
            table.replaceWith(wrapper);
            });
        });
        });
</script>
<script>
                                        document.addEventListener("DOMContentLoaded", function () {
                    const container = document.querySelectorAll(".summernote-output");

                    const phrases = [
                        "Fuzes & Primers",
                        "Projectiles and warheads",
                        "By Application",
                        "By Components",
                        "By Products",
                        "North America",
                        "Latin America",
                        "Middle East and Africa"
                    ];

                    container.forEach(area => {
                        let html = area.innerHTML;
                        phrases.forEach(phrase => {
                        const regex = new RegExp(phrase, 'g');
                        html = html.replace(
                            regex,
                            `<span class="nowrap">${phrase}</span>`
                        );
                        });
                        area.innerHTML = html;
                    });
                    });


</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('stickySidebar');
    const content = document.getElementById('mainContent');
    const offsetTop = 40; // Top space kami kelay
    const spacing = 20; // Space from bottom of content

    function updateSidebar() {
      const contentRect = content.getBoundingClientRect();
      const sidebarHeight = sidebar.offsetHeight;
      const maxScroll = content.offsetTop + content.offsetHeight - sidebarHeight - spacing;

      if (window.scrollY > content.offsetTop - offsetTop && window.scrollY < maxScroll) {
        sidebar.style.position = 'fixed';
        sidebar.style.top = offsetTop + 'px';
        sidebar.style.bottom = 'auto';
        sidebar.style.width = sidebar.parentElement.offsetWidth + 'px';
      } else if (window.scrollY >= maxScroll) {
        sidebar.style.position = 'absolute';
        sidebar.style.top = (content.offsetHeight - sidebarHeight) + 'px';
        sidebar.style.bottom = 'auto';
        sidebar.style.width = '100%';
      } else {
        sidebar.style.position = 'static';
        sidebar.style.top = 'auto';
        sidebar.style.width = 'auto';
      }
    }

    window.addEventListener('scroll', updateSidebar);
    window.addEventListener('resize', updateSidebar);
    updateSidebar();
  });
</script>

@endsection