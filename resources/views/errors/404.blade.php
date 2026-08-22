<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | SIM HMSE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#f0f2f5] font-sans flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sm:p-10 text-center">
        {{-- Icon Container --}}
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        {{-- Badge Status --}}
        <span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-100 mb-3">
            Error 404 · Not Found
        </span>

        {{-- Heading & Message --}}
        <h1 class="text-xl font-bold text-gray-800 tracking-tight">Halaman Tidak Ditemukan</h1>
        <p class="text-sm text-gray-500 mt-2 mb-6 leading-relaxed">
            Halaman atau tautan yang Anda tuju tidak tersedia atau telah dipindahkan.
        </p>

        {{-- Dynamic Target Route --}}
        @php
            $targetRoute = route('home');
            $targetLabel = 'Kembali ke Beranda';
            if (auth()->check()) {
                $user = auth()->user();
                if (in_array($user->role, ['pembina', 'kaprodi']) || in_array($user->jabatan, ['pembina', 'kaprodi'])) {
                    $targetRoute = route('pembina.dashboard');
                    $targetLabel = 'Kembali ke Portal Pembina';
                } else {
                    $targetRoute = route('dashboard');
                    $targetLabel = 'Kembali ke Dashboard';
                }
            }
        @endphp

        {{-- Action Button --}}
        <div class="flex justify-center">
            <a href="{{ $targetRoute }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ $targetLabel }}
            </a>
        </div>
    </div>

</body>
</html>
