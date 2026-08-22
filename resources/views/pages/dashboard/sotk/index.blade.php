<x-layouts.dashboard title="Struktur Organisasi">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">SOTK — Struktur Organisasi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola data pengurus himpunan</p>
        </div>
        <a href="{{ route('dashboard.sotk.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Anggota
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1 text-sm">
                    <p class="font-bold">{{ session('success') }}</p>
                    @if (session('temp_password'))
                        <div class="mt-2 p-3 bg-white rounded-lg border border-emerald-200 space-y-1">
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Kredensial Login Anggota Baru:</p>
                            <p class="text-xs text-gray-700">Email/Username: <span class="font-mono font-bold text-gray-900">{{ session('temp_email') }}</span></p>
                            <p class="text-xs text-gray-700">Password Sementara: <span class="font-mono font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">{{ session('temp_password') }}</span></p>
                            <p class="text-[11px] text-gray-400 mt-1">* Harap salin dan berikan kredensial ini kepada anggota. Anggota dapat mengganti password melalui menu Pengaturan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Bagan Organisasi (Bagan Pimpinan) --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-sm font-bold text-gray-800 mb-6">Bagan Pimpinan HMSE</h3>
        <div class="flex flex-col items-center gap-3">
            {{-- Kaprodi & Pembina --}}
            <div class="flex gap-3">
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-center min-w-[140px] flex flex-col items-center">
                    @if($kaprodi?->avatar)
                        <img src="{{ \App\Services\StorageHelper::url($kaprodi->avatar) }}" alt="{{ $kaprodi->name }}" class="w-10 h-10 rounded-full object-cover mb-1.5 border border-gray-200" loading="lazy">
                    @endif
                    <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wider">Kaprodi</p>
                    <p class="text-sm font-bold text-gray-700">{{ $kaprodi?->name ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-center min-w-[140px] flex flex-col items-center">
                    @if($pembina?->avatar)
                        <img src="{{ \App\Services\StorageHelper::url($pembina->avatar) }}" alt="{{ $pembina->name }}" class="w-10 h-10 rounded-full object-cover mb-1.5 border border-gray-200" loading="lazy">
                    @endif
                    <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wider">Pembina</p>
                    <p class="text-sm font-bold text-gray-700">{{ $pembina?->name ?? '-' }}</p>
                </div>
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- President --}}
            <div class="bg-gradient-to-br from-[#2C3DA6] to-[#00C4D8] text-white rounded-2xl px-8 py-4 text-center shadow-lg min-w-[200px] flex flex-col items-center">
                @if($president?->avatar)
                    <img src="{{ \App\Services\StorageHelper::url($president->avatar) }}" alt="{{ $president->name }}" class="w-12 h-12 rounded-full object-cover mb-2 border-2 border-white/40 shadow-sm" loading="lazy">
                @endif
                <p class="text-[10px] uppercase tracking-widest text-white/70 font-medium mb-0.5">President</p>
                <p class="text-base font-bold">{{ $president?->name ?? 'Belum Ditentukan' }}</p>
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- Vice President --}}
            <div class="bg-white border-2 border-[#2C3DA6]/20 rounded-xl px-6 py-3 text-center min-w-[180px] flex flex-col items-center">
                @if($vicePresident?->avatar)
                    <img src="{{ \App\Services\StorageHelper::url($vicePresident->avatar) }}" alt="{{ $vicePresident->name }}" class="w-10 h-10 rounded-full object-cover mb-1.5 border border-gray-200" loading="lazy">
                @endif
                <p class="text-[10px] text-[#2C3DA6] uppercase font-semibold tracking-wider">Vice President</p>
                <p class="text-sm font-bold text-gray-700">{{ $vicePresident?->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
    </div>

    {{-- Member List per Division --}}
    @php
        $divisionColors = [
            'Pimpinan Inti' => '#2C3DA6',
            'Resource Management' => '#00C4D8',
            'Internal and External Communication' => '#10b981',
            'Research and Creativity' => '#f59e0b',
            'Economy Creative' => '#ec4899',
            'Creative Media and Information' => '#8b5cf6',
        ];
    @endphp

    @forelse ($membersByDivision as $divisionName => $members)
        @php
            $color = $divisionColors[$divisionName] ?? '#2C3DA6';
        @endphp
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 rounded-full" style="background: {{ $color }};"></div>
                    <h3 class="text-sm font-bold text-gray-800">{{ $divisionName }}</h3>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">{{ $members->count() }} orang</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach ($members as $m)
                    <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                        @if ($m->avatar)
                            <img src="{{ \App\Services\StorageHelper::url($m->avatar) }}" alt="{{ $m->name }}" class="w-9 h-9 rounded-lg object-cover flex-shrink-0 border border-gray-200" loading="lazy">
                        @else
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-xs"
                                 style="background: {{ $color }}20; color: {{ $color }};">
                                {{ strtoupper(substr($m->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-700 truncate">{{ $m->name }}</p>
                            <p class="text-xs text-gray-400">{{ $m->nim_nip ?: 'NIM Tidak Ada' }} · {{ $m->email }}</p>
                        </div>
                        <span class="text-xs font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full whitespace-nowrap">{{ $m->jabatanLabel() }}</span>
                        <div class="flex items-center gap-1">
                            <form method="POST" action="{{ route('dashboard.sotk.destroy', $m->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Hapus Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <p class="font-semibold text-gray-700">Belum ada anggota pengurus terdaftar</p>
            <p class="text-sm text-gray-400 mt-1 mb-4">Tambahkan data pengurus pertama melalui tombol di bawah.</p>
            <a href="{{ route('dashboard.sotk.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
                Tambah Anggota Sekarang
            </a>
        </div>
    @endforelse

</x-layouts.dashboard>


