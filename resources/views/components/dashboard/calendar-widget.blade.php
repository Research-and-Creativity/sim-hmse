{{-- Mini Calendar Widget --}}
@props(['events' => []])

<div x-data="{
    currentDate: new Date(),
    today: new Date(),
    events: {{ Js::from($events) }},

    get monthName() {
        return this.currentDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
    },

    get daysInMonth() {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        return new Date(year, month + 1, 0).getDate();
    },

    get firstDayOfWeek() {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        return new Date(year, month, 1).getDay();
    },

    get days() {
        const days = [];
        for (let i = 0; i < this.firstDayOfWeek; i++) days.push(null);
        for (let i = 1; i <= this.daysInMonth; i++) days.push(i);
        return days;
    },

    prevMonth() {
        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1);
    },
    nextMonth() {
        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1);
    },

    isToday(day) {
        return day === this.today.getDate()
            && this.currentDate.getMonth() === this.today.getMonth()
            && this.currentDate.getFullYear() === this.today.getFullYear();
    },

    hasEvent(day) {
        if (!day) return false;
        const dateStr = this.currentDate.getFullYear() + '-'
            + String(this.currentDate.getMonth() + 1).padStart(2,'0') + '-'
            + String(day).padStart(2,'0');
        return this.events.some(e => e.date === dateStr);
    }
}" class="w-full">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-gray-700" x-text="monthName"></h3>
        <div class="flex items-center gap-1">
            <button @click="prevMonth()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="nextMonth()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Weekday Headers --}}
    <div class="grid grid-cols-7 gap-0 mb-1">
        @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
            <div class="text-center text-[10px] font-semibold text-gray-400 uppercase py-1">{{ $day }}</div>
        @endforeach
    </div>

    {{-- Days Grid --}}
    <div class="grid grid-cols-7 gap-0">
        <template x-for="(day, index) in days" :key="index">
            <div class="aspect-square flex items-center justify-center relative">
                <template x-if="day !== null">
                    <button
                        class="w-8 h-8 rounded-lg text-xs font-medium transition-all duration-200 relative"
                        :class="{
                            'bg-[#2C3DA6] text-white font-bold shadow-md shadow-[#2C3DA6]/30': isToday(day),
                            'hover:bg-gray-100 text-gray-600': !isToday(day),
                        }"
                        x-text="day"
                    ></button>
                </template>
                <template x-if="day !== null && hasEvent(day)">
                    <div class="absolute bottom-0.5 w-1 h-1 rounded-full"
                         :class="isToday(day) ? 'bg-white' : 'bg-[#00C4D8]'"></div>
                </template>
            </div>
        </template>
    </div>
</div>
