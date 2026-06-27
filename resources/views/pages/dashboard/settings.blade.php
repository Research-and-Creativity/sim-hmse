<x-layouts.dashboard title="Pengaturan">
    @php
        $currentUser = auth()->user();
        $initials = 'G';
        if ($currentUser && $currentUser->name) {
            $words = explode(' ', $currentUser->name);
            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        }
    @endphp

    <div class="mb-6">
        <h2 class="text-xl font-black text-gray-800">Pengaturan Akun</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola profil dan preferensi akun</p>
    </div>

    <div class="max-w-3xl space-y-6">

        {{-- Profile --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-5">Profil</h3>
            <div class="flex items-center gap-5 mb-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#2C3DA6] to-[#00C4D8] flex items-center justify-center flex-shrink-0">
                    <span class="text-white text-2xl font-black">{{ $initials }}</span>
                </div>
                <div>
                    <p class="text-base font-bold text-gray-700">{{ $currentUser?->name ?? 'Guest' }}</p>
                    <p class="text-sm text-gray-400">{{ $currentUser ? $currentUser->jabatanLabel() : 'Guest' }} · Kabinet Zenith</p>
                    <button class="mt-2 text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] transition-colors">Ganti Foto</button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" value="{{ $currentUser?->name ?? '' }}" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $currentUser?->email ?? '' }}" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIM / NIP</label>
                    <input type="text" value="{{ $currentUser?->nim_nip ?? '' }}" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" value="082123456789" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
            </div>
            <button class="mt-4 px-5 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-md shadow-[#2C3DA6]/20">Simpan Perubahan</button>
        </div>

        {{-- Password --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-5">Ubah Password</h3>
            <div class="space-y-4 max-w-md">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Lama</label>
                    <input type="password" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                    <input type="password" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                </div>
            </div>
            <button class="mt-4 px-5 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-md shadow-[#2C3DA6]/20">Ubah Password</button>
        </div>

    </div>

</x-layouts.dashboard>
