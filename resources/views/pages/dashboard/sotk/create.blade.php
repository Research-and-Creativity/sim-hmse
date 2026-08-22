<x-layouts.dashboard title="Tambah Anggota">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.sotk.index') }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Tambah Anggota Pengurus</h2>
            <p class="text-sm text-gray-400">Tambahkan data pengurus baru ke struktur organisasi</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="max-w-2xl mb-6 p-4 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm">
            <p class="font-semibold mb-2">Validasi gagal, periksa input berikut:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('dashboard.sotk.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Nama lengkap pengurus" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('name') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIM *</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required
                           placeholder="Contoh: 103122400064" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('nim') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                    @error('nim') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Divisi *</label>
                    <select name="divisi" required class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('divisi') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="">Pilih Divisi</option>
                        @foreach ($divisionOptions as $opt)
                            <option value="{{ $opt }}" @selected(old('divisi') === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                    @error('divisi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan *</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                           placeholder="Contoh: President, Head of Division, Staff, Sekretaris" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('jabatan') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                    @error('jabatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-xs font-normal text-gray-400">(Opsional)</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="email@domain.com" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp <span class="text-xs font-normal text-gray-400">(Opsional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="08xxxxxxxxxx" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('phone') border-red-400 @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2" x-data="{ fileName: '', previewUrl: '' }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil <span class="text-xs font-normal text-gray-400">(Opsional, Maks 2MB)</span></label>
                    <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <input type="file" name="avatar" accept="image/png,image/jpeg,image/jpg" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                               @change="
                                   const f = $event.target.files[0];
                                   if (f) {
                                       fileName = f.name;
                                       previewUrl = URL.createObjectURL(f);
                                   }
                               ">
                        <template x-if="!previewUrl">
                            <div>
                                <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-gray-500 font-medium">Klik untuk upload foto atau drag & drop</p>
                                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, JPEG maksimal 2MB</p>
                            </div>
                        </template>
                        <template x-if="previewUrl">
                            <div class="flex flex-col items-center">
                                <img :src="previewUrl" class="w-16 h-16 rounded-full object-cover shadow-sm mb-2 border-2 border-[#2C3DA6]">
                                <p class="text-xs text-[#2C3DA6] font-semibold" x-text="fileName"></p>
                            </div>
                        </template>
                    </div>
                    @error('avatar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-md shadow-[#2C3DA6]/20 transition-all">
                    Simpan Anggota
                </button>
                <a href="{{ route('dashboard.sotk.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</x-layouts.dashboard>

