<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentRegion extends Model
{
    protected $fillable = [
        'user_id',
        'region_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
