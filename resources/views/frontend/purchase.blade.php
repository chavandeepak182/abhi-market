@extends('frontend.layouts.header')
@section('title', "Checkout 1")
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
                        <h1 class="text-anime-style-2" data-cursor="-opaque">Checkout</h1>
                        <!-- <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">contact us</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    
  <div class="container py-5">
    <div class="text-center pricing-header">
      <p>Compact Loader Market Size, Share & Industry Analysis, By Product Type (Wheel Loader and Track Loader), By Source Type (Diesel, Electric, and Hybrid), and By Application (Construction, Landscaping, Agriculture, Forestry, and Others), and Regional Forecast, 2025 – 2032</p>
    </div>

    <div class="step-nav">
      <div class="arrow-step active">Select Licence Type</div>
      <div class="arrow-step active">Billing Information and Payment</div>
     <div class="arrow-step active">Order Confirmation</div>
    </div>

    <div class="card-deck">
      <!-- Excel Only -->
      <div class="plan-card">
  <div class="icon-right">
    <img src="assets/images/excel_user.svg" alt="User Icon" class="plan-icon" />
  </div>

  <div class="plan-title">EXCEL ONLY</div>
  <div class="price"> US$2000</div>
  <button class="buy-btn">Buy Now</button>

  <ul>
    <li>Single User Access</li>
    <li>No Free Customization</li>
    <li>2 Month Free Analyst Support</li>
    <li><strong>Deliverable Report Format:</strong> Excel</li>
    <li>Quantitative Data Only</li>
  </ul>

  <!-- <button class="buy-btn">Buy Now</button> -->
</div>


      <!-- Single User -->
<div class="plan-card">
 <div class="icon-right">
  
    <img src="assets/images/single_user.svg" alt="User Icon" class="plan-icon" />
  </div>

  <div class="plan-title">SINGLE USER ACCESS</div>
  <div class="price">US $4500</div>
  <button class="btn buy-btn">Buy Now</button>

      <ul>
        <li>Single User Access</li>
        <li>10% Free Customization</li>
        <li>3 Months Free Analyst Support</li>
        <li>Deliverable Report Format</li>
        <li>PDF</li>
        <li>Qualitative Data & InsightsMarket dynamics</li>
        <li>Market Trends</li>
        <li>Key insights</li>
        <li>Company profiles</li>
        <li>Competitive landscape, etc</li>
      </ul>
</div>


      <!-- Multi User (Popular) -->
      <div class="plan-card highlight">
  <!-- Badge -->
  <div class="badge-popular">Frequently Purchased</div>

  <!-- Top right icon -->
  <div class="icon-right">
    <img src="assets/images/compare_price_new.svg" alt="Multi User Icon" class="plan-icon" />
  </div>

  <!-- Centered title -->
  <div class="plan-title">MULTI USER ACCESS</div>

  <!-- Price and button -->
  <div class="price">US$ 5750</div>
  <button class="btn buy-btn">Buy Now</button>

  <!-- Features list -->
  <ul>
    <li>Team Access (Up to 5 User)</li>
    <li>15% Free Customization</li>
    <li>4 Months Free Analyst Support</li>
    <li>15% Discount on your Next Purchase <strong>of same licence type</strong></li>
    <li>Deliverable Report Format</li>
    <li>PDF</li>
    <li>Qualitative Data & InsightsMarket dynamics</li>
    <li>Market Trends</li>
    <li>Key insights</li>
    <li>Company profiles</li>
    <li>Competitive landscape, etc</li>
    <li>Excel</li>
    <li>Quantitative Data</li>
  </ul>
</div>



      <!-- Enterprise -->
      <div class="plan-card">
  <div class="icon-right">
    <img src="assets/images/enterprise_user.svg" alt="Corporate Icon" class="plan-icon" />
  </div>

  <div class="plan-title">CORPORATE ACCESS</div>
  <div class="price">US$ 7000</div>
  <button class="btn buy-btn">Buy Now</button>

  <ul>
    <li>Unlimited User Access</li>
    <li>25% Discount on your Next Purchase <strong>of same licence type</strong></li>
    <li>6 Months Free Analyst Support</li>
    <li>Deliverable Report Format</li>
    <li>PDF</li>
    <li>Qualitative Data & InsightsMarket dynamics</li>
    <li>Market Trends</li>
    <li>Key insights</li>
    <li>Company profiles</li>
    <li>Competitive landscape, etc</li>
    <li>Excel</li>
    <li>Quantitative Data</li>
  </ul>
</div>

    </div>
</div>
  

@endsection