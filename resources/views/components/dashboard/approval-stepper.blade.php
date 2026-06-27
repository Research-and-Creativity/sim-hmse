@props([
    'proposal' => null,
    'signedCount' => 0,
    'steps' => [],
    'current' => 0,
])

@php
if ($proposal) {
    $steps = [
        ['label' => 'Ketua Panitia', 'name' => $proposal->ketua_panitia ?? 'Ketua Panitia'],
        ['label' => 'Sekretaris HMSE', 'name' => $proposal->sekretaris ?? 'Sekretaris'],
        ['label' => 'Ketua HMSE', 'name' => 'Quratu Ayun Defaren'],
        ['label' => 'Pembina HMSE', 'name' => 'Yudha Islami Sulistya, S.Kom., M.Cs'],
        ['label' => 'Kaprodi RPL', 'name' => 'Abednego Dwi Septiadi, S.Kom., M.Kom'],
    ];
    $current = $signedCount;
}
@endphp

<div class="flex items-center w-full">
    @foreach($steps as $i => $step)
        {{-- Step --}}
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300
                    {{ $i < $current
                        ? 'bg-emerald-500 text-white'
                        : ($i === $current
                            ? 'bg-[#2C3DA6] text-white ring-4 ring-[#2C3DA6]/20'
                            : 'bg-gray-200 text-gray-400') }}">
                    @if($i < $current)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                <span class="text-[10px] font-medium mt-1.5 text-center max-w-[80px] leading-tight
                    {{ $i <= $current ? 'text-[#2C3DA6]' : 'text-gray-400' }}">
                    {{ $step['label'] ?? "Step " . ($i + 1) }}
                </span>
            </div>

            {{-- Connector --}}
            @if(!$loop->last)
                <div class="flex-1 h-0.5 mx-2 mt-[-16px] {{ $i < $current ? 'bg-emerald-400' : 'bg-gray-200' }}"></div>
            @endif
        </div>
    @endforeach
</div>
