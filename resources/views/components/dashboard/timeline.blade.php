@props([
    'steps' => [],
])

<div class="relative">
    @foreach($steps as $i => $step)
        <div class="flex gap-4 {{ !$loop->last ? 'pb-8' : '' }}">
            {{-- Line + Dot --}}
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold
                    {{ $step['done'] ?? false
                        ? 'bg-emerald-500 text-white'
                        : ($step['active'] ?? false
                            ? 'bg-[#2C3DA6] text-white ring-4 ring-[#2C3DA6]/20'
                            : 'bg-gray-200 text-gray-500') }}">
                    @if($step['done'] ?? false)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                @if(!$loop->last)
                    <div class="w-0.5 flex-1 mt-1 {{ ($step['done'] ?? false) ? 'bg-emerald-300' : 'bg-gray-200' }}"></div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 pb-1">
                <h4 class="text-sm font-semibold {{ ($step['done'] ?? false) ? 'text-emerald-700' : (($step['active'] ?? false) ? 'text-[#2C3DA6]' : 'text-gray-500') }}">
                    {{ $step['title'] }}
                </h4>
                @if(isset($step['date']))
                    <p class="text-xs text-gray-400 mt-0.5">{{ $step['date'] }}</p>
                @endif
                @if(isset($step['description']))
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $step['description'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
