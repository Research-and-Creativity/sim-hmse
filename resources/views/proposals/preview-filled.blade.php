<x-layouts.dashboard title="Preview Dokumen Terisi">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('proposals.show', $proposal->id) }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Preview Dokumen Terisi</h2>
            <p class="text-sm text-gray-400">Dokumen akan dibuat sesuai template dan data proposal Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Info --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Risk Level Info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Tingkat Risiko</p>
                <div class="flex items-center gap-2">
                    @if($proposal->risk_level === 'low')
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="font-semibold text-green-700">Resiko Rendah</span>
                    @else
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="font-semibold text-red-700">Resiko Tinggi</span>
                    @endif
                </div>
            </div>

            {{-- Template Info --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-blue-700">Dokumen Template</p>
                        <p class="text-xs text-blue-600 mt-1">Dokumen akan dibuat dengan cara mengisi template asli Anda. Hasil tetap mempertahankan desain dan format template.</p>
                    </div>
                </div>
            </div>

            {{-- Data Summary --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Data yang Digunakan</p>
                <div class="space-y-2 text-xs">
                    <div>
                        <span class="text-gray-500">Nama Kegiatan:</span>
                        <p class="font-semibold text-gray-700">{{ $proposal->title }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Anggaran:</span>
                        <p class="font-semibold text-gray-700">Rp {{ number_format($proposal->budget, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Dibuat:</span>
                        <p class="font-semibold text-gray-700">{{ $proposal->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Main Content --}}
        <div class="lg:col-span-2">

            {{-- What Will Happen --}}
            <div class="space-y-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4">📋 Apa yang Akan Terjadi</h3>
                    <ol class="space-y-3">
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#2C3DA6] text-white text-xs font-bold flex items-center justify-center">1</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Template dibaca</p>
                                <p class="text-xs text-gray-500">Sistem membaca file template DOCX asli Anda</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#2C3DA6] text-white text-xs font-bold flex items-center justify-center">2</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Data diisi</p>
                                <p class="text-xs text-gray-500">Placeholder ({{nama_kegiatan}}, {{anggaran}}, dll) diganti dengan data proposal</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#2C3DA6] text-white text-xs font-bold flex items-center justify-center">3</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Dokumen dibuat</p>
                                <p class="text-xs text-gray-500">File DOCX baru dibuat dengan format yang sama seperti template asli</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#2C3DA6] text-white text-xs font-bold flex items-center justify-center">4</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Diunduh</p>
                                <p class="text-xs text-gray-500">File siap ditambahkan ke dokumen maupun dicetak</p>
                            </div>
                        </li>
                    </ol>
                </div>

                {{-- Placeholder Info --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <p class="text-xs font-bold text-amber-700 mb-2">💡 Tips: Placeholder yang Didukung</p>
                    <div class="grid grid-cols-2 gap-2 text-xs font-mono bg-white p-2 rounded text-amber-900">
                        <span>{{nama_kegiatan}}</span>
                        <span>{{latar_belakang}}</span>
                        <span>{{tujuan}}</span>
                        <span>{{anggaran}}</span>
                        <span>{{timeline}}</span>
                        <span>{{tingkat_risiko}}</span>
                    </div>
                    <p class="text-xs text-amber-600 mt-2">Gunakan placeholder ini di template Anda untuk mengganti dengan data proposal secara otomatis.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <a href="{{ route('proposals.generate-filled', $proposal->id) }}" class="flex-1 px-4 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Dokumen
                </a>
                <a href="{{ route('proposals.show', $proposal->id) }}" class="flex-1 px-4 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>

        </div>

    </div>

</x-layouts.dashboard>
