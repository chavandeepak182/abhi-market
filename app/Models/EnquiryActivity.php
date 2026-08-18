<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryActivity extends Model
{
    protected $table = 'enquiry_activities';

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'activity_type',
        'description',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** "by <name>" line on the admin lead detail page. */
    public function getCreatedByAttribute()
    {
        return $this->user?->name ?? 'System';
    }

    /** Same thing, under the name the agent lead detail page uses. */
    public function getUserNameAttribute()
    {
        return $this->user?->name ?? 'System';
    }
}
