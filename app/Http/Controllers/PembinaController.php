<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class PembinaController extends Controller
{
    // ─── Dashboard ───────────────────────────────────────────────────────────
    public function dashboard()
    {
        return view('pages.pembina.dashboard');
    }

    // ─── Program Kerja (read-only) ────────────────────────────────────────────
    public function proker(Request $request)
    {
        return view('pages.pembina.proker');
    }

    // ─── Kalender ─────────────────────────────────────────────────────────────
    public function calendar()
    {
        return view('pages.pembina.calendar');
    }

    // ─── Proposal ─────────────────────────────────────────────────────────────
    public function proposalIndex(Request $request)
    {
        return view('pages.pembina.proposal.index');
    }

    public function proposalShow(string $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Hitung signedCount dari data approval yang sebenarnya
        $signedCount = $proposal->approvals()->where('status', 'approved')->count();

        // Role yang sedang login (untuk menentukan TTD siapa yang ditampilkan)
        $userJabatan = auth()->user()?->jabatan;

        // Next approver role (siapa yang harus TTD berikutnya)
        $nextApproverRole = $proposal->getNextApproverRole();

        return view('pages.pembina.proposal.show', compact('proposal', 'signedCount', 'userJabatan', 'nextApproverRole'));
    }

    public function proposalPreview(string $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Siapkan data SOTK untuk halaman pengesahan
        $sotk = [
            'pembina'    => \App\Models\User::where('jabatan', 'pembina')->first(),
            'kaprodi'    => \App\Models\User::where('jabatan', 'kaprodi')->first(),
            'ketua_hmse' => \App\Models\User::where('jabatan', 'ketua_hmse')->first(),
            'sekretaris' => \App\Models\User::where('jabatan', 'sekretaris')->first(),
        ];

        // Ambil data approvals (TTD) yang sudah ada, keyed by approver_role
        $approvals = $proposal->approvals()->with('approver')->get()->keyBy('approver_role');

        $isFromForm = false;
        $formData   = null;

        return view('pages.pembina.proposal.preview', compact('proposal', 'sotk', 'approvals', 'isFromForm', 'formData'));
    }

    // ─── Keuangan (read-only) ─────────────────────────────────────────────────
    public function keuangan()
    {
        $transaksiInternal = \App\Models\FinanceInternal::orderBy('transaction_date', 'asc')
                            ->orderBy('created_at', 'asc')
                            ->get();
        $internalIn = \App\Models\FinanceInternal::where('type', 'income')->sum('amount');
        $internalOut = \App\Models\FinanceInternal::where('type', 'outcome')->sum('amount');
        $saldoInternal = $internalIn - $internalOut;

        $prokerIn = \App\Models\FinanceProker::where('type', 'income')->sum('amount');
        $prokerOut = \App\Models\FinanceProker::where('type', 'outcome')->sum('amount');
        $totalAnggaranProker = $prokerIn;

        $proposals = \App\Models\Proposal::all();

        return view('pages.pembina.keuangan', [
            'totalPemasukan' => $internalIn + $prokerIn,
            'totalPengeluaran' => $internalOut + $prokerOut,
            'saldoKas' => $saldoInternal,
            'anggaranProker' => $totalAnggaranProker,
            'transaksiInternal' => $transaksiInternal,
            'proposals' => $proposals,
        ]);
    }

    // ─── AJAX Notifications ──────────────────────────────────────────────────
    public function getUnreadNotifications()
    {
        if (!auth()->check()) {
            return response()->json([], 401);
        }

        $notifications = \App\Models\ProposalNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function markNotificationsRead(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([], 401);
        }

        $notificationId = $request->input('id');
        if ($notificationId) {
            \App\Models\ProposalNotification::where('user_id', auth()->id())
                ->where('id', $notificationId)
                ->update(['read_at' => now()]);
        } else {
            \App\Models\ProposalNotification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }
}
