{{-- Dashboard Sidebar --}}
<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-200 transition-all duration-300 ease-in-out"
    :class="[
        sidebarOpen ? 'w-64' : 'w-20',
        sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]"
>
    {{-- Logo Area with Collapse Toggle --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo" class="w-full h-full object-contain">
            </div>
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200" class="overflow-hidden">
                <span class="text-sm font-black text-[#2C3DA6] tracking-tight leading-none block">SIM HMSE</span>
                <span class="text-[10px] text-gray-400 leading-none whitespace-nowrap">Management System</span>
            </div>
        </a>

        {{-- Collapse Toggle (Hamburger) --}}
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 hover:text-[#2C3DA6] hover:bg-blue-50 transition-all duration-200 flex-shrink-0"
            title="Toggle Sidebar"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        {{-- Menu Section: Utama --}}
        <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Menu Utama</p>

        <x-dashboard.sidebar-link
            href="{{ route('dashboard') }}"
            :active="request()->routeIs('dashboard')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>'
            label="Dashboard"
        />

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.proker.index') }}"
            :active="request()->routeIs('dashboard.proker.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'
            label="Program Kerja"
        />

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.calendar') }}"
            :active="request()->routeIs('dashboard.calendar')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'
            label="Kalender"
        />

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.proposal.index') }}"
            :active="request()->routeIs('dashboard.proposal.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
            label="Proposal"
        />

        {{-- Divider --}}
        <div class="my-3 border-t border-gray-100"></div>
        <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Keuangan</p>

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.finance.index') }}"
            :active="request()->routeIs('dashboard.finance.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
            label="Keuangan"
        />

        {{-- Divider --}}
        <div class="my-3 border-t border-gray-100"></div>
        <p x-show="sidebarOpen" class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Organisasi</p>

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.sotk.index') }}"
            :active="request()->routeIs('dashboard.sotk.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'
            label="SOTK"
        />

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.events.index') }}"
            :active="request()->routeIs('dashboard.events.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>'
            label="Events"
        />

        <x-dashboard.sidebar-link
            href="{{ route('dashboard.documents.index') }}"
            :active="request()->routeIs('dashboard.documents.*')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>'
            label="Dokumentasi"
        />

    </nav>
</aside>