@extends('frontend.layouts.header')
@section('title', "Industry Analysis, Research, Insights | M2 Square Consultancy")
@section('description', "M2 Square Consultancy delivers industry analysis, insights, and research reports with granular data, custom coverage, and competitive intelligence worldwide.")
@section('keywords', "industry analysis, industry research, industry insights, industry overview, industry outlook, industry intelligence")

@section('content')
    <!-- Page Header Start -->
  
    <div class="banner-section" style="background-image: url('{{ asset('assets/images/industry_banner.jpg') }}');">
        
    </div>

<style>
.banner-section {
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 1521px;
    height: 385px;
}

.banner-section::before {
    content: "";
    position: absolute;
    inset: 0;
    /* background: rgba(0, 0, 0, 0.4); dark overlay */
}

.banner-content {
    position: relative;
    z-index: 2;
}
</style>

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
     <!-- industries-section.blade.php -->

<section class="industries-section">
  <div class="container">
    <div class="section-title">
      <h2 class="text-anime-style-2" data-cursor="-opaque">
        Our <span>Industries</span>
      </h2>
    </div>

    <div class="row industries-grid">
      @foreach($allIndustries as $index => $industry)
        @php
            $industryName = $industry->industries_name;
            $slug = $industry->slug;

            // ✅ Ensure correct image path
            $imagePath = $industry->image;
            if (!Str::startsWith($imagePath, 'uploads/industries/')) {
                $imagePath = 'uploads/industries/' . $imagePath;
            }
            $industryImage = asset($imagePath);
        @endphp

        <div class="col-lg-3 col-md-4 col-sm-6 industry-column {{ $index >= 8 ? 'extra-industry d-none' : '' }}">
          <a href="{{ route('industries.details', ['slug' => $slug]) }}" 
             class="industry-card wow fadeInUp" 
             data-wow-delay="{{ $index * 0.1 }}s">
            <div class="image-wrap">
              <img src="{{ $industryImage }}" alt="{{ $industryName }}" loading="lazy">
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
      <div class="load-more-btn text-center wow fadeInUp" data-wow-delay="0.6s">
        <a href="javascript:void(0);" class="btn-default" id="loadMoreBtn">Load More</a>
      </div>
    @endif
  </div>
</section>

<style>
/* === Section === */
.industries-section {
  padding: 80px 0;
  background: #f9f9f9;
}

.section-title {
  text-align: center;
  margin-bottom: 50px;
}

.section-title h2 {
  font-size: 32px;
  font-weight: 700;
  color: #222;
}

.section-title span {
  color: #007bff;
}

/* === Grid Layout === */
.industries-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
}

.industry-column {
  flex: 1 1 calc(25% - 25px);
  max-width: calc(25% - 25px);
  transition: all 0.3s ease;
}

@media (max-width: 992px) {
  .industry-column {
    flex: 1 1 calc(33.33% - 25px);
    max-width: calc(33.33% - 25px);
  }
}

@media (max-width: 768px) {
  .industry-column {
    flex: 1 1 calc(50% - 25px);
    max-width: calc(50% - 25px);
  }
}

@media (max-width: 576px) {
  .industry-column {
    flex: 1 1 100%;
    max-width: 100%;
  }
}

/* === Card Design === */
.industry-card {
  background: #fff;
  border-radius: 12px;
  padding-bottom: 25px;
  text-decoration: none;
  color: #222;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  display: block;
  overflow: hidden;
}

.industry-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* === Image === */
.image-wrap {
  width: 100%;
  height: 180px;
  overflow: hidden;
  border-bottom: 3px solid #007bff;
}

.image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.industry-card:hover .image-wrap img {
  transform: scale(1.1);
}

/* === Title + Underline === */
.industry-name {
  padding-top: 15px;
}

.industry-name span {
  display: block;
  font-size: 16px;
  font-weight: 600;
  color: #222;
  margin-bottom: 6px;
}

.underline {
  width: 40px;
  height: 3px;
  background: #007bff;
  margin: 0 auto;
  transition: all 0.3s ease;
}

.industry-card:hover .underline {
  width: 60px;
  background: #ff7b00;
}

/* === Button === */
.load-more-btn {
  text-align: center;
  margin-top: 50px;
}

.btn-default {
  background: #007bff;
  color: #fff;
  padding: 15px 66px;
  border-radius: 50px;
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  transition: background 0.3s ease;
  display: inline-block;
}

.btn-default:hover {
  background: #ff7b00;
}

/* === Load Animation === */
.extra-industry {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.4s ease;
}

.extra-industry.show {
  opacity: 1;
  transform: translateY(0);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const loadMoreBtn = document.getElementById("loadMoreBtn");
  if (!loadMoreBtn) return;

  loadMoreBtn.addEventListener("click", function() {
    const hiddenItems = document.querySelectorAll(".extra-industry.d-none");
    hiddenItems.forEach((item, index) => {
      setTimeout(() => {
        item.classList.remove("d-none");
        item.classList.add("show");
      }, index * 100);
    });

    // Hide button after expanding
    loadMoreBtn.style.display = "none";
  });
});
</script>

            
<br> <br>  <br>                         

@endsection