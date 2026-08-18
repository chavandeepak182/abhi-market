<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'on_leave' => 'boolean',
        ];
    }

    /**
     * Broad timezone regions (see App\Services\TimezoneRegionMapper) this
     * agent covers - used for auto-assigning new website enquiries.
     */
    public function agentRegions()
    {
        return $this->hasMany(\App\Models\AgentRegion::class);
    }

    /**
     * Enquiries currently assigned to this agent - used to find the
     * least-loaded agent in a region when auto-assigning a new lead.
     */
    public function enquiries()
    {
        return $this->hasMany(\App\Models\Enquiry::class, 'assigned_to');
    }

    /**
     * The agent who covers this agent's leads while they're on_leave, if
     * one has been designated (see EnquiryController::store's auto-assign
     * logic).
     */
    public function coveredBy()
    {
        return $this->belongsTo(User::class, 'covered_by_id');
    }
}
