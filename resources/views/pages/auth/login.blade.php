<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login — SIM HMSE</title>
    <meta name="description" content="Login ke Sistem Informasi Manajemen HMSE Telkom University Purwokerto">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">

    <div class="min-h-screen flex" x-data="{ showPassword: false, email: '{{ old('email') }}', password: '' }">

        {{-- Left: Branding Panel --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden items-center justify-center"
            style="background: linear-gradient(135deg, #1a2a6c 0%, #2C3DA6 30%, #1E2D8F 60%, #00C4D8 100%); height: 100vh; position: sticky; top: 0; align-self: flex-start;">

            {{-- Animated Background Shapes --}}
            <div class="absolute inset-0 overflow-hidden">
                {{-- Large circle --}}
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full opacity-10 bg-white animate-pulse"
                    style="animation-duration: 6s;"></div>
                <div class="absolute top-1/3 -right-20 w-72 h-72 rounded-full opacity-[0.07] bg-white animate-pulse"
                    style="animation-duration: 8s;"></div>
                <div class="absolute -bottom-32 left-1/4 w-80 h-80 rounded-full opacity-[0.05] bg-white animate-pulse"
                    style="animation-duration: 10s;"></div>

                {{-- Grid Pattern --}}
                <div class="absolute inset-0 opacity-[0.03]"
                    style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;">
                </div>

                {{-- Diagonal Lines --}}
                <div class="absolute top-0 left-0 w-full h-full opacity-[0.04]"
                    style="background-image: repeating-linear-gradient(45deg, transparent, transparent 80px, rgba(255,255,255,.1) 80px, rgba(255,255,255,.1) 81px);">
                </div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 max-w-lg px-12 text-center">
                {{-- Logo --}}
                <div class="mt-6 mb-6 inline-flex items-center justify-center">
                    <div class="w-40 h-40 flex items-center justify-center">
                        <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo"
                            class="w-24 h-24 object-contain">
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
                    @foreach ([['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Manajemen Program Kerja', 'desc' => 'Kelola proker dari persiapan hingga selesai'], ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Proposal Otomatis', 'desc' => 'Generate PDF dengan tanda tangan digital'], ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1', 'title' => 'Pencatatan Keuangan', 'desc' => 'Transparansi kas internal & per-proker']] as $feature)
                        <div
                            class="flex items-start gap-4 p-4 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div
                                class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-[#00C4D8]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $feature['icon'] }}" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $feature['title'] }}</p>
                                <p class="text-xs text-white/40 mt-0.5">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Bottom Decoration --}}
                <div class="mt-6 flex items-center justify-center gap-3">
                    <div class="w-8 h-0.5 bg-white/20 rounded-full"></div>
                    <span class="text-[10px] text-white/30 uppercase tracking-widest font-semibold">Secure
                        Platform</span>
                    <div class="w-8 h-0.5 bg-white/20 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Right: Login Form --}}
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 sm:p-12 bg-[#f8f9fb]">
            <div class="w-full max-w-md">

                {{-- Mobile Logo (hidden on desktop) --}}
                <div class="lg:hidden text-center mb-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 mb-6">
                        <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo"
                            class="w-16 h-16 object-contain">
                        </svg>
                    </div>
                    <h1 class="text-2xl font-black text-gray-800">SIM HMSE</h1>
                    <p class="text-sm text-gray-400">Sistem Informasi Manajemen</p>
                </div>

                {{-- Welcome Text --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <h2 class="text-2xl font-black text-gray-800">Selamat Datang! 👋</h2>
                    </div>
                    <p class="text-sm text-gray-400 mb-3">Masuk ke akun kamu untuk melanjutkan</p>
                    @if (isset($role))
                        @php
                            $roleConfig = match ($role) {
                                'pengurus' => [
                                    'label' => 'Pengurus HMSE',
                                    'color' => 'bg-[#2C3DA6]/10 text-[#2C3DA6]',
                                    'icon' =>
                                        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                                ],
                                'pembina' => [
                                    'label' => 'Pembina HMSE',
                                    'color' => 'bg-[#00C4D8]/10 text-[#00C4D8]',
                                    'icon' =>
                                        'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                ],
                                'kaprodi' => [
                                    'label' => 'Kaprodi RPL',
                                    'color' => 'bg-[#7c3aed]/10 text-[#7c3aed]',
                                    'icon' =>
                                        'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                                ],
                                default => [
                                    'label' => 'Pembina / Kaprodi',
                                    'color' => 'bg-[#00C4D8]/10 text-[#00C4D8]',
                                    'icon' =>
                                        'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                ],
                            };
                        @endphp
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold {{ $roleConfig['color'] }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $roleConfig['icon'] }}" />
                            </svg>
                            Masuk sebagai {{ $roleConfig['label'] }}
                        </div>
                    @endif
                </div>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5" x-ref="loginForm">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role ?? 'pengurus' }}">

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" x-model="email"
                                placeholder="{{ ($role ?? 'pengurus') === 'pembina' ? 'pembina@ittelkom-pwt.ac.id' : (($role ?? 'pengurus') === 'kaprodi' ? 'kaprodi@ittelkom-pwt.ac.id' : 'nama@student.telkomuniversity.ac.id') }}"
                                required autofocus
                                class="w-full pl-11 pr-4 py-3 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-3 focus:ring-[#2C3DA6]/10 transition-all duration-200 placeholder:text-gray-300">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#"
                                class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] transition-colors">Lupa
                                password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                                x-model="password" placeholder="Masukkan password" required
                                class="w-full pl-11 pr-12 py-3 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-3 focus:ring-[#2C3DA6]/10 transition-all duration-200 placeholder:text-gray-300">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center gap-2.5">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-[#2C3DA6] focus:ring-[#2C3DA6]/30 transition-colors cursor-pointer">
                        <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">Ingat saya di
                            perangkat ini</label>
                    </div>

                    {{-- Error Alert --}}
                    @if (session('error'))
                        <div class="p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.134 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-700">Login gagal</p>
                                <p class="text-xs text-red-500 mt-0.5">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-3.5 text-sm font-bold text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 focus:outline-none"
                        @if (($role ?? 'pengurus') === 'pembina') style="background: linear-gradient(135deg, #00C4D8 0%, #0891b2 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, #06b6d4 0%, #00C4D8 100%)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #00C4D8 0%, #0891b2 100%)'"
                        @elseif(($role ?? 'pengurus') === 'kaprodi')
                        style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%)'"
                        @else
                        style="background: linear-gradient(135deg, #2C3DA6 0%, #1E2D8F 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, #3548b8 0%, #2C3DA6 100%)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #2C3DA6 0%, #1E2D8F 100%)'" @endif>
                        Masuk ke Dashboard
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-4 my-6">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400 font-medium">atau</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                {{-- SSO Button --}}
                <button type="button"
                    class="w-full flex items-center justify-center gap-3 py-3 text-sm font-semibold text-gray-600 bg-white border-2 border-gray-200 rounded-xl hover:border-[#2C3DA6]/30 hover:bg-blue-50/30 transition-all duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Login dengan Google (SSO Kampus)
                </button>

                {{-- Collapsible Quick Login Helper (visible for testing) --}}
                <div x-data="{ openHelper: false }"
                    class="mt-5 border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm transition-all duration-300">
                    <button type="button" @click="openHelper = !openHelper"
                        class="w-full flex items-center justify-between px-4 py-2.5 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider hover:bg-gray-100 transition-colors">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4.5 h-4.5 text-[#2C3DA6]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Akun Demo / Quick Login
                        </span>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': openHelper }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openHelper" class="p-3 bg-white divide-y divide-gray-100 max-h-56 overflow-y-auto"
                        style="display: none;">
                        @if (($role ?? 'pengurus') === 'pengurus')
                            @foreach ([['role' => 'Ketua HMSE', 'email' => 'ketua@hmse.ac.id'], ['role' => 'Vice President', 'email' => 'wakilketua@hmse.ac.id'], ['role' => 'Secretary 1', 'email' => 'sekretaris1@hmse.ac.id'], ['role' => 'Secretary 2', 'email' => 'sekretaris2@hmse.ac.id'], ['role' => 'Finance 1', 'email' => 'bendahara1@hmse.ac.id'], ['role' => 'Finance 2', 'email' => 'bendahara2@hmse.ac.id'], ['role' => 'Research and Creativity', 'email' => 'head.akademik@hmse.ac.id'], ['role' => 'Resource Management', 'email' => 'head.psdm@hmse.ac.id'], ['role' => 'Internal and External Communication', 'email' => 'head.humas@hmse.ac.id'], ['role' => 'Economy Creative', 'email' => 'head.mikat@hmse.ac.id'], ['role' => 'Creative Media and Information', 'email' => 'head.medinfo@hmse.ac.id']] as $demoUser)
                                <button type="button"
                                    @click="email = '{{ $demoUser['email'] }}'; password = 'hmse2026'; $nextTick(() => $refs.loginForm.submit())"
                                    class="w-full text-left py-2 px-2.5 rounded-lg hover:bg-blue-50/50 flex flex-col gap-0.5 group transition-colors cursor-pointer">
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-xs font-bold text-gray-700 group-hover:text-[#2C3DA6]">{{ $demoUser['role'] }}</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400">{{ $demoUser['email'] }}</span>
                                </button>
                            @endforeach
                        @elseif(($role ?? 'pengurus') === 'pembina')
                            <button type="button"
                                @click="email = 'pembina@ittelkom-pwt.ac.id'; password = 'pembina2026'; $nextTick(() => $refs.loginForm.submit())"
                                class="w-full text-left py-2 px-2.5 rounded-lg hover:bg-cyan-50/50 flex flex-col gap-0.5 group transition-colors cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-700 group-hover:text-cyan-600">Pembina
                                        HMSE</span>
                                </div>
                                <span class="text-[10px] text-gray-400">pembina@ittelkom-pwt.ac.id</span>
                            </button>
                        @elseif(($role ?? 'pengurus') === 'kaprodi')
                            <button type="button"
                                @click="email = 'kaprodi@ittelkom-pwt.ac.id'; password = 'pembina2026'; $nextTick(() => $refs.loginForm.submit())"
                                class="w-full text-left py-2 px-2.5 rounded-lg hover:bg-violet-50/50 flex flex-col gap-0.5 group transition-colors cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-700 group-hover:text-violet-600">Kaprodi
                                        RPL</span>
                                </div>
                                <span class="text-[10px] text-gray-400">kaprodi@ittelkom-pwt.ac.id</span>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Back to Role Selection --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-[#2C3DA6] transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali pilih peran
                    </a>
                </div>

                {{-- Footer --}}
                <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                    <p class="text-[11px] text-gray-300">
                        &copy; {{ date('Y') }} HMSE Telkom University Purwokerto
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
