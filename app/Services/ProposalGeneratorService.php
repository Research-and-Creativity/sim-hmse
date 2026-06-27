<?php

namespace App\Services;

use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProposalGeneratorService
{
    /**
     * Generate PDF for proposal
     */
    public function generatePdf(Proposal $proposal): string
    {
        // Determine which template based on risk level
        $template = $proposal->risk_level === 'high'
            ? 'documents.proposals.pdf-template-high-risk'
            : 'documents.proposals.pdf-template-low-risk';

        // Generate PDF
        $pdf = Pdf::loadView($template, [
            'proposal' => $proposal,
        ])->setPaper('a4', 'portrait');

        // Create filename
        $filename = 'proposal_' . $proposal->id . '_' . now()->timestamp . '.pdf';

        // Store in storage/app/proposals/generated
        $path = 'proposals/generated/' . $filename;
        Storage::put($path, $pdf->output());

        // Update proposal with file path
        $proposal->update(['file_path' => $path]);

        return $path;
    }

    /**
     * Generate PDF with all approvals/signatures embedded
     */
    public function generateFinalPdf(Proposal $proposal): string
    {
        // Determine which template based on risk level
        $template = $proposal->risk_level === 'high'
            ? 'documents.proposals.pdf-template-high-risk-final'
            : 'documents.proposals.pdf-template-low-risk-final';

        // Generate PDF
        $pdf = Pdf::loadView($template, [
            'proposal' => $proposal,
            'approvals' => $proposal->approvals,
        ])->setPaper('a4', 'portrait');

        // Create filename
        $filename = 'proposal_' . $proposal->id . '_final_' . now()->timestamp . '.pdf';

        // Store in storage/app/proposals/generated
        $path = 'proposals/generated/' . $filename;
        Storage::put($path, $pdf->output());

        return $path;
    }

    /**
     * Get list of required approvers for risk level
     */
    public function getRequiredApprovers(string $riskLevel): array
    {
        // Define approval hierarchy
        return [
            [
                'role' => 'ketua_panitia',
                'label' => 'Ketua Panitia',
                'order' => 1,
            ],
            [
                'role' => 'sekretaris',
                'label' => 'Sekretaris',
                'order' => 2,
            ],
            [
                'role' => 'ketua_hima',
                'label' => 'Ketua HMSE',
                'order' => 3,
            ],
            [
                'role' => 'pembina',
                'label' => 'Pembina HMSE',
                'order' => 4,
            ],
            [
                'role' => 'kaprodi',
                'label' => 'Kaprodi RPL',
                'order' => 5,
            ],
        ];
    }
}
