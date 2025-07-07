@extends('frontend.layouts.header')

@section('title', 'Request Sample')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-4">Request a Free Sample for:</h3>
                    <h5 class="text-primary">{{ $report->report_title }}</h5>
                    <p><strong>Published:</strong> {{ \Carbon\Carbon::parse($report->publish_date)->format('F, Y') }}</p>

                    <form action="{{ route('enquiry.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="page_url" value="{{ url()->current() }}">
                        <input type="hidden" name="page_name" value="{{ $report->report_title }}">

                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="contact" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="message" class="form-control" placeholder="Message (Optional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
