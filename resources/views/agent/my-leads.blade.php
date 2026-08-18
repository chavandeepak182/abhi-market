@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <!-- PAGE HEADER -->

    <div class="page-header">

        <div>
            <h1 class="page-title">
                My Leads
            </h1>

            <!-- <p class="page-subtitle">
                Leads assigned to you
            </p> -->
        </div>

    </div>

    <!-- SUMMARY CARDS -->

    <div class="summary-cards">

        <div class="summary-card">
            <span>Total Leads</span>
            <h3>{{ $totalLeads }}</h3>
        </div>

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

        <form method="GET">

            <div class="filter-row">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search Name, Email, Company">

                <input type="text"
                       name="country"
                       value="{{ request('country') }}"
                       placeholder="Country">

                <input type="text"
                       name="timezone"
                       value="{{ request('timezone') }}"
                       placeholder="Timezone">

                <input type="text"
                       name="usage_type"
                       value="{{ request('usage_type') }}"
                       placeholder="Usage Type">

                <select name="status">

                    <option value="">All Status</option>

                    <option value="new"
                        {{ request('status') == 'new' ? 'selected' : '' }}>
                        New
                    </option>

                    <option value="contacted"
                        {{ request('status') == 'contacted' ? 'selected' : '' }}>
                        Contacted
                    </option>

                    <option value="engaged"
                        {{ request('status') == 'engaged' ? 'selected' : '' }}>
                        Engaged
                    </option>

                    <option value="converted"
                        {{ request('status') == 'converted' ? 'selected' : '' }}>
                        Converted
                    </option>

                    <option value="not_interested"
                        {{ request('status') == 'not_interested' ? 'selected' : '' }}>
                        Not Interested
                    </option>

                </select>

                <select name="lead_type">

                    <option value="">All Lead Types</option>

                    <option value="hot"
                        {{ request('lead_type') == 'hot' ? 'selected' : '' }}>
                        Hot
                    </option>

                    <option value="warm"
                        {{ request('lead_type') == 'warm' ? 'selected' : '' }}>
                        Warm
                    </option>

                    <option value="cold"
                        {{ request('lead_type') == 'cold' ? 'selected' : '' }}>
                        Cold
                    </option>

                </select>

                <select name="task_status">

                    <option value="">Task Status</option>

                    <option value="completed"
                        {{ request('task_status') == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>

                    <option value="pending"
                        {{ request('task_status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                </select>

                <label class="filter-date-label">
                    From
                    <input type="date"
                           name="date_from"
                           value="{{ request('date_from') }}">
                </label>

                <label class="filter-date-label">
                    To
                    <input type="date"
                           name="date_to"
                           value="{{ request('date_to') }}">
                </label>
<!-- For pagination -->

<select name="per_page">

    <option value="25"
        {{ (int) request('per_page', 25) === 25 ? 'selected' : '' }}>
        25 per page
    </option>

    <option value="50"
        {{ (int) request('per_page', 25) === 50 ? 'selected' : '' }}>
        50 per page
    </option>

    <option value="100"
        {{ (int) request('per_page', 25) === 100 ? 'selected' : '' }}>
        100 per page
    </option>

    <option value="200"
        {{ (int) request('per_page', 25) === 200 ? 'selected' : '' }}>
        200 per page
    </option>

    <option value="500"
        {{ (int) request('per_page', 25) === 500 ? 'selected' : '' }}>
        500 per page
    </option>

</select>





                <button type="submit"
                        class="btn-filter">
                    Filter
                </button>

                <a href="{{ route('agent.leads') }}"
                   class="btn-reset">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <!-- TABLE -->

    <div class="table-card">

       <div class="table-scroll" id="leadsTableScroll">

            <table class="crm-table">

                <thead>

                    <tr>
                        <th>Lead ID</th>
                        <th>Lead</th>
                        <th>Company</th>
                        <th>Category</th>
                        <th>Report</th>
                        <th>Usage Type</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Status</th>
                        <th>Lead Type</th>
                        <th>Next Followup</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($leads as $lead)

                    <tr class="{{ $lead->has_unread_reply ? 'row-replied' : '' }}">

                        <td>
                            <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                        </td>

                        <td>

                            <div class="lead-name">

                                <a href="{{ route('agent.lead.details',$lead->id) }}"
                                   class="lead-link {{ $lead->has_unread_reply ? 'reply-highlight' : '' }}">

                                    {{ $lead->name }}

                                    @if($lead->has_unread_reply)
                                        <span class="reply-badge" title="Lead has replied">Replied</span>
                                    @endif

                                </a>

                            </div>

                            <div class="lead-email">

                                {{ $lead->email }}

                            </div>

                        </td>

                        <td>
                            {{ $lead->company ?? '-' }}
                        </td>

                        <td>
                            {{ $lead->reportCategory?->category_name ?? '-' }}
                        </td>

                        <td>
                            {{ $lead->report?->report_title ?? '-' }}
                        </td>

                        <td>
                            {{ $lead->usage_type ?? '-' }}
                        </td>

                        <td>
                            {{ $lead->country }}
                        </td>

                        <td>
                            {{ $lead->timezone }}
                        </td>

                        <td>

                            {{ now()->setTimezone($lead->timezone)->format('h:i A') }}

                        </td>

                        <td>

                            <span class="badge status-{{ $lead->status }}">

                                {{ ucfirst(str_replace('_',' ',$lead->status)) }}

                            </span>

                        </td>

                        <td>

                            <span class="badge type-{{ $lead->lead_type }}">

                                {{ ucfirst($lead->lead_type) }}

                            </span>

                        </td>

                        <td>

                            @if($lead->next_followup_date)
                                {{ $lead->next_followup_date->format('d M Y') }}
                            @elseif($lead->status === 'engaged')
                                <span class="followup-closed-text">Closed</span>
                            @else
                                -
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10" class="empty-row">

                            No Leads Assigned

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- PAGINATION -->
        @include('partials.floating-scrollbar')
    @include('partials.pagination', ['paginator' => $leads])

</div>

@endsection