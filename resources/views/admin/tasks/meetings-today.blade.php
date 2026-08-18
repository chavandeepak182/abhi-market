@extends('admin.layouts.header')
@section('title', "Today's Meetings")

@push('styles')
<style>
.meetings-page{padding:30px;max-width:1150px;margin:auto}
.meetings-page h1{margin:0 0 8px}
.meetings-page p{color:#64748b}
.agent-filter-bar{display:flex;align-items:center;gap:10px;margin:18px 0}
.agent-filter-bar select{padding:8px 14px;border-radius:8px;border:1px solid #e2e8f0}
.meeting-table-wrap{background:#fff;border-radius:14px;box-shadow:0 2px 10px #0000000d;overflow:hidden;margin-top:12px}
.meeting-table{width:100%;border-collapse:collapse}
.meeting-table th{text-align:left;padding:14px 20px;background:#f8fafc;color:#64748b;font-size:13px;text-transform:uppercase;letter-spacing:.03em;border-bottom:1px solid #edf2f7}
.meeting-table td{padding:16px 20px;border-bottom:1px solid #edf2f7;vertical-align:top}
.meeting-table tr:last-child td{border-bottom:0}
.meeting-time{font-weight:700;color:#2563eb;white-space:nowrap}
.meeting-lead-name{font-weight:700;color:#1f2937}
.meeting-email{color:#64748b;font-size:14px}
.meeting-agenda{color:#334155}
.meeting-local-time{color:#16a34a;font-weight:600;white-space:nowrap}
.meeting-link{color:#2563eb;text-decoration:none;font-weight:600;white-space:nowrap}
.meeting-empty{padding:35px;text-align:center;color:#94a3b8}
.badge{display:inline-block;padding:6px 10px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap}
.priority-high{background:#fee2e2;color:#b91c1c}
.priority-medium{background:#fef9c3;color:#a16207}
.priority-low{background:#f1f5f9;color:#475569}
@media(max-width:700px){.meetings-page{padding:16px}.meeting-table thead{display:none}.meeting-table,.meeting-table tbody,.meeting-table tr,.meeting-table td{display:block;width:100%}.meeting-table tr{padding:16px 20px;border-bottom:1px solid #edf2f7}.meeting-table td{padding:4px 0;border:0}}
</style>
@endpush

@section('content')
<main class="meetings-page">
    <h1>Today's Meetings</h1>
    <p>{{ now()->format('l, d M Y') }} - All Agents</p>

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

    <div class="meeting-table-wrap">
        @if($meetings->isEmpty())
            <div class="meeting-empty">No meetings scheduled for today.</div>
        @else
            <table class="meeting-table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Time</th>
                        <th>Agent</th>
                        <th>Lead Name</th>
                        <th>Email</th>
                        <th>Lead's Local Time</th>
                        <th>Agenda</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $meeting)
                        <tr>
                            <td>
                                <span class="badge {{ $meeting->priority_class }}">
                                    {{ $meeting->priority_label }}
                                </span>
                            </td>
                            <td class="meeting-time">{{ $meeting->scheduled_at->format('h:i A') }}</td>
                            <td>{{ $meeting->user->name ?? '-' }}</td>
                            <td class="meeting-lead-name">
                                {{ $meeting->lead?->name ?? $meeting->meeting_with ?? '—' }}
                            </td>
                            <td class="meeting-email">{{ $meeting->lead?->email ?? '-' }}</td>
                            <td class="meeting-local-time">
                                {{ $meeting->lead?->timezone ? \Carbon\Carbon::now($meeting->lead->timezone)->format('h:i A') : '-' }}
                            </td>
                            <td class="meeting-agenda">{{ $meeting->notes ?: '-' }}</td>
                            <td>
                                @if($meeting->enquiry_id)
                                    <a href="{{ route('leads.show', $meeting->enquiry_id) }}" class="meeting-link">View Lead</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
@endsection
