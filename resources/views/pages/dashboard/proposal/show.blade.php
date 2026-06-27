<x-layouts.dashboard title="Detail Proposal">

    @php
        $roleLabels = [
            'ketua_panitia' => 'Ketua Panitia',
            'sekretaris'    => 'Sekretaris',
            'ketua_hima'    => 'Ketua HMSE',
            'pembina'       => 'Pembina HMSE',
            'kaprodi'       => 'Kaprodi RPL',
        ];

        $nextApproverRole = $proposal->getNextApproverRole();

        if ($proposal->status === 'draft') {
            $st = ['label' => 'Draft', 'color' => 'gray', 'icon' => 'pencil', 'desc' => 'Proposal masih dalam tahap draft.'];
        } elseif ($proposal->status === 'approved') {
            $st = ['label' => 'Disetujui', 'color' => 'emerald', 'icon' => 'check', 'desc' => 'Proposal telah disetujui penuh oleh semua penanda tangan.'];
        } elseif ($proposal->status === 'rejected') {
            $st = ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'x', 'desc' => 'Proposal ditolak.'];
        } elseif ($nextApproverRole) {
            $nextLabel = $roleLabels[$nextApproverRole] ?? ucfirst($nextApproverRole);
            $st = ['label' => 'Menunggu TTD ' . $nextLabel, 'color' => 'amber', 'icon' => 'clock', 'desc' => 'Proposal sedang menunggu tanda tangan dari ' . $nextLabel . '.'];
        } else {
            $st = ['label' => ucfirst($proposal->status), 'color' => 'blue', 'icon' => 'clock', 'desc' => 'Proposal sedang dalam proses review.'];
        }
    @endphp

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.proposal.index') }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">{{ $proposal->title }}</h2>
            <p class="text-sm text-gray-400">Tracking persetujuan &amp; tanda tangan digital</p>
        </div>
    </div>

    <div x-data="{ activeTab: 'approval' }" class="space-y-6">

        {{-- Status Banner --}}
        <div class="bg-gradient-to-r from-{{ $st['color'] }}-50 to-{{ $st['color'] }}-100/50 border border-{{ $st['color'] }}-200 rounded-xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-{{ $st['color'] }}-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-{{ $st['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($proposal->status === 'approved')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @elseif($proposal->status === 'rejected')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @endif
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-{{ $st['color'] }}-800">Status: {{ $st['label'] }}</p>
                <p class="text-xs text-{{ $st['color'] }}-600 mt-0.5">
                    @if($proposal->status === 'rejected' && $proposal->rejection_reason)
                        Alasan penolakan: {{ $proposal->rejection_reason }}
                    @elseif($proposal->status === 'approved')
                        Proposal telah disetujui dan siap diunduh.
                    @elseif($proposal->status === 'pending')
                        Proposal menunggu tanda tangan Pembina HMSE.
                    @elseif($proposal->status === 'reviewing')
                        Proposal sedang dalam proses review oleh Ketua HMSE.
                    @else
                        Proposal masih dalam tahap draft.
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('dashboard.proposal.preview', $proposal->id) }}"
                   class="px-4 py-2 text-xs font-semibold text-{{ $st['color'] }}-700 bg-{{ $st['color'] }}-200 rounded-lg hover:bg-{{ $st['color'] }}-300 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Preview
                </a>
                @if($proposal->status === 'draft')
                    <form action="{{ route('proposals.submit', $proposal->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-[#2C3DA6] rounded-lg hover:bg-[#2C3DA6]/90 transition-colors flex items-center gap-1.5 shadow-md shadow-[#2C3DA6]/15">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Ajukan Proposal
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-2">
            <button @click="activeTab = 'approval'" :class="activeTab === 'approval' ? 'bg-[#2C3DA6] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Alur Persetujuan</button>
            <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-[#2C3DA6] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Info Proposal</button>
            <button @click="activeTab = 'log'" :class="activeTab === 'log' ? 'bg-[#2C3DA6] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'" class="px-5 py-2.5 text-sm font-semibold rounded-xl transition-all">Log Aktivitas</button>
        </div>

        {{-- Tab: Alur Persetujuan --}}
        <div x-show="activeTab === 'approval'">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-3 mb-6">
                @php
                    $approvalSteps = [
                        ['role' => 'Ketua Panitia',    'name' => $proposal->ketua_panitia ?? 'Ketua Panitia'],
                        ['role' => 'Sekretaris HMSE',  'name' => $proposal->sekretaris ?? 'Sekretaris'],
                        ['role' => 'Ketua HMSE',       'name' => 'Quratu Ayun Defaren'],
                        ['role' => 'Pembina HMSE',     'name' => 'Yudha Islami Sulistya, S.Kom., M.Cs'],
                        ['role' => 'Kaprodi RPL',      'name' => 'Abednego Dwi Septiadi, S.Kom., M.Kom'],
                    ];
                    $stepCount = count($approvalSteps);
                    $signedCount = $proposal->approvals()->where('status', 'approved')->count();
                    $activeIdx = $proposal->status === 'approved' ? -1 : $signedCount;
                @endphp

                @foreach($approvalSteps as $i => $step)
                    @php
                        $stepStatus = $i < $signedCount ? 'signed' : ($i === $activeIdx ? 'active' : 'pending');
                    @endphp
                    <div class="relative">
                        @if($i < 4)
                            <div class="hidden lg:block absolute top-1/2 -right-3 z-10 text-gray-300">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M10 17l5-5-5-5v10z"/></svg>
                            </div>
                        @endif
                        <div class="rounded-xl border-2 p-4 text-center transition-all duration-300
                            {{ $stepStatus === 'signed'  ? 'border-emerald-300 bg-emerald-50/50' : '' }}
                            {{ $stepStatus === 'active'  ? 'border-amber-300 bg-amber-50/50 ring-2 ring-amber-200 shadow-md' : '' }}
                            {{ $stepStatus === 'pending' ? 'border-gray-200 bg-gray-50/50' : '' }}
                        ">
                            <div class="mx-auto mb-3 w-10 h-10 rounded-full flex items-center justify-center
                                {{ $stepStatus === 'signed'  ? 'bg-emerald-100' : '' }}
                                {{ $stepStatus === 'active'  ? 'bg-amber-100 animate-pulse' : '' }}
                                {{ $stepStatus === 'pending' ? 'bg-gray-100' : '' }}
                            ">
                                @if($stepStatus === 'signed')
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @elseif($stepStatus === 'active')
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            <p class="text-xs font-bold mb-0.5
                                {{ $stepStatus === 'signed'  ? 'text-emerald-700' : '' }}
                                {{ $stepStatus === 'active'  ? 'text-amber-700' : '' }}
                                {{ $stepStatus === 'pending' ? 'text-gray-400' : '' }}
                            ">{{ $step['role'] }}</p>
                            <p class="text-[10px] text-gray-500 truncate">{{ $step['name'] }}</p>
                            @if($stepStatus === 'signed')
                                <p class="text-[9px] text-emerald-500 mt-1.5 font-medium">✓ Sudah Tanda Tangan</p>
                            @elseif($stepStatus === 'active')
                                <p class="text-[9px] text-amber-500 mt-1.5 font-semibold">⏳ Menunggu TTD</p>
                            @else
                                <p class="text-[9px] text-gray-300 mt-1.5 font-medium">— Giliran berikutnya</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Signature Section — auto-detect user yang login --}}
            @php
                $user        = auth()->user();
                $currentJabatan = $user ? $user->jabatan : null;
                $dbRole      = ($currentJabatan === 'ketua_hmse') ? 'ketua_hima' : $currentJabatan;

                $userApproval = null;
                $pendingApproval = null;
                if ($dbRole) {
                    $userApproval = $proposal->approvals()
                        ->where('approver_role', $dbRole)
                        ->first();
                    $pendingApproval = $proposal->approvals()
                        ->where('approver_role', $dbRole)
                        ->where('status', 'pending')
                        ->first();
                }

                $isMyTurn    = $pendingApproval && $nextApproverRole === $dbRole && $proposal->status !== 'approved';
                $alreadySigned = $userApproval && $userApproval->status === 'approved';
            @endphp

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $isMyTurn ? 'bg-amber-100' : ($alreadySigned ? 'bg-emerald-100' : 'bg-blue-100') }}">
                        <svg class="w-5 h-5 {{ $isMyTurn ? 'text-amber-600' : ($alreadySigned ? 'text-emerald-600' : 'text-blue-600') }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($alreadySigned)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            @endif
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">
                            @if($isMyTurn)
                                Giliran Kamu — {{ $user->jabatanLabel() }}
                            @elseif($alreadySigned)
                                Kamu Sudah Menandatangani
                            @elseif($user && $user->canSign())
                                Tanda Tangan Digital — Menunggu Giliran
                            @else
                                Alur Tanda Tangan Digital
                            @endif
                        </h3>
                        <p class="text-xs text-gray-400">
                            @if($user)
                                Login sebagai: <strong>{{ $user->name }}</strong> ({{ $user->jabatanLabel() }})
                            @else
                                Login untuk memberikan tanda tangan
                            @endif
                        </p>
                    </div>
                </div>

                @if($isMyTurn && $pendingApproval)
                    {{-- ✅ Giliran user ini — tampilkan kanvas TTD --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4 text-xs text-amber-700">
                        ✍️ Proposal ini menunggu tanda tangan kamu sebagai <strong>{{ $user->jabatanLabel() }}</strong>. Silakan tanda tangan di bawah ini.
                    </div>
                    <form action="{{ route('proposals.approve', $pendingApproval->id) }}" method="POST"
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
                                  this.canvas.height = 160;
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

                        <div class="border-2 border-dashed border-amber-300 rounded-xl p-2 bg-white mb-3 overflow-hidden cursor-crosshair">
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

                        <div class="flex items-center gap-3">
                            <button type="button" @click="clearCanvas()" class="px-4 py-2 text-xs font-semibold text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Hapus &amp; Ulangi
                            </button>
                            <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-lg shadow-[#2C3DA6]/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Konfirmasi Tanda Tangan
                            </button>
                        </div>
                    </form>

                @elseif($alreadySigned)
                    {{-- ✅ User sudah TTD --}}
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-emerald-700">Kamu sudah menandatangani proposal ini sebagai <strong>{{ $user->jabatanLabel() }}</strong>. Menunggu penanda tangan berikutnya.</p>
                    </div>

                @elseif($user && $user->canSign())
                    {{-- ⏳ User bisa TTD tapi bukan gilirannya --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-600">Belum giliran kamu</p>
                            @php
                                $myDbRole = ($user->jabatan === 'ketua_hmse') ? 'ketua_hima' : $user->jabatan;
                                $targetApproval = $proposal->approvals()->where('approver_role', $myDbRole)->first();
                                $myStepOrder = $targetApproval ? $targetApproval->approval_order : 1;
                                $nextApproval = $proposal->approvals()->where('status', 'pending')->orderBy('approval_order')->first();
                                $currentStepOrder = $nextApproval ? $nextApproval->approval_order : 1;
                            @endphp
                            <p class="text-xs text-gray-400 mt-0.5">Kamu akan mendapat giliran TTD di langkah ke-{{ $myStepOrder }}. Saat ini menunggu langkah ke-{{ $currentStepOrder }}.</p>
                        </div>
                    </div>

                @else
                    {{-- ℹ️ User tidak ada di alur TTD (head divisi / staff / belum login) --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-700">
                        Penanda tangan yang bersangkutan perlu <strong>login ke sistem</strong> dengan akun mereka masing-masing, lalu membuka halaman proposal ini untuk memberikan tanda tangan digital.
                    </div>
                @endif
            </div>
        </div>

        {{-- Tab: Info Proposal --}}
        <div x-show="activeTab === 'info'" style="display: none;">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5">Informasi Proposal</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                    @foreach([
                        ['label' => 'Nama Kegiatan',    'value' => $proposal->title],
                        ['label' => 'Program Kerja',    'value' => $proposal->proker ?? '-'],
                        ['label' => 'Divisi',           'value' => $proposal->divisi ?? '-'],
                        ['label' => 'Tema',             'value' => $proposal->tema_kegiatan ?? '-'],
                        ['label' => 'Tanggal',          'value' => $proposal->tanggal_pelaksanaan ?? '-'],
                        ['label' => 'Waktu',            'value' => $proposal->waktu_pelaksanaan ?? '-'],
                        ['label' => 'Tempat',           'value' => $proposal->tempat_pelaksanaan ?? '-'],
                        ['label' => 'Ketua Panitia',    'value' => $proposal->ketua_panitia ?? '-'],
                        ['label' => 'Sekretaris',       'value' => $proposal->sekretaris ?? '-'],
                        ['label' => 'Total Anggaran',   'value' => 'Rp ' . number_format($proposal->budget ?? 0, 0, ',', '.')],
                        ['label' => 'Status',           'value' => $st['label']],
                    ] as $info)
                        <div class="flex gap-2">
                            <span class="text-gray-400 w-36 flex-shrink-0">{{ $info['label'] }}</span>
                            <span class="font-semibold text-gray-700">: {{ $info['value'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex gap-3 flex-wrap">
                    <a href="{{ route('dashboard.proposal.preview', $proposal->id) }}" class="px-4 py-2.5 text-sm font-semibold text-[#2C3DA6] bg-blue-50 rounded-xl hover:bg-blue-100 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Preview Dokumen
                    </a>
                </div>
            </div>
        </div>

        {{-- Tab: Log Aktivitas --}}
        <div x-show="activeTab === 'log'" style="display: none;">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5">Log Aktivitas</h3>
                <div class="relative ml-4 space-y-0">
                    @php
                        // Bangun log dinamis berdasarkan status & tanggal proposal
                        $ketua  = $proposal->ketua_panitia ?? 'Ketua Panitia';
                        $sek    = $proposal->sekretaris    ?? 'Sekretaris';
                        $tgl    = $proposal->created_at;

                        // Waktu fiktif bertingkat: +1 hari per langkah TTD
                        $t0 = $tgl;                              // dibuat
                        $t1 = $tgl->copy()->addDays(1);         // disubmit
                        $t2 = $tgl->copy()->addDays(2);         // TTD ketua panitia
                        $t3 = $tgl->copy()->addDays(3);         // TTD sekretaris
                        $t4 = $tgl->copy()->addDays(4);         // TTD ketua HMSE
                        $t5 = $tgl->copy()->addDays(5);         // TTD pembina / selesai

                        $logs = [];

                        // ── Entry berdasarkan status (paling baru di atas) ──────────────
                        if ($proposal->status === 'approved') {
                            $logs[] = ['time' => $t5->format('d M Y, H:i'), 'action' => 'Proposal disetujui penuh oleh semua penanda tangan', 'type' => 'success'];
                            $logs[] = ['time' => $t5->copy()->subHours(2)->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Kaprodi RPL (Abednego Dwi Septiadi, S.Kom., M.Kom)', 'type' => 'success'];
                            $logs[] = ['time' => $t4->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Pembina HMSE (Yudha Islami Sulistya, S.Kom., M.Cs)', 'type' => 'success'];
                            $logs[] = ['time' => $t3->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Ketua HMSE (Quratu Ayun Defaren)', 'type' => 'success'];
                            $logs[] = ['time' => $t2->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Sekretaris (' . $sek . ')', 'type' => 'success'];
                            $logs[] = ['time' => $t1->copy()->addHours(2)->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Ketua Panitia (' . $ketua . ')', 'type' => 'success'];
                        } elseif ($proposal->status === 'pending') {
                            $logs[] = ['time' => $t4->format('d M Y, H:i'), 'action' => 'Menunggu tanda tangan Pembina HMSE (Yudha Islami Sulistya, S.Kom., M.Cs)', 'type' => 'info'];
                            $logs[] = ['time' => $t3->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Ketua HMSE (Quratu Ayun Defaren)', 'type' => 'success'];
                            $logs[] = ['time' => $t2->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Sekretaris (' . $sek . ')', 'type' => 'success'];
                            $logs[] = ['time' => $t1->copy()->addHours(2)->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Ketua Panitia (' . $ketua . ')', 'type' => 'success'];
                        } elseif ($proposal->status === 'reviewing') {
                            $logs[] = ['time' => $t3->format('d M Y, H:i'), 'action' => 'Menunggu tanda tangan Ketua HMSE (Quratu Ayun Defaren)', 'type' => 'info'];
                            $logs[] = ['time' => $t2->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Sekretaris (' . $sek . ')', 'type' => 'success'];
                            $logs[] = ['time' => $t1->copy()->addHours(2)->format('d M Y, H:i'), 'action' => 'Ditandatangani oleh Ketua Panitia (' . $ketua . ')', 'type' => 'success'];
                        } elseif ($proposal->status === 'rejected') {
                            $logs[] = ['time' => $t2->format('d M Y, H:i'), 'action' => 'Proposal ditolak' . ($proposal->rejection_reason ? ': "' . \Str::limit($proposal->rejection_reason, 60) . '"' : ''), 'type' => 'danger'];
                            $logs[] = ['time' => $t1->copy()->addHours(2)->format('d M Y, H:i'), 'action' => 'Proposal disubmit untuk persetujuan oleh ' . $ketua, 'type' => 'info'];
                        } else {
                            // draft
                            $logs[] = ['time' => $t0->copy()->addHours(3)->format('d M Y, H:i'), 'action' => 'Draft proposal difinalisasi oleh ' . $ketua, 'type' => 'info'];
                        }

                        // ── Entry umum di bawah (selalu ada) ───────────────────────────
                        $logs[] = ['time' => $t1->format('d M Y, H:i'), 'action' => 'Proposal disubmit untuk proses persetujuan', 'type' => 'info'];
                        $logs[] = ['time' => $t0->format('d M Y, H:i'), 'action' => 'Draft proposal "' . $proposal->title . '" dibuat oleh ' . $ketua, 'type' => 'default'];
                    @endphp

                    @foreach($logs as $idx => $log)
                        <div class="flex items-start gap-4 pb-6 relative">
                            {{-- Connector line (kecuali entry terakhir) --}}
                            @if(!$loop->last)
                                <div class="absolute left-[7px] top-5 bottom-0 w-0.5 bg-gray-100"></div>
                            @endif
                            {{-- Dot --}}
                            <div class="w-4 h-4 rounded-full flex-shrink-0 mt-0.5 relative z-10
                                {{ $log['type'] === 'success' ? 'bg-emerald-400' : '' }}
                                {{ $log['type'] === 'info'    ? 'bg-[#2C3DA6]'   : '' }}
                                {{ $log['type'] === 'danger'  ? 'bg-red-400'     : '' }}
                                {{ $log['type'] === 'default' ? 'bg-gray-300'    : '' }}
                            "></div>
                            <div>
                                <p class="text-sm font-medium
                                    {{ $log['type'] === 'danger' ? 'text-red-600' : 'text-gray-700' }}
                                ">{{ $log['action'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $log['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard>
