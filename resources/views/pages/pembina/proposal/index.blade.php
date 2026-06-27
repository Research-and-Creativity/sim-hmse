<x-layouts.dashboard-pembina title="Proposal">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Daftar Proposal</h2>
            <p class="text-sm text-gray-400 mt-0.5">Tinjau dan tandatangani proposal kegiatan himpunan</p>
        </div>
        {{-- Info badge --}}
        <div class="flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-100 rounded-xl text-xs font-semibold text-amber-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Tugas utama: Persetujuan TTD Proposal
        </div>
    </div>

    {{-- Filter Tabs --}}
    @php
        $tab = request('tab', 'pending');
        $statusMap = [
            'pending'   => ['label' => 'Menunggu TTD',  'color' => 'amber',   'icon' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'],
            'approved'  => ['label' => 'Disetujui',     'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'rejected'  => ['label' => 'Ditolak',       'color' => 'red',     'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'all'       => ['label' => 'Semua',          'color' => 'gray',    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ];

        $query = \App\Models\Proposal::latest();
        if ($tab !== 'all') {
            $query->where('status', $tab);
        }
        $proposals = $query->get();

        $counts = [
            'pending'  => \App\Models\Proposal::where('status', 'pending')->count(),
            'approved' => \App\Models\Proposal::where('status', 'approved')->count(),
            'rejected' => \App\Models\Proposal::where('status', 'rejected')->count(),
            'all'      => \App\Models\Proposal::count(),
        ];
    @endphp

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($statusMap as $val => $config)
            <a href="{{ route('pembina.proposal', ['tab' => $val]) }}"
               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 border
                      {{ $tab === $val
                           ? 'bg-' . $config['color'] . '-500 text-white border-' . $config['color'] . '-500 shadow-md'
                           : 'bg-white text-gray-500 border-gray-200 hover:border-' . $config['color'] . '-300 hover:text-' . $config['color'] . '-600' }}">
                {{ $config['label'] }}
                <span class="text-xs font-bold px-1.5 py-0.5 rounded-full
                             {{ $tab === $val ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">
                    {{ $counts[$val] }}
                </span>
            </a>
        @endforeach
    </div>

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
                            $st = $statusMap[$prop->status] ?? ['label' => ucfirst($prop->status), 'color' => 'gray', 'icon' => ''];
                            $colorMap = [
                                'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'dot' => 'bg-amber-500 animate-pulse'],
                                'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                                'red'     => ['bg' => 'bg-red-50',     'text' => 'text-red-700',     'dot' => 'bg-red-500'],
                                'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'dot' => 'bg-blue-500 animate-pulse'],
                                'gray'    => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',    'dot' => 'bg-gray-400'],
                            ];
                            $c = $colorMap[$st['color']] ?? $colorMap['gray'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('pembina.proposal.show', $prop->id) }}"
                                   class="font-semibold text-gray-700 hover:text-[#00C4D8] transition-colors">
                                    {{ $prop->title }}
                                </a>
                            </td>
                            <td class="px-4 py-4 text-gray-500">{{ $prop->proker ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $c['bg'] }} {{ $c['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-400">{{ $prop->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Preview --}}
                                    <a href="{{ route('pembina.proposal.preview', $prop->id) }}"
                                       class="p-2 rounded-lg hover:bg-cyan-50 text-gray-400 hover:text-[#00C4D8] transition-colors"
                                       title="Preview Proposal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Tanda Tangan (hanya jika pending) --}}
                                    @if($prop->status === 'pending')
                                        <a href="{{ route('pembina.proposal.show', $prop->id) }}"
                                           class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-lg hover:bg-amber-600 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                            TTD
                                        </a>
                                    @else
                                        <a href="{{ route('pembina.proposal.show', $prop->id) }}"
                                           class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors"
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="font-semibold">Tidak ada proposal</p>
                                @if($tab === 'pending')
                                    <p class="text-sm mt-1 text-emerald-500 font-medium">✓ Semua proposal sudah diproses</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.dashboard-pembina>
