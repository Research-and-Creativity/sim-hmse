@props([
    'href' => '#',
    'active' => false,
    'icon' => '',
    'label' => '',
])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
          {{ $active
              ? 'bg-gradient-to-r from-[#2C3DA6]/10 to-[#00C4D8]/10 text-[#2C3DA6] font-semibold shadow-sm'
              : 'text-gray-500 hover:text-[#2C3DA6] hover:bg-gray-50' }}"
   @if(!$active) x-data @endif
>
    <svg class="w-5 h-5 flex-shrink-0 {{ $active ? 'text-[#2C3DA6]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    <span x-show="sidebarOpen" class="truncate">{{ $label }}</span>
    @if($active)
        <div x-show="sidebarOpen" class="ml-auto w-1.5 h-1.5 rounded-full bg-[#00C4D8]"></div>
    @endif
</a>
