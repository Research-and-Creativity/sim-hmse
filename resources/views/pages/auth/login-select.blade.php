<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIM HMSE</title>
    <meta name="description" content="Pilih peran untuk masuk ke Sistem Informasi Manajemen HMSE Telkom University Purwokerto">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">

    <div class="min-h-screen flex">

        {{-- Left: Branding Panel --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden items-center justify-center"
              style="background: linear-gradient(135deg, #1a2a6c 0%, #2C3DA6 30%, #1E2D8F 60%, #00C4D8 100%); height: 100vh; position: sticky; top: 0; align-self: flex-start;">

            {{-- Animated Background Shapes --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full opacity-10 bg-white animate-pulse" style="animation-duration: 6s;"></div>
                <div class="absolute top-1/3 -right-20 w-72 h-72 rounded-full opacity-[0.07] bg-white animate-pulse" style="animation-duration: 8s;"></div>
                <div class="absolute -bottom-32 left-1/4 w-80 h-80 rounded-full opacity-[0.05] bg-white animate-pulse" style="animation-duration: 10s;"></div>

                <div class="absolute inset-0 opacity-[0.03]"
                     style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;">
                </div>

                <div class="absolute top-0 left-0 w-full h-full opacity-[0.04]"
                     style="background-image: repeating-linear-gradient(45deg, transparent, transparent 80px, rgba(255,255,255,.1) 80px, rgba(255,255,255,.1) 81px);">
                </div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 max-w-lg px-12 text-center">
                <div class="mt-6 mb-6 inline-flex items-center justify-center">
                    <div class="w-40 h-40 flex items-center justify-center">
                        <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo" class="w-24 h-24 object-contain">
                    </div>
                </div>

                <h1 class="text-4xl font-black text-white mb-3 tracking-tight">SIM HMSE</h1>
                <p class="text-lg text-white/60 font-medium mb-2">Sistem Informasi Manajemen</p>
                <p class="text-sm text-white/40 leading-relaxed mb-6">
                    Himpunan Mahasiswa Software Engineering<br>
                    Telkom University Purwokerto
                </p>

                {{-- Feature Highlights --}}
                <div class="space-y-4 text-left max-w-sm mx-auto">
                    @foreach([
                        ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Manajemen Program Kerja', 'desc' => 'Kelola proker dari persiapan hingga selesai'],
                        ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Proposal Otomatis', 'desc' => 'Generate PDF dengan tanda tangan digital'],
                        ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1', 'title' => 'Pencatatan Keuangan', 'desc' => 'Transparansi kas internal & per-proker'],
                    ] as $feature)
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $feature['title'] }}</p>
                                <p class="text-xs text-white/40 mt-0.5">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <div class="w-8 h-0.5 bg-white/20 rounded-full"></div>
                    <span class="text-[10px] text-white/30 uppercase tracking-widest font-semibold">Secure Platform</span>
                    <div class="w-8 h-0.5 bg-white/20 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Right: Role Selection --}}
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 sm:p-12 bg-[#f8f9fb]">
            <div class="w-full max-w-md">

                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 mb-6">
                        <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo" class="w-16 h-16 object-contain">
                    </div>
                    <h1 class="text-2xl font-black text-gray-800">SIM HMSE</h1>
                    <p class="text-sm text-gray-400">Sistem Informasi Manajemen</p>
                </div>

                {{-- Welcome --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-gray-800 mb-1">Masuk Sebagai 👤</h2>
                    <p class="text-sm text-gray-400">Pilih peran kamu untuk melanjutkan</p>
                </div>

                {{-- Role Cards --}}
                <div class="space-y-4">

                    {{-- 1. Pengurus --}}
                    <a href="{{ route('login.form', 'pengurus') }}"
                       class="group block w-full p-5 bg-white border-2 border-gray-100 rounded-2xl hover:border-[#2C3DA6] hover:shadow-lg hover:shadow-[#2C3DA6]/10 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300"
                                 style="background: linear-gradient(135deg, #2C3DA6, #1E2D8F);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-gray-800 group-hover:text-[#2C3DA6] transition-colors">Pengurus</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Login sebagai pengurus HMSE untuk mengelola organisasi, proposal, dan program kerja</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-[#2C3DA6] group-hover:translate-x-1 transition-all duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    {{-- 2. Pembina --}}
                    <a href="{{ route('login.form', 'pembina') }}"
                       class="group block w-full p-5 bg-white border-2 border-gray-100 rounded-2xl hover:border-[#00C4D8] hover:shadow-lg hover:shadow-[#00C4D8]/10 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300"
                                 style="background: linear-gradient(135deg, #00C4D8, #0891b2);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-[#00C4D8] transition-colors">Pembina</h3>
                                    <span class="text-[10px] font-bold text-[#00C4D8] bg-cyan-50 px-2 py-0.5 rounded-full border border-cyan-100">HMSE</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">Login untuk menandatangani dan menyetujui proposal kegiatan himpunan</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-[#00C4D8] group-hover:translate-x-1 transition-all duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    {{-- 3. Kaprodi --}}
                    <a href="{{ route('login.form', 'kaprodi') }}"
                       class="group block w-full p-5 bg-white border-2 border-gray-100 rounded-2xl hover:border-[#7c3aed] hover:shadow-lg hover:shadow-[#7c3aed]/10 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300"
                                 style="background: linear-gradient(135deg, #7c3aed, #5b21b6);">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-gray-800 group-hover:text-[#7c3aed] transition-colors">Kaprodi</h3>
                                    <span class="text-[10px] font-bold text-[#7c3aed] bg-violet-50 px-2 py-0.5 rounded-full border border-violet-100">RPL</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">Login sebagai Ketua Program Studi untuk menyetujui proposal kegiatan</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-[#7c3aed] group-hover:translate-x-1 transition-all duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    {{-- 3. Tamu (sementara disembunyikan)
                    <div class="group block w-full p-5 bg-white border-2 border-gray-100 rounded-2xl opacity-60 cursor-not-allowed">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-gray-500">Tamu</h3>
                                    <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full uppercase tracking-wider">Coming Soon</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">Akses terbatas untuk melihat informasi publik himpunan</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    --}}
                </div>

                {{-- Back to Home --}}
                <div class="mt-10 text-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#2C3DA6] transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke halaman utama
                    </a>
                </div>

                {{-- Footer --}}
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-[11px] text-gray-300">
                        &copy; {{ date('Y') }} HMSE Telkom University Purwokerto
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
