<x-layouts.dashboard title="Dokumentasi">

    <div x-data="{ 
        uploadOpen: false, 
        detailOpen: false,
        activeDoc: null,
        openDetail(doc) {
            this.activeDoc = doc;
            this.detailOpen = true;
        }
    }">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-gray-800">Dokumentasi & Arsip</h2>
                <p class="text-sm text-gray-400 mt-0.5">Kelola dokumen, proposal, dan file arsip kegiatan himpunan</p>
            </div>
            <div class="flex gap-2">
                <button @click="uploadOpen = !uploadOpen"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#2C3DA6] text-white text-sm font-semibold rounded-xl hover:bg-[#2C3DA6]/90 transition-all shadow-md shadow-[#2C3DA6]/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span x-text="uploadOpen ? 'Tutup Upload' : 'Upload File'"></span>
                </button>
            </div>
        </div>

        {{-- Modal Upload File --}}
        <div x-show="uploadOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" style="display: none;">
            <div @click.outside="uploadOpen = false" class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-lg w-full p-6 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-800">Upload Dokumen / Arsip</h3>
                    <button @click="uploadOpen = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('dashboard.documents.store') }}" enctype="multipart/form-data" class="space-y-4"
                      x-data="{ fileName: '', fileSize: '' }">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Dokumen *</label>
                        <select name="category" required class="w-full px-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-700">
                            <option value="Proposal">Proposal</option>
                            <option value="LPJ">LPJ (Laporan Pertanggungjawaban)</option>
                            <option value="Surat">Surat Menyurat / SK</option>
                            <option value="Foto">Foto Dokumentasi / Media</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Terkait Program Kerja (Opsional)</label>
                        <select name="program_kerja_id" class="w-full px-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-700">
                            <option value="">-- Tidak Terikat Proker Khusus --</option>
                            @foreach ($prokers as $pk)
                                <option value="{{ $pk->id }}">{{ $pk->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama / Label Dokumen (Opsional)</label>
                        <input type="text" name="name" placeholder="Biarkan kosong untuk nama asli file" 
                               class="w-full px-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Pilih File * (Maks 10MB)</label>
                        <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-blue-50/50 hover:border-[#2C3DA6]/40 transition-colors cursor-pointer">
                            <input type="file" name="file" required 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   @change="
                                       const f = $event.target.files[0];
                                       if (f) {
                                           fileName = f.name;
                                           fileSize = (f.size / 1048576).toFixed(2) + ' MB';
                                       }
                                   ">
                            <template x-if="!fileName">
                                <div>
                                    <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs text-gray-500 font-semibold">Klik untuk memilih file atau Drag & Drop</p>
                                    <p class="text-[10px] text-gray-400 mt-1">PDF, DOCX, XLSX, PPTX, JPG, PNG, ZIP (Maks 10MB)</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="flex items-center justify-center gap-2 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-xs font-semibold" x-text="fileName + ' (' + fileSize + ')'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                        <button type="button" @click="uploadOpen = false" class="px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 shadow-sm">Upload Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('dashboard.documents.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama dokumen..." class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
            </div>
            <select name="category" class="px-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-gray-600">
                <option value="">Semua Kategori</option>
                <option value="Proposal" @selected(($category ?? '') === 'Proposal')>Proposal</option>
                <option value="LPJ" @selected(($category ?? '') === 'LPJ')>LPJ</option>
                <option value="Surat" @selected(($category ?? '') === 'Surat')>Surat</option>
                <option value="Foto" @selected(($category ?? '') === 'Foto')>Foto</option>
                <option value="Lainnya" @selected(($category ?? '') === 'Lainnya')>Lainnya</option>
            </select>
            <select name="proker_id" class="px-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:border-[#2C3DA6] text-gray-600 max-w-xs">
                <option value="">Semua Proker</option>
                @foreach ($prokers as $pk)
                    <option value="{{ $pk->id }}" @selected(($prokerId ?? '') == $pk->id)>{{ $pk->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 transition-colors">
                Cari
            </button>
            <a href="{{ route('dashboard.documents.index') }}" class="px-3 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 text-center">
                Reset
            </a>
        </form>

        {{-- File Grid --}}
        @php
            $iconColors = [
                'pdf' => ['bg' => 'bg-red-50', 'text' => 'text-red-500', 'icon' => 'PDF', 'badge' => 'bg-red-100 text-red-700'],
                'doc' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-500', 'icon' => 'DOC', 'badge' => 'bg-blue-100 text-blue-700'],
                'img' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-500', 'icon' => 'IMG', 'badge' => 'bg-purple-100 text-purple-700'],
                'zip' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-500', 'icon' => 'ZIP', 'badge' => 'bg-amber-100 text-amber-700'],
                'xls' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-500', 'icon' => 'XLS', 'badge' => 'bg-emerald-100 text-emerald-700'],
                'ppt' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-500', 'icon' => 'PPT', 'badge' => 'bg-orange-100 text-orange-700'],
                'other' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'icon' => 'FILE', 'badge' => 'bg-gray-100 text-gray-700'],
            ];
        @endphp

        @if ($documents->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
                @foreach ($documents as $doc)
                    @php
                        $ic = $iconColors[$doc->file_type] ?? $iconColors['other'];
                        $fileUrl = Storage::url($doc->file_path);
                        $downloadUrl = route('dashboard.documents.download', $doc->id);
                        $docData = [
                            'id' => $doc->id,
                            'name' => $doc->name,
                            'file_type' => $doc->file_type,
                            'category' => $doc->category,
                            'size' => $doc->formattedSize(),
                            'created_at' => $doc->created_at->format('d M Y, H:i'),
                            'proker' => $doc->programKerja ? $doc->programKerja->name : null,
                            'uploader' => $doc->uploader ? $doc->uploader->name : null,
                            'url' => $fileUrl,
                            'download_url' => $downloadUrl,
                            'icon' => $ic['icon'],
                            'badge' => $ic['badge'],
                        ];
                    @endphp
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between cursor-pointer"
                         @click="openDetail({{ json_encode($docData) }})">
                        <div>
                            {{-- Cover Thumbnail for Image Files --}}
                            @if ($doc->file_type === 'img')
                                <div class="w-full h-36 rounded-lg overflow-hidden mb-3 bg-gray-100 border border-gray-100 flex items-center justify-center relative">
                                    <img src="{{ $fileUrl }}" alt="{{ $doc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-bold rounded-md bg-black/60 text-white backdrop-blur-xs">IMG</span>
                                </div>
                            @endif

                            <div class="flex items-start gap-3 mb-3">
                                @if ($doc->file_type !== 'img')
                                    <div class="w-11 h-11 rounded-xl {{ $ic['bg'] }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-black {{ $ic['text'] }}">{{ $ic['icon'] }}</span>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-700 truncate group-hover:text-[#2C3DA6] transition-colors" title="{{ $doc->name }}">
                                        {{ $doc->name }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $doc->formattedSize() }} · {{ $doc->created_at->format('d M Y') }}</p>
                                    @if ($doc->programKerja)
                                        <p class="text-[11px] text-blue-600 font-medium truncate mt-1">Proker: {{ $doc->programKerja->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-50" @click.stop>
                            <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $doc->category }}</span>
                            <div class="flex items-center gap-1">
                                <a href="{{ $downloadUrl }}" class="p-1.5 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-[#2C3DA6] transition-colors" title="Quick Download" @click.stop>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('dashboard.documents.destroy', $doc->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip file ini?');" class="inline" @click.stop>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Hapus Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <p class="font-semibold text-gray-700">Belum ada dokumen tersimpan</p>
                <p class="text-sm text-gray-400 mt-1 mb-4">Upload dokumen proposal, LPJ, surat, atau foto dokumentasi pertama Anda.</p>
            </div>
        @endif

        {{-- Modal Detail Dokumen --}}
        <div x-show="detailOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" style="display: none;">
            <div @click.outside="detailOpen = false" class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-lg w-full p-6 space-y-5" x-if="activeDoc">
                <div class="flex items-start justify-between border-b border-gray-100 pb-3 gap-3">
                    <div class="min-w-0 flex-1">
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full mb-1.5" :class="activeDoc?.badge || 'bg-gray-100 text-gray-700'" x-text="activeDoc?.category"></span>
                        <h3 class="text-base font-bold text-gray-800 break-words" x-text="activeDoc?.name"></h3>
                    </div>
                    <button @click="detailOpen = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Preview Media --}}
                <div class="bg-gray-50 rounded-xl border border-gray-100 overflow-hidden flex items-center justify-center min-h-[160px] max-h-[260px]">
                    <template x-if="activeDoc?.file_type === 'img'">
                        <img :src="activeDoc?.url" :alt="activeDoc?.name" class="w-full h-full max-h-[260px] object-contain p-2">
                    </template>
                    <template x-if="activeDoc?.file_type !== 'img'">
                        <div class="text-center p-6">
                            <div class="w-16 h-16 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center mx-auto mb-2">
                                <span class="text-base font-black text-[#2C3DA6]" x-text="activeDoc?.icon"></span>
                            </div>
                            <p class="text-xs text-gray-500 font-semibold" x-text="'Dokumen ' + (activeDoc?.icon || 'File')"></p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Klik tombol download di bawah untuk membuka file lengkap</p>
                        </div>
                    </template>
                </div>

                {{-- Metadata Grid --}}
                <div class="grid grid-cols-2 gap-3 text-xs bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-gray-400 font-medium">Ukuran File</p>
                        <p class="font-bold text-gray-700 mt-0.5" x-text="activeDoc?.size"></p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Tanggal Diunggah</p>
                        <p class="font-bold text-gray-700 mt-0.5" x-text="activeDoc?.created_at"></p>
                    </div>
                    <div class="col-span-2" x-show="activeDoc?.proker">
                        <p class="text-gray-400 font-medium">Program Kerja Terkait</p>
                        <p class="font-bold text-[#2C3DA6] mt-0.5" x-text="activeDoc?.proker"></p>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="detailOpen = false" class="px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Tutup
                    </button>
                    <a :href="activeDoc?.download_url" class="inline-flex items-center gap-2 px-5 py-2 text-xs font-bold text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 shadow-sm shadow-[#2C3DA6]/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download File
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard>
