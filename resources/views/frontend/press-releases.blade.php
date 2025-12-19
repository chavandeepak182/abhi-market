@extends('frontend.layouts.header')

@section('title', 'M2square Consultancy - Press Releases | Latest Updates | Company News')
@section('description', 'Stay updated with the latest press releases and official announcements from M2square Consultancy.')
@section('keywords', 'press releases, m2square consultancy, company news, business updates, official announcements, media coverage')

@section('content')

<!-- ===== Hero Banner ===== -->
<section class="hero-wrap position-relative" style="background-color:#006186;">
    <div class="hero-bg" style="background-color:#006186; background-size: cover;"></div>
    <div class="hero-overlay bg-dark opacity-50"></div>

    <div class="container hero-content py-5">
        <div class="row">
            <div class="col-lg-9 text-white">
                <!-- Breadcrumb -->
                <div class="breadcrumb-mini mb-2">
                    <a href="{{ url('/') }}" class="text-white">Home</a>
                    <span class="sep">/</span>
                    <span>Press Releases</span>
                </div>

                <!-- Heading -->
                <h1 class="hero-title display-5 mb-2" style="color:#fff">Latest Press Releases</h1>
            </div>
        </div>
    </div>

    <div class="hero-wave"></div>
</section>

<!-- ===== Press Releases Section ===== -->
<div class="container py-5">
    <!-- Press Release Cards -->
    <!-- ===== Press Releases Section ===== -->
    <div class="container py-5">
        <div class="row">
            <!-- ===== Left Sidebar (Categories) ===== -->
            <aside class="col-lg-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white fw-bold" style="background-color:#006186;">
                        Industries
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('press-releases') }}" 
                            class="text-decoration-none {{ request('category') == '' ? 'fw-bold text-primary' : 'text-dark' }}">
                            All Industries
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="{{ route('press-releases', ['category' => $category->pid]) }}" 
                                class="text-decoration-none {{ request('category') == $category->pid ? 'fw-bold text-primary' : 'text-dark' }}">
                                {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- ===== Right Content (Press Releases) ===== -->
            <div class="col-lg-9">

                <!-- Search Bar -->
                <form method="GET" action="{{ route('press-releases') }}" class="mb-4">
                    <div class="input-group">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="form-control" placeholder="Search press releases...">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>

            <!-- ===== List Style Press Releases ===== -->
                <div class="list-group shadow-sm">
                    @forelse($pressReleases as $press)
                        <div class="list-group-item py-4 mb-3 border rounded-3">  <!-- ✅ Added mb-3 + border + rounded -->
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ url('press-release/' . $press->slug) }}" class="text-decoration-none" style="color:#006186;">
                                            {{ $press->title }}
                                        </a>
                                    </h5>
                                    <p class="mb-2 text-muted">
                                        {{ Str::limit(strip_tags($press->content), 160, '...') }}
                                    </p>

                                    <div class="d-flex flex-wrap small text-secondary">
                                        <div class="me-3">
                                            <i class="bi bi-tags"></i>
                                            {{ $press->category_name ?? 'Uncategorized' }}
                                        </div>
                                        <div>
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($press->publish_date)->format('F d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted py-5">
                            No press releases found.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $pressReleases->withQueryString()->links() }}
                </div>

        </div>
    </div>
</div>

<!-- Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category').select2({
            placeholder: "-- Select Category --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
