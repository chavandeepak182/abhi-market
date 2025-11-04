@extends('admin.layouts.header')
@section('title', "Manage Press Releases")
@section('content')
<style>
    .pagination-wrapper nav {
        display: flex;
        gap: 4px;
    }
    .pagination .page-item .page-link {
        padding: 6px 12px;
        border-radius: 6px;
    }
    /* Fix for striped table index visibility */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9 !important; /* light gray for odd rows */
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #ffffff !important; /* white for even rows */
    }

    .table td, .table th {
        color: #333 !important; /* dark text color so visible on all rows */
    }
</style>

<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li>
                    <a href="{{ url('admin/dashboard') }}" 
                       class="text-gray-200 fw-normal text-15 hover-text-main-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <span class="text-gray-500 fw-normal d-flex">
                        <i class="ph ph-caret-right"></i>
                    </span>
                </li>
                <li>
                    <span class="text-main-600 fw-normal text-15">Manage Press Releases</span>
                </li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('press-releases.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Create Press Release
                </a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card overflow-hidden">
        <div class="card-body overflow-x-auto">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($pressReleases->isEmpty())
                <div class="alert alert-info mb-0">No press releases found.</div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Publish Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pressReleases as $index => $pressRelease)
                        <tr>
                            <td>{{ $pressReleases->firstItem() + $index }}</td>
                            <td>
                                <span class="h6 mb-0 fw-medium text-gray-300">
                                    {{ $pressRelease->title }}
                                </span>
                            </td>
                            <td>
                                <span class="h6 mb-0 fw-medium text-gray-300">
                                    {{ $pressRelease->category_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="h6 mb-0 fw-medium text-gray-300">
                                    {{ $pressRelease->publish_date ? \Carbon\Carbon::parse($pressRelease->publish_date)->format('d M, Y') : '—' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('press-releases.edit', $pressRelease->id) }}" 
                                   class="btn btn-warning btn-xs edit">
                                   <i class="far fa-edit"></i>
                                </a>

                                <form action="{{ route('press-releases.delete', $pressRelease->id) }}" 
                                      method="POST" 
                                      style="display:inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete this press release?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-xs delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $pressReleases->firstItem() }} to {{ $pressReleases->lastItem() }} of {{ $pressReleases->total() }} results
                    </div>
                    <div class="pagination-wrapper">
                        {{ $pressReleases->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
