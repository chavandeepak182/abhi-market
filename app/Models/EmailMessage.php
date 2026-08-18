<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model
{
    // ai_email_logs is abhi-market's existing email log table (already
    // written to by ProcessEnquiryAI / SyncGmail / SyncCustomerEmails /
    // FetchEmails) - reused here instead of a parallel email_messages
    // table, extended with the CRM columns via migration.
    protected $table = 'ai_email_logs';

    protected $fillable = [
        'enquiry_id',
        'agent_id',
        'source',
        'message_type',
        'delivery_status',
        'delivery_error',

        'email_subject',
        'email_body',
        // Accepted as mass-assignable input too - the mutators below keep
        // these in sync with email_subject/email_body either way, so
        // callers can pass whichever naming they use.
        'subject',
        'body',

        'attachment_path',
        'attachment_name',

        'from_email',
        'to_email',
        'cc_email',
        'bcc_email',

        'reply_to',

        'message_id',
        'in_reply_to',

        'thread_id',
        'conversation_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function attachments()
    {
        return $this->hasMany(EmailMessageAttachment::class, 'email_message_id');
    }

    /*
    |--------------------------------------------------------------------------
    | subject / body accessors
    |--------------------------------------------------------------------------
    | email_subject / email_body remain the canonical columns written by
    | the existing AI email pipeline. The CRM-style lead detail page reads
    | ->subject / ->body, so these keep both in sync without touching that
    | existing code.
    */

    public function getSubjectAttribute($value)
    {
        return $value ?: $this->attributes['email_subject'] ?? null;
    }

    public function getBodyAttribute($value)
    {
        return $value ?: $this->attributes['email_body'] ?? null;
    }

    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = $value;
        $this->attributes['email_subject'] = $value;
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = $value;
        $this->attributes['email_body'] = $value;
    }
}
