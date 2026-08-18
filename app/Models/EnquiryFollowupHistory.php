<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryFollowupHistory extends Model
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

    protected $casts = [
        'completed_at' => 'datetime',
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
