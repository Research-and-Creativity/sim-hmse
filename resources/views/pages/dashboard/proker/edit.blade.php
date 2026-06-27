<x-layouts.dashboard title="Edit Program Kerja">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.proker.show', $formState['id']) }}"
            class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Edit Program Kerja</h2>
            <p class="text-sm text-gray-400">Ubah data program kerja yang sudah tersimpan</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm">
            <p class="font-semibold mb-2">Validasi gagal, periksa input berikut:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $timelineItems = collect($formState['timeline'] ?? [])
            ->map(function ($item) {
                return [
                    'title' => $item['title'] ?? '',
                    'date' => $item['date'] ?? '',
                ];
            })
            ->values();

        if ($timelineItems->isEmpty()) {
            $timelineItems = collect([['title' => '', 'date' => '']]);
        }

        $budgetItems = collect($formState['budget_items'] ?? [])
            ->map(function ($item) {
                return [
                    'name' => $item['item'] ?? '',
                    'qty' => $item['qty'] ?? '',
                    'unit' => $item['unit'] ?? '',
                    'price' => $item['price'] ?? 0,
                ];
            })
            ->values();

        if ($budgetItems->isEmpty()) {
            $budgetItems = collect([['name' => '', 'qty' => '', 'unit' => '', 'price' => 0]]);
        }
    @endphp

    <form method="POST" action="{{ route('dashboard.proker.update', $formState['id']) }}" enctype="multipart/form-data"
        x-data="{
            step: 1,
            totalSteps: 4,
            stepLabels: ['Info Dasar', 'Jadwal', 'Anggaran', 'Review'],
            milestones: @js($timelineItems),
            items: @js($budgetItems),
            dateStart: '',
            dateEnd: '',
            minDate: new Date().toISOString().split('T')[0],
            satuanOptions: ['Pcs', 'Box', 'Buah', 'Lembar', 'Paket', 'Set', 'Meter', 'Kg', 'Liter', 'Orang', 'Hari', 'Jam'],
            riskLevel: @js(old('risk_level', $formState['risk_level'] ?? 'rendah')),
        }" class="max-w-4xl">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
            <div class="flex items-center w-full">
                <template x-for="(label, i) in stepLabels" :key="i">
                    <div class="flex items-center" :class="i < stepLabels.length - 1 ? 'flex-1' : ''">
                        <div class="flex flex-col items-center">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300"
                                :class="i + 1 < step ? 'bg-emerald-500 text-white' : (i + 1 === step ?
                                    'bg-[#2C3DA6] text-white ring-4 ring-[#2C3DA6]/20' : 'bg-gray-200 text-gray-400'
                                )">
                                <template x-if="i + 1 < step">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </template>
                                <template x-if="i + 1 >= step">
                                    <span x-text="i + 1"></span>
                                </template>
                            </div>
                            <span class="text-[10px] font-medium mt-1.5 text-center max-w-[80px] leading-tight"
                                :class="i + 1 <= step ? 'text-[#2C3DA6]' : 'text-gray-400'" x-text="label"></span>
                        </div>

                        <template x-if="i < stepLabels.length - 1">
                            <div class="flex-1 h-0.5 mx-2 mt-[-16px]"
                                :class="i + 1 < step ? 'bg-emerald-400' : 'bg-gray-200'"></div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <div x-show="step === 1" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-800">Informasi Dasar</h3>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Program Kerja *</label>
                <input type="text" name="name" value="{{ old('name', $formState['name']) }}"
                    placeholder="Contoh: Workshop UI/UX Design"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Divisi *</label>
                    <select name="division"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="">Pilih Divisi</option>
                        @foreach ($divisionOptions as $division)
                            <option value="{{ $division }}" @selected(old('division', $formState['division']) === $division)>{{ $division }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Penanggung Jawab *</label>
                    <select name="pj_user_id"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="">Pilih Penanggung Jawab</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account['id'] }}" @selected((string) old('pj_user_id', $formState['pj_user_id']) === (string) $account['id'])>{{ $account['name'] }}
                                ({{ $account['division'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tingkat Risiko *</label>
                    <select name="risk_level" x-model="riskLevel"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="">Pilih Tingkat Risiko</option>
                        <option value="rendah" @selected(old('risk_level', $formState['risk_level'] ?? '') === 'rendah')>Rendah</option>
                        <option value="sedang" @selected(old('risk_level', $formState['risk_level'] ?? '') === 'sedang')>Sedang</option>
                        <option value="tinggi" @selected(old('risk_level', $formState['risk_level'] ?? '') === 'tinggi')>Tinggi</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-2">Tingkat risiko akan mempengaruhi konteks dan template proposal
                        yang dibuat</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status *</label>
                <select name="status"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                    @foreach (['draft' => 'Draft', 'preparation' => 'Persiapan', 'on-progress' => 'On Progress', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $formState['status']) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea rows="4" name="description" placeholder="Deskripsi singkat program kerja..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all resize-none">{{ old('description', $formState['description']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $formState['location']) }}"
                        placeholder="Lokasi pelaksanaan"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Target Peserta</label>
                    <input type="number" name="target_participants"
                        value="{{ old('target_participants', $formState['target_participants']) }}"
                        placeholder="Jumlah peserta"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                </div>
            </div>

            {{-- ═══ PENGATURAN EVENT PUBLIK ═══ --}}
            <div class="border-t border-gray-100 pt-5">
                <h4 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#2C3DA6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                    Pengaturan Event Publik
                </h4>

                {{-- Poster Upload --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Poster / Banner Event</label>
                    @php $prokerRow = \App\Models\ProgramKerja::find($formState['id']); @endphp
                    @if ($prokerRow?->poster)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $prokerRow->poster) }}" alt="Poster" class="h-32 rounded-lg object-cover border border-gray-200">
                            <p class="text-xs text-gray-400 mt-1">Poster saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    <input type="file" name="poster" accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#2C3DA6]/10 file:text-[#2C3DA6] hover:file:bg-[#2C3DA6]/20 transition-all">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>

                {{-- Toggle & Settings --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- is_public toggle --}}
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Tampil ke Publik</p>
                            <p class="text-xs text-gray-400 mt-0.5">Tampilkan proker ini di halaman Event/News publik
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer"
                                {{ old('is_public', $prokerRow?->is_public) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2C3DA6]">
                            </div>
                        </label>
                    </div>

                    {{-- open_registration toggle --}}
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Buka Pendaftaran</p>
                            <p class="text-xs text-gray-400 mt-0.5">Izinkan mahasiswa umum mendaftar event ini</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                            <input type="hidden" name="open_registration" value="0">
                            <input type="checkbox" name="open_registration" value="1" class="sr-only peer"
                                {{ old('open_registration', $prokerRow?->open_registration) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2C3DA6]">
                            </div>
                        </label>
                    </div>

                    {{-- Batas Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Waktu Pendaftaran</label>
                        <input type="datetime-local" name="registration_deadline"
                            value="{{ old('registration_deadline', $prokerRow?->registration_deadline?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                    </div>

                    {{-- Kuota Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kuota Pendaftaran</label>
                        <input type="number" name="registration_quota" min="1"
                            value="{{ old('registration_quota', $prokerRow?->registration_quota) }}"
                            placeholder="Kosong = sama dengan target peserta"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div x-show="step === 2" style="display:none;"
            class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-800">Jadwal & Timeline</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai * <span
                            class="text-xs text-gray-400">(minimal hari ini)</span></label>
                    <input type="date" name="date_start"
                        value="{{ old('date_start', $formState['date_start']) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                    <p class="text-xs text-gray-400 mt-1">Tanggal mulai tidak boleh lebih awal dari hari ini</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai * <span
                            class="text-xs text-gray-400" x-show="!dateStart">(pilih tanggal mulai
                            dulu)</span></label>
                    <input type="date" name="date_end" value="{{ old('date_end', $formState['date_end']) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                    <p class="text-xs text-gray-400 mt-1" x-show="dateStart">Tanggal selesai harus sama atau lebih
                        lambat dari tanggal mulai</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Tahapan Kegiatan</label>
                <div class="space-y-3">
                    <template x-for="(m, i) in milestones" :key="i">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-7 h-7 rounded-full bg-[#2C3DA6]/10 text-[#2C3DA6] text-xs font-bold flex items-center justify-center flex-shrink-0"
                                x-text="i + 1"></span>
                            <input type="text" :name="`timeline_titles[${i}]`" placeholder="Nama tahapan"
                                x-model="m.title"
                                class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6]">
                            <input type="date" :name="`timeline_dates[${i}]`" x-model="m.date"
                                class="px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6]">
                            <button type="button" @click="milestones.splice(i, 1)" x-show="milestones.length > 1"
                                class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="milestones.push({ title: '', date: '' })"
                        class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Tahapan
                    </button>
                </div>
            </div>
        </div>

        <div x-show="step === 3" style="display:none;"
            class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-800">Rencana Anggaran (RAB)</h3>
            <div class="space-y-3">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-200">
                                <th class="pb-2 pr-3">Item</th>
                                <th class="pb-2 pr-3">Qty</th>
                                <th class="pb-2 pr-3">Satuan</th>
                                <th class="pb-2 pr-3">Harga (Rp)</th>
                                <th class="pb-2 text-right">Subtotal</th>
                                <th class="pb-2 w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, i) in items" :key="i">
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 pr-3"><input type="text" :name="`budget_item_names[${i}]`"
                                            x-model="item.name" placeholder="Nama item"
                                            class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                                    </td>
                                    <td class="py-2 pr-3"><input type="text" :name="`budget_qtys[${i}]`"
                                            x-model="item.qty" placeholder="1"
                                            class="w-20 px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                                    </td>
                                    <td class="py-2 pr-3"><input type="text" :name="`budget_units[${i}]`"
                                            x-model="item.unit" placeholder="pcs"
                                            class="w-24 px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                                    </td>
                                    <td class="py-2 pr-3"><input type="number" :name="`budget_prices[${i}]`"
                                            x-model.number="item.price" placeholder="0"
                                            class="w-32 px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#2C3DA6]">
                                    </td>
                                    <td class="py-2 text-right font-semibold text-gray-600"
                                        x-text="'Rp ' + ((item.price || 0) * (item.qty || 0)).toLocaleString('id-ID')">
                                    </td>
                                    <td class="py-2 text-center">
                                        <button type="button" @click="items.splice(i, 1)" x-show="items.length > 1"
                                            class="text-gray-400 hover:text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-200">
                                <td colspan="4" class="py-3 text-right font-bold text-gray-700">Total</td>
                                <td class="py-3 text-right font-black text-[#2C3DA6]"
                                    x-text="'Rp ' + items.reduce((s, i) => s + ((i.price || 0) * (i.qty || 0)), 0).toLocaleString('id-ID')">
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" @click="items.push({ name: '', qty: '', unit: '', price: 0 })"
                    class="text-xs font-semibold text-[#2C3DA6] hover:text-[#00C4D8] flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Item
                </button>
            </div>
        </div>

        <div x-show="step === 4" style="display:none;"
            class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Review & Kirim</h3>
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 mb-4">
                <p class="font-semibold mb-1">Semua data siap disimpan</p>
                <p class="text-xs text-emerald-600">Klik simpan untuk memperbarui program kerja.</p>
            </div>
            <p class="text-sm text-gray-500">Perubahan akan disimpan ke database.</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="button" x-show="step > 1" @click="step--"
                class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                ← Sebelumnya
            </button>
            <div x-show="step === 1"></div>

            <div class="flex gap-3">
                <button type="button" x-show="step < totalSteps" @click="step++"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 transition-colors shadow-md shadow-[#2C3DA6]/20">
                    Selanjutnya →
                </button>
                <button type="submit" x-show="step === totalSteps"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-600/20">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

</x-layouts.dashboard>
