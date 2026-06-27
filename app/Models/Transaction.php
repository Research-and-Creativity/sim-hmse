<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'description',
        'amount',
        'method',
        'proof_path',
        'proposal_id',
        'user_id',
    ];

    /**
     * Get the proposal associated with the transaction (if any).
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Get the user who created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
