@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <!-- <div class="page-header">

        <div>

            <h1 class="page-title">
                Lead Management
            </h1>

            <p class="page-subtitle">
                View, manage and monitor all customer enquiries
            </p>

        </div> -->

        <div class="page-header-actions">

            <a href="{{ route('leads.export', request()->query()) }}"
               class="btn-export"
               title="Export all leads (complete lead details, CSV)">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>

                Export

            </a>

            <!-- <a href="{{ route('leads.create') }}"
               class="btn-add">

                + Add Lead

            </a> -->

        </div>

    </div>

    <!-- SUMMARY CARDS -->

    <div class="summary-cards">

        <div class="summary-card">

            <span>Total Leads</span>

            <h3>
                {{ $leads->total() }}
            </h3>

        </div>

        <div class="summary-card hot-card">

            <span>Hot Leads</span>

            <h3>
                {{ \App\Models\Lead::where('lead_type','hot')->count() }}
            </h3>

        </div>

        <div class="summary-card warm-card">

            <span>Warm Leads</span>

            <h3>
                {{ \App\Models\Lead::where('lead_type','warm')->count() }}
            </h3>

        </div>

        <div class="summary-card cold-card">

            <span>Cold Leads</span>

            <h3>
                {{ \App\Models\Lead::where('lead_type','cold')->count() }}
            </h3>

        </div>

    </div>

    <!-- FILTERS -->

    <div class="filter-card">

    <form method="GET"
          action="{{ route('leads.index') }}">

        <div class="filter-row">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search Name, Email, Company">

            <input type="text"
                   name="agent"
                   value="{{ request('agent') }}"
                   placeholder="Agent Name">

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

                <option value="">
                    All Status
                </option>

                <option value="new"
                    {{ request('status')=='new' ? 'selected' : '' }}>
                    New
                </option>

                <option value="contacted"
                    {{ request('status')=='contacted' ? 'selected' : '' }}>
                    Contacted
                </option>

                <option value="engaged"
                    {{ request('status')=='engaged' ? 'selected' : '' }}>
                    Engaged
                </option>

                <option value="converted"
                    {{ request('status')=='converted' ? 'selected' : '' }}>
                    Converted
                </option>

                <option value="not_interested"
                    {{ request('status')=='not_interested' ? 'selected' : '' }}>
                    Not Interested
                </option>

            </select>

            <select name="lead_type">

                <option value="">
                    All Lead Types
                </option>

                <option value="hot"
                    {{ request('lead_type')=='hot' ? 'selected' : '' }}>
                    Hot
                </option>

                <option value="warm"
                    {{ request('lead_type')=='warm' ? 'selected' : '' }}>
                    Warm
                </option>

                <option value="cold"
                    {{ request('lead_type')=='cold' ? 'selected' : '' }}>
                    Cold
                </option>

            </select>

            <!-- <select name="task_status">

                <option value="">
                    Task Status
                </option>

                <option value="completed"
                    {{ request('task_status')=='completed' ? 'selected' : '' }}>
                    Completed
                </option>

                <option value="pending"
                    {{ request('task_status')=='pending' ? 'selected' : '' }}>
                    Pending
                </option>

            </select> -->

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

<!-- For Pagination -->

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

            <a href="{{ route('leads.index') }}"
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
                        <th>Agent</th>
                        <th>Followups</th>
                        <th>Next Follow-up</th>
                        <th>Created</th>
                        <!-- <th width="180">Actions</th> -->

                    </tr>

                </thead>

                <tbody>

                    @forelse($leads as $lead)

                    <tr class="
                        @if($lead->has_unread_reply) row-replied
                        @elseif($lead->global_report_pending) row-report-pending
                        @endif
                    ">

                        <td>
                            <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                        </td>

                        <td>

                            <div class="lead-name">

                                @if($lead->is_new_lead)
                                    <span class="new-lead-dot" title="New lead (created in the last 24 hours)"></span>
                                @endif

                                <!-- <a href="{{ route('leads.show',$lead->id) }}"
                                   class="lead-link"> -->
                                <a href="{{ route('leads.view',$lead->id) }}"
                                   class="lead-link">
                                    {{ $lead->name }}

                                </a>

                                @if($lead->has_unread_reply)
                                    <span class="reply-badge" title="Lead has replied">Replied</span>
                                @elseif($lead->global_report_pending)
                                    <span class="pending-badge" title="Global report not sent yet after the thank-you email">Report Pending</span>
                                @endif

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
    @php
        $timezoneMap = [
            'North America' => 'America/New_York',
            'South America' => 'America/Sao_Paulo',
            'South Asia'    => 'Asia/Kolkata',
            'Europe'        => 'Europe/London',
            'Middle East'   => 'Asia/Dubai',
            'Africa'        => 'Africa/Johannesburg',
            'Australia'     => 'Australia/Sydney',
        ];

        $timezone = $timezoneMap[$lead->timezone] ?? $lead->timezone;

        try {
            echo now()->setTimezone($timezone)->format('h:i A');
        } catch (\Exception $e) {
            echo '-';
        }
    @endphp
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

                            {{ $lead->user?->name ?? 'Not Assigned' }}

                            @if($lead->user?->agent_id)
                                <div class="agent-id-badge">{{ $lead->user->agent_id }}</div>
                            @endif

                        </td>

                        <td>

                            {{ $lead->followup_count }}/6

                        </td>

                        <td>

                            @if($lead->global_report_pending)
                                <span class="followup-pending-text">Waiting on report</span>
                            @elseif($lead->next_followup_date)
                                {{ $lead->next_followup_date->format('d M Y') }}
                            @elseif($lead->status === 'engaged')
                                <span class="followup-closed-text">Closed</span>
                            @else
                                -
                            @endif

                        </td>

                        <td>

                            {{ $lead->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <!-- <div class="action-buttons">

                                 <a href="{{ route('leads.show',$lead->id) }}"
                                   class="btn-view">

                                    View

                                </a> 

                                 <a href="{{ route('leads.edit',$lead->id) }}"
                                   class="btn-edit"> 
                                <a href="{{ route('leads.show',$lead->id)}}"
                                class= "btn-edit">

                                    Edit

                                </a>

                            </div> -->

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="16"
                            class="empty-row">

                            No Leads Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
    @include('partials.floating-scrollbar')
    <!-- PAGINATION -->

    @include('partials.pagination', ['paginator' => $leads])

@endsection