{{-- resources/views/errors/404.blade.php --}}
@extends('frontend.layouts.header')

@section('title', 'Page Not Found - M2 Square Consultancy')

@section('description', 'The page you are looking for could not be found on M2 Square Consultancy.')

@section('content')
    <section class="error-page py-5 text-center">
        <div class="container">
            <h1 class="display-4 mb-3">404</h1>
            <h2 class="mb-4">Oops! Page not found</h2>
            <p class="mb-4">
                The page you’re looking for doesn’t exist or may have been moved.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go to Homepage</a>
        </div>
    </section>
@endsection