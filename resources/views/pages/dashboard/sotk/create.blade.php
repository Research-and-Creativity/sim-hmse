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

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" placeholder="Nama lengkap" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIM *</label>
                    <input type="text" placeholder="13012100XX" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Angkatan</label>
                    <select class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option>2024</option><option>2023</option><option>2022</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Divisi *</label>
                    <select class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="">Pilih Divisi</option>
                        <option>Pimpinan Inti</option>
                        <option>Divisi Akademik</option>
                        <option>Divisi Kreatif</option>
                        <option>Divisi Eksternal</option>
                        <option>Divisi Kewirausahaan</option>
                        <option>Divisi Olahraga & Seni</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan *</label>
                    <input type="text" placeholder="Contoh: Kepala Divisi" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" placeholder="email@student.ac.id" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-gray-400">Klik untuk upload atau drag & drop</p>
                        <p class="text-[10px] text-gray-300 mt-1">JPG, PNG max 2MB</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button class="px-6 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-md shadow-[#2C3DA6]/20">Simpan</button>
                <a href="{{ route('dashboard.sotk.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Batal</a>
            </div>
        </div>
    </div>

</x-layouts.dashboard>
