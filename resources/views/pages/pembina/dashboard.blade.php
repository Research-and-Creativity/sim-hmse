<x-layouts.dashboard-pembina title="Dashboard">

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 mb-8"
         style="background: linear-gradient(135deg, #0891b2 0%, #00C4D8 50%, #06b6d4 100%);">
        <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10 blur-3xl bg-white"></div>
        <div class="absolute bottom-0 left-1/3 w-48 h-48 rounded-full opacity-5 blur-3xl bg-white"></div>

        {{-- Decorative icon --}}
        <div class="absolute right-8 top-1/2 -translate-y-1/2 opacity-10 hidden md:block">
            <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>

        <div class="relative z-10">
            <p class="text-white/60 text-sm font-medium mb-1">Selamat datang 👋</p>
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">
                {{ auth()->user()?->name ?? 'Pembina HMSE' }}
            </h2>
            <p class="text-white/60 text-sm mb-4">
                {{ auth()->user()?->jabatanLabel() ?? 'Pembina / Kaprodi' }}
            </p>
            <p class="text-white/50 text-sm max-w-lg">
                Pantau perkembangan program kerja, tinjau proposal kegiatan, dan berikan persetujuan TTD untuk proposal yang membutuhkan tanda tanganmu.
            </p>
        </div>
    </div>

    {{-- Stat Cards --}}
    @php
        $totalProker    = \App\Models\ProgramKerja::count();
        $proposalPending = \App\Models\Proposal::where('status', 'pending')->count();
        $proposalApproved = \App\Models\Proposal::where('status', 'approved')->count();
        $totalProposal  = \App\Models\Proposal::count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total Proker --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#2C3DA6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-black text-gray-800">{{ $totalProker }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Program Kerja</p>
        </div>

        {{-- Proposal Menunggu TTD --}}
        <div class="bg-white rounded-xl p-5 border-2 {{ $proposalPending > 0 ? 'border-amber-200' : 'border-gray-100' }} shadow-sm hover:shadow-md transition-all duration-300 group relative overflow-hidden">
            @if($proposalPending > 0)
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-amber-400"></div>
            @endif
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                @if($proposalPending > 0)
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full animate-pulse">Perlu TTD</span>
                @endif
            </div>
            <p class="text-2xl font-black text-gray-800">{{ $proposalPending }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Proposal Menunggu TTD</p>
        </div>

        {{-- Proposal Disetujui --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-black text-gray-800">{{ $proposalApproved }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Proposal Disetujui</p>
        </div>

        {{-- Total Proposal --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-black text-gray-800">{{ $totalProposal }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Semua Proposal</p>
        </div>

    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Proposal Menunggu Persetujuan --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-gray-800">Proposal Perlu Persetujuan</h3>
                    @if($proposalPending > 0)
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">{{ $proposalPending }} menunggu</span>
                    @endif
                </div>
                <a href="{{ route('pembina.proposal') }}" class="text-xs font-semibold text-[#00C4D8] hover:text-[#0891b2] transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @php
                    $pendingProposals = \App\Models\Proposal::where('status', 'pending')
                        ->latest()->take(5)->get();
                @endphp
                @forelse($pendingProposals as $prop)
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50/50 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-700 truncate">{{ $prop->title }}</p>
                                <p class="text-xs text-gray-400">{{ $prop->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('pembina.proposal.show', $prop->id) }}"
                           class="flex-shrink-0 px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Tanda Tangan
                        </a>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">Tidak ada proposal yang perlu ditandatangani</p>
                        <p class="text-xs text-gray-400 mt-1">Semua proposal sudah diproses ✓</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Ringkasan & Quick Links --}}
        <div class="space-y-5">

            {{-- Calendar Widget --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <x-dashboard.calendar-widget :events="[
                    ['date' => now()->format('Y-m-') . '15', 'title' => 'Workshop UI/UX'],
                    ['date' => now()->format('Y-m-') . '22', 'title' => 'Seminar Tech'],
                    ['date' => now()->format('Y-m-') . '05', 'title' => 'Bazaar'],
                ]" />
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('pembina.proposal') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 transition-all duration-200 group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span class="text-sm font-semibold">Review Proposal</span>
                        @if($proposalPending > 0)
                            <span class="ml-auto text-xs font-bold bg-amber-500 text-white px-1.5 py-0.5 rounded-full">{{ $proposalPending }}</span>
                        @endif
                    </a>
                    <a href="{{ route('pembina.proker') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-cyan-50 text-gray-500 hover:text-[#00C4D8] transition-all duration-200">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-sm font-semibold">Lihat Program Kerja</span>
                    </a>
                    <a href="{{ route('pembina.keuangan') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-cyan-50 text-gray-500 hover:text-[#00C4D8] transition-all duration-200">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/>
                        </svg>
                        <span class="text-sm font-semibold">Laporan Keuangan</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    {{-- Proker Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800">Program Kerja Terbaru</h3>
            <a href="{{ route('pembina.proker') }}" class="text-xs font-semibold text-[#00C4D8] hover:text-[#0891b2] transition-colors">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @php
                $recentProker = \App\Models\ProgramKerja::latest()->take(5)->get();
            @endphp
            @forelse($recentProker as $proker)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50/50 transition-colors duration-200">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-2 h-2 rounded-full flex-shrink-0
                            {{ $proker->status === 'on-progress' ? 'bg-blue-500 animate-pulse' :
                               ($proker->status === 'completed' ? 'bg-emerald-500' :
                               ($proker->status === 'preparation' ? 'bg-amber-500' : 'bg-gray-300')) }}">
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-700 truncate">{{ $proker->name }}</p>
                            <p class="text-xs text-gray-400">{{ $proker->divisi ?? 'Umum' }}</p>
                        </div>
                    </div>
                    <x-dashboard.status-badge :status="$proker->status" />
                </div>
            @empty
                <div class="px-6 py-10 text-center text-gray-400">
                    <p class="text-sm">Belum ada program kerja</p>
                </div>
            @endforelse
        </div>
    </div>

</x-layouts.dashboard-pembina>
