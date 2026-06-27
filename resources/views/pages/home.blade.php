<x-layouts.public title="Beranda">

    {{-- ===== HERO SECTION ===== --}}
    <section class="relative min-h-screen flex items-center overflow-hidden" style="background: linear-gradient(135deg, #1E2D8F 0%, #2C3DA6 50%, #3B4FBF 100%);">

        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10 blur-3xl" style="background: #00C4D8;"></div>
        <div class="absolute bottom-24 left-1/4 w-64 h-64 rounded-full opacity-5 blur-3xl" style="background: #ffffff;"></div>

        {{-- Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-20 pb-32 w-full">
            <div class="max-w-2xl">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full border text-xs font-semibold uppercase tracking-widest" style="border-color: rgba(255,255,255,0.25); color: rgba(255,255,255,0.8);">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: #00C4D8;"></span>
                    Kabinet Zenith · {{ date('Y') }}
                </div>

                {{-- Judul --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-3">
                    Himpunan Mahasiswa<br>Software Engineering
                </h1>

                {{-- Subtitle --}}
                <h2 class="text-xl sm:text-2xl font-bold mb-6" style="color: #00C4D8; text-decoration: underline; text-decoration-color: #00C4D8; text-underline-offset: 4px;">
                    Telkom University Purwokerto
                </h2>

                {{-- Deskripsi --}}
                <p class="text-sm sm:text-base leading-relaxed mb-10" style="color: rgba(255,255,255,0.65);">
                    Selamat Datang Di Website profile Himpunan Mahasiswa Software Engineering Telkom University Purwokerto
                </p>

                {{-- Scroll Button --}}
                <a href="#about"
                   class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-semibold uppercase tracking-wider transition-all duration-200 hover:bg-white/10"
                   style="border: 1.5px solid rgba(255,255,255,0.4); color: rgba(255,255,255,0.85);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Arrow Down
                </a>

            </div>
        </div>

        {{-- Wave SVG Divider --}}
        <div class="absolute bottom-0 left-0 right-0 leading-none z-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none" class="w-full" style="display:block;">
                <path fill="#ffffff" d="M0,40 C180,90 360,0 540,50 C720,100 900,10 1080,55 C1170,77 1320,20 1440,45 L1440,100 L0,100 Z"/>
            </svg>
        </div>

    </section>

    {{-- ===== ABOUT SECTION ===== --}}
    <section id="about" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Kiri: Foto --}}
                <div class="flex justify-center lg:justify-start">
                    <div class="relative w-full max-w-md">
                        {{-- Foto Pengurus --}}
                        <img src="{{ asset('images/pengurus.png') }}" alt="Foto Pengurus HMSE" class="w-full h-auto rounded-2xl" style="filter: drop-shadow(0 20px 25px rgba(0,0,0,0.15)); background: transparent;">
                        {{-- Dekorasi --}}
                        <div class="absolute -bottom-8 -right-8 w-32 h-32 rounded-full -z-10" style="background: #00C4D8; opacity: 0.15; filter: blur(40px);"></div>
                        <div class="absolute -top-8 -left-8 w-24 h-24 rounded-full -z-10" style="background: #2C3DA6; opacity: 0.08; filter: blur(40px);"></div>
                    </div>
                </div>

                {{-- Kanan: Teks --}}
                <div>
                    {{-- Heading dengan vertical bar --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-1 h-10 rounded-full" style="background: #2C3DA6;"></div>
                        <h2 class="text-3xl sm:text-4xl font-black" style="color: #1a1a2e;">About Us</h2>
                    </div>

                    <div class="space-y-4 text-gray-600 leading-relaxed text-justify mb-8">
                        <p>
                            Himpunan Mahasiswa Software Engineering (HMSE) merupakan organisasi kemahasiswaan yang menjadi wadah bagi mahasiswa Software Engineering untuk berkembang, berkolaborasi, dan berkontribusi secara aktif dalam lingkungan akademik maupun non-akademik. HMSE hadir sebagai penghubung antara mahasiswa, dosen, serta pihak eksternal dalam mendukung peningkatan kualitas diri, baik dalam aspek keilmuan, keterampilan, maupun soft skills. Dengan semangat kebersamaan dan inovasi, HMSE berkomitmen untuk menciptakan lingkungan yang inspiratif dan progresif, sehingga mampu mendorong setiap anggotanya untuk terus bertumbuh dan mencapai potensi terbaiknya, sejalan dengan visi menuju keunggulan bersama.
                        </p>
                    </div>

                    <a href="{{ route('about') }}"
                       class="inline-flex items-center gap-2 px-7 py-2.5 rounded-full text-sm font-bold uppercase tracking-wider border-2 transition-all duration-200 hover:text-white"
                       style="border-color: #2C3DA6; color: #2C3DA6;"
                       onmouseover="this.style.background='#2C3DA6'"
                       onmouseout="this.style.background='transparent'">
                        Selengkapnya
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== EVENT SECTION ===== --}}
    <section class="py-20" style="background: #f8f9ff;">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-12">
                <div class="flex items-center justify-center gap-4 mb-3">
                    <div class="w-8 h-1 rounded-full" style="background: #00C4D8;"></div>
                    <h2 class="text-3xl font-black" style="color: #2C3DA6;">Event & Program Kerja</h2>
                    <div class="w-8 h-1 rounded-full" style="background: #00C4D8;"></div>
                </div>
                <p class="text-gray-500 text-sm">Event terbaru HMSE yang terbuka untuk mahasiswa umum</p>
            </div>

            @php
                $latestEvents = \App\Models\ProgramKerja::where('is_public', true)
                    ->orderBy('date_start','asc')->take(3)->get();
            @endphp

            @if($latestEvents->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach($latestEvents as $ev)
                        @php
                            $regCount = $ev->eventRegistrations()->whereIn('status',['pending','confirmed'])->count();
                            $quota    = $ev->registration_quota ?? $ev->target_participants;
                        @endphp
                        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <a href="{{ route('events.show', $ev->id) }}">
                                <div class="aspect-video bg-gray-100">
                                    @if($ev->poster)
                                        <img src="{{ str_starts_with($ev->poster, 'http') ? $ev->poster : asset('storage/' . $ev->poster) }}" alt="{{ $ev->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"
                                             style="background: linear-gradient(135deg, {{ $ev->color ?? '#2C3DA6' }}18, {{ $ev->color ?? '#2C3DA6' }}35)">
                                            <svg class="w-10 h-10 opacity-25" fill="none" stroke="{{ $ev->color ?? '#2C3DA6' }}" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-5">
                                <p class="text-xs font-semibold mb-1" style="color: #00C4D8;">{{ $ev->division }}</p>
                                <h3 class="font-bold mt-1 mb-2 line-clamp-2" style="color: #1a1a2e;">{{ $ev->name }}</h3>
                                <p class="text-xs text-gray-400">
                                    {{ optional($ev->date_start)->format('d M Y') }}
                                    @if($ev->location) · {{ $ev->location }} @endif
                                </p>
                                <a href="{{ route('events.show', $ev->id) }}" class="inline-flex items-center gap-1 mt-3 text-sm font-semibold" style="color: #00C4D8;">
                                    Lihat Detail →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @for($i = 0; $i < 3; $i++)
                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                            <div class="aspect-video animate-pulse" style="background: linear-gradient(135deg, #e8ecff, #dce2ff);"></div>
                            <div class="p-5 space-y-2">
                                <div class="h-3 bg-gray-100 rounded-full animate-pulse w-1/3"></div>
                                <div class="h-4 bg-gray-200 rounded-full animate-pulse"></div>
                                <div class="h-3 bg-gray-100 rounded-full animate-pulse w-2/5 mt-3"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('events.index') }}"
                   class="inline-flex items-center gap-2 px-8 py-3 rounded-full text-sm font-bold uppercase tracking-wider border-2 transition-all duration-200 hover:text-white"
                   style="border-color: #2C3DA6; color: #2C3DA6;"
                   onmouseover="this.style.background='#2C3DA6'"
                   onmouseout="this.style.background='transparent'">
                    Lihat Semua Event
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ===== GALLERY SECTION ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-12">
                <div class="flex items-center justify-center gap-4 mb-3">
                    <div class="w-8 h-1 rounded-full" style="background: #00C4D8;"></div>
                    <h2 class="text-3xl font-black" style="color: #2C3DA6;">Galeri Kegiatan</h2>
                    <div class="w-8 h-1 rounded-full" style="background: #00C4D8;"></div>
                </div>
                <p class="text-gray-500 text-sm">Dokumentasi kegiatan dan program kerja HMSE</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @if(isset($gallery) && $gallery->count() > 0)
                    @foreach($gallery->take(8) as $item)
                        <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer bg-gray-100">
                            <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="Dokumentasi HMSE"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                                 style="background: rgba(44,61,166,0.5);">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 8; $i++)
                        <div class="aspect-square rounded-xl animate-pulse" style="background: linear-gradient(135deg, #e8ecff, #dce2ff);"></div>
                    @endfor
                @endif
            </div>

        </div>
    </section>

</x-layouts.public>
