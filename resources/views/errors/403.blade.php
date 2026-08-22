<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | SIM HMSE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#f0f2f5] font-sans flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full text-center bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 relative overflow-hidden">
        {{-- Background Glow --}}
        <div class="absolute -top-16 -right-16 w-32 h-32 bg-[#2C3DA6]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-[#00C4D8]/10 rounded-full blur-2xl pointer-events-none"></div>

        {{-- Icon --}}
        <div class="w-20 h-20 mx-auto rounded-3xl bg-red-50 text-red-500 flex items-center justify-center mb-6 shadow-inner border border-red-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m0 0v2m0-2h2m-2 0H10m2-6V7a4 4 0 00-8 0v4h8zm0 0h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h2"/>
            </svg>
        </div>

        {{-- Error Code & Message --}}
        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-black uppercase tracking-wider rounded-full inline-block mb-3">
            Error 403 · Forbidden
        </span>
        <h1 class="text-2xl font-black text-gray-800 tracking-tight mb-2">Akses Ditolak</h1>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            {{ $exception->getMessage() ?: 'Maaf, akun Anda tidak memiliki hak akses atau wewenang untuk membuka halaman ini.' }}
        </p>

        {{-- Action Buttons --}}
        @php
            $targetRoute = route('home');
            $targetLabel = 'Kembali ke Beranda';
            if (auth()->check()) {
                $u = auth()->user();
                if (in_array($u->role, ['pembina', 'kaprodi']) || in_array($u->jabatan, ['pembina', 'kaprodi'])) {
                    $targetRoute = route('pembina.dashboard');
                    $targetLabel = 'Kembali ke Portal Pembina';
                } else {
                    $targetRoute = route('dashboard');
                    $targetLabel = 'Kembali ke Dashboard';
                }
            }
        @endphp

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ $targetRoute }}"
               class="px-6 py-3 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20 inline-flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ $targetLabel }}
            </a>
            @if(!auth()->check())
                <a href="{{ route('login') }}"
                   class="px-6 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors inline-flex items-center justify-center">
                    Login Akun
                </a>
            @endif
        </div>
    </div>

</body>
</html>
