@php
    $user = auth()->user();
    $isKaprodi = $user && $user->jabatan === 'kaprodi';
    $primaryColor = $isKaprodi ? '#7c3aed' : '#00C4D8';
    $primaryHover = $isKaprodi ? '#6d28d9' : '#0891b2';
    
    $chipBg = $isKaprodi ? 'bg-violet-50' : 'bg-cyan-50';
    $chipText = $isKaprodi ? 'text-[#7c3aed]' : 'text-[#00C4D8]';
    $chipBorder = $isKaprodi ? 'border-violet-100' : 'border-cyan-100';
    $chipHoverBg = $isKaprodi ? 'hover:bg-violet-100/50' : 'hover:bg-cyan-50/50';
    
    $gradientFrom = $isKaprodi ? 'from-[#7c3aed]' : 'from-[#00C4D8]';
    $gradientTo = $isKaprodi ? 'to-[#5b21b6]' : 'to-[#0891b2]';

    $unreadNotificationsData = $unreadNotificationsData ?? (
        $user 
            ? \App\Models\ProposalNotification::where('user_id', $user->id)
                ->whereNull('read_at')
                ->latest()
                ->get()
            : collect()
    );
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — SIM HMSE</title>
    <meta name="description" content="Portal Pembina & Kaprodi — Sistem Informasi Manajemen HMSE">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="antialiased bg-[#f0f2f5] font-sans" x-data="notificationSystem()" x-init="initNotifications()">

    <div class="flex min-h-screen">

        {{-- Sidebar Pembina --}}
        <x-dashboard.sidebar-pembina />

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
             :class="{
                 'lg:ml-64': sidebarOpen,
                 'lg:ml-20': !sidebarOpen,
                 'ml-20': sidebarMobileOpen && !sidebarOpen,
                 'ml-64': sidebarMobileOpen && sidebarOpen
             }">

            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

                    {{-- Left: Mobile Toggle + Page Title --}}
                    <div class="flex items-center gap-3">
                        <button @click="sidebarMobileOpen = !sidebarMobileOpen"
                                class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-[#00C4D8] hover:bg-cyan-50 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-lg font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                            <p class="text-xs text-gray-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Right: Role Badge + User --}}
                    <div class="flex items-center gap-3">

                        {{-- Notifications --}}
                        <div class="relative">
                            <button @click="notifOpen = !notifOpen"
                                    class="relative p-2.5 rounded-xl text-gray-400 hover:text-[{{ $primaryColor }}] hover:{{ $chipBg }} transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span x-show="notifications.length > 0"
                                      class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            </button>
                            <div x-show="notifOpen"
                                 x-transition
                                 @click.outside="notifOpen = false"
                                 class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 text-left"
                                 style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <h3 class="text-sm font-bold text-gray-800">Notifikasi</                                    <template x-if="notifications.length > 0">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-[10px] font-bold bg-red-50 text-red-600 rounded-full" x-text="notifications.length + ' Baru'"></span>
                                            <button @click="markAllAsRead()" class="text-[10px] {{ $chipText }} hover:text-[{{ $primaryHover }}] font-semibold transition-colors">Tandai semua dibaca</button>
                                        </div>
                                    </template>
                                </div>
                                <div class="max-h-64 overflow-y-auto p-2 space-y-1">
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <a :href="'/pembina/proposal/' + notif.proposal_id" 
                                           @click="markAsRead(notif.id)"
                                           class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer block">
                                            <div class="w-8 h-8 rounded-full {{ $chipBg }} flex items-center justify-center flex-shrink-0 {{ $chipText }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[10px] {{ $chipText }} font-bold uppercase tracking-wider">Butuh Persetujuan</p>
                                                <p class="text-xs text-gray-600 mt-0.5 leading-relaxed truncate" x-text="notif.message"></p>
                                            </div>
                                        </a>
                                    </template>
                                    <template x-if="notifications.length === 0">
                                        <div class="text-center py-8 text-gray-400 text-xs">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                            Tidak ada notifikasi baru
                                        </div>
                                    </template>
                                </div>
                                <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                                    <a href="{{ route('pembina.proposal') }}" class="text-xs font-semibold text-[{{ $primaryColor }}] hover:underline">Lihat Semua Proposal</a>
                                </div>
                            </div>
                        </div>

                        <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                        {{-- Role Chip --}}
                        <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 {{ $chipBg }} rounded-lg border {{ $chipBorder }}">
                            <svg class="w-3.5 h-3.5 {{ $chipText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-xs font-semibold {{ $chipText }}">
                                {{ auth()->user()?->jabatanLabel() ?? 'Pembina / Kaprodi' }}
                            </span>
                        </div>

                        <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ userOpen: false }">
                            <button @click="userOpen = !userOpen"
                                    class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $gradientFrom }} {{ $gradientTo }} flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">
                                        {{ strtoupper(substr(auth()->user()?->name ?? 'PB', 0, 2)) }}
                                    </span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-semibold text-gray-700 leading-none">
                                        {{ auth()->user()?->name ?? 'Pembina HMSE' }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 leading-none mt-0.5">
                                        {{ auth()->user()?->jabatanLabel() ?? 'Pembina' }}
                                    </p>
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
                                    <p class="text-sm font-semibold text-gray-700">{{ auth()->user()?->name ?? 'Pembina HMSE' }}</p>
                                    <p class="text-xs text-gray-400">{{ auth()->user()?->email ?? '' }}</p>
                                </div>
                                <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-[{{ $primaryColor }}] hover:{{ $chipBg }}">
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

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="px-6 py-4 text-center text-xs text-gray-400 border-t border-gray-200 bg-white">
                &copy; {{ date('Y') }} HMSE Telkom University Purwokerto. Portal Pembina & Kaprodi.
            </footer>
        </div>

    </div>

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="sidebarMobileOpen"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarMobileOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         style="display: none;">
    </div>

    <!-- Floating toast notifications -->
    <div class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-4 opacity-0 scale-95"
                 x-transition:enter-end="translate-y-0 opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="translate-y-4 opacity-0 scale-95"
                 class="pointer-events-auto w-full bg-white/90 backdrop-blur-md border border-cyan-100 shadow-2xl rounded-2xl p-4 flex gap-3 items-start relative hover:shadow-cyan-100/50 transition-all duration-300">
                
                <!-- Bell icon with animation -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#00C4D8] to-[#0891b2] flex items-center justify-center flex-shrink-0 text-white shadow-lg shadow-cyan-100/30">
                    <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0 pr-4">
                    <h4 class="text-sm font-bold text-gray-800">Notifikasi Tanda Tangan</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed" x-text="toast.message"></p>
                    
                    <div class="mt-3 flex gap-2">
                        <a :href="'/pembina/proposal/' + toast.proposalId" 
                           @click="markAsRead(toast.id)"
                           class="px-3 py-1.5 bg-[#00C4D8] hover:bg-[#0891b2] text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1 shadow-sm">
                            Tinjau & TTD
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <button @click="dismissToast(toast.id)" 
                                class="px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-500 text-xs font-bold rounded-lg transition-colors">
                            Nanti
                        </button>
                    </div>
                </div>
                
                <!-- Close Button -->
                <button @click="dismissToast(toast.id)" class="text-gray-300 hover:text-gray-500 transition-colors absolute top-3 right-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    {{ $scripts ?? '' }}
    @stack('scripts')

    <script>
        function notificationSystem() {
            return {
                sidebarOpen: true,
                sidebarMobileOpen: false,
                notifOpen: false,
                userOpen: false,
                notifications: @json($unreadNotificationsData),
                toasts: [],
                
                initNotifications() {
                    // Poll every 5 seconds
                    setInterval(() => {
                        this.fetchNotifications();
                    }, 5000);
                },

                async fetchNotifications() {
                    try {
                        const response = await axios.get('{{ route("pembina.notifications.unread") }}');
                        const newNotifications = response.data;

                        // Find notifications that are new
                        newNotifications.forEach(notif => {
                            const exists = this.notifications.some(existing => existing.id === notif.id);
                            if (!exists) {
                                // Trigger toast
                                this.triggerToast(notif);
                            }
                        });

                        this.notifications = newNotifications;
                    } catch (error) {
                        console.error('Failed to fetch notifications:', error);
                    }
                },

                triggerToast(notif) {
                    const toast = {
                        id: notif.id,
                        proposalId: notif.proposal_id,
                        message: notif.message,
                        visible: true
                    };
                    this.toasts.push(toast);

                    // Play notification sound
                    try {
                        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-500.wav');
                        audio.volume = 0.4;
                        audio.play();
                    } catch (e) {
                        console.log('Audio autoplay blocked or failed:', e);
                    }

                    // Auto dismiss toast after 10 seconds
                    setTimeout(() => {
                        toast.visible = false;
                    }, 10000);
                },

                async markAsRead(id) {
                    try {
                        await axios.post('{{ route("pembina.notifications.mark-read") }}', { id });
                        this.notifications = this.notifications.filter(n => n.id !== id);
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    } catch (error) {
                        console.error('Failed to mark notification as read:', error);
                    }
                },

                async markAllAsRead() {
                    try {
                        await axios.post('{{ route("pembina.notifications.mark-read") }}');
                        this.notifications = [];
                        this.toasts.forEach(t => t.visible = false);
                        this.toasts = [];
                    } catch (error) {
                        console.error('Failed to mark all as read:', error);
                    }
                },

                dismissToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) {
                        toast.visible = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
