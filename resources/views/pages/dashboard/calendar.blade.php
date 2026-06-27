<x-layouts.dashboard title="Kalender Kegiatan">

    <div x-data="{
        currentDate: new Date(),
        view: 'month',
        selectedDate: null,

        events: [
            { title: 'Workshop UI/UX Design', date: '2026-04-15', color: '#2C3DA6', divisi: 'Akademik' },
            { title: 'Seminar Tech Week', date: '2026-04-22', color: '#00C4D8', divisi: 'Eksternal' },
            { title: 'Rapat Koordinasi', date: '2026-04-10', color: '#f59e0b', divisi: 'Inti' },
            { title: 'Bazaar Kewirausahaan', date: '2026-05-05', color: '#ec4899', divisi: 'Kewirausahaan' },
            { title: 'Bootcamp Laravel', date: '2026-04-08', color: '#22c55e', divisi: 'Akademik' },
            { title: 'Tournament E-Sport', date: '2026-05-10', color: '#8b5cf6', divisi: 'Olahraga' },
        ],

        get monthName() {
            return this.currentDate.toLocaleString('id-ID', { month: 'long', year: 'numeric' });
        },
        get daysInMonth() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
        },
        get firstDayOfWeek() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
        },
        get calendarDays() {
            const days = [];
            for (let i = 0; i < this.firstDayOfWeek; i++) days.push({ day: null });
            for (let i = 1; i <= this.daysInMonth; i++) {
                const dateStr = this.currentDate.getFullYear() + '-' + String(this.currentDate.getMonth()+1).padStart(2,'0') + '-' + String(i).padStart(2,'0');
                days.push({ day: i, date: dateStr, events: this.events.filter(e => e.date === dateStr) });
            }
            return days;
        },
        isToday(day) {
            const t = new Date();
            return day === t.getDate() && this.currentDate.getMonth() === t.getMonth() && this.currentDate.getFullYear() === t.getFullYear();
        },
        prevMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1); },
        nextMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1); },
        goToday() { this.currentDate = new Date(); },

        getEventsForDate(dateStr) {
            return this.events.filter(e => e.date === dateStr);
        },

        get selectedEvents() {
            if (!this.selectedDate) return [];
            return this.events.filter(e => e.date === this.selectedDate);
        }
    }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <button @click="prevMonth()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <h2 class="text-xl font-black text-gray-800 min-w-[200px] text-center" x-text="monthName"></h2>
                <button @click="nextMonth()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <button @click="goToday()" class="ml-2 px-3 py-1.5 text-xs font-semibold text-[#2C3DA6] bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    Hari Ini
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Calendar Grid --}}
            <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                {{-- Weekday Headers --}}
                <div class="grid grid-cols-7 border-b border-gray-100">
                    @foreach(['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                        <div class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider {{ $day === 'Minggu' ? 'text-red-400' : '' }}">
                            {{ $day }}
                        </div>
                    @endforeach
                </div>

                {{-- Days --}}
                <div class="grid grid-cols-7">
                    <template x-for="(cell, i) in calendarDays" :key="i">
                        <div @click="cell.day && (selectedDate = cell.date)"
                             class="min-h-[100px] border-b border-r border-gray-50 p-2 transition-colors duration-150"
                             :class="{
                                 'bg-blue-50/50': selectedDate === cell.date,
                                 'hover:bg-gray-50 cursor-pointer': cell.day,
                                 'bg-gray-50/30 cursor-default': !cell.day
                             }">
                            <template x-if="cell.day">
                                <div class="flex flex-col h-full">
                                    <div class="flex justify-center mb-1.5">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-semibold transition-all duration-200"
                                              :class="isToday(cell.day) ? 'bg-[#2C3DA6] text-white font-bold shadow-md shadow-[#2C3DA6]/30' : 'text-gray-600 hover:bg-gray-100'"
                                              x-text="cell.day"></span>
                                    </div>
                                    <div class="mt-1 flex-1 space-y-1">
                                        <template x-for="ev in cell.events" :key="ev.title">
                                            <div class="text-[10px] font-semibold text-white px-1.5 py-0.5 rounded truncate text-center shadow-sm"
                                                 :style="'background:' + ev.color"
                                                 x-text="ev.title"></div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Sidebar: Event Details --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">
                        <span x-show="!selectedDate">Kegiatan Bulan Ini</span>
                        <span x-show="selectedDate" x-text="'Kegiatan: ' + (selectedDate || '')"></span>
                    </h3>

                    <template x-if="selectedDate && selectedEvents.length > 0">
                        <div class="space-y-3">
                            <template x-for="ev in selectedEvents" :key="ev.title">
                                <div class="p-3 rounded-lg border border-gray-100 hover:shadow-sm transition-shadow">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-2.5 h-2.5 rounded-full" :style="'background:' + ev.color"></div>
                                        <span class="text-sm font-semibold text-gray-700" x-text="ev.title"></span>
                                    </div>
                                    <p class="text-xs text-gray-400 ml-4.5" x-text="ev.divisi"></p>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="selectedDate && selectedEvents.length === 0">
                        <p class="text-sm text-gray-400 text-center py-4">Tidak ada kegiatan di tanggal ini</p>
                    </template>

                    <template x-if="!selectedDate">
                        <div class="space-y-3">
                            <template x-for="ev in events" :key="ev.title + ev.date">
                                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                     @click="selectedDate = ev.date">
                                    <div class="w-2 h-8 rounded-full" :style="'background:' + ev.color"></div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-700 truncate" x-text="ev.title"></p>
                                        <p class="text-xs text-gray-400" x-text="ev.date + ' · ' + ev.divisi"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                {{-- Legend --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">Keterangan Warna</h3>
                    <div class="space-y-2">
                        @foreach([
                            ['color' => '#2C3DA6', 'label' => 'Akademik'],
                            ['color' => '#00C4D8', 'label' => 'Eksternal'],
                            ['color' => '#f59e0b', 'label' => 'Koordinasi'],
                            ['color' => '#ec4899', 'label' => 'Kewirausahaan'],
                            ['color' => '#22c55e', 'label' => 'Workshop'],
                            ['color' => '#8b5cf6', 'label' => 'Olahraga & Seni'],
                        ] as $legend)
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded" style="background: {{ $legend['color'] }};"></div>
                                <span class="text-xs text-gray-500">{{ $legend['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard>
