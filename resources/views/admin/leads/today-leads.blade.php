@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <!-- <div class="page-header">

        <div>

            <h1 class="page-title">
                Today's Operations
            </h1>

            <p class="page-subtitle">
                Follow-ups scheduled for {{ today()->format('d F Y') }}
            </p>

        </div>

    </div> -->

    <div class="summary-cards">

        <div class="summary-card card-today-leads">
            <span>Today's leads</span>
            <h3>{{ $allTodayLeads->count()}}</h3>
        </div>

        <div class="summary-card card-today-followups">
            <span>Today's follow-ups</span>
            <h3>{{ $followups->count() }}</h3>
        </div>

        <div class="summary-card card-completed">
            <span>Completed tasks</span>
            <h3>
                {{
                    $todayLeads->where('today_task_completed',true)->count()
                    +
                    $followups->where('today_task_completed',true)->count()
                }}
            </h3>
        </div>

        <div class="summary-card card-pending">
            <span>Pending tasks</span>
            <h3>
                {{
                    $todayLeads->where('today_task_completed',false)->count()
                    +
                    $followups->where('today_task_completed',false)->count()
                }}
            </h3>
        </div>

    </div>

    <div class="filter-card">

        <form method="GET">

            <div class="filter-row">

                <select name="agent_id">

                    <option value="">
                        All agents
                    </option>

                    @foreach($agents as $agent)

                        <option value="{{ $agent->id }}"
                            {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                            {{ $agent->name }}
                        </option>

                    @endforeach

                </select>

                <select name="task_status">

                    <option value="">
                        All tasks
                    </option>

                    <option value="completed"
                        {{ request('task_status')=='completed' ? 'selected':'' }}>
                        Completed
                    </option>

                    <option value="pending"
                        {{ request('task_status')=='pending' ? 'selected':'' }}>
                        Pending
                    </option>

                </select>

                <button type="submit"
                        class="btn-filter">
                    Apply
                </button>

                <a href="{{ route('leads.today') }}"
                   class="btn-reset">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <!-- TODAY LEADS -->

    <div class="section-title">
        Today's new leads
    </div>

    <div class="table-card" id="leadsTableCard">

        <div class="table-scroll">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Done</th>
                        <th>Lead ID</th>
                        <th>Lead</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Status</th>
                        <th>Lead Type</th>
                        <th>Agent</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($todayLeads as $lead)

                    <tr @if($loop->index >= 3) class="extra-row" style="display:none" @endif>

                        <td>

                            <input type="checkbox"
                                   class="task-checkbox"
                                   data-id="{{ $lead->id }}"
                                   {{ $lead->today_task_completed ? 'checked' : '' }}>

                        </td>

                        <td>
                            <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                        </td>

                        <td>

                            <a href="{{ route('leads.show',$lead->id) }}"
                               class="lead-link">

                                {{ $lead->name }}

                            </a>

                        </td>

                        <td>{{ $lead->email }}</td>

                        <td>{{ $lead->company }}</td>

                        <td>{{ $lead->country }}</td>

                        <td>{{ $lead->timezone }}</td>

                       <td class="local-time">
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
            echo \Carbon\Carbon::now($timezone)->format('h:i A');
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

                            <a href="{{ route('leads.show',$lead->id) }}"
                               class="btn-view">
                                View
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="12"
                            class="empty-row">

                            No Leads Received Today

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($todayLeads->count() > 3)

        <div class="view-all-wrap">
            <button type="button" class="btn-view-all" onclick="toggleRows('leadsTableCard', this)">
                View all
            </button>
        </div>

        @endif

    </div>

    <!-- FOLLOWUPS -->

    <div class="section-title mt-4">
        Today's follow-ups
    </div>
<div id="todays-followups">
    <div class="table-card" id="followupsTableCard">

        <div class="table-scroll">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Done</th>
                        <th>Lead ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Follow-up</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($followups as $lead)

                    <tr @if($loop->index >= 3) class="extra-row" style="display:none" @endif>

                        <td>

                            <input type="checkbox"
                                   class="task-checkbox"
                                   data-id="{{ $lead->id }}"
                                   {{ $lead->today_task_completed ? 'checked' : '' }}>

                        </td>

                        <td>
                            <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                        </td>

                        <td>

                            <a href="{{ route('leads.show',$lead->id) }}"
                               class="lead-link">

                                {{ $lead->name }}

                            </a>

                        </td>

                        <td>{{ $lead->email }}</td>

                        <td>{{ $lead->company }}</td>

                        <td>{{ $lead->country }}</td>

                        <td>{{ $lead->timezone }}</td>

                        <td class="local-time">

                            {{ \Carbon\Carbon::now($lead->timezone)->format('h:i A') }}

                        </td>

                        <td>

                            {{ $lead->followup_count }}/6

                        </td>

                        <td>

                            <span class="badge status-{{ $lead->status }}">
                                {{ ucfirst(str_replace('_',' ',$lead->status)) }}
                            </span>

                        </td>

                        <td>

                            {{ $lead->user?->name ?? 'Not Assigned' }}

                            @if($lead->user?->agent_id)
                                <div class="agent-id-badge">{{ $lead->user->agent_id }}</div>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('leads.show',$lead->id) }}"
                               class="btn-view">
                                View
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="12"
                            class="empty-row">

                            No Followups Scheduled Today

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($followups->count() > 3)

        <div class="view-all-wrap">
            <button type="button" class="btn-view-all" onclick="toggleRows('followupsTableCard', this)">
                View all
            </button>
        </div>

        @endif

    </div>
