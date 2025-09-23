@extends('frontend.layouts.header')
@section('title', 'Request Sample')

{{-- Inject meta noindex --}}
@section('meta')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h2 style="text-align: center;">
                <a href="{{ route('reports.details', $slug) }}" 
                   style="color:#006186; text-decoration: underline;">
                    {{ $report->report_title }}
                </a>
            </h2>

            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-4" style="color: #006186;">
                        Request a Free Sample PDF 
                        <i class="fas fa-file-pdf" style="font-size: 32px; color: #006186; margin-left: 5px;"></i>
                    </h3>

                    <p><strong>Published:</strong> {{ \Carbon\Carbon::parse($report->publish_date)->format('F, Y') }}</p>

                   <form id="enquiry-form" action="{{ route('enquiry.store') }}" method="POST">
    @csrf

    <input type="hidden" name="page_url" value="{{ url()->current() }}">
    <input type="hidden" name="page_name" value="{{ $report->report_title }}">
    <input type="hidden" name="report_title" value="{{ $report->report_title }}">

    {{-- reCAPTCHA v3 hidden field --}}
    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">

    {{-- Name --}}
    <div class="form-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
    </div>

    {{-- Job Title (optional) --}}
    <div class="form-group mb-3">
        <input type="text" name="job_title" class="form-control" placeholder="Job Title (Optional)">
    </div>

    {{-- Company Name (optional) --}}
    <div class="form-group mb-3">
        <input type="text" name="company_name" class="form-control" placeholder="Company Name (Optional)">
    </div>

    {{-- Country + Phone --}}
    <div class="form-group mb-3">
        <select name="country_id" id="country_id" class="form-control">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" data-phone="{{ $country->phone_code }}">
                    {{ $country->name }} ({{ $country->phone_code }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Phone Number with auto phone code --}}
    <div class="form-group mb-3 d-flex">
        <input type="text" id="phone_code" class="form-control me-2" style="max-width:100px;" placeholder="+Code" readonly>
        <input type="text" name="contact" class="form-control" placeholder="Phone Number" required>
    </div>

    {{-- Email --}}
    <div class="form-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
    </div>

    {{-- Message --}}
    <div class="form-group mb-3">
        <textarea name="message" class="form-control" placeholder="Message (Optional)"></textarea>
    </div>

    <button type="submit" class="btn btn-primary w-100">Submit</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Google reCAPTCHA v3 --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.sitekey') }}"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute("{{ config('captcha.sitekey') }}", {action: "submit"}).then(function(token) {
            document.getElementById("recaptchaResponse").value = token;
            console.log("✅ v3 token generated:", token);
        });
    });
</script>
<script>
document.getElementById('country_id').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    let phoneCode = selected.getAttribute('data-phone');
    document.getElementById('phone_code').value = phoneCode ? phoneCode : '';
});
</script>
@endsection
