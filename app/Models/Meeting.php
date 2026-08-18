<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = 'enquiry_meetings';

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'title',
        'meeting_with',
        'scheduled_at',
        'duration_minutes',
        'notes',
        'status',
        'conducted',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'conducted'    => 'boolean',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    /** Alias of enquiry() - the CRM-style views read $meeting->lead. */
    public function lead()
    {
        return $this->enquiry();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
