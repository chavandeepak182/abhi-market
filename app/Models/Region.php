<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'active',
    ];

    /**
     * Agents (users) who cover this region, via the agent_timezone pivot.
     */
    public function agents()
    {
        return $this->belongsToMany(User::class, 'agent_timezone');
    }
}
