<x-layouts.dashboard-pembina title="Detail Proposal">

    {{-- Back --}}
    <div class="mb-6">
        <a href="{{ route('pembina.proposal') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#00C4D8] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Proposal
        </a>
    </div>

    @php
        // Label role yang mudah dibaca
        $roleLabels = [
            'ketua_panitia' => 'Ketua Panitia',
            'sekretaris'    => 'Sekretaris',
            'ketua_hmse'    => 'Ketua HMSE',
            'ketua_hima'    => 'Ketua HMSE',
            'pembina'       => 'Pembina',
            'kaprodi'       => 'Kaprodi',
        ];

        // Tentukan label status berdasarkan next approver role yang sebenarnya
        if ($proposal->status === 'draft') {
            $st = ['label' => 'Draft', 'color' => 'gray'];
        } elseif ($proposal->status === 'approved') {
            $st = ['label' => 'Disetujui', 'color' => 'emerald'];
        } elseif ($proposal->status === 'rejected') {
            $st = ['label' => 'Ditolak', 'color' => 'red'];
        } elseif ($nextApproverRole) {
            $nextLabel = $roleLabels[$nextApproverRole] ?? ucfirst($nextApproverRole);
            $st = ['label' => 'Menunggu TTD ' . $nextLabel, 'color' => 'amber'];
        } else {
            $st = ['label' => ucfirst($proposal->status), 'color' => 'blue'];
        }

        $colorMap = [
            'amber'   => 'bg-amber-50 text-amber-700 border-amber-200',
            'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'red'     => 'bg-red-50 text-red-700 border-red-200',
            'blue'    => 'bg-blue-50 text-blue-700 border-blue-200',
            'gray'    => 'bg-gray-100 text-gray-500 border-gray-200',
        ];
    @endphp

    {{-- Header Info --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h2 class="text-xl font-black text-gray-800">{{ $proposal->title }}</h2>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $colorMap[$st['color']] }}">
                        {{ $st['label'] }}
                    </span>
                </div>
                <div class="flex flex-wrap gap-4 text-xs text-gray-400 mt-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                        {{ $proposal->proker ?? 'Program Kerja Umum' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $proposal->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('pembina.proposal.preview', $proposal->id) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview Dokumen
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Approval Stepper --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
                <h3 class="text-sm font-bold text-gray-800 mb-5">Progress Persetujuan</h3>
                <x-dashboard.approval-stepper :proposal="$proposal" :signedCount="$signedCount" />
            </div>

            {{-- TTD Action Box --}}
            @php
                // Tentukan jabatan user yang sedang login
                $currentJabatan = $userJabatan ?? auth()->user()?->jabatan;

                // Cari approval milik user saat ini berdasarkan jabatannya
                $userApproval = null;
                $pendingApproval = null;

                if ($currentJabatan) {
                    $userApproval = $proposal->approvals()
                        ->where('approver_role', $currentJabatan)
                        ->first();

                    $pendingApproval = $proposal->approvals()
                        ->where('approver_role', $currentJabatan)
                        ->where('status', 'pending')
                        ->first();
                }

                // Cek apakah sekarang giliran user ini untuk TTD
                $isMyTurn = $pendingApproval && $nextApproverRole === $currentJabatan;
            @endphp

            @if($proposal->status !== 'draft' && $proposal->status !== 'approved' && $proposal->status !== 'rejected')
                <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
                    @if($isMyTurn && $pendingApproval)
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-amber-800">Tanda Tangan Diperlukan</p>
                            <p class="text-xs text-amber-600 mt-0.5">Proposal ini membutuhkan persetujuan kamu sebagai {{ $roleLabels[$currentJabatan] ?? ucfirst($currentJabatan) }}</p>
                        </div>
                    </div>

                        {{-- Approve Form --}}
                        <form action="{{ route('proposals.approve', $pendingApproval->id) }}" method="POST" class="mb-3"
                              x-data="{
                                  drawing: false,
                                  canvas: null,
                                  ctx: null,
                                  lastX: 0,
                                  lastY: 0,
                                  isEmpty: true,
                                  init() {
                                      this.canvas = this.$refs.sigCanvas;
                                      this.ctx = this.canvas.getContext('2d');
                                      this.resizeCanvas();
                                      window.addEventListener('resize', () => this.resizeCanvas());
                                  },
                                  resizeCanvas() {
                                      const rect = this.canvas.parentElement.getBoundingClientRect();
                                      this.canvas.width = rect.width;
                                      this.canvas.height = 120;
                                      this.ctx.strokeStyle = '#1a202c';
                                      this.ctx.lineWidth = 2.5;
                                      this.ctx.lineCap = 'round';
                                      this.ctx.lineJoin = 'round';
                                  },
                                  startDraw(e) {
                                      this.drawing = true;
                                      const pos = this.getPos(e);
                                      this.lastX = pos.x;
                                      this.lastY = pos.y;
                                  },
                                  draw(e) {
                                      if (!this.drawing) return;
                                      e.preventDefault();
                                      const pos = this.getPos(e);
                                      this.ctx.beginPath();
                                      this.ctx.moveTo(this.lastX, this.lastY);
                                      this.ctx.lineTo(pos.x, pos.y);
                                      this.ctx.stroke();
                                      this.lastX = pos.x;
                                      this.lastY = pos.y;
                                      this.isEmpty = false;
                                  },
                                  stopDraw() {
                                      this.drawing = false;
                                  },
                                  clearCanvas() {
                                      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                                      this.isEmpty = true;
                                      this.$refs.sigInput.value = '';
                                  },
                                  getPos(e) {
                                      const rect = this.canvas.getBoundingClientRect();
                                      if (e.touches && e.touches.length > 0) {
                                          return {
                                              x: e.touches[0].clientX - rect.left,
                                              y: e.touches[0].clientY - rect.top
                                          };
                                      }
                                      return {
                                          x: e.clientX - rect.left,
                                          y: e.clientY - rect.top
                                      };
                                  },
                                  trimCanvas(canvas) {
                                      const ctx = canvas.getContext('2d');
                                      const copy = document.createElement('canvas');
                                      const copyCtx = copy.getContext('2d');
                                      const imgWidth = canvas.width;
                                      const imgHeight = canvas.height;
                                      
                                      const pixels = ctx.getImageData(0, 0, imgWidth, imgHeight);
                                      const l = pixels.data.length;
                                      
                                      let bound = { top: null, left: null, right: null, bottom: null };
                                      
                                      for (let i = 0; i < l; i += 4) {
                                          if (pixels.data[i + 3] > 0) {
                                              const x = (i / 4) % imgWidth;
                                              const y = Math.floor((i / 4) / imgWidth);
                                              
                                              if (bound.top === null) bound.top = y;
                                              else if (y < bound.top) bound.top = y;
                                              
                                              if (bound.left === null) bound.left = x;
                                              else if (x < bound.left) bound.left = x;
                                              
                                              if (bound.right === null) bound.right = x;
                                              else if (x > bound.right) bound.right = x;
                                              
                                              if (bound.bottom === null) bound.bottom = y;
                                              else if (y > bound.bottom) bound.bottom = y;
                                          }
                                      }
                                      
                                      if (bound.top === null) return canvas.toDataURL('image/png');
                                      
                                      const padding = 15;
                                      const startX = Math.max(0, bound.left - padding);
                                      const startY = Math.max(0, bound.top - padding);
                                      const endX = Math.min(imgWidth, bound.right + padding);
                                      const endY = Math.min(imgHeight, bound.bottom + padding);
                                      
                                      const trimWidth = endX - startX;
                                      const trimHeight = endY - startY;
                                      
                                      copy.width = trimWidth;
                                      copy.height = trimHeight;
                                      
                                      copyCtx.drawImage(
                                          canvas,
                                          startX,
                                          startY,
                                          trimWidth,
                                          trimHeight,
                                          0,
                                          0,
                                          trimWidth,
                                          trimHeight
                                      );
                                      
                                      return copy.toDataURL('image/png');
                                  },
                                  handleSubmit(e) {
                                      if (this.isEmpty) {
                                          alert('Silakan tanda tangan terlebih dahulu pada kanvas.');
                                          e.preventDefault();
                                          return false;
                                      }
                                      this.$refs.sigInput.value = this.trimCanvas(this.canvas);
                                  }
                              }" x-init="init()" @submit="handleSubmit($event)">
                            @csrf
                            <input type="hidden" name="signature_data" x-ref="sigInput">

                            <p class="text-[11px] font-bold text-amber-800 mb-1.5 uppercase tracking-wide">Kanvas Tanda Tangan:</p>
                            <div class="border-2 border-dashed border-amber-300 rounded-xl p-2 bg-white mb-2.5 overflow-hidden cursor-crosshair">
                                <canvas x-ref="sigCanvas"
                                    @mousedown="startDraw($event)"
                                    @mousemove="draw($event)"
                                    @mouseup="stopDraw()"
                                    @mouseleave="stopDraw()"
                                    @touchstart.prevent="startDraw($event)"
                                    @touchmove.prevent="draw($event)"
                                    @touchend="stopDraw()"
                                    class="w-full" style="touch-action: none;"></canvas>
                            </div>

                            <div class="flex gap-2 mb-3">
                                <button type="button" @click="clearCanvas()"
                                        class="flex-1 py-1.5 bg-amber-100/60 hover:bg-amber-100 text-amber-800 text-xs font-bold rounded-lg transition-colors">
                                    Hapus & Ulangi
                                </button>
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 py-2.5 bg-emerald-500 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors shadow-md shadow-emerald-500/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Setujui & Simpan TTD
                            </button>
                        </form>
                        {{-- Reject Form --}}
                        <form action="{{ route('proposals.reject', $pendingApproval->id) }}" method="POST"
                              x-data="{ confirm: false }">
                            @csrf
                            <div x-show="!confirm">
                                <button type="button" @click="confirm = true"
                                        class="w-full flex items-center justify-center gap-2 py-2 text-red-500 text-sm font-semibold rounded-xl border border-red-200 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak Proposal
                                </button>
                            </div>
                            <div x-show="!confirm" style="display:none"></div>
                            <div x-show="confirm" class="space-y-2" style="display:none">
                                <textarea name="rejection_reason" rows="2"
                                          placeholder="Alasan penolakan (wajib)..."
                                          class="w-full text-xs px-3 py-2 border border-red-200 rounded-lg focus:outline-none focus:border-red-400" required></textarea>
                                <button type="submit"
                                        class="w-full py-2 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors">
                                    Konfirmasi Tolak
                                </button>
                                <button type="button" @click="confirm = false"
                                        class="w-full py-2 text-gray-400 text-sm rounded-xl hover:bg-gray-100 transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    @elseif($userApproval && $userApproval->status === 'approved')
                        {{-- User ini sudah menyetujui --}}
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-700">Kamu sudah menyetujui proposal ini</p>
                                <p class="text-xs text-emerald-500 mt-0.5">Tanda tangan kamu sebagai {{ $roleLabels[$currentJabatan] ?? ucfirst($currentJabatan) }} sudah tercatat.</p>
                                @if($nextApproverRole)
                                    <p class="text-xs text-amber-600 mt-2">⏳ Menunggu TTD {{ $roleLabels[$nextApproverRole] ?? ucfirst($nextApproverRole) }}</p>
                                @endif
                            </div>
                        </div>
                    @elseif($pendingApproval)
                        {{-- Belum giliran user ini --}}
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-amber-700">Menunggu giliran persetujuan kamu</p>
                                <p class="text-xs text-amber-500 mt-0.5">Ada approval yang perlu diselesaikan terlebih dahulu sebelum giliran kamu sebagai {{ $roleLabels[$currentJabatan] ?? ucfirst($currentJabatan) }}.</p>
                            </div>
                        </div>
                    @else
                        {{-- User ini tidak memiliki approval slot --}}
                        <div class="text-center py-3">
                            <p class="text-sm text-gray-500 font-medium">Kamu tidak memiliki aksi persetujuan untuk proposal ini</p>
                        </div>
                    @endif
                </div>
            @elseif($proposal->status === 'approved')
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 text-center">
                    <svg class="w-10 h-10 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-bold text-emerald-700">Proposal Disetujui</p>
                    <p class="text-xs text-emerald-500 mt-1">Semua tanda tangan sudah lengkap</p>
                </div>
            @endif
        </div>

        {{-- Proposal Detail --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Ringkasan Proposal</h3>

            <div class="space-y-4">
                @if($proposal->description)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $proposal->description }}</p>
                    </div>
                @endif

                @if($proposal->kegiatan)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kegiatan</p>
                        <p class="text-sm text-gray-600">{{ $proposal->kegiatan }}</p>
                    </div>
                @endif

                @if($proposal->tujuan)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tujuan</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $proposal->tujuan }}</p>
                    </div>
                @endif

                @if($proposal->anggaran)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Anggaran</p>
                        <p class="text-sm font-bold text-gray-700">Rp {{ number_format($proposal->anggaran, 0, ',', '.') }}</p>
                    </div>
                @endif

                @if($proposal->tanggal_pelaksanaan)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Pelaksanaan</p>
                        <p class="text-sm text-gray-600">{{ $proposal->tanggal_pelaksanaan }}</p>
                    </div>
                @endif

                @if($proposal->tempat)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tempat</p>
                        <p class="text-sm text-gray-600">{{ $proposal->tempat }}</p>
                    </div>
                @endif
            </div>

            {{-- Timeline Approval --}}
            @if($proposal->approvals && $proposal->approvals->count() > 0)
                <div class="mt-6 pt-5 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-800 mb-4">Riwayat Persetujuan</h4>
                    <x-dashboard.timeline :approvals="$proposal->approvals" />
                </div>
            @endif
        </div>

    </div>

</x-layouts.dashboard-pembina>
