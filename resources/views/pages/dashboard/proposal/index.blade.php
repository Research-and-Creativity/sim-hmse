<x-layouts.dashboard title="Proposal">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Daftar Proposal</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola proposal kegiatan himpunan</p>
        </div>
        <a href="{{ route('dashboard.proposal.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all duration-200 shadow-md shadow-[#2C3DA6]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Proposal
        </a>
    </div>

    {{-- Status color map --}}
    @php
        $statusMap = [
            'approved'  => ['label' => 'Disetujui',               'color' => 'emerald', 'pulse' => false],
            'pending'   => ['label' => 'Menunggu TTD Pembina',    'color' => 'amber',   'pulse' => true],
            'reviewing' => ['label' => 'Menunggu TTD Ketua',      'color' => 'blue',    'pulse' => true],
            'draft'     => ['label' => 'Draft',                   'color' => 'gray',    'pulse' => false],
            'rejected'  => ['label' => 'Ditolak',                 'color' => 'red',     'pulse' => false],
        ];
    @endphp

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Proposal</th>
                        <th class="px-4 py-4">Program Kerja</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Tanggal</th>
                        <th class="px-4 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($proposals as $prop)
                        @php
                            $st = $statusMap[$prop->status] ?? ['label' => ucfirst($prop->status), 'color' => 'gray', 'pulse' => false];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.proposal.show', $prop->id) }}" class="font-semibold text-gray-700 hover:text-[#2C3DA6] transition-colors">
                                    {{ $prop->title }}
                                </a>
                            </td>
                            <td class="px-4 py-4 text-gray-500">{{ $prop->proker ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $st['color'] }}-50 text-{{ $st['color'] }}-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $st['color'] }}-500 {{ $st['pulse'] ? 'animate-pulse' : '' }}"></span>
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-400">{{ $prop->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Preview (mata) → langsung ke preview proposal lengkap --}}
                                    <a href="{{ route('dashboard.proposal.preview', $prop->id) }}"
                                       class="p-2 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-[#2C3DA6] transition-colors"
                                       title="Preview Proposal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    {{-- Detail → halaman detail/approval --}}
                                    <a href="{{ route('dashboard.proposal.show', $prop->id) }}"
                                       class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"
                                       title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="font-semibold">Belum ada proposal</p>
                                <p class="text-sm mt-1">Klik "Buat Proposal" untuk membuat proposal baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.dashboard>
