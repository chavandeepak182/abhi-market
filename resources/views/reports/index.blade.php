@extends('admin.layouts.header')
@section('title', "Manage reports")
@section('content')
<style>
    .pagination-wrapper nav {
    display: flex;
    gap: 4px; /* space between page numbers */
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
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Manage Reports</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('reports.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Create Report</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card overflow-hidden">
        <div class="card-body overflow-x-auto">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

           
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Report Name</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $index => $report)
                    <tr>
                        <td>{{ $reports->firstItem() + $index }}</td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $report->report_title }}</span></td>
                        <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $report->category_name }}</span></td>
                        <td>
                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-xs edit"><i class="far fa-edit"></i></a>
                            <form action="{{ route('reports.delete', $report->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
                    Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                </div>
                <div class="pagination-wrapper">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
