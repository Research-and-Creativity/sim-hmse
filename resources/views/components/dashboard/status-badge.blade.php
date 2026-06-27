@props([
    'status' => 'draft',
])

@php
    $styles = [
        'draft'       => 'bg-gray-100 text-gray-600',
        'preparation' => 'bg-amber-50 text-amber-700',
        'on-progress' => 'bg-blue-50 text-blue-700',
        'completed'   => 'bg-emerald-50 text-emerald-700',
        'cancelled'   => 'bg-red-50 text-red-600',
    ];

    $labels = [
        'draft'       => 'Draft',
        'preparation' => 'Persiapan',
        'on-progress' => 'On Progress',
        'completed'   => 'Selesai',
        'cancelled'   => 'Dibatalkan',
    ];

    $dots = [
        'draft'       => 'bg-gray-400',
        'preparation' => 'bg-amber-500',
        'on-progress' => 'bg-blue-500 animate-pulse',
        'completed'   => 'bg-emerald-500',
        'cancelled'   => 'bg-red-500',
    ];
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $styles[$status] ?? $styles['draft'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dots[$status] ?? $dots['draft'] }}"></span>
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
