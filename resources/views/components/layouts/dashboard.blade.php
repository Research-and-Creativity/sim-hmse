<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — SIM HMSE</title>
    <meta name="description" content="Sistem Informasi Manajemen HMSE Telkom University Purwokerto">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="antialiased bg-[#f0f2f5] font-sans" x-data="{ sidebarOpen: true, sidebarMobileOpen: false }">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <x-dashboard.sidebar />

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
             :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">

            {{-- Top Bar --}}
            <x-dashboard.topbar :title="$title ?? 'Dashboard'" />

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="px-6 py-4 text-center text-xs text-gray-400 border-t border-gray-200 bg-white">
                &copy; {{ date('Y') }} HMSE Telkom University Purwokerto. Sistem Informasi Manajemen.
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

    {{ $scripts ?? '' }}
    @stack('scripts')
</body>
</html>
