<x-layouts.dashboard title="Peserta — {{ $event->name }}">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                <a href="{{ route('dashboard.events.index') }}" class="hover:text-gray-600 transition-colors">Events</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span>Peserta</span>
            </div>
            <h2 class="text-xl font-black text-gray-800">{{ $event->name }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">
                {{ $registrations->total() }} total pendaftar
            </p>
        </div>
        <a href="{{ route('dashboard.events.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    @php
        $pending   = $registrations->getCollection()->where('status', 'pending')->count();
        $confirmed = $registrations->getCollection()->where('status', 'confirmed')->count();
        $cancelled = $registrations->getCollection()->where('status', 'cancelled')->count();
    @endphp
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
            <p class="text-2xl font-black text-amber-500">{{ $registrations->total() }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
            <p class="text-2xl font-black text-green-500">{{ $confirmed }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Dikonfirmasi</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4 text-center">
            <p class="text-2xl font-black text-gray-400">{{ $pending }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Pending</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($registrations->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-600">Belum ada peserta yang mendaftar</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. HP</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prodi / Smt</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($registrations as $i => $reg)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $registrations->firstItem() + $i }}</td>
                                <td class="px-5 py-3.5">
                                    <p class="font-semibold text-gray-800">{{ $reg->name }}</p>
                                    @if($reg->note)
                                        <p class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ $reg->note }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-gray-600">{{ $reg->nim ?: '—' }}</td>
                                <td class="px-5 py-3.5 text-gray-600">{{ $reg->email }}</td>
                                <td class="px-5 py-3.5 text-gray-600">{{ $reg->phone ?: '—' }}</td>
                                <td class="px-5 py-3.5 text-gray-600">
                                    {{ $reg->prodi ?: '—' }}
                                    @if($reg->semester) <span class="text-gray-400">/ Smt {{ $reg->semester }}</span> @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @php
                                        $sc = match($reg->status) {
                                            'confirmed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default     => 'bg-amber-100 text-amber-700',
                                        };
                                        $sl = match($reg->status) {
                                            'confirmed' => 'Dikonfirmasi',
                                            'cancelled' => 'Dibatalkan',
                                            default     => 'Pending',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $sc }}">{{ $sl }}</span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <form method="POST"
                                          action="{{ route('dashboard.events.registrations.update', [$event->id, $reg->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#2C3DA6]/20 cursor-pointer">
                                            <option value="pending"   {{ $reg->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $reg->status === 'confirmed' ? 'selected' : '' }}>Konfirmasi</option>
                                            <option value="cancelled" {{ $reg->status === 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($registrations->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $registrations->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.dashboard>
