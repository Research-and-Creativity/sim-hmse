<x-layouts.dashboard title="Detail Program Kerja">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.proker.index') }}"
            class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">{{ $proker['name'] }}</h2>
            <p class="text-sm text-gray-400">{{ $proker['divisi'] }} · PJ: {{ $pj['name'] ?? 'User Tidak Ditemukan' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Main Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Status Card + Quick Edit --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6" x-data="{ editing: false, status: '{{ $proker['status'] }}' }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-800">Status Proker</h3>
                    <button @click="editing = !editing"
                        class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] transition-colors">
                        <span x-text="editing ? 'Simpan' : 'Edit Status'"></span>
                    </button>
                </div>

                {{-- Status Display --}}
                <div x-show="!editing" class="flex items-center gap-4">
                    <x-dashboard.status-badge :status="$proker['status']" />
                    <span class="text-sm text-gray-500">Terakhir diperbarui: {{ $lastUpdated }}</span>
                </div>

                {{-- Status Edit --}}
                <div x-show="editing" x-transition class="flex flex-wrap gap-2">
                    @foreach (['draft', 'preparation', 'on-progress', 'completed', 'cancelled'] as $s)
                        <button @click="status = '{{ $s }}'"
                            :class="status === '{{ $s }}' ? 'ring-2 ring-[#2C3DA6] ring-offset-2' : ''"
                            class="transition-all duration-200 rounded-full">
                            <x-dashboard.status-badge :status="$s" />
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Info Umum --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Informasi Umum</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([['label' => 'Nama Proker', 'value' => $proker['name']], ['label' => 'Divisi', 'value' => $proker['divisi']], ['label' => 'Penanggung Jawab', 'value' => $pj['name'] ?? 'User Tidak Ditemukan'], ['label' => 'Periode', 'value' => $proker['date_start'] . ' - ' . $proker['date_end']], ['label' => 'Tingkat Risiko', 'value' => $proker['risk_level']], ['label' => 'Lokasi', 'value' => $proker['location']], ['label' => 'Target Peserta', 'value' => $proker['target_participants'] . ' Mahasiswa']] as $info)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                                {{ $info['label'] }}</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $info['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Deskripsi</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $proker['description'] }}</p>
            </div>

            {{-- Tabs: Timeline, Dokumen, Anggaran, Panitia --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ activeTab: 'timeline' }">
                <div class="flex border-b border-gray-100 overflow-x-auto">
                    @foreach (['timeline' => 'Timeline', 'documents' => 'Dokumen', 'budget' => 'Anggaran', 'committee' => 'Panitia'] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                            :class="activeTab === '{{ $key }}' ? 'text-[#2C3DA6] border-[#2C3DA6]' :
                                'text-gray-400 border-transparent hover:text-gray-600'"
                            class="px-5 py-3.5 text-sm font-semibold border-b-2 transition-all duration-200 whitespace-nowrap">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="p-6">
                    {{-- Timeline Tab --}}
                    <div x-show="activeTab === 'timeline'">
                        <x-dashboard.timeline :steps="$proker['timeline']" />
                    </div>

                    {{-- Documents Tab --}}
                    <div x-show="activeTab === 'documents'" style="display: none;">
                        @if (empty($proker['documents']))
                            <p class="text-sm text-gray-400">Belum ada dokumen pendukung.</p>
                        @else
                            <div class="space-y-3">
                                @foreach ($proker['documents'] as $doc)
                                    <div
                                        class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                                        <div
                                            class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                                        {{ $doc['type'] === 'pdf' ? 'bg-red-100 text-red-600' : ($doc['type'] === 'doc' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-700 truncate">{{ $doc['name'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $doc['size'] }}</p>
                                        </div>
                                        <button class="text-xs font-semibold text-[#2C3DA6]">Download</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Budget Tab --}}
                    <div x-show="activeTab === 'budget'" style="display: none;">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr
                                        class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                        <th class="pb-3 pr-4">Item</th>
                                        <th class="pb-3 pr-4">Qty</th>
                                        <th class="pb-3 pr-4">Satuan</th>
                                        <th class="pb-3 pr-4 text-right">Harga</th>
                                        <th class="pb-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($proker['budget_items'] as $budget)
                                        <tr class="text-gray-600">
                                            <td class="py-3 pr-4 font-medium">{{ $budget['item'] }}</td>
                                            <td class="py-3 pr-4 text-gray-400">{{ $budget['qty'] }}
                                                {{ $budget['unit'] ?? '' }}</td>
                                            <td class="py-3 pr-4 text-right">Rp
                                                {{ number_format($budget['price'], 0, ',', '.') }}</td>
                                            <td class="py-3 text-right font-semibold">Rp
                                                {{ number_format((int) ($budget['qty'] ?? 0) * $budget['price'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-center text-sm text-gray-400">Belum ada
                                                rencana anggaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-gray-200 font-bold text-gray-800">
                                        <td colspan="4" class="py-3 text-right">Total Anggaran</td>
                                        <td class="py-3 text-right text-[#2C3DA6]">Rp
                                            {{ number_format(collect($proker['budget_items'])->sum(fn($item) => (int) ($item['qty'] ?? 0) * $item['price']), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Committee Tab --}}
                    <div x-show="activeTab === 'committee'" style="display: none;">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($committeeMembers as $member)
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#2C3DA6] to-[#00C4D8] flex items-center justify-center flex-shrink-0">
                                        <span
                                            class="text-white text-xs font-bold">{{ mb_substr($member['name'], 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">{{ $member['name'] }}</p>
                                        <p class="text-xs text-gray-400">{{ $member['role'] }} ·
                                            {{ $member['division'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Sidebar --}}
        <div class="space-y-6">
            {{-- Progress --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Progress Keseluruhan</h3>
                <div class="relative w-32 h-32 mx-auto mb-4">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#f3f4f6"
                            stroke-width="10" />
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#2C3DA6"
                            stroke-width="10" stroke-dasharray="314"
                            stroke-dashoffset="{{ 314 - (314 * $proker['progress']) / 100 }}" stroke-linecap="round"
                            class="transition-all duration-1000" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-black text-[#2C3DA6]">{{ $proker['progress'] }}%</span>
                    </div>
                </div>
                <p class="text-center text-xs text-gray-400">{{ $doneSteps }} dari {{ $totalSteps }} tahapan
                    selesai</p>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Tautan Cepat</h3>
                <div class="space-y-2">
                    @if ($proposal)
                        <a href="{{ route('dashboard.proposal.show', $proposal->id) }}"
                            class="flex items-center gap-2 p-2.5 rounded-lg hover:bg-blue-50 text-sm text-gray-600 hover:text-[#2C3DA6] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Lihat Proposal
                        </a>
                    @else
                        <a href="{{ route('dashboard.proposal.create') }}?proker_id={{ $proker['id'] }}"
                            class="flex items-center gap-2 p-2.5 rounded-lg hover:bg-blue-50 text-sm text-gray-600 hover:text-[#2C3DA6] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Buat Proposal
                        </a>
                    @endif
                    <a href="{{ route('dashboard.finance.proker') }}?proker_id={{ $proker['id'] }}"
                        class="flex items-center gap-2 p-2.5 rounded-lg hover:bg-emerald-50 text-sm text-gray-600 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1" />
                        </svg>
                        Lihat Keuangan
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.dashboard>
