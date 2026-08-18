<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Kept as a thin alias over EnquiryActivity (same table) in case anything
 * references App\Models\LeadActivity directly - prefer
 * App\Models\EnquiryActivity / Enquiry::activities() for new code.
 */
class LeadActivity extends Model
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
}
