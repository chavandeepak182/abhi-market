<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Kept as a thin alias over EnquiryFollowupHistory (same table) in case
 * anything references App\Models\FollowupHistory directly - prefer
 * App\Models\EnquiryFollowupHistory / Enquiry::followupHistories() for
 * new code.
 */
class FollowupHistory extends Model
{
    protected $table = 'enquiry_followup_histories';

    protected $fillable = [
        'enquiry_id',
        'followup_no',
        'header',
        'user_id',
        'remarks',
        'completed_at',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
