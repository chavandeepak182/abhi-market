@extends('frontend.layouts.header')
@section('content')
<style>
    .thankyou-container {
        text-align: center;
        padding: 80px 20px;
        background: linear-gradient(135deg, #f0f9ff, #e0f7fa);
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .thankyou-icon {
        font-size: 80px;
        color: #006186;
        animation: pop 0.6s ease-in-out;
    }
    @keyframes pop {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .thankyou-title {
        font-size: 42px;
        color: #006186;
        margin-top: 20px;
        font-weight: bold;
    }
    .thankyou-message {
        font-size: 20px;
        color: #444;
        margin: 15px 0 30px;
    }
    .thankyou-btn {
        background: #006186;
        color: #fff;
        padding: 12px 28px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 18px;
        transition: 0.3s;
    }
    .thankyou-btn:hover {
        background: #004d5a;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
    }
</style>

<div class="thankyou-container">
    <div class="thankyou-icon">✅</div>
    <h1 class="thankyou-title">Thank You!</h1>
    <p class="thankyou-message">Your enquiry has been submitted successfully. 🙏 <br> 
        Our team will get back to you shortly.</p>
    <a href="{{ url('/') }}" class="thankyou-btn">Back to Home</a>
</div>
@endsection
