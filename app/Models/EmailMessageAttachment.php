<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailMessageAttachment extends Model
{
    protected $fillable = ['email_message_id', 'file_name', 'file_path', 'file_size'];

    public function emailMessage()
    {
        return $this->belongsTo(EmailMessage::class, 'email_message_id');
    }
}
