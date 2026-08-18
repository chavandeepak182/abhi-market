<div class="calendar-card" style="margin-top:25px">
    <h3>Meetings and calls</h3>
    @forelse($meetingsForDay as $meeting)
        <div style="padding:12px 0;border-bottom:1px solid #e5e7eb"><strong>{{ $meeting->scheduled_at->format('h:i A') }} — {{ $meeting->title }}</strong><br><small>{{ $meeting->lead?->name }}@if($meeting->lead?->lead_id) ({{ $meeting->lead->lead_id }})@endif · {{ $meeting->duration_minutes }} minutes @if($meeting->notes) · {{ $meeting->notes }} @endif</small></div>
    @empty
        <p>No meetings or calls scheduled for this date.</p>
    @endforelse
</div>
