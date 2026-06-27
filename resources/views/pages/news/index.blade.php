<x-layouts.public title="Event & Proker" description="Daftar event dan program kerja HMSE yang terbuka untuk umum">

    {{-- Page Header --}}
    <section class="pt-28 pb-14 bg-gradient-to-br from-[#0f2044] via-[#1e3a5f] to-[#2e86ab] relative overflow-hidden">
        {{-- Decorative circles --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#2e86ab]/20 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#f4a261]/10 rounded-full translate-y-1/2 -translate-x-1/4 blur-2xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 text-white/80 text-xs font-semibold rounded-full mb-5 backdrop-blur-sm border border-white/10">
                <svg class="w-3.5 h-3.5 text-[#f4a261]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Program Kerja HMSE
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-4 leading-tight">
                Event & Program Kerja
            </h1>
            <p class="text-white/60 text-base sm:text-lg max-w-2xl mx-auto">
                Ikuti event dan program kerja HMSE — buka untuk seluruh mahasiswa.
                Daftar sekarang sebelum kuota habis!
            </p>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filter & Search Bar --}}
            <form method="GET" action="{{ route('events.index') }}"
                  class="flex flex-col sm:flex-row gap-3 mb-10 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">

                {{-- Search --}}
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input
                        id="search-events"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari event atau program kerja..."
                        class="pl-10 pr-4 py-2.5 w-full text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-[#2e86ab] focus:ring-2 focus:ring-[#2e86ab]/20 transition-all duration-200"
                    >
                </div>

                {{-- Division Filter --}}
                <select name="division"
                        class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-[#2e86ab] focus:ring-2 focus:ring-[#2e86ab]/20 transition-all duration-200 min-w-[180px]">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div }}" {{ $division === $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>

                {{-- Status Filter --}}
                <select name="status"
                        class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-[#2e86ab] focus:ring-2 focus:ring-[#2e86ab]/20 transition-all duration-200 min-w-[150px]">
                    <option value="">Semua Status</option>
                    <option value="preparation" {{ $status === 'preparation' ? 'selected' : '' }}>Persiapan</option>
                    <option value="on-progress" {{ $status === 'on-progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>

                <button type="submit"
                        class="px-6 py-2.5 bg-[#1e3a5f] text-white text-sm font-semibold rounded-xl hover:bg-[#2a4f80] transition-colors duration-200">
                    Cari
                </button>
                @if($search || $division || $status)
                    <a href="{{ route('events.index') }}"
                       class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200 text-center">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Result Count --}}
            <p class="text-sm text-gray-500 mb-6">
                Menampilkan <span class="font-semibold text-[#1e3a5f]">{{ $events->total() }}</span> event
                @if($search) untuk "<span class="font-semibold">{{ $search }}</span>" @endif
            </p>

            @if($events->isNotEmpty())

                {{-- Events Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        @php
                            $statusLabel = match($event->status) {
                                'preparation'  => ['label' => 'Persiapan',  'cls' => 'bg-amber-100 text-amber-700 border-amber-200'],
                                'on-progress'  => ['label' => 'Berlangsung','cls' => 'bg-blue-100 text-blue-700 border-blue-200'],
                                'completed'    => ['label' => 'Selesai',    'cls' => 'bg-green-100 text-green-700 border-green-200'],
                                'cancelled'    => ['label' => 'Dibatalkan', 'cls' => 'bg-red-100 text-red-700 border-red-200'],
                                default        => ['label' => 'Draft',      'cls' => 'bg-gray-100 text-gray-600 border-gray-200'],
                            };
                            $regCount = $event->eventRegistrations()->whereIn('status',['pending','confirmed'])->count();
                            $quota    = $event->registration_quota ?? $event->target_participants;
                            $isFull   = $quota && $regCount >= $quota;
                            $isOpen   = $event->open_registration
                                        && !$isFull
                                        && (!$event->registration_deadline || now()->lte($event->registration_deadline));
                        @endphp

                        <article class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">

                            {{-- Poster / Thumbnail --}}
                            <a href="{{ route('events.show', $event->id) }}" class="block relative overflow-hidden">
                                <div class="aspect-video bg-gray-100">
                                    @if($event->poster)
                                        <img
                                            src="{{ str_starts_with($event->poster, 'http') ? $event->poster : asset('storage/' . $event->poster) }}"
                                            alt="Poster {{ $event->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"
                                             style="background: linear-gradient(135deg, {{ $event->color ?? '#2C3DA6' }}22, {{ $event->color ?? '#2C3DA6' }}44)">
                                            <svg class="w-14 h-14 opacity-30" fill="none" stroke="{{ $event->color ?? '#2C3DA6' }}" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Status Badge --}}
                                <span class="absolute top-3 left-3 px-2.5 py-1 text-xs font-bold rounded-full border {{ $statusLabel['cls'] }} shadow-sm backdrop-blur-sm">
                                    {{ $statusLabel['label'] }}
                                </span>

                                {{-- Open Registration Badge --}}
                                @if($isOpen)
                                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-[#1e3a5f] text-white text-xs font-bold rounded-full shadow-sm animate-pulse">
                                        Buka Daftar
                                    </span>
                                @elseif($isFull)
                                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                                        Penuh
                                    </span>
                                @endif
                            </a>

                            {{-- Card Body --}}
                            <div class="p-5 flex flex-col flex-1">

                                {{-- Division --}}
                                <p class="text-xs font-semibold text-[#2e86ab] uppercase tracking-wider mb-1.5">
                                    {{ $event->division }}
                                </p>

                                {{-- Title --}}
                                <h2 class="text-base font-bold text-[#1e3a5f] leading-snug mb-3 line-clamp-2 flex-1">
                                    <a href="{{ route('events.show', $event->id) }}" class="hover:text-[#2e86ab] transition-colors duration-200">
                                        {{ $event->name }}
                                    </a>
                                </h2>

                                {{-- Info Grid --}}
                                <div class="space-y-1.5 mb-4">
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5 text-[#2e86ab] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>
                                            {{ optional($event->date_start)->translatedFormat('d M Y') }} —
                                            {{ optional($event->date_end)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    @if($event->location)
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <svg class="w-3.5 h-3.5 text-[#2e86ab] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="line-clamp-1">{{ $event->location }}</span>
                                        </div>
                                    @endif
                                    @if($quota)
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <svg class="w-3.5 h-3.5 text-[#2e86ab] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>{{ $regCount }} / {{ $quota }} peserta</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- CTA --}}
                                <a href="{{ route('events.show', $event->id) }}"
                                   class="inline-flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold rounded-xl transition-all duration-200
                                   {{ $isOpen
                                       ? 'bg-[#1e3a5f] text-white hover:bg-[#2a4f80]'
                                       : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    @if($isOpen)
                                        Daftar Sekarang
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    @else
                                        Lihat Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    @endif
                                </a>

                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($events->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $events->links() }}
                    </div>
                @endif

            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">
                        @if($search || $division || $status)
                            Event tidak ditemukan
                        @else
                            Belum ada event yang dipublikasikan
                        @endif
                    </h3>
                    <p class="text-sm text-gray-400 mb-4">
                        @if($search || $division || $status)
                            Coba ubah filter pencarian kamu
                        @else
                            Event akan segera ditambahkan, pantau terus!
                        @endif
                    </p>
                    @if($search || $division || $status)
                        <a href="{{ route('events.index') }}"
                           class="px-5 py-2.5 bg-[#1e3a5f] text-white text-sm font-semibold rounded-xl hover:bg-[#2a4f80] transition-colors duration-200">
                            Lihat Semua Event
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </section>

</x-layouts.public>
