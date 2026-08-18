<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'enquiry_attachments';

    protected $fillable = [
        'enquiry_id',
        'user_id',
        'file_name',
        'file_path',
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