</div>  

    <!-- MEETINGS -->

    <div class="section-title mt-4">
        Today's meetings
    </div>

    <div class="table-card" id="meetingsTableCard">

        <div class="table-scroll">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Conducted</th>
                        <th>Time</th>
                        <th>Title</th>
                        <th>Lead / With</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($meetings as $meeting)

                    <tr @if($loop->index >= 3) class="extra-row" style="display:none" @endif>

                        <td>

                            <input type="checkbox"
                                   class="meeting-checkbox"
                                   data-id="{{ $meeting->id }}"
                                   {{ $meeting->conducted ? 'checked' : '' }}>

                        </td>

                        <td>{{ $meeting->scheduled_at->format('h:i A') }}</td>

                        <td>{{ $meeting->title }}</td>

                        <td>
                            {{ $meeting->meeting_with ?: $meeting->lead?->name }}
                            @if($meeting->lead?->lead_id)
                                <div class="lead-id-badge">{{ $meeting->lead->lead_id }}</div>
                            @endif
                        </td>

                        <td>{{ $meeting->duration_minutes }} min</td>

                        <td>

                            <span class="badge status-{{ $meeting->status }}">
                                {{ ucfirst($meeting->status) }}
                            </span>

                        </td>

                        <td>

                            {{ $meeting->user?->name ?? 'Not Assigned' }}

                            @if($meeting->user?->agent_id)
                                <div class="agent-id-badge">{{ $meeting->user->agent_id }}</div>
                            @endif

                        </td>

                        <td>

                            @if($meeting->lead_id)
                                <a href="{{ route('leads.show',$meeting->lead_id) }}"
                                   class="btn-view">
                                    View
                                </a>
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="empty-row">

                            No Meetings Scheduled Today

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($meetings->count() > 3)

        <div class="view-all-wrap">
            <button type="button" class="btn-view-all" onclick="toggleRows('meetingsTableCard', this)">
                View all
            </button>
        </div>

        @endif

    </div>

</div>

<script>

function reorderRows(checkbox){

    const tbody = checkbox.closest('tbody');

    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort(function(a, b){

        const aBox = a.querySelector('.task-checkbox, .meeting-checkbox');
        const bBox = b.querySelector('.task-checkbox, .meeting-checkbox');

        const aDone = aBox && aBox.checked ? 1 : 0;
        const bDone = bBox && bBox.checked ? 1 : 0;

        return aDone - bDone;

    });

    rows.forEach(function(row){
        tbody.appendChild(row);
    });

}

document.querySelectorAll('.task-checkbox')
.forEach(function(box){

    box.addEventListener('change', function(){

        fetch(
            '/leads/' + this.dataset.id + '/toggle-task',
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
                }
            }
        );

        reorderRows(this);

    });

});

document.querySelectorAll('.meeting-checkbox')
.forEach(function(box){

    box.addEventListener('change', function(){

        fetch(
            '/meetings/' + this.dataset.id + '/toggle-conducted',
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
                }
            }
        );

        reorderRows(this);

    });

});

function toggleRows(cardId, btn){

    const card = document.getElementById(cardId);
    const rows = card.querySelectorAll('.extra-row');

    if(!rows.length) return;

    const isHidden = rows[0].style.display === 'none';

    rows.forEach(function(row){
        row.style.display = isHidden ? '' : 'none';
    });

    btn.textContent = isHidden ? 'Show less' : 'View all';

}

</script>

@endsection
