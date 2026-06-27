<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKerja extends Model
{
    protected $fillable = [
        'name',
        'division',
        'status',
        'pj_user_id',
        'date_start',
        'date_end',
        'description',
        'location',
        'target_participants',
        'risk_level',
        'progress',
        'color',
        'timeline',
        'documents',
        'budget_items',
        'committee_member_ids',
        'poster',
        'is_public',
        'open_registration',
        'registration_deadline',
        'registration_quota',
    ];

    protected $casts = [
        'date_start'            => 'date',
        'date_end'              => 'date',
        'timeline'              => 'array',
        'documents'             => 'array',
        'budget_items'          => 'array',
        'committee_member_ids'  => 'array',
        'is_public'             => 'boolean',
        'open_registration'     => 'boolean',
        'registration_deadline' => 'datetime',
    ];

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
}

