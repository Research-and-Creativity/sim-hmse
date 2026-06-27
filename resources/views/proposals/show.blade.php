<x-layouts.dashboard title="Detail Proposal">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('proposals.index') }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">{{ $proposal->title ?? 'Proposal Kegiatan' }}</h2>
            <p class="text-sm text-gray-400">{{ $proposal->proker ?? '-' }} · {{ $proposal->divisi ?? '-' }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.134 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Status Banner --}}
            @php
                $statusConfig = match($proposal->status) {
                    'draft' => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'icon_bg' => 'bg-gray-100', 'icon_color' => 'text-gray-500', 'text' => 'text-gray-700', 'sub' => 'text-gray-500', 'label' => 'Draft — Belum disubmit'],
                    'submitted', 'pending' => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'icon_bg' => 'bg-amber-100', 'icon_color' => 'text-amber-600', 'text' => 'text-amber-800', 'sub' => 'text-amber-600', 'label' => 'Menunggu Persetujuan'],
                    'approved' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'icon_bg' => 'bg-emerald-100', 'icon_color' => 'text-emerald-600', 'text' => 'text-emerald-800', 'sub' => 'text-emerald-600', 'label' => 'Proposal Disetujui'],
                    'rejected' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-500', 'text' => 'text-red-700', 'sub' => 'text-red-500', 'label' => 'Proposal Ditolak'],
                    default => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-500', 'text' => 'text-blue-700', 'sub' => 'text-blue-500', 'label' => ucfirst($proposal->status)],
                };
            @endphp
            <div class="{{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} border rounded-xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $statusConfig['icon_bg'] }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 {{ $statusConfig['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</p>
                    @if($nextApprover)
                        <p class="text-xs {{ $statusConfig['sub'] }} mt-0.5">Menunggu tanda tangan: {{ ucfirst(str_replace('_', ' ', $nextApprover)) }}</p>
                    @endif
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full
                    {{ $proposal->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                    {{ $proposal->status === 'draft' ? 'bg-gray-200 text-gray-600' : '' }}
                    {{ in_array($proposal->status, ['pending', 'submitted']) ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $proposal->status === 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                ">{{ ucfirst($proposal->status) }}</span>
            </div>

            {{-- Proposal Info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6" x-data="{ activeTab: 'content' }">
                <div class="flex border-b border-gray-100 mb-5 overflow-x-auto">
                    @foreach(['content' => 'Isi Proposal', 'approval' => 'Alur Persetujuan'] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                                :class="activeTab === '{{ $key }}' ? 'text-[#2C3DA6] border-[#2C3DA6]' : 'text-gray-400 border-transparent hover:text-gray-600'"
                                class="px-5 py-3 text-sm font-semibold border-b-2 transition-all whitespace-nowrap">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Tab: Content --}}
                <div x-show="activeTab === 'content'" class="space-y-5">
                    @foreach([
                        ['label' => 'Latar Belakang', 'value' => $proposal->background],
                        ['label' => 'Tujuan', 'value' => $proposal->objective],
                        ['label' => 'Deskripsi Risiko', 'value' => $proposal->risk_description],
                    ] as $section)
                        @if($section['value'])
                            <div>
                                <h4 class="text-sm font-bold text-gray-700 mb-2">{{ $section['label'] }}</h4>
                                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line bg-gray-50 rounded-lg p-4">{{ $section['value'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Tab: Approval Flow --}}
                <div x-show="activeTab === 'approval'" style="display: none;">
                    @if($approvals->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-gray-400">Belum ada alur persetujuan. Submit proposal terlebih dahulu.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($approvals as $approval)
                                <div class="flex items-center gap-4 p-4 rounded-xl border-2 transition-all
                                    {{ $approval->status === 'approved' ? 'border-emerald-200 bg-emerald-50/50' : '' }}
                                    {{ $approval->status === 'pending' ? 'border-gray-200 bg-gray-50/50' : '' }}
                                    {{ $approval->status === 'rejected' ? 'border-red-200 bg-red-50/50' : '' }}
                                ">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                        {{ $approval->status === 'approved' ? 'bg-emerald-100' : '' }}
                                        {{ $approval->status === 'pending' ? 'bg-gray-100' : '' }}
                                        {{ $approval->status === 'rejected' ? 'bg-red-100' : '' }}
                                    ">
                                        @if($approval->status === 'approved')
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        @elseif($approval->status === 'rejected')
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-700">{{ ucfirst(str_replace('_', ' ', $approval->approver_role)) }}</p>
                                        <p class="text-xs text-gray-400">Urutan ke-{{ $approval->approval_order }}</p>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full
                                        {{ $approval->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                        {{ $approval->status === 'pending' ? 'bg-gray-100 text-gray-500' : '' }}
                                        {{ $approval->status === 'rejected' ? 'bg-red-100 text-red-500' : '' }}
                                    ">{{ $approval->status === 'approved' ? '✓ Disetujui' : ($approval->status === 'rejected' ? '✗ Ditolak' : 'Menunggu') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Sidebar --}}
        <div class="space-y-6">

            {{-- Info Card --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    @foreach([
                        ['label' => 'Program Kerja', 'value' => $proposal->proker ?? '-'],
                        ['label' => 'Divisi', 'value' => $proposal->divisi ?? '-'],
                        ['label' => 'Tingkat Risiko', 'value' => $proposal->risk_level === 'high' ? 'Tinggi' : 'Rendah'],
                        ['label' => 'Anggaran', 'value' => 'Rp ' . number_format($proposal->budget ?? 0, 0, ',', '.')],
                        ['label' => 'Timeline', 'value' => $proposal->timeline ?? '-'],
                        ['label' => 'Dibuat', 'value' => $proposal->created_at?->format('d M Y, H:i') ?? '-'],
                    ] as $info)
                        <div class="flex justify-between gap-2">
                            <span class="text-gray-400">{{ $info['label'] }}</span>
                            <span class="font-semibold text-gray-700 text-right">{{ $info['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Aksi</h3>
                <div class="space-y-2">
                    @if($proposal->status === 'draft')
                        <a href="{{ route('proposals.edit', $proposal) }}"
                           class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-[#2C3DA6] bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Proposal
                        </a>
                        <form action="{{ route('proposals.submit', $proposal) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-md shadow-[#2C3DA6]/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Submit untuk Persetujuan
                            </button>
                        </form>
                    @endif

                    @if($proposal->file_path)
                        <a href="{{ route('proposals.download-pdf', $proposal) }}"
                           class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download PDF
                        </a>
                    @endif

                    <form action="{{ route('proposals.generate-pdf', $proposal) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Generate PDF
                        </button>
                    </form>
                </div>
            </div>

            {{-- Rejection Reason --}}
            @if($proposal->status === 'rejected' && $proposal->rejection_reason)
                <div class="bg-red-50 rounded-xl border border-red-200 p-5">
                    <h3 class="text-sm font-bold text-red-700 mb-2">Alasan Penolakan</h3>
                    <p class="text-sm text-red-600">{{ $proposal->rejection_reason }}</p>
                </div>
            @endif
        </div>
    </div>

</x-layouts.dashboard>
