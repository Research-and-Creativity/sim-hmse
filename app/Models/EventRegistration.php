<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'program_kerja_id',
        'name',
        'nim',
        'email',
        'phone',
        'prodi',
        'semester',
        'note',
        'status',
        'token',
    ];

    public function programKerja(): BelongsTo
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}
