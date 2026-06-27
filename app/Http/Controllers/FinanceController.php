<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\FinanceInternal;
use App\Models\FinanceProker;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Exports\FinanceExport;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $transaksiInternal = \App\Models\FinanceInternal::orderBy('transaction_date', 'asc')
                            ->orderBy('created_at', 'asc')
                            ->get();
        $internalIn = FinanceInternal::where('type', 'income')->sum('amount');
        $internalOut = FinanceInternal::where('type', 'outcome')->sum('amount');
        $saldoInternal = $internalIn - $internalOut;

        $listProker = \App\Models\ProgramKerja::all();

        $selectedProkerId = $request->query('proker_id', optional($listProker->first())->id);

        $transaksiProker = [];
        $summaryProker = ['budget' => 0, 'actual' => 0, 'leftover' => 0];

        if ($selectedProkerId) {
            $transaksiProker = FinanceProker::where('proker_id', $selectedProkerId)->get();

            // Prefer planned budget from ProgramKerja->budget_items if available.
            $prokerModel = \App\Models\ProgramKerja::find($selectedProkerId);
            if ($prokerModel && !empty($prokerModel->budget_items)) {
                $anggaran = collect($prokerModel->budget_items)->sum(function ($item) {
                    $qty = (int) ($item['qty'] ?? 0);
                    $price = (float) ($item['price'] ?? 0);
                    return $qty * $price;
                });
            } else {
                // Fallback: use income-type entries from FinanceProker as anggaran
                $anggaran = FinanceProker::where('proker_id', $selectedProkerId)->where('type', 'income')->sum('amount');
            }

            $realisasi = FinanceProker::where('proker_id', $selectedProkerId)->where('type', 'outcome')->sum('amount');

            $summaryProker = [
                'budget' => $anggaran,
                'actual' => $realisasi,
                'leftover' => $anggaran - $realisasi
            ];
        }

        $prokerIn = FinanceProker::where('type', 'income')->sum('amount');
        $prokerOut = FinanceProker::where('type', 'outcome')->sum('amount');
        $totalAnggaranProker = $prokerIn;

        $proposals = Proposal::all();

        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            $chartDataRaw = FinanceInternal::select(
                    DB::raw("strftime('%m', transaction_date) as month_num"),
                    DB::raw("strftime('%Y-%m', transaction_date) as month_key"),
                    DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                    DB::raw("SUM(CASE WHEN type = 'outcome' THEN amount ELSE 0 END) as total_outcome")
                )
                ->groupBy('month_key', 'month_num')
                ->orderBy('month_key', 'desc')
                ->limit(6)
                ->get()
                ->reverse()
                ->values();

            $monthNames = [
                '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
                '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
            ];
            foreach ($chartDataRaw as $data) {
                $data->month_name = $monthNames[$data->month_num] ?? $data->month_num;
            }
        } else {
            $chartDataRaw = FinanceInternal::select(
                    DB::raw("DATE_FORMAT(transaction_date, '%b') as month_name"),
                    DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                    DB::raw("SUM(CASE WHEN type = 'outcome' THEN amount ELSE 0 END) as total_outcome")
                )
                ->groupBy(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"), 'month_name')
                ->orderBy(DB::raw("DATE_FORMAT(transaction_date, '%Y-%m')"), 'desc')
                ->limit(6)
                ->get()
                ->reverse()
                ->values();
        }

        $maxAmount = 0;
        foreach ($chartDataRaw as $data) {
            if ($data->total_income > $maxAmount) $maxAmount = $data->total_income;
            if ($data->total_outcome > $maxAmount) $maxAmount = $data->total_outcome;
        }
        if ($maxAmount == 0) $maxAmount = 1;

        $chartData = [];
        foreach ($chartDataRaw as $data) {
            $chartData[] = [
                'month' => $data->month_name,
                'in'    => ($data->total_income / $maxAmount) * 100,
                'out'   => ($data->total_outcome / $maxAmount) * 100,
                'raw_in'  => $data->total_income,
                'raw_out' => $data->total_outcome,
            ];
        }

        return view('pages.dashboard.finance.index', [
            'totalPemasukan' => $internalIn + $prokerIn,
            'totalPengeluaran' => $internalOut + $prokerOut,
            'saldoKas' => $saldoInternal,
            'anggaranProker' => $totalAnggaranProker,
            'transaksiInternal' => $transaksiInternal,
            'proposals' => $proposals,
            'chartData' => $chartData,
            'listProker' => $listProker,
            'selectedProkerId' => $selectedProkerId,
            'transaksiProker' => $transaksiProker,
            'summaryProker' => $summaryProker
        ]);
    }

    public function create()
    {
        $transactionTypes = [
            'income' => 'Pemasukan (Income)',
            'outcome' => 'Pengeluaran (Outcome)'
        ];

        return view('pages.dashboard.finance.create', compact('transactionTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,outcome',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $createdBy = auth()->id();
        if (!$createdBy) {
            return back()
                ->withInput()
                ->withErrors(['auth' => 'Silakan login kembali sebelum menyimpan laporan keuangan.']);
        }

        \App\Models\FinanceInternal::create([
            'transaction_date' => $validated['transaction_date'],
            'title' => $validated['title'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'description' => $validated['description'],
            'attachment' => $attachmentPath,
            'created_by' => $createdBy,
        ]);

        return redirect()->route('dashboard.finance.index', ['tab' => 'internal'])
                        ->with('success', 'Laporan berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaction = FinanceInternal::findOrFail($id);
        $transactionTypes = [
            'income' => 'Pemasukan (Income)',
            'outcome' => 'Pengeluaran (Outcome)'
        ];

        return view('pages.dashboard.finance.edit', compact('transaction', 'transactionTypes'));
    }

    public function update(Request $request, $id)
    {
        $transaction = FinanceInternal::findOrFail($id);

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,outcome',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'title.required' => 'Judul transaksi wajib diisi.',
            'type.required' => 'Tipe transaksi wajib dipilih.',
            'type.in' => 'Tipe transaksi harus berupa "income" atau "outcome".',
            'amount.required' => 'Jumlah transaksi wajib diisi.',
            'amount.numeric' => 'Jumlah transaksi harus berupa angka.',
            'amount.min' => 'Jumlah transaksi tidak boleh negatif.',
            'attachment.image' => 'File lampiran harus berupa gambar.',
            'attachment.mimes' => 'File lampiran harus berformat JPEG, PNG, atau JPG.',
            'attachment.max' => 'Ukuran file lampiran tidak boleh lebih dari 5 MB.',
        ]);

        if ($request->hasFile('attachment')) {
            if ($transaction->attachment) {
                \Storage::disk('public')->delete($transaction->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $transaction->update($validated);

        return redirect()->route('dashboard.finance.index', ['tab' => 'internal'])
                        ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $finance = FinanceInternal::findOrFail($id);

        if ($finance->attachment) {
        \Storage::disk('public')->delete($finance->attachment);
        }

        $finance->delete();

        return redirect()->route('dashboard.finance.index', ['tab' => $request->query('tab', 'internal')])
                        ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new FinanceExport, 'Laporan_Keuangan_HMSE_'.now()->format('Y-m-d').'.xlsx');
    }
}
