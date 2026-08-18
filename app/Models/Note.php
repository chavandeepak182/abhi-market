<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Notes are stored as activity_type='note' rows in enquiry_activities
 * (see LeadController::storeNote / EnquiryController::storeNote) so the
 * "Notes & Activity" feed on both lead detail pages is a single combined
 * timeline instead of two separate lists. This model is kept for schema
 * parity / direct queries, scoped to that activity_type.
 */
class Note extends Model
{
    protected $table = 'enquiry_activities';

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'description',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notes', function ($query) {
            $query->where('activity_type', 'note');
        });

        static::creating(function ($note) {
            $note->activity_type = 'note';
        });
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
