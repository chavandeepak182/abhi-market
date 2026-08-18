<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledFollowup extends Model
{
    protected $table = 'enquiry_scheduled_followups';

    protected $fillable = [
        'enquiry_id', 'user_id', 'email_template_id', 'sequence',
        'scheduled_at', 'sent_at', 'cancelled_at', 'subject', 'body',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function enquiry() { return $this->belongsTo(Enquiry::class, 'enquiry_id'); }
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function template() { return $this->belongsTo(EmailTemplate::class, 'email_template_id'); }
}
