<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalApproval;
use App\Services\ProposalGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ProposalController extends Controller
{
    protected ProposalGeneratorService $proposalService;

    public function __construct(ProposalGeneratorService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    /**
     * Show list of proposals
     */
    public function index()
    {
        // Temporarily bypass auth
        $proposals = Proposal::paginate(15);
        return view('proposals.index', compact('proposals'));
    }

    /**
     * Show form to create new proposal
     */
    public function create()
    {
        return view('proposals.create', [
            'riskLevels' => ['low' => 'Resiko Rendah', 'high' => 'Resiko Tinggi'],
        ]);
    }

    /**
     * Store new proposal
     */
    public function store(Request $request)
    {
        $isSubmitting = $request->input('action') === 'submit';

        $rules = [
            'proker_id'           => 'nullable|exists:program_kerjas,id',
            'title'               => 'required|string|max:255',
            'tema_kegiatan'       => 'nullable|string|max:255',
            'jenis_kegiatan'      => 'nullable|string|max:100',
            'tanggal_pelaksanaan' => 'nullable|string|max:100',
            'waktu_pelaksanaan'   => 'nullable|string|max:100',
            'tempat_pelaksanaan'  => 'nullable|string|max:255',
            'timeline'            => 'nullable|string|max:255',
            'ketua_panitia'       => 'nullable|string|max:255',
            'divisi'              => 'nullable|string|max:150',
            'background'          => $isSubmitting ? 'required|string' : 'nullable|string',
            'objective'           => $isSubmitting ? 'required|string' : 'nullable|string',
            'manfaat_kegiatan'    => 'nullable|string',
            'bentuk_kegiatan'     => 'nullable|string',
            'sasaran_peserta'     => 'nullable|string|max:255',
            'risk_level'          => 'required|in:low,medium,high',
            'risk_description'    => $isSubmitting ? 'required|string' : 'nullable|string',
            'budget'              => 'nullable|numeric|min:0',
            'penutup'             => 'nullable|string',
        ];

        $messages = [
            'title.required'            => 'Nama / Judul Kegiatan wajib diisi.',
            'background.required'       => 'Latar belakang wajib diisi sebelum mengajukan persetujuan.',
            'objective.required'        => 'Tujuan kegiatan wajib diisi sebelum mengajukan persetujuan.',
            'risk_description.required' => 'Identifikasi risiko wajib diisi sebelum mengajukan persetujuan.',
            'risk_level.required'       => 'Tingkat risiko wajib dipilih.',
        ];

        $validated = $request->validate($rules, $messages);

        // Extract sekretaris from panitia array if provided
        $sekretaris = null;
        if ($request->has('panitia_jabatan') && is_array($request->input('panitia_jabatan'))) {
            foreach ($request->input('panitia_jabatan') as $idx => $jbt) {
                if (str_contains(strtolower(trim($jbt)), 'sekretaris')) {
                    $sekretaris = $request->input('panitia_nama')[$idx] ?? null;
                    break;
                }
            }
        }

        $status = $isSubmitting ? 'reviewing' : 'draft';

        $proposal = Proposal::create([
            'user_id'             => auth()->id(),
            'proker_id'           => $validated['proker_id'] ?? null,
            'title'               => $validated['title'],
            'status'              => $status,
            'tema_kegiatan'       => $validated['tema_kegiatan'] ?? null,
            'jenis_kegiatan'      => $validated['jenis_kegiatan'] ?? null,
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'] ?? null,
            'waktu_pelaksanaan'   => $validated['waktu_pelaksanaan'] ?? null,
            'tempat_pelaksanaan'  => $validated['tempat_pelaksanaan'] ?? null,
            'timeline'            => $validated['timeline'] ?? null,
            'ketua_panitia'       => $validated['ketua_panitia'] ?? (auth()->user()?->name ?? 'Ketua Panitia'),
            'sekretaris'          => $sekretaris,
            'divisi'              => $validated['divisi'] ?? (auth()->user()?->divisi ?? null),
            'background'          => $validated['background'] ?? null,
            'objective'           => $validated['objective'] ?? null,
            'manfaat_kegiatan'    => $validated['manfaat_kegiatan'] ?? null,
            'bentuk_kegiatan'     => $validated['bentuk_kegiatan'] ?? null,
            'sasaran_peserta'     => $validated['sasaran_peserta'] ?? null,
            'risk_level'          => $validated['risk_level'] ?? 'low',
            'risk_description'    => $validated['risk_description'] ?? null,
            'budget'              => $validated['budget'] ?? 0,
            'penutup'             => $validated['penutup'] ?? null,
        ]);

        // Create approval records for all required approvers
        $approvers = $this->proposalService->getRequiredApprovers($proposal->risk_level);
        foreach ($approvers as $approver) {
            $approverUser = \App\Models\User::where('jabatan', $approver['role'])->first();
            $adminUser = \App\Models\User::where('role', 'admin')->first();
            $approverId = $approverUser?->id ?? $adminUser?->id ?? auth()->id();

            ProposalApproval::create([
                'proposal_id'    => $proposal->id,
                'approver_id'    => $approverId,
                'approver_role'  => $approver['role'],
                'approval_order' => $approver['order'],
                'status'         => 'pending',
            ]);
        }

        $message = $isSubmitting
            ? 'Proposal "' . $proposal->title . '" berhasil diajukan untuk proses tanda tangan dan persetujuan!'
            : 'Draft proposal "' . $proposal->title . '" berhasil disimpan di database!';

        return redirect()->route('dashboard.proposal.show', $proposal->id)
            ->with('success', $message);
    }

    /**
     * Show single proposal details
     */
    public function show(Proposal $proposal)
    {
        // $this->authorize('view', $proposal);

        return view('proposals.show', [
            'proposal' => $proposal,
            'approvals' => $proposal->approvals()->get(),
            'isFullyApproved' => $proposal->isFullyApproved(),
            'nextApprover' => $proposal->getNextApproverRole(),
        ]);
    }

    /**
     * Show form to edit proposal
     */
    public function edit(Proposal $proposal)
    {
        // $this->authorize('update', $proposal);

        // Only allow editing if still in draft
        if ($proposal->status !== 'draft') {
            return redirect()->route('proposals.show', $proposal)
                ->with('error', 'Hanya proposal dalam status draft yang dapat diedit.');
        }

        return view('proposals.edit', [
            'proposal' => $proposal,
            'riskLevels' => ['low' => 'Resiko Rendah', 'high' => 'Resiko Tinggi'],
        ]);
    }

    /**
     * Update proposal
     */
    public function update(Request $request, Proposal $proposal)
    {
        // $this->authorize('update', $proposal);

        if ($proposal->status !== 'draft') {
            return back()->with('error', 'Hanya proposal dalam status draft yang dapat diubah.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'background' => 'required|string',
            'objective' => 'required|string',
            'risk_level' => 'required|in:low,medium,high',
            'risk_description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'timeline' => 'required|string|max:255',
        ]);

        $proposal->update($validated);

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal berhasil diperbarui.');
    }

    /**
     * Generate PDF preview
     */
    public function generatePdf(Proposal $proposal)
    {
        // $this->authorize('view', $proposal);

        try {
            $filePath = $this->proposalService->generatePdf($proposal);
            return Storage::download($filePath);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Submit proposal for approval
     */
    public function submit(Request $request, Proposal $proposal)
    {
        // $this->authorize('update', $proposal);

        if ($proposal->status !== 'draft') {
            return back()->with('error', 'Hanya proposal draft yang dapat disubmit.');
        }

        $proposal->update(['status' => 'reviewing']);

        // NOTE: Auto-approval untuk ketua_panitia dan sekretaris dinonaktifkan
        // agar proses tanda tangan berjalan berurutan dari awal secara manual untuk simulasi.
        /*
        $panitiaApproval = $proposal->approvals()->where('approver_role', 'ketua_panitia')->first();
        if ($panitiaApproval) {
            $panitiaApproval->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approver_id' => \App\Models\User::where('jabatan', 'ketua_panitia')->first()?->id ?? 5
            ]);
        }

        $sekretarisApproval = $proposal->approvals()->where('approver_role', 'sekretaris')->first();
        if ($sekretarisApproval) {
            $sekretarisApproval->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approver_id' => \App\Models\User::where('jabatan', 'sekretaris')->first()?->id ?? 3
            ]);
        }
        */

        // Generate initial PDF
        try {
            $this->proposalService->generatePdf($proposal);
        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.proposal.show', $proposal->id)
            ->with('success', 'Proposal berhasil disubmit untuk persetujuan.');
    }

    /**
     * Approve proposal (for approvers)
     */
    public function approve(Request $request, ProposalApproval $approval)
    {
        $proposal = $approval->proposal;
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        // Validasi jabatan yang sesuai dengan tahap approval
        $userJabatan = $user->jabatan;
        $normalizedJabatan = ($userJabatan === 'ketua_hmse') ? 'ketua_hima' : $userJabatan;

        $hasAuthority = ($user->role === 'admin') 
            || ($approval->approver_id && $approval->approver_id === $user->id)
            || ($approval->approver_role === $userJabatan || $approval->approver_role === $normalizedJabatan);

        if (!$hasAuthority) {
            return back()->with('error', 'Anda tidak memiliki wewenang untuk menyetujui tahap ' . ucfirst(str_replace('_', ' ', $approval->approver_role)) . '.');
        }

        $validated = $request->validate([
            'signature_data' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Set approver_id ke user yang sedang login jika belum di-assign
        if (!$approval->approver_id && auth()->id()) {
            $approval->update(['approver_id' => auth()->id()]);
        }

        $approval->approve($validated['signature_data'] ?? null, $validated['notes'] ?? null);

        // Kirim notifikasi ke Pembina dan Kaprodi jika Pengurus (Ketua Hima) baru saja tanda tangan
        if ($approval->approver_role === 'ketua_hima' && $approval->status === 'approved') {
            $pembina = \App\Models\User::where('jabatan', 'pembina')->first();
            $kaprodi = \App\Models\User::where('jabatan', 'kaprodi')->first();

            $dateFormatted = now()->translatedFormat('d F Y, H:i');

            if ($pembina) {
                \App\Models\ProposalNotification::create([
                    'proposal_id' => $proposal->id,
                    'user_id' => $pembina->id,
                    'type' => 'pengurus_signed',
                    'message' => "Proposal '{$proposal->title}' telah ditandatangani oleh Pengurus pada {$dateFormatted}. Silakan tinjau dan lakukan tanda tangan.",
                ]);
            }

            if ($kaprodi) {
                \App\Models\ProposalNotification::create([
                    'proposal_id' => $proposal->id,
                    'user_id' => $kaprodi->id,
                    'type' => 'pengurus_signed',
                    'message' => "Proposal '{$proposal->title}' telah ditandatangani oleh Pengurus pada {$dateFormatted}. Silakan tinjau dan lakukan tanda tangan.",
                ]);
            }
        }

        // Check if all approvals are done
        if ($proposal->isFullyApproved()) {
            $proposal->update(['status' => 'approved']);
            // Generate final PDF with all signatures
            try {
                $this->proposalService->generateFinalPdf($proposal);
            } catch (\Exception $e) {
                \Log::error('Final PDF generation failed: ' . $e->getMessage());
            }
        } else {
            // Update status proposal based on next approver
            $nextRole = $proposal->getNextApproverRole();
            if (in_array($nextRole, ['pembina', 'kaprodi'])) {
                $proposal->update(['status' => 'pending']);
            } else {
                $proposal->update(['status' => 'reviewing']);
            }
        }

        return back()->with('success', 'Tanda tangan berhasil disimpan! Proposal telah disetujui.');
    }

    /**
     * Reject proposal
     */
    public function reject(Request $request, ProposalApproval $approval)
    {
        $proposal = $approval->proposal;
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        // Validasi jabatan yang sesuai dengan tahap approval
        $userJabatan = $user->jabatan;
        $normalizedJabatan = ($userJabatan === 'ketua_hmse') ? 'ketua_hima' : $userJabatan;

        $hasAuthority = ($user->role === 'admin') 
            || ($approval->approver_id && $approval->approver_id === $user->id)
            || ($approval->approver_role === $userJabatan || $approval->approver_role === $normalizedJabatan);

        if (!$hasAuthority) {
            return back()->with('error', 'Anda tidak memiliki wewenang untuk menolak tahap ' . ucfirst(str_replace('_', ' ', $approval->approver_role)) . '.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $approval->reject($validated['rejection_reason']);
        $proposal->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Proposal berhasil ditolak.');
    }

    /**
     * Download PDF
     */
    public function downloadPdf(Proposal $proposal)
    {
        // $this->authorize('view', $proposal);

        if (!$proposal->file_path || !Storage::exists($proposal->file_path)) {
            return back()->with('error', 'File PDF tidak ditemukan.');
        }

        return Storage::download($proposal->file_path, 'proposal_' . $proposal->id . '.pdf');
    }

    /**
     * Delete proposal
     */
    public function destroy(Proposal $proposal)
    {
        // $this->authorize('delete', $proposal);

        if ($proposal->status !== 'draft') {
            return back()->with('error', 'Hanya proposal draft yang dapat dihapus.');
        }

        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dihapus.');
    }

    /**
     * Generate and download filled proposal from template
     */
    public function generateFilledDocument(Proposal $proposal)
    {
        // $this->authorize('view', $proposal);

        try {
            $templateService = new \App\Services\ProposalTemplateFillerService();

            // Generate filled document
            $filePath = $templateService->generateFilledProposal($proposal, $proposal->risk_level);

            // Return download
            $filename = 'proposal_' . $proposal->id . '_' . date('Ymd');
            return response()->download($filePath, $filename . '.docx');

        } catch (\Exception $e) {
            return back()->with('error', 'Error generating document: ' . $e->getMessage());
        }
    }

    /**
     * Preview filled proposal before download
     */
    public function previewFilledDocument(Proposal $proposal)
    {
        // $this->authorize('view', $proposal);

        try {
            $templateService = new \App\Services\ProposalTemplateFillerService();

            // Get template info
            $riskLevel = $proposal->risk_level === 'low' ? 'Rendah' : 'Tinggi';
            $proposalData = [
                'title' => $proposal->title,
                'background' => $proposal->background,
                'objective' => $proposal->objective,
                'risk_level' => $riskLevel,
                'budget' => number_format((float) ($proposal->budget ?? 0), 0, ',', '.'),
                'timeline' => $proposal->timeline,
                'created_at' => $proposal->created_at ? $proposal->created_at->format('d/m/Y') : '-',
            ];

            return view('proposals.preview-filled', [
                'proposal' => $proposal,
                'proposalData' => $proposalData,
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error previewing document: ' . $e->getMessage());
        }
    }

    /**
     * Download template DOCX berdasarkan risk level
     */
    public function downloadTemplate(string $riskLevel)
    {
        $filename = $riskLevel === 'high'
            ? 'template-proposal-tinggi.docx'
            : 'template-proposal-rendah.docx';

        $filePath = resource_path('templates/proposals/' . $filename);

        if (!file_exists($filePath)) {
            return back()->with('error', 'Template proposal belum tersedia, hubungi admin.');
        }

        return response()->download($filePath, $filename);
    }

    public function preview(Request $request)
    {
        // Cast form data to object so blade can use $proposal->field syntax
        $proposal = (object) [
            'title'               => $request->input('title', 'Judul Proposal'),
            'tema_kegiatan'       => $request->input('tema_kegiatan', '-'),
            'jenis_kegiatan'      => $request->input('jenis_kegiatan', '-'),
            'tanggal_pelaksanaan' => $request->input('tanggal_pelaksanaan', '-'),
            'waktu_pelaksanaan'   => $request->input('waktu_pelaksanaan', '-'),
            'tempat_pelaksanaan'  => $request->input('tempat_pelaksanaan', '-'),
            'timeline'            => $request->input('timeline', '-'),
            'background'          => $request->input('background', '-'),
            'objective'           => $request->input('objective', '-'),
            'manfaat_kegiatan'    => $request->input('manfaat_kegiatan', '-'),
            'bentuk_kegiatan'     => $request->input('bentuk_kegiatan', '-'),
            'sasaran_peserta'     => $request->input('sasaran_peserta', '-'),
            'risk_level'          => $request->input('risk_level', 'low'),
            'risk_description'    => $request->input('risk_description', '-'),
            'budget'              => $request->input('budget', 0),
            'penutup'             => $request->input('penutup', '-'),
            'user'                => (object) ['name' => $request->input('ketua_panitia', 'Nama')],
        ];

        // Pass raw form data too so the download button can use it
        $formData = $request->except('_token');

        // Get SOTK Users
        $sotk = [
            'ketua_hmse' => \App\Models\User::whereIn('jabatan', ['ketua_hmse', 'President'])->first(),
            'sekretaris' => \App\Models\User::whereIn('jabatan', ['sekretaris', 'Secretary 1', 'Secretary 2'])->first(),
            'pembina' => \App\Models\User::where('jabatan', 'pembina')->first(),
            'kaprodi' => \App\Models\User::where('jabatan', 'kaprodi')->first(),
        ];

        return view('pages.dashboard.proposal.preview', compact('proposal', 'formData', 'sotk'));
    }

    /**
     * Generate and download DOCX from template using form data
     */
    public function downloadPreviewDocx(Request $request)
    {
        try {
            $data = $request->except('_token');

            $service = new \App\Services\ProposalDocxFillerService();
            $filePath = $service->generateFromFormData($data);

            $filename = 'Proposal_' . ($data['title'] ?? 'Kegiatan') . '.docx';
            // Sanitize filename
            $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);

            return response()->download($filePath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate DOCX: ' . $e->getMessage());
        }
    }
}

