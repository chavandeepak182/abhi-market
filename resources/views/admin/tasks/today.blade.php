@extends('admin.layouts.header')
@section('title', "Today's Work Dashboard")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
<style>
.agent-filter-bar{display:flex;align-items:center;gap:10px;margin-bottom:18px}
.agent-filter-bar select{padding:8px 14px;border-radius:8px;border:1px solid #e2e8f0}
.agent-col{color:#475569;font-size:13px}
</style>
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Today's Work Dashboard</h1>
            <p class="page-subtitle">All Agents - New Leads + Scheduled Followups + Meetings</p>
        </div>
    </div>

    <form method="GET" class="agent-filter-bar">
        <label for="agent_id">Agent:</label>
        <select name="agent_id" id="agent_id" onchange="this.form.submit()">
            <option value="">All Agents</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}" {{ (string) $agentFilter === (string) $agent->id ? 'selected' : '' }}>
                    {{ $agent->name }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="summary-cards">
        <div class="summary-card">
            <span>Today's Leads</span>
            <h3>{{ $todayLeads->count() }}</h3>
        </div>
        <div class="summary-card hot-card">
            <span>Today's Followups</span>
            <h3>{{ $followups->count() }}</h3>
        </div>
        <div class="summary-card warm-card">
            <span>Completed Tasks</span>
            <h3>{{ $completedTasks }}</h3>
        </div>
        <div class="summary-card cold-card">
            <span>Pending Tasks</span>
            <h3>{{ $pendingTasks }}</h3>
        </div>
    </div>

    <!-- TODAY LEADS -->
    <div class="section-title">Today's New Leads</div>

    <div class="table-card">
        <div class="table-scroll">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Done</th>
                        <th>Priority</th>
                        <th>Name</th>
                        <th>Agent</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Status</th>
                        <th>Lead Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayLeads as $lead)
                    <tr>
                        <td>
                            <input type="checkbox" class="task-checkbox" data-id="{{ $lead->id }}"
                                   {{ $lead->today_task_completed ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span class="badge {{ $lead->priority_class }}" title="Based on {{ $lead->timezone }} local time">
                                {{ $lead->priority_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('leads.show', $lead->id) }}" class="lead-link">{{ $lead->name }}</a>
                            <div class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</div>
                        </td>
                        <td class="agent-col">{{ $lead->user->name ?? '-' }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->company }}</td>
                        <td>{{ $lead->country }}</td>
                        <td>{{ $lead->timezone }}</td>
                        <td>{{ $lead->timezone ? \Carbon\Carbon::now($lead->timezone)->format('h:i A') : '-' }}</td>
                        <td><span class="badge status-{{ $lead->status }}">{{ ucfirst(str_replace('_',' ',$lead->status)) }}</span></td>
                        <td><span class="badge type-{{ $lead->lead_type }}">{{ ucfirst($lead->lead_type) }}</span></td>
                        <td><a href="{{ route('leads.show', $lead->id) }}" class="btn-view">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="12" class="empty-row">No Leads Received Today</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOLLOWUPS -->
    <div class="section-title mt-4">Today's Followups</div>

    <div class="table-card">
        <div class="table-scroll">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Done</th>
                        <th>Priority</th>
                        <th>Name</th>
                        <th>Agent</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Local Time</th>
                        <th>Followup</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($followups as $lead)
                    <tr>
                        <td>
                            <input type="checkbox" class="task-checkbox" data-id="{{ $lead->id }}"
                                   {{ $lead->today_task_completed ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span class="badge {{ $lead->priority_class }}" title="Based on {{ $lead->timezone }} local time">
                                {{ $lead->priority_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('leads.show', $lead->id) }}" class="lead-link">{{ $lead->name }}</a>
                            <div class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</div>
                        </td>
                        <td class="agent-col">{{ $lead->user->name ?? '-' }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->company }}</td>
                        <td>{{ $lead->country }}</td>
                        <td>{{ $lead->timezone }}</td>
                        <td>{{ $lead->timezone ? \Carbon\Carbon::now($lead->timezone)->format('h:i A') : '-' }}</td>
                        <td>{{ $lead->followup_count }}/6</td>
                        <td><span class="badge status-{{ $lead->status }}">{{ ucfirst(str_replace('_',' ',$lead->status)) }}</span></td>
                        <td><a href="{{ route('leads.show', $lead->id) }}" class="btn-view">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="12" class="empty-row">No Followups Scheduled Today</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MEETINGS -->
    <div class="section-title mt-4">Today's Meetings</div>

    <div class="table-card">
        <div class="table-scroll">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Conducted</th>
                        <th>Priority</th>
                        <th>Time</th>
                        <th>Title</th>
                        <th>Agent</th>
                        <th>Lead / With</th>
                        <th>Lead's Local Time</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meetings as $meeting)
                    <tr>
                        <td>
                            <input type="checkbox" class="meeting-checkbox" data-id="{{ $meeting->id }}"
                                   {{ $meeting->conducted ? 'checked' : '' }}>
                        </td>
                        <td><span class="badge {{ $meeting->priority_class }}">{{ $meeting->priority_label }}</span></td>
                        <td>{{ $meeting->scheduled_at->format('h:i A') }}</td>
                        <td>{{ $meeting->title }}</td>
                        <td class="agent-col">{{ $meeting->user->name ?? '-' }}</td>
                        <td>
                            {{ $meeting->meeting_with ?: $meeting->lead?->name }}
                            @if($meeting->lead?->lead_id)
                                <div class="lead-id-badge">{{ $meeting->lead->lead_id }}</div>
                            @endif
                        </td>
                        <td>{{ $meeting->lead?->timezone ? \Carbon\Carbon::now($meeting->lead->timezone)->format('h:i A') : '-' }}</td>
                        <td>{{ $meeting->duration_minutes }} min</td>
                        <td><span class="badge status-{{ $meeting->status }}">{{ ucfirst($meeting->status) }}</span></td>
                        <td>
                            @if($meeting->enquiry_id)
                                <a href="{{ route('leads.show', $meeting->enquiry_id) }}" class="btn-view">View</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="empty-row">No Meetings Scheduled Today</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
    rows.forEach(function(row){ tbody.appendChild(row); });
}

document.querySelectorAll('.task-checkbox').forEach(function(box){
    box.addEventListener('change', function(){
        fetch('/admin/tasks/' + this.dataset.id + '/toggle', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        reorderRows(this);
    });
});

document.querySelectorAll('.meeting-checkbox').forEach(function(box){
    box.addEventListener('change', function(){
        fetch('/admin/tasks/meeting/' + this.dataset.id + '/toggle-conducted', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        reorderRows(this);
    });
});
</script>

@endsection
