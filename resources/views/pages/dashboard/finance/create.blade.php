<x-layouts.dashboard title="Tambah Laporan Keuangan">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.finance.index', ['tab' => 'internal']) }}"
            class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Tambah Laporan Keuangan</h2>
            <p class="text-sm text-gray-400">Buat laporan keuangan baru untuk himpunan</p>
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

    <form method="POST" action="{{ route('dashboard.finance.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Transaksi *</label>
                    <input type="text" name="title" required value="{{ old('title') }}"
                        placeholder="Contoh: Laporan Keuangan Bulan Januari 2024"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Transaksi *</label>
                    <input type="date" name="transaction_date" required
                        value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Transaksi *</label>
                    <select name="type" required
                        placeholder="Pilih tipe transaksi"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] text-gray-600">
                        <option value="income">Pemasukan (Income)</option>
                        <option value="outcome">Pengeluaran (Outcome)</option>
                    </select>
                </div>
                <div x-data="{ 
                    displayAmount: '',
                    get rawAmount() {
                            return this.displayAmount.replace(/\D/g, '');
                        }
                }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nominal (Rp) *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                        <input type="text" 
                            x-model="displayAmount" 
                            @input="displayAmount = $event.target.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                            placeholder="0"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:border-[#2C3DA6] transition-all">
        
                        <input type="hidden" name="amount" :value="rawAmount">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Metode Transaksi *</label>
                    <input type="text" name="method" value="{{ old('method') }}"
                        placeholder="Contoh: Transfer Bank, Tunai, dsb."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">
                </div>
            </div>

            
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Tambahan</label>
                <textarea rows="4" name="description" placeholder="Deskripsi singkat..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:border-[#2C3DA6] focus:ring-2 focus:ring-[#2C3DA6]/20 transition-all">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Bukti Transaksi (Nota/Struk) *</label>
                <div id="drop-area" class="relative bg-white rounded-xl border-2 border-dashed border-gray-200 p-8 text-center hover:border-[#2C3DA6]/40 transition-colors cursor-pointer">
                    <input type="file" name="attachment" id="file-input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50">
                    
                    {{-- Area Tampilan Awal --}}
                    <div id="placeholder-view" class="space-y-2">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-500 font-semibold text-gray-500 mb-1">Klik untuk memilih file</p>
                        <p class="text-xs text-gray-500">(JPEG, JPG, PNG — maks 5MB)</p>
                    </div>

                    {{-- Area Preview (Akan Muncul Setelah Pilih File) --}}
                    <div id="preview-container" class="hidden space-y-2">
                        <img id="image-preview" class="mx-auto max-h-40 rounded-lg shadow-sm border border-gray-100">
                        <p id="file-name-display" class="text-sm font-semibold text-emerald-600"></p>
                    </div>
                </div>

                <div id="upload-notif" class="hidden mt-3 p-2 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg text-center animated fade-in">
                    File berhasil ditambahkan!
                </div>
            </div>
        </div> 

        <div class="flex items-center justify-end mt-6">
            <div class="flex gap-3">
                <a href="{{ route('dashboard.finance.index', ['tab' => 'internal']) }}" 
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-600/20">
                    Simpan Laporan Keuangan
                </button>
            </div>
        </div>

    </form>

    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('file-input');
            const previewContainer = document.getElementById('preview-container');
            const placeholderView = document.getElementById('placeholder-view');
            const imagePreview = document.getElementById('image-preview');
            const fileNameDisplay = document.getElementById('file-name-display');

            if (!dropArea || !fileInput) return;

            function handleFile(file) {
                if (file.size > 5 * 1024 * 1024) { 
                    alert('Jangan gede-gede boss! Maksimal 5MB aja.');
                    fileInput.value = ""; 
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.classList.remove('hidden');
                    placeholderView.classList.add('hidden');
                    imagePreview.src = e.target.result;
                    fileNameDisplay.innerText = `${file.name}`;
                    
                    dropArea.classList.remove('border-gray-200', 'bg-white', 'bg-emerald-50', 'border-emerald-500');
                    dropArea.classList.add('border-emerald-500', 'bg-emerald-50');
                }
                reader.readAsDataURL(file);
            }

            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });

            ['dragenter', 'dragover'].forEach(name => {
                dropArea.addEventListener(name, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.classList.add('bg-emerald-50', 'border-emerald-500');
                });
            });

            ['dragleave'].forEach(name => {
                dropArea.addEventListener(name, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!fileInput.value) {
                        dropArea.classList.remove('bg-emerald-50', 'border-emerald-500');
                    }
                });
            });

            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                dropArea.classList.remove('bg-emerald-50', 'border-emerald-500');

                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    const droppedFiles = e.dataTransfer.files;
                    
                    fileInput.files = droppedFiles; 
                    
                    handleFile(droppedFiles[0]);
                }
            });
        });
        </script>
        @endpush

</x-layouts.dashboard>
