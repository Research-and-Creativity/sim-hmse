<x-layouts.public title="{{ $event->name }}" description="{{ Str::limit($event->description, 160) }}">

    {{-- Header --}}
    <section class="pt-28 pb-10 bg-gradient-to-br from-[#0f2044] via-[#1e3a5f] to-[#2e86ab] relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#2e86ab]/20 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
        </div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-white/60 text-sm mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('events.index') }}" class="hover:text-white transition-colors">Event & Proker</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/90 line-clamp-1">{{ $event->name }}</span>
            </nav>

            @php
                $statusLabel = match($event->status) {
                    'preparation'  => ['label' => 'Persiapan',   'cls' => 'bg-amber-400/20 text-amber-200 border-amber-400/30'],
                    'on-progress'  => ['label' => 'Berlangsung', 'cls' => 'bg-blue-400/20 text-blue-200 border-blue-400/30'],
                    'completed'    => ['label' => 'Selesai',     'cls' => 'bg-green-400/20 text-green-200 border-green-400/30'],
                    'cancelled'    => ['label' => 'Dibatalkan',  'cls' => 'bg-red-400/20 text-red-200 border-red-400/30'],
                    default        => ['label' => 'Draft',       'cls' => 'bg-white/10 text-white/60 border-white/20'],
                };
            @endphp

            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $statusLabel['cls'] }}">
                    {{ $statusLabel['label'] }}
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full border border-white/20 bg-white/10 text-white/70">
                    {{ $event->division }}
                </span>
                @if($isOpen)
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-[#f4a261] text-white animate-pulse">
                        ✦ Pendaftaran Dibuka
                    </span>
                @endif
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white leading-tight">
                {{ $event->name }}
            </h1>
        </div>
    </section>

    {{-- Body --}}
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="mb-6 flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT — Detail Event --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Poster --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        @if($event->poster)
                            <img src="{{ str_starts_with($event->poster, 'http') ? $event->poster : asset('storage/' . $event->poster) }}"
                                 alt="Poster {{ $event->name }}"
                                 class="w-full object-cover max-h-[480px]">
                        @else
                            <div class="w-full aspect-video flex items-center justify-center"
                                 style="background: linear-gradient(135deg, {{ $event->color ?? '#2C3DA6' }}18, {{ $event->color ?? '#2C3DA6' }}35)">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto mb-3 opacity-25" fill="none" stroke="{{ $event->color ?? '#1e3a5f' }}" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-400 font-medium">Poster belum tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Informasi Event --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-[#1e3a5f] mb-5 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#2e86ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Event
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Tanggal --}}
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-9 h-9 bg-[#2e86ab]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4.5 h-4.5 text-[#2e86ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-0.5">Tanggal Pelaksanaan</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ optional($event->date_start)->translatedFormat('d M Y') }}
                                        @if($event->date_start != $event->date_end)
                                            — {{ optional($event->date_end)->translatedFormat('d M Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-9 h-9 bg-[#2e86ab]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4.5 h-4.5 text-[#2e86ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-0.5">Lokasi</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $event->location ?: 'Belum ditentukan' }}</p>
                                </div>
                            </div>

                            {{-- Peserta --}}
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-9 h-9 bg-[#2e86ab]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4.5 h-4.5 text-[#2e86ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-0.5">Peserta Terdaftar</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $registrationCount }}
                                        @if($quota) <span class="font-normal text-gray-500">/ {{ $quota }} kuota</span> @endif
                                    </p>
                                    @if($quota)
                                        <div class="mt-1.5 w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full transition-all duration-500
                                                {{ $isFull ? 'bg-red-500' : 'bg-[#2e86ab]' }}"
                                                 style="width: {{ min(100, ($registrationCount / $quota) * 100) }}%"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Batas Daftar --}}
                            @if($event->registration_deadline)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="w-9 h-9 bg-[#f4a261]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4.5 h-4.5 text-[#f4a261]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium mb-0.5">Batas Pendaftaran</p>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $event->registration_deadline->translatedFormat('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    @if($event->description)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#2e86ab]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Deskripsi
                            </h2>
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    @endif

                </div>

                {{-- RIGHT — Registration Form --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24">

                        @if($isOpen)
                            {{-- Form Pendaftaran --}}
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#1e3a5f] to-[#2e86ab] px-6 py-5">
                                    <h3 class="text-white font-bold text-lg">Daftar Sekarang</h3>
                                    <p class="text-white/70 text-sm mt-0.5">Isi form berikut untuk mendaftar</p>
                                </div>

                                <form action="{{ route('events.register', $event->id) }}" method="POST" class="p-6 space-y-4">
                                    @csrf

                                    {{-- Error Global --}}
                                    @if($errors->any())
                                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <p>• {{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Nama --}}
                                    <div>
                                        <label for="reg-name" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input id="reg-name" type="text" name="name" value="{{ old('name') }}"
                                               placeholder="Nama lengkap kamu"
                                               class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all
                                               {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                                    </div>

                                    {{-- NIM --}}
                                    <div>
                                        <label for="reg-nim" class="block text-xs font-semibold text-gray-700 mb-1">NIM</label>
                                        <input id="reg-nim" type="text" name="nim" value="{{ old('nim') }}"
                                               placeholder="Nomor Induk Mahasiswa"
                                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all">
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label for="reg-email" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input id="reg-email" type="email" name="email" value="{{ old('email') }}"
                                               placeholder="email@example.com"
                                               class="w-full px-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all
                                               {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                                    </div>

                                    {{-- No. HP --}}
                                    <div>
                                        <label for="reg-phone" class="block text-xs font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                                        <input id="reg-phone" type="text" name="phone" value="{{ old('phone') }}"
                                               placeholder="08xxxxxxxxxx"
                                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all">
                                    </div>

                                    {{-- Prodi & Semester --}}
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="reg-prodi" class="block text-xs font-semibold text-gray-700 mb-1">Program Studi</label>
                                            <input id="reg-prodi" type="text" name="prodi" value="{{ old('prodi') }}"
                                                   placeholder="Prodi kamu"
                                                   class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all">
                                        </div>
                                        <div>
                                            <label for="reg-semester" class="block text-xs font-semibold text-gray-700 mb-1">Semester</label>
                                            <select id="reg-semester" name="semester"
                                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all">
                                                <option value="">—</option>
                                                @for($s = 1; $s <= 8; $s++)
                                                    <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Catatan --}}
                                    <div>
                                        <label for="reg-note" class="block text-xs font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
                                        <textarea id="reg-note" name="note" rows="3"
                                                  placeholder="Pertanyaan atau hal yang ingin disampaikan..."
                                                  class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2e86ab]/30 focus:border-[#2e86ab] transition-all resize-none">{{ old('note') }}</textarea>
                                    </div>

                                    <button type="submit"
                                            class="w-full py-3 bg-gradient-to-r from-[#1e3a5f] to-[#2e86ab] text-white text-sm font-bold rounded-xl hover:opacity-90 transition-opacity duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Kirim Pendaftaran
                                    </button>
                                </form>
                            </div>

                        @elseif($isFull)
                            <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 text-center">
                                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-1">Kuota Penuh</h3>
                                <p class="text-sm text-gray-500">Maaf, kuota pendaftaran untuk event ini sudah habis.</p>
                            </div>

                        @elseif(!$event->open_registration)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                                <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-1">Pendaftaran Belum Dibuka</h3>
                                <p class="text-sm text-gray-500">Pendaftaran untuk event ini belum dibuka. Pantau terus halaman ini!</p>
                            </div>

                        @else
                            <div class="bg-white rounded-2xl shadow-sm border border-amber-100 p-6 text-center">
                                <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-1">Pendaftaran Ditutup</h3>
                                <p class="text-sm text-gray-500">Batas waktu pendaftaran sudah lewat.</p>
                            </div>
                        @endif

                        {{-- Back Button --}}
                        <a href="{{ route('events.index') }}"
                           class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                            </svg>
                            Kembali ke Daftar Event
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layouts.public>
