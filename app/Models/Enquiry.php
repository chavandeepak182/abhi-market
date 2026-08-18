<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'message',
        'enquiry_type',
        'page_url',
        'company_name',
        'job_title',
        'usage_type',
        'status',
        'lead_type',
        'country_id',
        'timezone',
        'timezone_region',
        'assigned_to',
        'assigned_by',
        'followup_date',
        'converted_amount',
        'has_unread_reply',
        'today_task_completed',
        'followup_count',
    ];

    protected $casts = [
        'followup_date'         => 'date',
        'has_unread_reply'      => 'boolean',
        'today_task_completed'  => 'boolean',
        'followup_count'        => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** The agent this enquiry/lead is assigned to. */
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** Combined note / status / reassign / email / attachment activity feed. */
    public function activities()
    {
        return $this->hasMany(EnquiryActivity::class, 'enquiry_id')->latest();
    }

    /** Completed automated-followup log (see App\Models\ScheduledFollowup). */
    public function followupHistories()
    {
        return $this->hasMany(EnquiryFollowupHistory::class, 'enquiry_id')->latest('completed_at');
    }

    /** Manual followup notes (the older /followup/{id} flow). */
    public function followups()
    {
        return $this->hasMany(EnquiryFollowup::class, 'enquiry_id');
    }

    /** Email thread history, stored in ai_email_logs. */
    public function emails()
    {
        return $this->hasMany(EmailMessage::class, 'enquiry_id');
    }

    /** Extra manually-uploaded attachments. */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'enquiry_id');
    }

    /** Scheduled meetings with this lead. */
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'enquiry_id');
    }

    /** Queued automated follow-up emails (see App\Services\FollowupScheduler). */
    public function scheduledFollowups()
    {
        return $this->hasMany(ScheduledFollowup::class, 'enquiry_id');
    }

    /*
    |--------------------------------------------------------------------------
    | CRM-style accessors
    |--------------------------------------------------------------------------
    | abhi-market's `enquiries` table predates the CRM-style lead detail
    | pages, so these map the CRM attribute names those pages use onto the
    | real columns here, instead of renaming the real columns everywhere
    | else in the app that already relies on them.
    */

    /** Display code for the lead, e.g. "ENQ-00042". */
    public function getLeadIdAttribute()
    {
        return 'ENQ-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getPhoneAttribute()
    {
        return $this->attributes['contact'] ?? null;
    }

    public function getCompanyAttribute()
    {
        return $this->attributes['company_name'] ?? null;
    }

    public function getDesignationAttribute()
    {
        return $this->attributes['job_title'] ?? null;
    }

    /** Next followup date - alias of the existing `followup_date` column. */
    public function getNextFollowupDateAttribute()
    {
        return $this->followup_date;
    }

    /** Country name, resolved from country_id (no local Country model exists). */
    public function getCountryAttribute()
    {
        if (! $this->country_id) {
            return null;
        }

        return DB::table('countries')->where('id', $this->country_id)->value('name');
    }
}
