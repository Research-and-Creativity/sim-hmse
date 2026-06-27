<x-layouts.dashboard title="Program Kerja">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Daftar Program Kerja</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola semua program kerja himpunan</p>
        </div>
        <a href="{{ route('dashboard.proker.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all duration-200 shadow-md shadow-[#2C3DA6]/20 hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Proker
        </a>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('dashboard.proker.index') }}"
        class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ $filters['search'] }}"
                    placeholder="Cari program kerja..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
            </div>

            {{-- Status Filter --}}
            <select name="status"
                class="px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>

            {{-- Divisi Filter --}}
            <select name="divisi"
                class="px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                <option value="">Semua Divisi</option>
                @foreach ($divisionOptions as $division)
                    <option value="{{ $division }}" @selected($filters['divisi'] === $division)>{{ $division }}</option>
                @endforeach
            </select>

            <button type="submit"
                class="px-4 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 transition-colors">
                Terapkan
            </button>

            <a href="{{ route('dashboard.proker.index') }}"
                class="px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-center">
                Reset
            </a>
        </div>
    </form>

    {{-- Proker Cards Grid --}}
    @if ($prokers->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($prokers as $proker)
                <div
                    class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 overflow-hidden group">
                    {{-- Color Bar --}}
                    <div class="h-1" style="background: {{ $proker['color'] }};"></div>

                    <div class="p-5">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('dashboard.proker.show', $proker['id']) }}"
                                    class="text-sm font-bold text-gray-800 hover:text-[#2C3DA6] transition-colors line-clamp-2">
                                    {{ $proker['name'] }}
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $proker['divisi'] }}</p>
                            </div>
                            <x-dashboard.status-badge :status="$proker['status']" />
                        </div>

                        {{-- Info --}}
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $proker['date_start'] }} — {{ $proker['date_end'] }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                PJ: {{ $proker['pj'] }}
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-3">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[11px] font-semibold text-gray-500">Progress</span>
                                <span class="text-[11px] font-bold"
                                    style="color: {{ $proker['color'] }}">{{ $proker['progress'] }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500"
                                    style="width: {{ $proker['progress'] }}%; background: {{ $proker['color'] }};">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                            <a href="{{ route('dashboard.proker.show', $proker['id']) }}"
                                class="flex-1 text-center text-xs font-semibold text-[#2C3DA6] py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('dashboard.proker.edit', $proker['id']) }}"
                                class="flex-1 text-center text-xs font-semibold text-gray-500 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-10 text-center">
            <h3 class="text-sm font-bold text-gray-700 mb-1">Belum ada Program Kerja</h3>
            <p class="text-sm text-gray-400">Ubah filter pencarian atau tambahkan proker baru.</p>
        </div>
    @endif

</x-layouts.dashboard>
