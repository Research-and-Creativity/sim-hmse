<x-layouts.dashboard title="Dokumentasi">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Dokumentasi & Arsip</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola dokumen, proposal, dan file kegiatan</p>
        </div>
        <div class="flex gap-2">
            <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Upload File
            </button>
        </div>
    </div>

    {{-- Upload Area --}}
    <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-8 mb-6 text-center hover:border-[#2C3DA6]/40 transition-colors cursor-pointer">
        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
        <p class="text-sm font-semibold text-gray-500 mb-1">Drag & Drop file di sini</p>
        <p class="text-xs text-gray-400">atau klik untuk memilih file (PDF, DOCX, JPG, PNG — maks 10MB)</p>
    </div>

    {{-- Filter --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Cari dokumen..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
        </div>
        <select class="px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-gray-600">
            <option value="">Semua Kategori</option>
            <option>Proposal</option>
            <option>LPJ</option>
            <option>Surat</option>
            <option>Foto</option>
        </select>
        <select class="px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-gray-600">
            <option value="">Semua Proker</option>
            <option>Workshop UI/UX</option>
            <option>Seminar Tech Week</option>
        </select>
    </div>

    {{-- File Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach([
            ['name' => 'Proposal Workshop UI-UX.pdf', 'size' => '2.4 MB', 'type' => 'pdf', 'date' => '10 Mar 2026', 'category' => 'Proposal'],
            ['name' => 'LPJ Bootcamp Web Dev.pdf', 'size' => '3.8 MB', 'type' => 'pdf', 'date' => '15 Mar 2026', 'category' => 'LPJ'],
            ['name' => 'Rundown Seminar.docx', 'size' => '156 KB', 'type' => 'doc', 'date' => '20 Mar 2026', 'category' => 'Surat'],
            ['name' => 'Poster Tech Week.png', 'size' => '3.1 MB', 'type' => 'img', 'date' => '22 Mar 2026', 'category' => 'Foto'],
            ['name' => 'Surat Peminjaman Ruangan.pdf', 'size' => '540 KB', 'type' => 'pdf', 'date' => '25 Mar 2026', 'category' => 'Surat'],
            ['name' => 'Dokumentasi Workshop.zip', 'size' => '48.2 MB', 'type' => 'zip', 'date' => '28 Mar 2026', 'category' => 'Foto'],
            ['name' => 'Laporan Keuangan Mar.xlsx', 'size' => '1.2 MB', 'type' => 'xls', 'date' => '30 Mar 2026', 'category' => 'LPJ'],
            ['name' => 'SK Panitia Seminar.pdf', 'size' => '280 KB', 'type' => 'pdf', 'date' => '01 Apr 2026', 'category' => 'Surat'],
        ] as $file)
            @php
                $iconColors = [
                    'pdf' => ['bg' => 'bg-red-50', 'text' => 'text-red-500', 'icon' => 'PDF'],
                    'doc' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-500', 'icon' => 'DOC'],
                    'img' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-500', 'icon' => 'IMG'],
                    'zip' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-500', 'icon' => 'ZIP'],
                    'xls' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-500', 'icon' => 'XLS'],
                ];
                $ic = $iconColors[$file['type']] ?? $iconColors['pdf'];
            @endphp
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl {{ $ic['bg'] }} flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-black {{ $ic['text'] }}">{{ $ic['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate group-hover:text-[#2C3DA6] transition-colors">{{ $file['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $file['size'] }} · {{ $file['date'] }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $file['category'] }}</span>
                    <div class="flex gap-1">
                        <button class="p-1.5 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-[#2C3DA6] transition-colors" title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </button>
                        <button class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-layouts.dashboard>
