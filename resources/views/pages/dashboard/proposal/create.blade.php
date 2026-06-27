<x-layouts.dashboard title="Buat Proposal">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.proposal.index') }}"
            class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Isi Proposal Kegiatan</h2>
            <p class="text-sm text-gray-400">Isi bagian-bagian proposal sesuai template standar HMSE</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
            <p class="font-bold mb-1">Ada beberapa kolom yang belum diisi dengan benar:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proposals.store') }}" method="POST" x-data="{
        activeSection: 'info',
        sections: [
            { id: 'info', label: 'Informasi Umum', icon: 'info' },
            { id: 'pendahuluan', label: 'Pendahuluan', icon: 'book' },
            { id: 'kegiatan', label: 'Detail Kegiatan', icon: 'calendar' },
            { id: 'anggaran', label: 'Anggaran', icon: 'money' },
            { id: 'penutup', label: 'Penutup & Lampiran', icon: 'flag' },
        ],
        completedSections: [],
        isSaving: false,

        markComplete(id) {
            if (!this.completedSections.includes(id)) this.completedSections.push(id);
        },
        isComplete(id) {
            return this.completedSections.includes(id);
        },
        get progress() {
            return Math.round((this.completedSections.length / this.sections.length) * 100);
        }
    }" @submit="isSaving = true">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- Left: Section Navigation --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 sticky top-24">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Template Proposal</h3>
                        <span class="text-xs font-bold text-[#2C3DA6]" x-text="progress + '%'"></span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="w-full h-1.5 bg-gray-100 rounded-full mb-4 overflow-hidden">
                        <div class="h-full bg-[#2C3DA6] rounded-full transition-all duration-500"
                            :style="'width:' + progress + '%'"></div>
                    </div>

                    <nav class="space-y-1">
                        <template x-for="(s, i) in sections" :key="s.id">
                            <button
                                type="button"
                                @click="activeSection = s.id"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-left"
                                :class="activeSection === s.id ?
                                    'bg-[#2C3DA6]/10 text-[#2C3DA6]' :
                                    (isComplete(s.id) ? 'text-emerald-600 hover:bg-emerald-50' :
                                        'text-gray-500 hover:bg-gray-50')">
                                {{-- Number/Check --}}
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0"
                                    :class="isComplete(s.id) ?
                                        'bg-emerald-100 text-emerald-600' :
                                        (activeSection === s.id ? 'bg-[#2C3DA6] text-white' :
                                            'bg-gray-100 text-gray-400')">
                                    <template x-if="isComplete(s.id)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </template>
                                    <template x-if="!isComplete(s.id)">
                                        <span x-text="i + 1"></span>
                                    </template>
                                </div>
                                <span x-text="s.label" class="truncate"></span>
                            </button>
                        </template>
                    </nav>

                    {{-- Action Buttons --}}
                    <div class="mt-6 pt-4 border-t border-gray-100 space-y-2">
                        <button type="submit" :disabled="isSaving"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] border border-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg x-show="!isSaving" class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <svg x-show="isSaving" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                            </svg>
                            <span x-text="isSaving ? 'Menyimpan...' : '💾 Simpan Draft'"></span>
                        </button>
                        <button type="submit" formnovalidate
                            formaction="{{ route('dashboard.proposal.preview.post') }}" formmethod="POST"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-[#2C3DA6] bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Proposal
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: Form Content --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- Template Header Info --}}
                <div
                    class="bg-gradient-to-r from-[#2C3DA6]/5 to-[#00C4D8]/5 rounded-xl border border-[#2C3DA6]/10 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-[#2C3DA6] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-[#2C3DA6]">Template Standar HMSE</p>
                        <p class="text-xs text-gray-500 mt-0.5">Isi setiap bagian sesuai kebutuhan. Sistem akan otomatis
                            menyusun proposal sesuai format resmi. Klik "Preview" untuk melihat hasilnya.</p>
                    </div>
                </div>

                {{-- Section 1: Info Umum --}}
                <div x-show="activeSection === 'info'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: block;">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-800">📋 Informasi Umum</h3>
                            <button type="button" @click="markComplete('info'); activeSection = 'pendahuluan'"
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                ✓ Tandai Selesai & Lanjut
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kegiatan *</label>
                            <input type="text" name="title" placeholder="Contoh: Workshop UI/UX Design 2026"
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 transition-all"
                                required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tema Kegiatan</label>
                                <input type="text" name="tema_kegiatan" placeholder="Tema kegiatan"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                                    <option value="">Pilih Jenis</option>
                                    <option>Seminar</option>
                                    <option>Workshop</option>
                                    <option>Kompetisi</option>
                                    <option>Webinar</option>
                                    <option>Pelatihan</option>
                                    <option>Kunjungan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pelaksanaan
                                    *</label>
                                <input type="date" name="tanggal_pelaksanaan"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu</label>
                                <input type="time" name="waktu_pelaksanaan"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tempat *</label>
                                <input type="text" name="tempat_pelaksanaan" placeholder="Lokasi"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Timeline Pelaksanaan
                                *</label>
                            <input type="text" name="timeline" placeholder="Contoh: 15 Januari - 20 Januari 2024"
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 transition-all"
                                required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Ketua Panitia *</label>
                                <input type="text" name="ketua_panitia" placeholder="Nama ketua panitia"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Divisi / Bidang</label>
                                <select name="divisi"
                                    class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                                    <option value="">Pilih Divisi</option>
                                    <option>President</option>
                                    <option>Vice President</option>
                                    <option>Secretary 1</option>
                                    <option>Secretary 2</option>
                                    <option>Finance 1</option>
                                    <option>Finance 2</option>
                                    <option>Head of Resource Management</option>
                                    <option>Staff Resource Management</option>
                                    <option>Head of Internal and External Communication</option>
                                    <option>Staff of Internal and External Communication</option>
                                    <option>Head of Research and Creativity</option>
                                    <option>Staff of Research and Creativity</option>
                                    <option>Head of Economy Creative</option>
                                    <option>Staff of Economy Creative</option>
                                    <option>Head of Creative Media and Information</option>
                                    <option>Staff of Creative Media and Information</option>
                                </select>
                            </div>
                        </div>

                        {{-- Risk Level Selection --}}
                        <div class="pt-4 border-t border-gray-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Tingkat Risiko</label>
                            <div x-data="{ riskLevel: 'low' }" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label
                                        class="flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                                        :class="riskLevel === 'low' ? 'border-green-400 bg-green-50' : 'border-gray-200'">
                                        <input type="radio" name="risk_level" value="low" x-model="riskLevel">
                                        <span class="font-semibold text-gray-800">Resiko Rendah</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                                        :class="riskLevel === 'medium' ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200'">
                                        <input type="radio" name="risk_level" value="medium" x-model="riskLevel">
                                        <span class="font-semibold text-gray-800">Resiko Sedang</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition"
                                        :class="riskLevel === 'high' ? 'border-red-400 bg-red-50' : 'border-gray-200'">
                                        <input type="radio" name="risk_level" value="high" x-model="riskLevel">
                                        <span class="font-semibold text-gray-800">Resiko Tinggi</span>
                                    </label>
                                </div>

                                {{-- Template Download Section --}}
                                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                                    <p class="text-sm font-semibold text-gray-800 mb-3">📥 Download Template Standar
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <a href="{{ route('proposals.download-template', 'low') }}"
                                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-green-600 bg-white border border-green-300 rounded-lg hover:bg-green-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Template Risiko Rendah
                                        </a>
                                        <a href="{{ route('proposals.download-template', 'high') }}"
                                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Template Risiko Tinggi
                                        </a>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Unduh template DOCX sesuai tingkat risiko
                                        kegiatan Anda untuk referensi dan pengerjaan awal proposal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Pendahuluan --}}
                <div x-show="activeSection === 'pendahuluan'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-800">📖 Pendahuluan</h3>
                            <button type="button" @click="markComplete('pendahuluan'); activeSection = 'kegiatan'"
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                ✓ Tandai Selesai & Lanjut
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Latar Belakang *</label>
                            <p class="text-xs text-gray-400 mb-2">Jelaskan alasan dan konteks mengapa kegiatan ini
                                perlu dilaksanakan.</p>
                            <textarea rows="6" name="background" placeholder="Tuliskan latar belakang kegiatan di sini..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 resize-none transition-all"
                                required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tujuan Kegiatan *</label>
                            <p class="text-xs text-gray-400 mb-2">Sebutkan tujuan yang ingin dicapai dari kegiatan ini.
                            </p>
                            <textarea rows="4" name="objective" placeholder="Tuliskan tujuan kegiatan di sini..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 resize-none transition-all"
                                required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Manfaat Kegiatan</label>
                            <textarea rows="4" name="manfaat_kegiatan" placeholder="Manfaat yang diharapkan..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] resize-none transition-all"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Identifikasi & Mitigasi
                                Risiko *</label>
                            <p class="text-xs text-gray-400 mb-2">Jelaskan potensi risiko yang mungkin terjadi dan cara
                                mengantisipasi/mengatasi risiko tersebut.</p>
                            <textarea rows="4" name="risk_description"
                                placeholder="Tuliskan identifikasi dan rencana mitigasi risiko di sini..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/10 resize-none transition-all"
                                required></textarea>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Detail Kegiatan --}}
                <div x-show="activeSection === 'kegiatan'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-800">📅 Detail Kegiatan</h3>
                            <button type="button" @click="markComplete('kegiatan'); activeSection = 'anggaran'"
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                ✓ Tandai Selesai & Lanjut
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Bentuk Kegiatan *</label>
                            <textarea rows="3" name="bentuk_kegiatan"
                                placeholder="Contoh: Kegiatan berbentuk workshop satu hari penuh dengan sesi teori dan praktik langsung..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] resize-none transition-all"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Sasaran Peserta</label>
                            <textarea rows="2" name="sasaran_peserta" placeholder="Contoh: Mahasiswa Prodi RPL semester 2–6..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] resize-none transition-all"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Susunan Acara /
                                Rundown</label>
                            <div x-data="{ rows: [{ kegiatan: '', waktu_mulai: '', waktu_selesai: '', durasi: '', lokasi: '', pic: '', deskripsi: '' }] }" class="space-y-4">
                                <template x-for="(r, i) in rows" :key="i">
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl relative">
                                        <button type="button" @click="rows.splice(i,1)" x-show="rows.length > 1"
                                            class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-gray-500 mb-1">Kegiatan</label>
                                                <input type="text" x-model="r.kegiatan"
                                                    :name="`rundown_kegiatan[${i}]`" placeholder="Nama kegiatan"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">PIC /
                                                    Penanggung Jawab</label>
                                                <input type="text" x-model="r.pic" :name="`rundown_pic[${i}]`"
                                                    placeholder="PIC"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-3">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Waktu
                                                    Mulai</label>
                                                <input type="time" x-model="r.waktu_mulai"
                                                    :name="`rundown_waktu_mulai[${i}]`"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Waktu
                                                    Selesai</label>
                                                <input type="time" x-model="r.waktu_selesai"
                                                    :name="`rundown_waktu_selesai[${i}]`"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-gray-500 mb-1">Durasi</label>
                                                <input type="text" x-model="r.durasi"
                                                    :name="`rundown_durasi[${i}]`" placeholder="30 menit"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-gray-500 mb-1">Lokasi</label>
                                                <input type="text" x-model="r.lokasi"
                                                    :name="`rundown_lokasi[${i}]`" placeholder="Lokasi"
                                                    class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                            <input type="text" x-model="r.deskripsi"
                                                :name="`rundown_deskripsi[${i}]`" placeholder="Deskripsi singkat"
                                                class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                        </div>
                                    </div>
                                </template>
                                <button type="button"
                                    @click="rows.push({kegiatan:'', waktu_mulai:'', waktu_selesai:'', durasi:'', lokasi:'', pic:'', deskripsi:''})"
                                    class="text-xs font-semibold text-[#2C3DA6] flex items-center gap-1 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Kegiatan
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Susunan Panitia</label>
                            <div x-data="{ panitia: [{ nama: '', nim: '', jabatan: 'Ketua Panitia' }, { nama: '', nim: '', jabatan: 'Sekretaris' }, { nama: '', nim: '', jabatan: 'Bendahara' }] }" class="space-y-2">
                                <template x-for="(p, i) in panitia" :key="i">
                                    <div class="flex gap-2">
                                        <input type="text" x-model="p.jabatan" :name="`panitia_jabatan[${i}]`"
                                            placeholder="Jabatan"
                                            class="w-1/3 px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                        <input type="text" x-model="p.nama" :name="`panitia_nama[${i}]`"
                                            placeholder="Nama lengkap"
                                            class="w-1/3 px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                        <input type="text" x-model="p.nim" :name="`panitia_nim[${i}]`"
                                            placeholder="NIM"
                                            class="w-1/3 px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                        <button type="button" @click="panitia.splice(i,1)"
                                            x-show="panitia.length > 1" class="text-gray-400 hover:text-red-500"><svg
                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                </template>
                                <button type="button" @click="panitia.push({nama:'', nim:'', jabatan:''})"
                                    class="text-xs font-semibold text-[#2C3DA6] flex items-center gap-1 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Panitia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 4: Anggaran --}}
                <div x-show="activeSection === 'anggaran'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-800">💰 Rencana Anggaran Biaya</h3>
                            <button type="button" @click="markComplete('anggaran'); activeSection = 'penutup'"
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                ✓ Tandai Selesai & Lanjut
                            </button>
                        </div>

                        <div x-data="{
                            pemasukan: [
                                { rincian: 'Subsidi Institusi', vol: 1, satuan: 'Paket', harga: 0 }
                            ],
                            pengeluaran: [
                                { divisi: '', rincian: 'Sewa Ruangan', vol: 1, satuan: 'Ruangan', harga: 0 }
                            ],
                            get totalIn() { return this.pemasukan.reduce((s, r) => s + ((r.vol || 0) * (r.harga || 0)), 0); },
                            get totalOut() { return this.pengeluaran.reduce((s, r) => s + ((r.vol || 0) * (r.harga || 0)), 0); }
                        }">
                            {{-- Hidden budget field (Total Pengeluaran) --}}
                            <input type="hidden" name="budget" :value="totalOut">

                            {{-- Tabel Pemasukan --}}
                            <div class="mb-8">
                                <h4 class="text-sm font-bold text-emerald-600 mb-3 border-b border-emerald-100 pb-2">
                                    Pemasukan</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr
                                                class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b-2 border-gray-200">
                                                <th class="pb-3 text-left">Rincian</th>
                                                <th class="pb-3 text-center w-20">Vol</th>
                                                <th class="pb-3 text-left w-24">Satuan</th>
                                                <th class="pb-3 text-right w-36">Harga Satuan (Rp)</th>
                                                <th class="pb-3 text-right w-36">Jumlah (Rp)</th>
                                                <th class="pb-3 w-10"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, i) in pemasukan" :key="'in' + i">
                                                <tr class="border-b border-gray-50">
                                                    <td class="py-2 pr-2"><input type="text" x-model="row.rincian"
                                                            :name="`pemasukan_rincian[${i}]`"
                                                            placeholder="Nama sumber dana"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="number"
                                                            x-model.number="row.vol" :name="`pemasukan_vol[${i}]`"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-center">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="text" x-model="row.satuan"
                                                            :name="`pemasukan_satuan[${i}]`" placeholder="Paket"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="number"
                                                            x-model.number="row.harga" :name="`pemasukan_harga[${i}]`"
                                                            placeholder="0"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-right">
                                                    </td>
                                                    <td class="py-2 text-right font-semibold text-gray-700"
                                                        x-text="'Rp ' + ((row.vol || 0) * (row.harga || 0)).toLocaleString('id-ID')">
                                                    </td>
                                                    <td class="py-2"><button type="button"
                                                            @click="pemasukan.splice(i,1)"
                                                            x-show="pemasukan.length > 1"
                                                            class="text-gray-400 hover:text-red-500"><svg
                                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg></button></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                        <tfoot>
                                            <tr class="border-t-2 border-gray-200">
                                                <td colspan="4"
                                                    class="py-3 text-right text-sm font-bold text-gray-700">Total
                                                    Pemasukan</td>
                                                <td class="py-3 text-right text-base font-black text-emerald-600"
                                                    x-text="'Rp ' + totalIn.toLocaleString('id-ID')"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="button"
                                    @click="pemasukan.push({rincian:'', vol:1, satuan:'', harga:0})"
                                    class="mt-3 text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Pemasukan
                                </button>
                            </div>

                            {{-- Tabel Pengeluaran --}}
                            <div>
                                <h4 class="text-sm font-bold text-red-600 mb-3 border-b border-red-100 pb-2">
                                    Pengeluaran</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr
                                                class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b-2 border-gray-200">
                                                <th class="pb-3 text-left w-48">Divisi</th>
                                                <th class="pb-3 text-left">Rincian</th>
                                                <th class="pb-3 text-center w-20">Vol</th>
                                                <th class="pb-3 text-left w-24">Satuan</th>
                                                <th class="pb-3 text-right w-36">Harga Satuan (Rp)</th>
                                                <th class="pb-3 text-right w-36">Jumlah (Rp)</th>
                                                <th class="pb-3 w-10"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, i) in pengeluaran" :key="'out' + i">
                                                <tr class="border-b border-gray-50">
                                                    <td class="py-2 pr-2">
                                                        <select x-model="row.divisi"
                                                            :name="`pengeluaran_divisi[${i}]`"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                                            <option value="">Pilih Divisi</option>
                                                            <option>Acara</option>
                                                            <option>Humas & Pubdekdok</option>
                                                            <option>Konsumsi</option>
                                                            <option>Perlengkapan</option>
                                                            <option>Kesekretariatan</option>
                                                            <option>Lain-lain</option>
                                                        </select>
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="text" x-model="row.rincian"
                                                            :name="`pengeluaran_rincian[${i}]`"
                                                            placeholder="Nama item pengeluaran"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="number"
                                                            x-model.number="row.vol" :name="`pengeluaran_vol[${i}]`"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-center">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="text" x-model="row.satuan"
                                                            :name="`pengeluaran_satuan[${i}]`" placeholder="Pcs"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6]">
                                                    </td>
                                                    <td class="py-2 pr-2"><input type="number"
                                                            x-model.number="row.harga"
                                                            :name="`pengeluaran_harga[${i}]`" placeholder="0"
                                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-right">
                                                    </td>
                                                    <td class="py-2 text-right font-semibold text-gray-700"
                                                        x-text="'Rp ' + ((row.vol || 0) * (row.harga || 0)).toLocaleString('id-ID')">
                                                    </td>
                                                    <td class="py-2"><button type="button"
                                                            @click="pengeluaran.splice(i,1)"
                                                            x-show="pengeluaran.length > 1"
                                                            class="text-gray-400 hover:text-red-500"><svg
                                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg></button></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                        <tfoot>
                                            <tr class="border-t-2 border-gray-200">
                                                <td colspan="5"
                                                    class="py-3 text-right text-sm font-bold text-gray-700">Total
                                                    Pengeluaran</td>
                                                <td class="py-3 text-right text-base font-black text-red-600"
                                                    x-text="'Rp ' + totalOut.toLocaleString('id-ID')"></td>
                                                <td></td>
                                            </tr>
                                            <tr class="border-t-2 border-gray-200 bg-gray-50">
                                                <td colspan="5"
                                                    class="py-3 text-right text-sm font-bold text-gray-700">Saldo
                                                    (Pemasukan - Pengeluaran)</td>
                                                <td class="py-3 text-right text-base font-black"
                                                    :class="totalIn - totalOut >= 0 ? 'text-[#2C3DA6]' : 'text-red-600'"
                                                    x-text="'Rp ' + (totalIn - totalOut).toLocaleString('id-ID')"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="button"
                                    @click="pengeluaran.push({divisi:'', rincian:'', vol:1, satuan:'', harga:0})"
                                    class="mt-3 text-xs font-semibold text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Pengeluaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 5: Penutup --}}
                <div x-show="activeSection === 'penutup'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-800">🏁 Penutup</h3>
                            <button
                                type="button"
                                @click="markComplete('penutup')"
                                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                                ✓ Tandai Selesai
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Penutup</label>
                            <textarea rows="4" name="penutup"
                                placeholder="Contoh: Demikian proposal ini kami susun dengan harapan kegiatan Workshop UI/UX Design 2026 dapat terlaksana dengan baik..."
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2C3DA6] resize-none transition-all"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Lampiran (opsional)</label>
                            <div
                                class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                                <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <p class="text-xs text-gray-400">Klik untuk upload atau drag & drop (PDF, JPG, PNG)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Final Actions --}}
                    <div class="mt-6 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" :disabled="isSaving"
                                class="flex-1 flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-lg shadow-[#2C3DA6]/20 transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg x-show="!isSaving" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <svg x-show="isSaving" class="w-5 h-5 animate-spin" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                <span x-text="isSaving ? 'Menyimpan...' : '💾 Simpan Draft'"></span>
                            </button>
                            <button type="submit" formnovalidate
                                formaction="{{ route('dashboard.proposal.preview.post') }}" formmethod="POST"
                                class="flex-1 flex items-center justify-center gap-2 px-6 py-3 text-sm font-semibold text-[#2C3DA6] bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview Proposal
                            </button>
                            <button type="button"
                                class="px-6 py-3 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors">
                                📨 Submit untuk Persetujuan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</x-layouts.dashboard>
