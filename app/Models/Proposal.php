<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'proker_id',
        'user_id',
        'title',
        'proker',
        'divisi',
        'status',
        'ketua_panitia',
        'sekretaris',
        'background',
        'objective',
        'tema_kegiatan',
        'jenis_kegiatan',
        'manfaat_kegiatan',
        'bentuk_kegiatan',
        'sasaran_peserta',
        'tanggal_pelaksanaan',
        'waktu_pelaksanaan',
        'tempat_pelaksanaan',
        'timeline',
        'budget',
        'risk_level',
        'risk_description',
        'penutup',
        'file_path',
        'rejection_reason',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created this proposal
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proker(): BelongsTo
    {
        return $this->belongsTo(ProgramKerja::class, 'proker_id');
    }

    /**
     * Get all approvals for this proposal
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(ProposalApproval::class)->orderBy('approval_order');
    }

    /**
     * Check if proposal is approved by all required approvers
     */
    public function isFullyApproved(): bool
    {
        $approvals = $this->approvals;
        if ($approvals->isEmpty()) {
            return false;
        }
        return $approvals->every(fn($approval) => $approval->status === 'approved');
    }

    /**
     * Get next approver role that needs to approve
     */
    public function getNextApproverRole(): ?string
    {
        return $this->approvals()
            ->where('status', 'pending')
            ->orderBy('approval_order')
            ->first()
            ?->approver_role;
    }
}
