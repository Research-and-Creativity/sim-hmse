<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'HMSE' }} — Himpunan Mahasiswa Software Engineering</title>
    <meta name="description" content="{{ $description ?? 'Himpunan Mahasiswa Software Engineering Telkom University Purwokerto' }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">

    {{-- Vite: Tailwind CSS + Alpine.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Slot untuk head tambahan --}}
    {{ $head ?? '' }}
</head>
<body class="antialiased bg-white text-gray-800 font-sans">

    {{-- Navbar --}}
    <x-public.navbar />

    {{-- Konten Utama --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-public.footer />

    {{-- Slot untuk script tambahan --}}
    {{ $scripts ?? '' }}

</body>
</html>
