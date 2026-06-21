<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryFollowup extends Model
{
    use HasFactory;

    protected $table = 'enquiry_followups';

    protected $fillable = [
        'enquiry_id',
        'followup_date',
        'remark',
        'client_reply',
        'status',
        'lead_type',
        'user_id',
        'job_title'
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