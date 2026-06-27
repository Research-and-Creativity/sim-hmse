@php
    $user = auth()->user();
    $isKaprodi = $user && $user->jabatan === 'kaprodi';
    $themeColor = $isKaprodi ? '#7c3aed' : '#00C4D8';
    $themeBg = $isKaprodi ? 'bg-violet-50' : 'bg-cyan-50';
    $themeText = $isKaprodi ? 'text-[#7c3aed]' : 'text-[#00C4D8]';
    $themeHoverText = $isKaprodi ? 'group-hover:text-[#7c3aed]' : 'group-hover:text-[#00C4D8]';
    $themeBorder = $isKaprodi ? 'border-violet-100' : 'border-cyan-100';
    $themeHoverBg = $isKaprodi ? 'hover:bg-violet-50 hover:text-[#7c3aed]' : 'hover:bg-cyan-50 hover:text-[#00C4D8]';
@endphp

{{-- Sidebar Pembina / Kaprodi --}}
<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-200 transition-all duration-300 ease-in-out"
    :class="[
        sidebarOpen ? 'w-64' : 'w-20',
        sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]"
>
    {{-- Logo Area with Collapse Toggle --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100 flex-shrink-0">
        <a href="{{ route('pembina.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo" class="w-full h-full object-contain">
            </div>
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200" class="overflow-hidden">
                <span class="text-sm font-black text-[{{ $themeColor }}] tracking-tight leading-none block">SIM HMSE</span>
                <span class="text-[10px] text-gray-400 leading-none whitespace-nowrap">
                    Portal {{ auth()->user()?->jabatan === 'kaprodi' ? 'Kaprodi' : 'Pembina' }}
                </span>
            </div>
        </a>

        {{-- Collapse Toggle --}}
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 hover:text-[{{ $themeColor }}] hover:{{ $themeBg }} transition-all duration-200 flex-shrink-0"
            title="Toggle Sidebar"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Role Badge --}}
    <div x-show="sidebarOpen" class="px-4 py-3 border-b border-gray-100
         {{ auth()->user()?->jabatan === 'kaprodi' ? 'bg-violet-50/50' : 'bg-cyan-50/50' }}">
        <div class="flex items-center gap-2">
            @if(auth()->user()?->jabatan === 'kaprodi')
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-[#7c3aed] to-[#5b21b6] flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-7m9-5v7M3 9v7"/>
                    </svg>
                </div>
            @else
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-[#00C4D8] to-[#0891b2] flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            @endif
            <div>
                <p class="text-[11px] font-bold {{ $themeText }}">
                    {{ auth()->user()?->jabatanLabel() ?? 'Pembina / Kaprodi' }}
                </p>
                <p class="text-[10px] text-gray-400">Mode: Persetujuan Proposal</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        {{-- Menu Section: Utama --}}
        <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('pembina.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('pembina.dashboard') ? "$themeBg $themeText" : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('pembina.dashboard') ? $themeText : 'text-gray-400 group-hover:text-gray-600' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Dashboard</span>
        </a>

        {{-- Program Kerja --}}
        <a href="{{ route('pembina.proker') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('pembina.proker*') ? "$themeBg $themeText" : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('pembina.proker*') ? $themeText : 'text-gray-400 group-hover:text-gray-600' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Program Kerja</span>
        </a>

        {{-- Kalender --}}
        <a href="{{ route('pembina.calendar') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('pembina.calendar') ? "$themeBg $themeText" : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('pembina.calendar') ? $themeText : 'text-gray-400 group-hover:text-gray-600' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Kalender</span>
        </a>

        {{-- Proposal --}}
        <a href="{{ route('pembina.proposal') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('pembina.proposal*') ? "$themeBg $themeText" : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
            <div class="relative flex-shrink-0">
                <svg class="w-5 h-5 {{ request()->routeIs('pembina.proposal*') ? $themeText : 'text-gray-400 group-hover:text-gray-600' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{-- Badge pending --}}
                @php $pendingCount = \App\Models\Proposal::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                    </span>
                @endif
            </div>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Proposal</span>
            @if($pendingCount > 0)
                <span x-show="sidebarOpen"
                      class="ml-auto text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-full">
                    {{ $pendingCount }} pending
                </span>
            @endif
        </a>

        {{-- Divider --}}
        <div class="my-3 border-t border-gray-100"></div>
        <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Keuangan</p>

        {{-- Keuangan --}}
        <a href="{{ route('pembina.keuangan') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-200
                  {{ request()->routeIs('pembina.keuangan*') ? "$themeBg $themeText" : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('pembina.keuangan*') ? $themeText : 'text-gray-400 group-hover:text-gray-600' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Keuangan</span>
        </a>

    </nav>

    {{-- Bottom: Logout --}}
    <div class="p-3 border-t border-gray-100 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="group flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150">Logout</span>
            </button>
        </form>
    </div>
</aside>
