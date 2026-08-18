{{--
    Site-wide meeting reminder popups - ported 1:1 from global-crm's
    subviews/meeting-reminders.blade.php.

    Included once in admin.layouts.header (site-wide) so it keeps polling
    and firing no matter which page the agent is on, not just while they
    happen to be sitting on the Lead Details page.

    Reminds 60 and 15 minutes before each scheduled meeting.
--}}
@if(session('role_id') == config('constants.roles.agent'))
<script>
(function(){
    const REMINDER_OFFSETS_MIN = [60, 15]; // minutes-before-start to remind at
    const POLL_INTERVAL_MS = 5 * 60 * 1000; // re-check for newly scheduled meetings every 5 min
    const UPCOMING_URL = '{{ route('enquiry.meetings.upcoming') }}';
    const armed = new Set(); // "meetingId:offset" keys we've already scheduled a timer for

    function requestPermission(){
        if('Notification' in window && Notification.permission === 'default'){
            Notification.requestPermission();
        }
    }

    function fire(meeting, minutesBefore){
        const body = minutesBefore > 0
            ? meeting.title + ' starts in ' + minutesBefore + ' minute' + (minutesBefore === 1 ? '' : 's') + ' (' + meeting.time + ')'
            : meeting.title + ' is starting now (' + meeting.time + ')';

        if('Notification' in window && Notification.permission === 'granted'){
            new Notification('Meeting reminder', { body: body });
        } else if (typeof window.ldToast === 'function') {
            window.ldToast('Meeting reminder: ' + body, 'info');
        } else {
            // Fallback minimal toast if we're on a page without ldToast()
            console.log('Meeting reminder: ' + body);
        }
    }

    function arm(meeting){
        const startMs = new Date(meeting.scheduled_at).getTime();

        REMINDER_OFFSETS_MIN.forEach(function(minutesBefore){
            const key = meeting.id + ':' + minutesBefore;
            if(armed.has(key)){ return; }

            const fireAt = startMs - (minutesBefore * 60 * 1000);
            const delay = fireAt - Date.now();

            // Only arm timers that are still in the future and within
            // setTimeout's safe range (browsers cap large delays at ~24 days,
            // and upcomingMeetings() already only returns the next 24h anyway).
            if(delay > 0 && delay < 24 * 60 * 60 * 1000){
                armed.add(key);
                setTimeout(function(){ fire(meeting, minutesBefore); }, delay);
            }
        });
    }

    // Exposed so a page can immediately arm reminders for a meeting it just
    // created, without waiting for the next poll.
    window.crmArmMeetingReminders = arm;

    function poll(){
        fetch(UPCOMING_URL, { headers: { 'Accept': 'application/json' } })
            .then(function(r){ return r.json(); })
            .then(function(list){ (list || []).forEach(arm); })
            .catch(function(){ /* silent: reminders just won't fire this round */ });
    }

    document.addEventListener('DOMContentLoaded', function(){
        requestPermission();
        poll();
        setInterval(poll, POLL_INTERVAL_MS);
    });
})();
</script>
@endif
