<x-layouts.dashboard title="Dashboard">

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 mb-8"
         style="background: linear-gradient(135deg, #2C3DA6 0%, #1E2D8F 50%, #00C4D8 100%);">
        <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10 blur-3xl bg-white"></div>
        <div class="absolute bottom-0 left-1/3 w-48 h-48 rounded-full opacity-5 blur-3xl bg-white"></div>
        <div class="relative z-10">
            <p class="text-white/60 text-sm font-medium mb-1">Selamat datang kembali 👋</p>
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ auth()->user()?->name ?? 'Admin HMSE' }}</h2>
            <p class="text-white/50 text-sm max-w-lg">Kelola program kerja, proposal, keuangan, dan administrasi himpunan dari satu dashboard.</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total Proker --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#2C3DA6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+3 bulan ini</span>
            </div>
            <p class="text-2xl font-black text-gray-800">12</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Program Kerja</p>
        </div>

        {{-- Proposal Aktif --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">4 menunggu</span>
            </div>
            <p class="text-2xl font-black text-gray-800">8</p>
            <p class="text-xs text-gray-400 mt-0.5">Proposal Aktif</p>
        </div>

        {{-- Saldo Kas --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">↑ 12%</span>
            </div>
            <p class="text-2xl font-black text-gray-800">Rp 4.250.000</p>
            <p class="text-xs text-gray-400 mt-0.5">Saldo Kas Internal</p>
        </div>

        {{-- Total Anggota --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">5 divisi</span>
            </div>
            <p class="text-2xl font-black text-gray-800">32</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Pengurus Aktif</p>
        </div>

    </div>

    {{-- Main Grid: Activity + Calendar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Proker Terbaru --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Program Kerja Terbaru</h3>
                <a href="{{ route('dashboard.proker.index') }}" class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach([
                    ['name' => 'Workshop UI/UX Design', 'divisi' => 'Divisi Akademik', 'status' => 'on-progress', 'date' => '15 Apr 2026'],
                    ['name' => 'Seminar Nasional Tech Week', 'divisi' => 'Divisi Eksternal', 'status' => 'preparation', 'date' => '22 Apr 2026'],
                    ['name' => 'Bootcamp Web Development', 'divisi' => 'Divisi Akademik', 'status' => 'completed', 'date' => '01 Mar 2026'],
                    ['name' => 'Turnamen E-Sport HMSE Cup', 'divisi' => 'Divisi Olahraga & Seni', 'status' => 'draft', 'date' => '10 Mei 2026'],
                    ['name' => 'Bazaar Kewirausahaan', 'divisi' => 'Divisi Kewirausahaan', 'status' => 'preparation', 'date' => '05 Mei 2026'],
                ] as $proker)
                    <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50/50 transition-colors duration-200">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-2 h-2 rounded-full flex-shrink-0
                                {{ $proker['status'] === 'on-progress' ? 'bg-blue-500 animate-pulse' :
                                   ($proker['status'] === 'completed' ? 'bg-emerald-500' :
                                   ($proker['status'] === 'preparation' ? 'bg-amber-500' : 'bg-gray-300')) }}">
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-700 truncate">{{ $proker['name'] }}</p>
                                <p class="text-xs text-gray-400">{{ $proker['divisi'] }} · {{ $proker['date'] }}</p>
                            </div>
                        </div>
                        <x-dashboard.status-badge :status="$proker['status']" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Calendar Widget + Upcoming --}}
        <div class="space-y-6">
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
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('dashboard.proker.create') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-[#2C3DA6] transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-[11px] font-semibold text-center">Tambah Proker</span>
                    </a>
                    <a href="{{ route('dashboard.proposal.create') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-purple-50 text-gray-500 hover:text-purple-600 transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-[11px] font-semibold text-center">Buat Proposal</span>
                    </a>
                    <a href="{{ route('dashboard.finance.index') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 text-gray-500 hover:text-emerald-600 transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/>
                        </svg>
                        <span class="text-[11px] font-semibold text-center">Keuangan</span>
                    </a>
                    <a href="{{ route('dashboard.documents.index') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-cyan-50 text-gray-500 hover:text-[#00C4D8] transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-[11px] font-semibold text-center">Dokumentasi</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800">Aktivitas Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach([
                    ['icon' => 'check', 'color' => 'emerald', 'text' => 'Proposal "Workshop UI/UX" disetujui oleh Ketua Hima', 'time' => '2 jam lalu'],
                    ['icon' => 'upload', 'color' => 'blue', 'text' => 'Bukti transaksi kas internal diunggah oleh Bendahara', 'time' => '4 jam lalu'],
                    ['icon' => 'user', 'color' => 'purple', 'text' => '3 anggota baru ditambahkan ke Divisi Akademik', 'time' => '1 hari lalu'],
                    ['icon' => 'doc', 'color' => 'amber', 'text' => 'Laporan keuangan Maret 2026 diekspor ke Excel', 'time' => '2 hari lalu'],
                    ['icon' => 'calendar', 'color' => 'cyan', 'text' => 'Jadwal Seminar Tech Week diperbarui', 'time' => '3 hari lalu'],
                ] as $activity)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-{{ $activity['color'] }}-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            @if($activity['icon'] === 'check')
                                <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @elseif($activity['icon'] === 'upload')
                                <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            @elseif($activity['icon'] === 'user')
                                <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            @elseif($activity['icon'] === 'doc')
                                <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-600">{{ $activity['text'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.dashboard>
