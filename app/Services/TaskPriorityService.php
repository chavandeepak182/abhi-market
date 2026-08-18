<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\Meeting;
use Carbon\Carbon;

/**
 * Works out how urgent a lead/followup/meeting is for the Today's Tasks
 * and Meetings dashboards (admin + agent). Ported 1:1 from global-crm's
 * Agent\DashboardController (leadPriorityMeta / meetingPriorityMeta), just
 * pulled out into a shared service so both the admin and agent controllers
 * can use the exact same rule instead of two copies drifting apart.
 */
class TaskPriorityService
{
    private const WORK_START_HOUR = 9;  // 9:00 AM lead-local
    private const WORK_END_HOUR = 18; // 6:00 PM lead-local

    /**
     * rank 0 = High (closing within the hour) - bubbles to the top
     * rank 1 = Medium (inside working hours)
     * rank 2 = Low (window not open yet, already closed, or unknown tz)
     */
    public static function leadPriorityMeta(?string $timezone): array
    {
        if (! $timezone) {
            return [
                'rank'    => 2,
                'minutes' => 9999,
                'label'   => 'Low · Timezone Unknown',
                'class'   => 'priority-low',
            ];
        }

        try {
            $now = Carbon::now($timezone);
        } catch (\Exception $e) {
            return [
                'rank'    => 2,
                'minutes' => 9999,
                'label'   => 'Low · Timezone Unknown',
                'class'   => 'priority-low',
            ];
        }

        $hour = $now->hour + ($now->minute / 60);
        $start = self::WORK_START_HOUR;
        $end = self::WORK_END_HOUR;

        // Currently inside the lead's 9AM-6PM working window
        if ($hour >= $start && $hour < $end) {
            $minutesLeft = ($end - $hour) * 60;

            if ($minutesLeft <= 60) {
                return [
                    'rank'    => 0,
                    'minutes' => $minutesLeft,
                    'label'   => 'High · Closing in '.self::formatMinutes($minutesLeft),
                    'class'   => 'priority-high',
                ];
            }

            return [
                'rank'    => 1,
                'minutes' => $minutesLeft,
                'label'   => 'Medium · In Working Hours',
                'class'   => 'priority-medium',
            ];
        }

        // Window hasn't opened yet today
        if ($hour < $start) {
            $minutesToOpen = ($start - $hour) * 60;

            return [
                'rank'    => 2,
                'minutes' => $minutesToOpen,
                'label'   => 'Low · Opens in '.self::formatMinutes($minutesToOpen),
                'class'   => 'priority-low',
            ];
        }

        // Window already closed for today
        $minutesSinceClose = ($hour - $end) * 60;

        return [
            'rank'    => 2,
            'minutes' => $minutesSinceClose,
            'label'   => 'Low · Closed For Today',
            'class'   => 'priority-low',
        ];
    }

    public static function formatMinutes(float $minutes): string
    {
        $minutes = max(0, round($minutes));
        $h = intdiv((int) $minutes, 60);
        $m = ((int) $minutes) % 60;

        return $h > 0 ? $h.'h '.$m.'m' : $m.'m';
    }

    /** Attaches priority_rank / priority_minutes / priority_label / priority_class onto the model. */
    public static function applyLeadMeta(Enquiry $lead): void
    {
        $meta = self::leadPriorityMeta($lead->timezone);

        $lead->priority_rank = $meta['rank'];
        $lead->priority_minutes = $meta['minutes'];
        $lead->priority_label = $meta['label'];
        $lead->priority_class = $meta['class'];
    }

    /**
     * A meeting's urgency is based on what time it is RIGHT NOW in the
     * linked lead's own timezone, relative to the 9AM-6PM working window -
     * same rule as leads/followups, so the most time-sensitive meeting
     * (lead's window closing soonest) bubbles to the top.
     */
    public static function meetingPriorityMeta(Meeting $meeting): array
    {
        if (! $meeting->enquiry) {
            return [
                'rank'    => 2,
                'minutes' => 9999,
                'label'   => 'Low · No Lead Linked',
                'class'   => 'priority-low',
            ];
        }

        return self::leadPriorityMeta($meeting->enquiry->timezone);
    }

    public static function applyMeetingMeta(Meeting $meeting): void
    {
        $meta = self::meetingPriorityMeta($meeting);

        $meeting->priority_rank = $meta['rank'];
        $meeting->priority_minutes = $meta['minutes'];
        $meeting->priority_label = $meta['label'];
        $meeting->priority_class = $meta['class'];
    }
}
