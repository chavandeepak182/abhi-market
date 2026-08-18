<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [

        'name',

        'subject',

        'body'
        ,'type', 'days_after_creation', 'followup_number'
    ];

    /**
     * The single template a user can pick manually from an email
     * composer's dropdown. Excludes 'followup' templates, which are only
     * ever used by the automated follow-up scheduler (see
     * FollowupScheduler / SendScheduledFollowups) and should never show
     * up as something an admin or agent picks by hand while sending a
     * one-off email.
     *
     * Only one Sample Report (global) template is supported at a time -
     * same rule as the Email Templates admin page (see
     * EmailTemplateController::index / admin.email-templates.index),
     * which is why this is capped to a single row instead of returning
     * every 'global' row. Ordering by name keeps this in sync with that
     * page, which also treats the alphabetically-first 'global' row as
     * *the* Sample Report template - so whichever one shows up here is
     * always the same one shown (and editable) there. Any other 'global'
     * rows left over from before this was locked down to one (e.g. a
     * leftover "Energy" or other extra template) are simply never
     * returned, so they can no longer be picked when sending an email -
     * even though the rows still exist in the database until an admin
     * deletes them directly.
     */
    public function scopeSendable($query)
    {
        return $query->where('type', 'global')->orderBy('name')->limit(1);
    }
}
