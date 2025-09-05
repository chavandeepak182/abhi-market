@extends('frontend.layouts.header')
@section('title', 'PayPal Payment')

@section('content')
<div class="container py-5 text-center">
    <h2>Redirecting to PayPal...</h2>

    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="paypalForm">
        <input type="hidden" name="business" value="sb-q73pr14720721@business.example.com">
        <input type="hidden" name="cmd" value="_xclick">

        <!-- Dynamic values from controller -->
        <input type="hidden" name="item_name" value="{{ $reportName }} - {{ $licenseType }}">
        <input type="hidden" name="amount" value="{{ $price }}">
        <input type="hidden" name="currency_code" value="USD">

        <input type="hidden" name="return" value="{{ route('paypal.success') }}">
        <input type="hidden" name="cancel_return" value="{{ route('paypal.cancel') }}">

        <button type="submit" class="btn btn-primary">Pay with PayPal (Sandbox)</button>
    </form>

    <script>
        document.paypalForm.submit();
    </script>
</div>
@endsection
