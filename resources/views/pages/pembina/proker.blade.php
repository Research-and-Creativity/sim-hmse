<x-layouts.dashboard-pembina title="Program Kerja">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Program Kerja HMSE</h2>
            <p class="text-sm text-gray-400 mt-0.5">Daftar seluruh program kerja himpunan (mode: baca)</p>
        </div>
        {{-- Info badge --}}
        <div class="flex items-center gap-2 px-4 py-2 bg-cyan-50 border border-cyan-100 rounded-xl text-xs font-semibold text-cyan-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Hanya dapat melihat, tidak bisa mengedit
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        @php
            $statuses = ['all' => 'Semua', 'preparation' => 'Persiapan', 'on-progress' => 'Berjalan', 'completed' => 'Selesai', 'draft' => 'Draft'];
            $currentFilter = request('status', 'all');
        @endphp
        @foreach($statuses as $val => $label)
            <a href="{{ route('pembina.proker', $val !== 'all' ? ['status' => $val] : []) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200
                      {{ $currentFilter === $val ? 'bg-[#00C4D8] text-white shadow-md shadow-[#00C4D8]/30' : 'bg-white text-gray-500 border border-gray-200 hover:border-[#00C4D8] hover:text-[#00C4D8]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ProKer Grid --}}
    @php
        $query = \App\Models\ProgramKerja::latest();
        if ($currentFilter !== 'all') {
            $query->where('status', $currentFilter);
        }
        $prokers = $query->get();

        $statusConfig = [
            'on-progress'  => ['label' => 'Sedang Berjalan', 'color' => 'blue',    'bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'dot' => 'bg-blue-500 animate-pulse'],
            'preparation'  => ['label' => 'Persiapan',       'color' => 'amber',   'bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'dot' => 'bg-amber-500'],
            'completed'    => ['label' => 'Selesai',          'color' => 'emerald', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
            'draft'        => ['label' => 'Draft',            'color' => 'gray',    'bg' => 'bg-gray-100',   'text' => 'text-gray-500',    'dot' => 'bg-gray-400'],
        ];
    @endphp

    @if($prokers->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-16 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="font-semibold text-gray-500">Belum ada program kerja</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($prokers as $proker)
                @php $st = $statusConfig[$proker->status] ?? $statusConfig['draft']; @endphp
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                    {{-- Top bar color --}}
                    <div class="h-1 {{ $proker->status === 'on-progress' ? 'bg-blue-400' : ($proker->status === 'completed' ? 'bg-emerald-400' : ($proker->status === 'preparation' ? 'bg-amber-400' : 'bg-gray-300')) }}"></div>

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h3 class="text-sm font-bold text-gray-800 leading-tight">{{ $proker->name }}</h3>
                            <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold {{ $st['bg'] }} {{ $st['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}"></span>
                                {{ $st['label'] }}
                            </span>
                        </div>

                        <div class="space-y-1.5 mb-4">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $proker->divisi ?? 'Divisi Umum' }}
                            </div>
                            @if($proker->tanggal_mulai)
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($proker->tanggal_mulai)->format('d M Y') }}
                                </div>
                            @endif
                        </div>

                        @if($proker->description)
                            <p class="text-xs text-gray-400 leading-relaxed line-clamp-2 mb-4">{{ $proker->description }}</p>
                        @endif

                        {{-- Proposal terkait --}}
                        @php
                            $relatedProposals = \App\Models\Proposal::where('proker', $proker->name)
                                ->orWhere('proker_id', $proker->id)
                                ->take(1)->get();
                        @endphp
                        @if($relatedProposals->isNotEmpty())
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Proposal Terkait</p>
                                @foreach($relatedProposals as $rp)
                                    <a href="{{ route('pembina.proposal.show', $rp->id) }}"
                                       class="flex items-center gap-2 text-xs font-semibold text-[#00C4D8] hover:underline">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ Str::limit($rp->title, 35) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-layouts.dashboard-pembina>
