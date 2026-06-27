<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalApproval extends Model
{
    protected $fillable = [
        'proposal_id',
        'approver_id',
        'approver_role',
        'status',
        'signature_data',
        'notes',
        'approved_at',
        'approval_order',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the proposal being approved
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Get the user who is approving
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Mark as approved with optional signature
     */
    public function approve(string $signatureData = null, string $notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'signature_data' => $signatureData,
            'notes' => $notes,
            'approved_at' => now(),
        ]);
    }

    /**
     * Mark as rejected with reason
     */
    public function reject(string $reason): void
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $reason,
        ]);
    }
}
