@extends('admin.layouts.header')

@push('styles')
<style>
.meetings-page{padding:30px;max-width:1150px;margin:auto}.meetings-page h1{margin:0 0 8px}.meetings-page p{color:#64748b}.meeting-table-wrap{background:#fff;border-radius:14px;box-shadow:0 2px 10px #0000000d;overflow:hidden;margin-top:24px}.meeting-table{width:100%;border-collapse:collapse}.meeting-table th{text-align:left;padding:14px 20px;background:#f8fafc;color:#64748b;font-size:13px;text-transform:uppercase;letter-spacing:.03em;border-bottom:1px solid #edf2f7}.meeting-table td{padding:16px 20px;border-bottom:1px solid #edf2f7;vertical-align:top}.meeting-table tr:last-child td{border-bottom:0}.meeting-time{font-weight:700;color:#2563eb;white-space:nowrap}.meeting-lead-name{font-weight:700;color:#1f2937}.meeting-email{color:#64748b;font-size:14px}.meeting-agenda{color:#334155}.meeting-local-time{color:#16a34a;font-weight:600;white-space:nowrap}.meeting-link{color:#2563eb;text-decoration:none;font-weight:600;white-space:nowrap}.meeting-empty{padding:35px;text-align:center;color:#94a3b8}.badge{display:inline-block;padding:6px 10px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap}.priority-high{background:#fee2e2;color:#b91c1c}.priority-medium{background:#fef9c3;color:#a16207}.priority-low{background:#f1f5f9;color:#475569}@media(max-width:700px){.meetings-page{padding:16px}.meeting-table thead{display:none}.meeting-table,.meeting-table tbody,.meeting-table tr,.meeting-table td{display:block;width:100%}.meeting-table tr{padding:16px 20px;border-bottom:1px solid #edf2f7}.meeting-table td{padding:4px 0;border:0}}
</style>
@endpush

@section('content')
<main class="meetings-page">
    <h1>Today's Meetings</h1>
    <p>{{ now()->format('l, d M Y') }}</p>

    <div class="meeting-table-wrap">
        @if($meetings->isEmpty())
            <div class="meeting-empty">No meetings scheduled for today.</div>
        @else
            <table class="meeting-table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Time</th>
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
                            <td class="meeting-lead-name">
                                {{ $meeting->lead?->name ?? $meeting->meeting_with ?? '—' }}
                                @if($meeting->lead?->lead_id)
                                    <span class="lead-id-badge">{{ $meeting->lead->lead_id }}</span>
                                @endif
                            </td>
                            <td class="meeting-email">{{ $meeting->lead?->email ?? '—' }}</td>
                            <td class="meeting-local-time meeting-live-clock" data-tz="{{ $meeting->lead?->timezone }}">
                                {{ $meeting->lead?->timezone ? \Carbon\Carbon::now($meeting->lead->timezone)->format('h:i A') : '—' }}
                            </td>
                            <td class="meeting-agenda">{{ $meeting->title ?: ($meeting->notes ?: '—') }}</td>
                            <td><a class="meeting-link" href="{{ route('agent.lead.details', $meeting->lead_id) }}">View lead</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

<script>
/* Keep each lead's local-time column ticking, same pattern as the lead details page */
function meetingUpdateClocks(){
    document.querySelectorAll('.meeting-live-clock').forEach(function(el){
        const tz = el.dataset.tz;
        if(!tz){ return; }
        try{
            el.textContent = new Intl.DateTimeFormat('en-US', {
                timeZone: tz,
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }).format(new Date());
        }catch(e){ /* invalid timezone string, leave server-rendered value */ }
    });
}
meetingUpdateClocks();
setInterval(meetingUpdateClocks, 30000);
</script>
@endsection
