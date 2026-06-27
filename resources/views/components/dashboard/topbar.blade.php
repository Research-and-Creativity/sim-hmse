@props(['title' => 'Dashboard'])

<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

        {{-- Left: Mobile Toggle + Page Title --}}
        <div class="flex items-center gap-3">
            {{-- Mobile Hamburger --}}
            <button @click="sidebarMobileOpen = !sidebarMobileOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title --}}
            <div>
                <h1 class="text-lg font-bold text-gray-800">{{ $title }}</h1>
                <p class="text-xs text-gray-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">

            {{-- Search --}}
            <div class="hidden md:block relative" x-data="{ searchOpen: false }">
                <button @click="searchOpen = !searchOpen"
                        class="p-2.5 rounded-xl text-gray-400 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                <div x-show="searchOpen"
                     x-transition
                     @click.outside="searchOpen = false"
                     class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 p-3 z-50">
                    <input type="text" placeholder="Cari menu, proker, proposal..."
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
            </div>

            @php
                $user = auth()->user();
                $pendingProposals = [];
                if ($user) {
                    $dbRole = ($user->jabatan === 'ketua_hmse') ? 'ketua_hima' : $user->jabatan;
                    
                    // Ambil proposal yang butuh persetujuan user ini
                    $approvals = \App\Models\ProposalApproval::where('approver_role', $dbRole)
                        ->where('status', 'pending')
                        ->with('proposal')
                        ->get();
                        
                    foreach ($approvals as $app) {
                        $prop = $app->proposal;
                        if ($prop && $prop->getNextApproverRole() === $dbRole) {
                            $pendingProposals[] = $prop;
                        }
                    }
                }
                $notifCount = count($pendingProposals);
            @endphp

            {{-- Notifications --}}
            <div class="relative" x-data="{ notifOpen: false }">
                <button @click="notifOpen = !notifOpen"
                        class="relative p-2.5 rounded-xl text-gray-400 hover:text-[#2C3DA6] hover:bg-blue-50 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($notifCount > 0)
                        {{-- Badge --}}
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>
                <div x-show="notifOpen"
                     x-transition
                     @click.outside="notifOpen = false"
                     class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                        @if($notifCount > 0)
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-red-50 text-red-600 rounded-full">{{ $notifCount }} Baru</span>
                        @endif
                    </div>
                    <div class="max-h-64 overflow-y-auto p-2 space-y-1">
                        @forelse($pendingProposals as $prop)
                            <a href="{{ route('dashboard.proposal.show', $prop->id) }}" class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer block">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-[#2C3DA6]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Menunggu TTD Kamu</p>
                                    <p class="text-sm text-gray-700 font-medium truncate mt-0.5">{{ $prop->title }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Status: Menunggu TTD Ketua HMSE</p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-400 text-xs">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                Tidak ada notifikasi baru
                            </div>
                        @endforelse
                    </div>
                    <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                        <a href="{{ route('dashboard.proposal.index') }}" class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8]">Lihat Semua Proposal</a>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="w-px h-8 bg-gray-200 mx-1 hidden sm:block"></div>

            @php
                $currentUser = auth()->user();
                $initials = 'G';
                if ($currentUser && $currentUser->name) {
                    $words = explode(' ', $currentUser->name);
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                }
            @endphp
            {{-- User Dropdown --}}
            <div class="relative" x-data="{ userOpen: false }">
                <button @click="userOpen = !userOpen"
                        class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#2C3DA6] to-[#00C4D8] flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ $initials }}</span>
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-sm font-semibold text-gray-700 leading-none">{{ $currentUser?->name ?? 'Guest' }}</p>
                        <p class="text-[10px] text-gray-400 leading-none mt-0.5">{{ $currentUser ? $currentUser->jabatanLabel() : 'Guest' }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="userOpen"
                     x-transition
                     @click.outside="userOpen = false"
                     class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-700">{{ $currentUser?->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-400">{{ $currentUser?->email ?? 'guest@hmse.ac.id' }}</p>
                    </div>
                    <a href="{{ route('dashboard.settings') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pengaturan
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-[#2C3DA6] hover:bg-blue-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Website Publik
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 w-full text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
