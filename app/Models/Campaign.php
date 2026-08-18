<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function leads()
    {
        return $this->belongsToMany(Enquiry::class, 'campaign_leads', 'campaign_id', 'enquiry_id');
    }
}
