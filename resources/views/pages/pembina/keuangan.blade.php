<x-layouts.dashboard-pembina title="Keuangan">

    {{-- Tabs: Internal / Per-Proker --}}
    <div x-data="{ tab: 'overview', showDetailModal: false, selectedTx: null }" class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-gray-800">Laporan Keuangan</h2>
                <p class="text-sm text-gray-400 mt-0.5">Transparansi keuangan internal dan per-proker (mode: baca)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.finance.export') }}" class="px-4 py-2.5 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel
                </a>
            </div>
        </div>

        {{-- Tab Buttons --}}
        <div class="flex gap-2">
            <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-[#00C4D8] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Overview</button>
            <button @click="tab = 'internal'" :class="tab === 'internal' ? 'bg-[#00C4D8] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Kas Internal</button>
            <button @click="tab = 'proker'" :class="tab === 'proker' ? 'bg-[#00C4D8] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Per-Proker</button>
        </div>

        {{-- Overview --}}
        <div x-show="tab === 'overview'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @foreach([
                    ['label' => 'Total Pemasukan', 'value' => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'), 'icon' => 'trending-up', 'color' => 'emerald', 'change' => '+15%'],
                    ['label' => 'Total Pengeluaran', 'value' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'), 'icon' => 'trending-down', 'color' => 'red', 'change' => '+8%'],
                    ['label' => 'Saldo Kas', 'value' => 'Rp ' . number_format($saldoKas, 0, ',', '.'), 'icon' => 'wallet', 'color' => 'cyan', 'change' => 'Aktif'],
                    ['label' => 'Anggaran Proker', 'value' => 'Rp ' . number_format($anggaranProker, 0, ',', '.'), 'icon' => 'chart', 'color' => 'purple', 'change' => '5 proker'],
                ] as $stat)
                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] === 'cyan' ? 'cyan-50' : $stat['color'] . '-50' }} flex items-center justify-center">
                                <svg class="w-5 h-5 text-{{ $stat['color'] === 'cyan' ? '[#00C4D8]' : $stat['color'] . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-{{ $stat['color'] === 'cyan' ? 'cyan-600 bg-cyan-50' : $stat['color'] . '-600 bg-' . $stat['color'] . '-50' }} px-2 py-0.5 rounded-full">{{ $stat['change'] }}</span>
                        </div>
                        <p class="text-xl font-black text-gray-800">{{ $stat['value'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Simple Bar Chart --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-6">Ringkasan Keuangan 6 Bulan Terakhir</h3>
                <div class="flex items-end justify-between gap-2 h-48">
                    @foreach([
                        ['month' => 'Nov', 'in' => 60, 'out' => 30],
                        ['month' => 'Des', 'in' => 80, 'out' => 45],
                        ['month' => 'Jan', 'in' => 45, 'out' => 55],
                        ['month' => 'Feb', 'in' => 70, 'out' => 40],
                        ['month' => 'Mar', 'in' => 90, 'out' => 50],
                        ['month' => 'Apr', 'in' => 65, 'out' => 35],
                    ] as $bar)
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full flex gap-0.5 items-end justify-center" style="height: 160px;">
                                <div class="w-5 bg-[#00C4D8] rounded-t-md transition-all duration-500" style="height: {{ $bar['in'] }}%;"></div>
                                <div class="w-5 bg-red-400 rounded-t-md transition-all duration-500" style="height: {{ $bar['out'] }}%;"></div>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-400">{{ $bar['month'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-center gap-6 mt-4">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-[#00C4D8]"></div><span class="text-xs text-gray-500">Pemasukan</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-red-400"></div><span class="text-xs text-gray-500">Pengeluaran</span></div>
                </div>
            </div>
        </div>

        {{-- Kas Internal --}}
        <div x-show="tab === 'internal'" style="display: none;">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800">Catatan Kas Internal</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Keterangan</th>
                            <th class="px-4 py-3 text-right">Pemasukan</th>
                            <th class="px-4 py-3 text-right">Pengeluaran</th>
                            <th class="px-4 py-3 text-right">Saldo</th>
                            <th class="px-4 py-3 text-right">Metode</th>
                            <th class="px-4 py-3 text-center">Deskripsi Tambahan</th>
                            <th class="px-4 py-3 text-center">Bukti</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-50">
                            @php $saldo = 0; @endphp
                            @forelse($transaksiInternal as $tx)
                                @php
                                    $debit = $tx->type === 'income' ? $tx->amount : 0;
                                    $credit = $tx->type === 'outcome' ? $tx->amount : 0;
                                    $saldo += $debit - $credit;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3 text-gray-500">
                                        {{ $tx->transaction_date ? \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $tx->title }}</td>
                                    <td class="px-4 py-3 text-right {{ $debit > 0 ? 'text-emerald-600 font-semibold' : 'text-gray-300' }}">
                                        {{ $debit > 0 ? '+ Rp ' . number_format($debit, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right {{ $credit > 0 ? 'text-red-500 font-semibold' : 'text-gray-300' }}">
                                        {{ $credit > 0 ? '- Rp ' . number_format($credit, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-700">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $tx->method ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 max-w-xs truncate" title="{{ $tx->description }}">{{ $tx->description ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($tx->attachment)
                                            <button @click="selectedTx = {
                                                        date: '{{ $tx->transaction_date ? \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') : '-' }}',
                                                        type: '{{ $tx->type }}',
                                                        desc: '{{ addslashes($tx->title) }}',
                                                        amount: '{{ number_format($tx->amount, 0, ',', '.') }}',
                                                        method: '{{ $tx->method }}',
                                                        proker: '{{ $tx->proposal ? addslashes($tx->proposal->proker) : 'Kas Internal Umum' }}',
                                                        proof_url: '{{ asset('storage/' . $tx->attachment) }}'
                                                    }; showDetailModal = true;" class="p-1.5 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-[#00C4D8] transition-colors" title="Lihat bukti">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada catatan transaksi kas internal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Per-Proker --}}
        <div x-show="tab === 'proker'" style="display: none;">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-4 mb-6">
                    <label class="text-sm font-semibold text-gray-700">Pilih Proker:</label>
                    <select class="px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#00C4D8] text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#00C4D8]/20 min-w-[250px]">
                        <option value="">Pilih Program Kerja...</option>
                        @foreach($proposals as $p)
                            <option value="{{ $p->id }}">{{ $p->proker }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-emerald-50 rounded-xl"><p class="text-xs text-emerald-600 font-semibold">Anggaran</p><p class="text-lg font-black text-emerald-700">Rp 3.200.000</p></div>
                    <div class="p-4 bg-blue-50 rounded-xl"><p class="text-xs text-blue-600 font-semibold">Terpakai</p><p class="text-lg font-black text-blue-700">Rp 1.900.000</p></div>
                    <div class="p-4 bg-amber-50 rounded-xl"><p class="text-xs text-amber-600 font-semibold">Sisa</p><p class="text-lg font-black text-amber-700">Rp 1.300.000</p></div>
                </div>

                {{-- Proker finance table similar to internal --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-xs font-semibold text-gray-400 uppercase"><th class="px-4 py-3 text-left">Item</th><th class="px-4 py-3 text-right">Anggaran</th><th class="px-4 py-3 text-right">Realisasi</th><th class="px-4 py-3 text-right">Selisih</th></tr></thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach([
                                ['item' => 'Sewa Ruangan', 'budget' => 500000, 'actual' => 500000],
                                ['item' => 'Snack & Makan Siang', 'budget' => 1250000, 'actual' => 1100000],
                                ['item' => 'Honor Pemateri', 'budget' => 1000000, 'actual' => 0],
                                ['item' => 'Sertifikat', 'budget' => 150000, 'actual' => 150000],
                                ['item' => 'Dekorasi & Publikasi', 'budget' => 300000, 'actual' => 150000],
                            ] as $b)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $b['item'] }}</td>
                                    <td class="px-4 py-3 text-right text-gray-500">Rp {{ number_format($b['budget'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-700">Rp {{ number_format($b['actual'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-semibold {{ ($b['budget'] - $b['actual']) >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                        Rp {{ number_format($b['budget'] - $b['actual'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Detail Transaksi --}}
        <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
            <div @click.away="showDetailModal = false" x-transition.opacity.duration.300ms
                 class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-800">Detail Transaksi</h3>
                    <button @click="showDetailModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-6 space-y-4" x-show="selectedTx">
                    <div class="grid grid-cols-2 gap-y-4 text-sm">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Tanggal</p>
                            <p class="font-semibold text-gray-800" x-text="selectedTx?.date"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Jenis</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold"
                                  :class="selectedTx?.type === 'pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500'"
                                  x-text="selectedTx?.type === 'pemasukan' ? 'Debit (Masuk)' : 'Kredit (Keluar)'"></span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 mb-1">Keterangan</p>
                            <p class="font-medium text-gray-800" x-text="selectedTx?.desc"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Nominal</p>
                            <p class="font-bold text-gray-800 text-lg">Rp <span x-text="selectedTx?.amount"></span></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Metode Pembayaran</p>
                            <p class="font-semibold text-gray-800" x-text="selectedTx?.method"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 mb-1">Terkait Proker</p>
                            <p class="font-semibold text-[#00C4D8]" x-text="selectedTx?.proker"></p>
                        </div>
                        <div class="col-span-2 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-2">Bukti Transaksi</p>
                            <a :href="selectedTx?.proof_url" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-[#00C4D8] text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Berkas Asli
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard-pembina>
