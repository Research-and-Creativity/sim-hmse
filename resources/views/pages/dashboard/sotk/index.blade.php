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

    {{-- Bagan Organisasi (visual) --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-sm font-bold text-gray-800 mb-6">Bagan Organisasi HMSE</h3>
        <div class="flex flex-col items-center gap-3">
            {{-- Kaprodi & Pembina --}}
            <div class="flex gap-3">
                @foreach([
                    ['role' => 'Kaprodi', 'name' => '-'],
                    ['role' => 'Pembina', 'name' => '-'],
                ] as $top)
                    <div class="bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-center">
                        <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wider">{{ $top['role'] }}</p>
                        <p class="text-sm font-bold text-gray-700">{{ $top['name'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- President --}}
            <div class="bg-gradient-to-br from-[#2C3DA6] to-[#00C4D8] text-white rounded-2xl px-8 py-4 text-center shadow-lg">
                <p class="text-[10px] uppercase tracking-widest text-white/70 font-medium mb-1">President</p>
                <p class="text-base font-bold">Quratu Ayun Defaren</p>
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- Vice President --}}
            <div class="bg-white border-2 border-[#2C3DA6]/20 rounded-xl px-6 py-3 text-center">
                <p class="text-[10px] text-[#2C3DA6] uppercase font-semibold tracking-wider">Vice President</p>
                <p class="text-sm font-bold text-gray-700">Muhammad Rasyid Ridho</p>
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- Secretary & Finance --}}
            <div class="flex flex-wrap justify-center gap-3">
                @foreach([
                    ['role' => 'Secretary 1', 'name' => 'Andini Pratiwi'],
                    ['role' => 'Secretary 2', 'name' => 'Dwi Wulan Ramadhani'],
                    ['role' => 'Finance 1', 'name' => 'Radita Putri Nuraini'],
                    ['role' => 'Finance 2', 'name' => 'Salumita Ardiana'],
                ] as $sup)
                    <div class="bg-white border-2 border-[#2C3DA6]/20 rounded-xl px-5 py-3 text-center">
                        <p class="text-[10px] text-[#2C3DA6] uppercase font-semibold tracking-wider">{{ $sup['role'] }}</p>
                        <p class="text-sm font-bold text-gray-700">{{ $sup['name'] }}</p>
                    </div>
                @endforeach
            </div>
            <div class="w-0.5 h-4 bg-gray-300"></div>
            {{-- Divisi --}}
            <div class="flex flex-wrap justify-center gap-2">
                @foreach(['Resource Management', 'Internal and External Communication', 'Research and Creativity', 'Economy Creative', 'Creative Media and Information'] as $div)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5 text-center">
                        <p class="text-xs font-semibold text-gray-700">{{ $div }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Member List per Division --}}
    @foreach([
        ['division' => 'Pimpinan', 'color' => '#2C3DA6', 'members' => [
            ['name' => 'Quratu Ayun Defaren', 'nim' => '103122400064', 'role' => 'President'],
            ['name' => 'Muhammad Rasyid Ridho', 'nim' => '103122400018', 'role' => 'Vice President'],
        ]],
        ['division' => 'Sekretaris & Keuangan', 'color' => '#6366f1', 'members' => [
            ['name' => 'Andini Pratiwi', 'nim' => '103122400060', 'role' => 'Secretary 1'],
            ['name' => 'Dwi Wulan Ramadhani', 'nim' => '109092530006', 'role' => 'Secretary 2'],
            ['name' => 'Radita Putri Nuraini', 'nim' => '103122400056', 'role' => 'Finance 1'],
            ['name' => 'Salumita Ardiana', 'nim' => '109092530004', 'role' => 'Finance 2'],
        ]],
        ['division' => 'Resource Management', 'color' => '#00C4D8', 'members' => [
            ['name' => 'Cikal Chrestella Cora', 'nim' => '103122400051', 'role' => 'Head of Resource Management'],
            ['name' => 'Eko Rifki Setyawan', 'nim' => '109092500036', 'role' => 'Staff Resource Management'],
            ['name' => 'Khilma \'Ainunnajah', 'nim' => '109092530002', 'role' => 'Staff Resource Management'],
        ]],
        ['division' => 'Internal and External Communication', 'color' => '#10b981', 'members' => [
            ['name' => 'Najwa Areefa Ghaisani', 'nim' => '103122400028', 'role' => 'Head of Internal and External Communication'],
            ['name' => 'Abidah Fatimatuzzahrah', 'nim' => '103122400004', 'role' => 'Staff of Internal and External Communication'],
            ['name' => 'Felda Ardelia Oktrianti', 'nim' => '109092500023', 'role' => 'Staff of Internal and External Communication'],
            ['name' => 'Riyan Hidayat Tuafik', 'nim' => '103122400050', 'role' => 'Staff of Internal and External Communication'],
            ['name' => 'Andhika Abipraya Saputra', 'nim' => '109092500028', 'role' => 'Staff of Internal and External Communication'],
        ]],
        ['division' => 'Research and Creativity', 'color' => '#f59e0b', 'members' => [
            ['name' => 'Haryanto Wifakul Azmi', 'nim' => '103122400037', 'role' => 'Head of Research and Creativity'],
            ['name' => 'Ulung Putra Sadewo', 'nim' => '103122400013', 'role' => 'Staff of Research and Creativity'],
            ['name' => 'Putra Anugrah Pamungkas', 'nim' => '103122400007', 'role' => 'Staff of Research and Creativity'],
            ['name' => 'Muhammad Farel Alghazali', 'nim' => '109092500033', 'role' => 'Staff of Research and Creativity'],
            ['name' => 'Geusan Edurais Aria Daffa', 'nim' => '103122400026', 'role' => 'Staff of Research and Creativity'],
        ]],
        ['division' => 'Economy Creative', 'color' => '#ec4899', 'members' => [
            ['name' => 'Marta Safitri', 'nim' => '10312240047', 'role' => 'Head of Economy Creative'],
            ['name' => 'Rizqi Nawaf', 'nim' => '103122430010', 'role' => 'Staff of Economy Creative'],
            ['name' => 'Danu Warisman', 'nim' => '103122400041', 'role' => 'Staff of Economy Creative'],
        ]],
        ['division' => 'Creative Media and Information', 'color' => '#8b5cf6', 'members' => [
            ['name' => 'Putri Naila Salsabila', 'nim' => '103122400048', 'role' => 'Head of Creative Media and Information'],
            ['name' => 'Apriani Putri', 'nim' => '109092500019', 'role' => 'Staff of Creative Media and Information'],
            ['name' => 'Fatikhah Sukma Arti', 'nim' => '103122400019', 'role' => 'Staff of Creative Media and Information'],
            ['name' => 'Muhammad Rizqi Amartia Putra', 'nim' => '109092500025', 'role' => 'Staff of Creative Media and Information'],
            ['name' => 'Rahmadanis Danang Kumala', 'nim' => '103122400066', 'role' => 'Staff of Creative Media and Information'],
        ]],
    ] as $group)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-1 h-6 rounded-full" style="background: {{ $group['color'] }};"></div>
                <h3 class="text-sm font-bold text-gray-800">{{ $group['division'] }}</h3>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ count($group['members']) }} orang</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($group['members'] as $m)
                    <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: {{ $group['color'] }}20; color: {{ $group['color'] }};">
                            <span class="text-xs font-bold">{{ $m['name'] === '-' ? '?' : mb_substr($m['name'], 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-700">{{ $m['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $m['nim'] }}</p>
                        </div>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $m['role'] }}</span>
                        <div class="flex items-center gap-1">
                            <button class="p-1.5 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-[#2C3DA6] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</x-layouts.dashboard>

