<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Enquiry;
use App\Models\ScheduledFollowup;

class FollowupScheduler
{
    /**
     * Build the automatic follow-up email schedule for a newly created
     * lead, based on the "minutes after creation" gap the admin has
     * configured on each follow-up email template, and stamp the lead's
     * followup_date with the earliest date in that schedule.
     *
     * This is the single source of truth for followup_date - it is
     * never typed in manually by an agent. If the admin changes a
     * template's day-gap later, that only affects leads created after the
     * change; leads already scheduled keep their original dates.
     */
    public static function scheduleForLead(Enquiry $lead): void
    {
        $templates = EmailTemplate::where('type', 'followup')
            ->whereNotNull('days_after_creation')
            ->whereNotNull('followup_number')
            ->orderBy('followup_number')
            ->take(6)
            ->get();

        if ($templates->isEmpty()) {
            return;
        }

        $earliest = null;

        foreach ($templates as $template) {

            $scheduledAt = now()->copy()->addMinutes($template->days_after_creation);

            ScheduledFollowup::create([
                'enquiry_id' => $lead->id,
                'user_id' => $lead->assigned_to,
                'email_template_id' => $template->id,
                'sequence' => $template->followup_number,
                'scheduled_at' => $scheduledAt,
                'subject' => $template->subject,
                'body' => $template->body,
            ]);

            if (! $earliest || $scheduledAt->lt($earliest)) {
                $earliest = $scheduledAt;
            }
        }

        $lead->update([
            'followup_date' => $earliest->toDateString(),
        ]);
    }

    /**
     * Move followup_date forward to whatever follow-up is still pending
     * after one has just gone out. Called right after a follow-up email
     * is sent.
     */
    public static function advance(Enquiry $lead): void
    {
        $next = $lead->scheduledFollowups()
            ->whereNull('sent_at')
            ->whereNull('cancelled_at')
            ->orderBy('scheduled_at')
            ->first();

        $lead->update([
            'followup_date' => $next?->scheduled_at?->toDateString(),
        ]);
    }
}
