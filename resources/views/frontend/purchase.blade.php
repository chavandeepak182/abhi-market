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
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="text-center pricing-header">
        <p><strong>{{ $report->report_name }}</strong></p>
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
            <img src="{{ asset('assets/images/excel_user.svg') }}" alt="User Icon" class="plan-icon" />
        </div>
        <div class="plan-title">EXCEL ONLY</div>
        <div class="price">US$ 2000</div>

        <!-- PayPal Hosted Button -->
        <div id="paypal-container-XXKU8VV4D6YAE"></div>
        <script>
        paypal.HostedButtons({
            hostedButtonId: "XXKU8VV4D6YAE",
        }).render("#paypal-container-XXKU8VV4D6YAE")
        </script>

        <ul>
            <li>Single User Access</li>
            <li>No Free Customization</li>
            <li>2 Month Free Analyst Support</li>
            <li><strong>Deliverable Report Format:</strong> Excel</li>
            <li>Quantitative Data Only</li>
        </ul>
    </div>

    <!-- Single User -->
    <div class="plan-card">
        <div class="icon-right">
            <img src="{{ asset('assets/images/single_user.svg') }}" alt="User Icon" class="plan-icon" />
        </div>
        <div class="plan-title">SINGLE USER ACCESS</div>
        <div class="price">US$ 4500</div>

        <!-- PayPal Hosted Button -->
        <div id="paypal-container-DZL37ESPWW4RL"></div>
        <script>
        paypal.HostedButtons({
            hostedButtonId: "DZL37ESPWW4RL",
        }).render("#paypal-container-DZL37ESPWW4RL")
        </script>

        <ul>
            <li>Single User Access</li>
            <li>10% Free Customization</li>
            <li>3 Months Free Analyst Support</li>
            <li>Deliverable Report Format: PDF</li>
            <li>Qualitative Data & Insights</li>
            <li>Market dynamics, Trends, Key insights</li>
            <li>Company profiles, Competitive landscape, etc</li>
        </ul>
    </div>

    <!-- Multi User -->
    <div class="plan-card highlight">
        <div class="badge-popular">Frequently Purchased</div>
        <div class="icon-right">
            <img src="{{ asset('assets/images/compare_price_new.svg') }}" alt="Multi User Icon" class="plan-icon" />
        </div>
        <div class="plan-title">MULTI USER ACCESS</div>
        <div class="price">US$ 5750</div>

        <!-- PayPal Hosted Button -->
        <div id="paypal-container-VBALQETTFK8BL"></div>
        <script>
        paypal.HostedButtons({
            hostedButtonId: "VBALQETTFK8BL",
        }).render("#paypal-container-VBALQETTFK8BL")
        </script>

        <ul>
            <li>Team Access (Up to 5 Users)</li>
            <li>15% Free Customization</li>
            <li>4 Months Free Analyst Support</li>
            <li>15% Discount on Next Purchase</li>
            <li>Deliverables: PDF, Excel</li>
            <li>Qualitative & Quantitative Data</li>
            <li>Market Trends, Insights, etc.</li>
        </ul>
    </div>

    <!-- Corporate -->
    <div class="plan-card">
        <div class="icon-right">
            <img src="{{ asset('assets/images/enterprise_user.svg') }}" alt="Corporate Icon" class="plan-icon" />
        </div>
        <div class="plan-title">CORPORATE ACCESS</div>
        <div class="price">US$ 7000</div>

        <!-- PayPal Hosted Button -->
        <div id="paypal-container-CXUARTN2YX5U8"></div>
        <script>
        paypal.HostedButtons({
            hostedButtonId: "CXUARTN2YX5U8",
        }).render("#paypal-container-CXUARTN2YX5U8")
        </script>

        <ul>
            <li>Unlimited User Access</li>
            <li>25% Discount on Next Purchase</li>
            <li>6 Months Free Analyst Support</li>
            <li>Deliverables: PDF, Excel</li>
            <li>Market Trends, Insights, Competitive Landscape</li>
        </ul>
    </div>
</div>

</div>
@endsection
