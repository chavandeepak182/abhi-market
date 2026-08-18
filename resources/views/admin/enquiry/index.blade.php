@extends('admin.layouts.header')
@section('title', "All Enquiries")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>
            <h1 class="page-title">Lead Management</h1>
            <p class="page-subtitle">View, manage and monitor all customer enquiries</p>
        </div>

        <div class="page-header-actions">

            @if (session('status'))
                <div class="alert alert-success mb-0 py-2 px-3">
                    {{ session('status') }}
                </div>
            @endif

            <select class="form-control" id="exportOptions" style="width:120px;" onchange="
                let params = new URLSearchParams(window.location.search);
                if (this.value) { window.location.href = '{{ url('admin/enquiries/export') }}/' + this.value + '?' + params.toString(); }
            ">
                <option value="" selected disabled>Export</option>
                <option value="csv">CSV</option>
                <option value="json">JSON</option>
            </select>

        </div>

    </div>

    <!-- FILTER ROW -->
  <!-- FILTER ROW -->
<form method="GET" action="{{ url('admin/enquiries') }}">
    <div class="row align-items-end g-3">

        <div class="summary-card hot-card">
            <span>Hot Leads</span>
            <h3>{{ $hotLeads }}</h3>
        </div>

        <div class="summary-card warm-card">
            <span>Warm Leads</span>
            <h3>{{ $warmLeads }}</h3>
        </div>

        <div class="summary-card cold-card">
            <span>Cold Leads</span>
            <h3>{{ $coldLeads }}</h3>
        </div>

    </div>

    <!-- FILTERS -->

    <div class="filter-card">

    <form method="GET" action="{{ url('admin/enquiries') }}">

        <div class="filter-row">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Name, Email, Company">

            <select name="agent">
                <option value="">All Agents</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ request('agent') == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="country" value="{{ request('country') }}" placeholder="Country">

            <input type="text" name="timezone" value="{{ request('timezone') }}" placeholder="Timezone">

            <select name="usage_type">
                <option value="">All Usage Types</option>
                <option value="personal" {{ request('usage_type')=='personal' ? 'selected' : '' }}>Personal</option>
                <option value="office" {{ request('usage_type')=='office' ? 'selected' : '' }}>Office</option>
            </select>

            <select name="status">
                <option value="">All Status</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                <option value="not_interested" {{ request('status') == 'not_interested' ? 'selected' : '' }}>Not Interested</option>
                <option value="unassigned" {{ request('status') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
            </select>

            <select name="lead_type">
                <option value="">All Lead Types</option>
                <option value="hot" {{ request('lead_type')=='hot' ? 'selected' : '' }}>Hot</option>
                <option value="warm" {{ request('lead_type')=='warm' ? 'selected' : '' }}>Warm</option>
                <option value="cold" {{ request('lead_type')=='cold' ? 'selected' : '' }}>Cold</option>
            </select>

            <label class="filter-date-label">
                From
                <input type="date" name="from_date" value="{{ request('from_date') }}">
            </label>

            <label class="filter-date-label">
                To
                <input type="date" name="to_date" value="{{ request('to_date') }}">
            </label>

            <select name="per_page">
                <option value="25" {{ (int) request('per_page', 50) === 25 ? 'selected' : '' }}>25 per page</option>
                <option value="50" {{ (int) request('per_page', 50) === 50 ? 'selected' : '' }}>50 per page</option>
                <option value="100" {{ (int) request('per_page', 50) === 100 ? 'selected' : '' }}>100 per page</option>
                <option value="200" {{ (int) request('per_page', 50) === 200 ? 'selected' : '' }}>200 per page</option>
                <option value="500" {{ (int) request('per_page', 50) === 500 ? 'selected' : '' }}>500 per page</option>
            </select>

            <button type="submit" class="btn-filter">Filter</button>

            <a href="{{ url('admin/enquiries') }}" class="btn-reset">Reset</a>

        </div>

    </form>

    </div>

    <!-- TABLE -->

    <div class="table-card">

        <div class="table-scroll" id="leadsTableScroll">

            <table class="crm-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lead</th>
                        <th>Company</th>
                        <th>Report / Page</th>
                        <th>Usage Type</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Status</th>
                        <th>Lead Type</th>
                        <th>Agent</th>
                        <th>Next Follow-up</th>
                        <th>Created</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($enquiries as $enquiry)

                    <tr>

                        <td>#{{ $enquiry->id }}</td>

                        <td>

                            <div class="lead-name">

                                @if(\Carbon\Carbon::parse($enquiry->created_at)->gt(now()->subDay()))
                                    <span class="new-lead-dot" title="New lead (created in the last 24 hours)"></span>
                                @endif

                                <a href="{{ route('leads.show', $enquiry->id) }}" class="lead-link">
                                    {{ $enquiry->name }}
                                </a>
                            </div>

                            <div class="lead-email">{{ $enquiry->email }}</div>

                        </td>

                        <td>{{ $enquiry->company_name ?? '-' }}</td>

                        <td>{{ $enquiry->page_name ?? $enquiry->enquiry_type ?? '-' }}</td>

                        <td>
                            @if($enquiry->usage_type == 'office')
                                <span class="badge bg-success">Office</span>
                            @else
                                <span class="badge bg-secondary">Personal</span>
                            @endif
                        </td>

                        <td>{{ $enquiry->country_name ?? '-' }}</td>

                        <td>{{ $enquiry->timezone ?? '-' }}</td>

                        <td>
                            @php
                                $localTime = '-';
                                if (!empty($enquiry->timezone)) {
                                    try {
                                        $localTime = now()->setTimezone($enquiry->timezone)->format('h:i A');
                                    } catch (\Exception $e) {
                                        $localTime = '-';
                                    }
                                }
                            @endphp
                            {{ $localTime }}
                        </td>

                        <td>
                            <span class="badge status-{{ $enquiry->status }}">
                                {{ ucfirst(str_replace('_',' ',$enquiry->status)) }}
                            </span>
                        </td>

                        <td>
                            @if($enquiry->lead_type)
                                <span class="badge type-{{ $enquiry->lead_type }}">{{ ucfirst($enquiry->lead_type) }}</span>
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $enquiry->agent_name ?? 'Not Assigned' }}</td>

                        <td>
                            @if($enquiry->followup_date)
                                {{ \Carbon\Carbon::parse($enquiry->followup_date)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y') }}</td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="13" class="empty-row">No Leads Found</td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @include('partials.floating-scrollbar')

    <!-- PAGINATION -->

    @include('partials.pagination', ['paginator' => $enquiries])

</div>

@endsection
