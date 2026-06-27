<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinanceProker extends Model
{
    protected $guarded = [];

    protected $fillable = ['proker_id', 'title', 'type', 'amount', 'transaction_date', 'method', 'description', 'created_by'];

    public function programKerja(): BelongsTo
    {
        return $this->belongsTo(ProgramKerja::class, 'proker_id');
    }
}
