<x-layouts.dashboard title="Manajemen Event Publik">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Manajemen Event Publik</h2>
            <p class="text-sm text-gray-400 mt-0.5">Atur proker yang ditampilkan ke publik & kelola pendaftaran peserta</p>
        </div>
        <a href="{{ route('dashboard.proker.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Buat Proker Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Info Box --}}
    <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl text-sm text-blue-700 flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            Atur proker yang ditampilkan di halaman publik (News/Event) dengan mengaktifkan <strong>Tampil ke Publik</strong> dari halaman edit proker.
            Aktifkan juga <strong>Buka Pendaftaran</strong> agar mahasiswa umum bisa mendaftar.
        </div>
    </div>

    @if($events->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center bg-white rounded-2xl border border-gray-100">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-700 mb-1">Belum ada program kerja</h3>
            <p class="text-sm text-gray-400 mb-4">Buat proker baru dan aktifkan "Tampil ke Publik"</p>
            <a href="{{ route('dashboard.proker.create') }}"
               class="px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all">
                Buat Proker
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($events as $event)
                @php
                    $quota = $event->registration_quota ?? $event->target_participants;
                    $isFull = $quota && $event->registrations_count >= $quota;
                @endphp
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="h-1.5" style="background: {{ $event->color ?? '#2C3DA6' }};"></div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="text-sm font-bold text-gray-800 line-clamp-2 flex-1">{{ $event->name }}</h3>
                            <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                @if($event->is_public)
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Publik</span>
                                @else
                                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">Privat</span>
                                @endif
                                @if($event->open_registration && $event->is_public)
                                    @if($isFull)
                                        <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Penuh</span>
                                    @else
                                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Daftar Buka</span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="space-y-1.5 mb-4">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ optional($event->date_start)->format('d M Y') }} — {{ optional($event->date_end)->format('d M Y') }}
                            </div>
                            @if($event->location)
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            @endif
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $event->registrations_count }} pendaftar
                                    @if($quota) / {{ $quota }} kuota @endif
                                </span>
                            </div>
                        </div>

                        {{-- Progress bar --}}
                        @if($quota)
                            <div class="mb-4">
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $isFull ? 'bg-red-400' : '' }}"
                                         style="width: {{ min(100, ($event->registrations_count / $quota) * 100) }}%;
                                         {{ !$isFull ? 'background: ' . ($event->color ?? '#2C3DA6') . ';' : '' }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-2">
                            <a href="{{ route('dashboard.proker.show', $event->id) }}"
                               class="flex-1 py-2.5 text-xs font-semibold text-[#2C3DA6] bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors text-center">
                                Detail Proker
                            </a>
                            <a href="{{ route('dashboard.events.registrations', $event->id) }}"
                               class="flex-1 py-2.5 text-xs font-semibold text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-center">
                                Lihat Pendaftar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-layouts.dashboard>
