<nav
    x-data="{
        mobileOpen: false,
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 10;
            });
        }
    }"
    :class="scrolled ? 'shadow-md bg-white' : 'bg-white/95 backdrop-blur-sm'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                {{-- Logo Image --}}
                <div class="w-9 h-9 relative flex-shrink-0">
                    <img src="{{ asset('images/logo-zenit.png') }}" alt="HMSE Logo" class="w-full h-full object-contain">
                </div>
                <div class="hidden sm:block">
                    <span class="text-sm font-black text-[#2C3DA6] tracking-tight leading-none block">HMSE</span>
                    <span class="text-[10px] text-gray-400 leading-none">Tel-U Purwokerto</span>
                </div>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                          {{ request()->routeIs('home') ? 'text-[#2C3DA6] font-semibold' : 'text-gray-500 hover:text-[#2C3DA6]' }}">
                    Home
                </a>
                <a href="{{ route('about') }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                          {{ request()->routeIs('about') ? 'text-[#2C3DA6] font-semibold' : 'text-gray-500 hover:text-[#2C3DA6]' }}">
                    About Us
                </a>
                <a href="{{ route('events.index') }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200
                          {{ request()->routeIs('events.*') ? 'text-[#2C3DA6] font-semibold' : 'text-gray-500 hover:text-[#2C3DA6]' }}">
                    Event & Proker
                </a>

                {{-- Related Dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button
                        class="px-5 py-2 text-sm font-bold text-white uppercase tracking-wider rounded-full transition-all duration-200 hover:opacity-90 hover:shadow-md"
                        style="background-color: #00C4D8;"
                    >
                        Related
                    </button>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50"
                    >
                        <a href="https://zetech.telkomuniversity.ac.id" target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-150">
                            <svg class="w-4 h-4 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Zetech
                        </a>
                        <a href="#" target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-150">
                            <svg class="w-4 h-4 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Web Prodi
                        </a>
                    </div>
                </div>

                {{-- Login Dashboard Button --}}
                <a href="{{ route('login') }}"
                   class="ml-2 px-5 py-2 text-sm font-semibold text-[#2C3DA6] border-2 border-[#2C3DA6] rounded-full transition-all duration-200 hover:bg-[#2C3DA6] hover:text-white">
                    Login
                </a>
            </div>

            {{-- Hamburger Mobile --}}
            <button
                @click="mobileOpen = !mobileOpen"
                class="md:hidden p-2 rounded-lg text-gray-500 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-200"
            >
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white border-t border-gray-100 shadow-lg"
        @click.outside="mobileOpen = false"
    >
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-1">
            <a href="{{ route('home') }}"
               class="px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150
                      {{ request()->routeIs('home') ? 'text-[#2C3DA6] font-semibold bg-blue-50' : 'text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50' }}">
                Home
            </a>
            <a href="{{ route('about') }}"
               class="px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150
                      {{ request()->routeIs('about') ? 'text-[#2C3DA6] font-semibold bg-blue-50' : 'text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50' }}">
                About Us
            </a>
            <a href="{{ route('events.index') }}"
               class="px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-150
                      {{ request()->routeIs('events.*') ? 'text-[#2C3DA6] font-semibold bg-blue-50' : 'text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50' }}">
                Event & Proker
            </a>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50">
                    Related
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-4 flex flex-col gap-1 mt-1">
                    <a href="https://zetech.telkomuniversity.ac.id" target="_blank"
                       class="px-4 py-2.5 rounded-lg text-sm text-gray-500 hover:text-[#2C3DA6] hover:bg-blue-50">
                        &rarr; Zetech
                    </a>
                    <a href="#" target="_blank"
                       class="px-4 py-2.5 rounded-lg text-sm text-gray-500 hover:text-[#2C3DA6] hover:bg-blue-50">
                        &rarr; Web Prodi
                    </a>
                </div>
            </div>
            <div class="pt-2 pb-1 border-t border-gray-100 mt-1">
                <a href="{{ route('login') }}"
                   class="block w-full text-center px-4 py-2.5 text-sm font-bold text-white rounded-full"
                   style="background-color: #00C4D8;">
                    Login Dashboard
                </a>
            </div>
        </div>
    </div>
</nav>
