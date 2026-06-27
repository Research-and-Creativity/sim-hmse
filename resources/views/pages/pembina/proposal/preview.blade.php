<x-layouts.dashboard-pembina title="Preview Proposal">

    @php
        $backUrl    = route('pembina.proposal.show', $proposal->id);
        $isFromForm = false;
    @endphp

    {{-- ───── ACTION BAR ───── --}}
    <div class="flex items-center gap-3 flex-wrap mb-5">

        {{-- Status badge --}}
        @php
            $roleLabels = [
                'ketua_panitia' => 'Ketua Panitia',
                'sekretaris'    => 'Sekretaris',
                'ketua_hmse'    => 'Ketua HMSE',
                'ketua_hima'    => 'Ketua HMSE',
                'pembina'       => 'Pembina',
                'kaprodi'       => 'Kaprodi',
            ];
            $nextRole = $proposal->getNextApproverRole();
            if ($proposal->status === 'approved') {
                $badgeLabel = 'Disetujui';
                $badgeClass = 'bg-emerald-50 border-emerald-200 text-emerald-700';
                $dotClass   = 'bg-emerald-500';
            } elseif ($proposal->status === 'rejected') {
                $badgeLabel = 'Ditolak';
                $badgeClass = 'bg-red-50 border-red-200 text-red-700';
                $dotClass   = 'bg-red-500';
            } elseif ($nextRole) {
                $badgeLabel = 'Menunggu TTD ' . ($roleLabels[$nextRole] ?? ucfirst($nextRole));
                $badgeClass = 'bg-amber-50 border-amber-200 text-amber-700';
                $dotClass   = 'bg-amber-500 animate-pulse';
            } else {
                $badgeLabel = ucfirst($proposal->status);
                $badgeClass = 'bg-blue-50 border-blue-200 text-blue-700';
                $dotClass   = 'bg-blue-500';
            }
        @endphp
        <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold border {{ $badgeClass }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
            {{ $badgeLabel }}
        </span>

        <div class="flex-1"></div>

        {{-- Download DOCX --}}
        <form action="{{ route('dashboard.proposal.download-docx') }}" method="POST" class="flex-shrink-0">
            @csrf
            <input type="hidden" name="title"               value="{{ $proposal->title }}">
            <input type="hidden" name="tema_kegiatan"       value="{{ $proposal->tema_kegiatan }}">
            <input type="hidden" name="jenis_kegiatan"      value="{{ $proposal->jenis_kegiatan }}">
            <input type="hidden" name="tanggal_pelaksanaan" value="{{ $proposal->tanggal_pelaksanaan }}">
            <input type="hidden" name="waktu_pelaksanaan"   value="{{ $proposal->waktu_pelaksanaan }}">
            <input type="hidden" name="tempat_pelaksanaan"  value="{{ $proposal->tempat_pelaksanaan }}">
            <input type="hidden" name="timeline"            value="{{ $proposal->timeline }}">
            <input type="hidden" name="background"          value="{{ $proposal->background }}">
            <input type="hidden" name="objective"           value="{{ $proposal->objective }}">
            <input type="hidden" name="manfaat_kegiatan"    value="{{ $proposal->manfaat_kegiatan }}">
            <input type="hidden" name="bentuk_kegiatan"     value="{{ $proposal->bentuk_kegiatan }}">
            <input type="hidden" name="sasaran_peserta"     value="{{ $proposal->sasaran_peserta }}">
            <input type="hidden" name="risk_level"          value="{{ $proposal->risk_level }}">
            <input type="hidden" name="risk_description"    value="{{ $proposal->risk_description }}">
            <input type="hidden" name="budget"              value="{{ $proposal->budget }}">
            <input type="hidden" name="penutup"             value="{{ $proposal->penutup }}">
            <input type="hidden" name="ketua_panitia"       value="{{ $proposal->ketua_panitia }}">
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2 text-sm font-bold text-white
                       bg-[#00C4D8] rounded-xl hover:bg-[#0891b2]
                       shadow-lg shadow-[#00C4D8]/20 hover:shadow-[#00C4D8]/30
                       hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download DOCX
            </button>
        </form>

        {{-- Kembali ke TTD --}}
        <a href="{{ $backUrl }}"
           class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2 text-sm font-bold
                  text-amber-700 bg-amber-50 border border-amber-200 rounded-xl
                  hover:bg-amber-100 hover:-translate-y-0.5 transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Kembali ke TTD
        </a>
    </div>

    {{-- ───── INFO BANNER ───── --}}
    <div class="flex items-center gap-4 px-5 py-4 mb-6 rounded-2xl
                bg-gradient-to-r from-cyan-50 to-blue-50
                border border-cyan-100">
        <div class="w-10 h-10 flex-shrink-0 rounded-xl
                    bg-[#00C4D8]/15 flex items-center justify-center">
            <svg class="w-5 h-5 text-[#00C4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-800">Pratinjau Dokumen Proposal</p>
            <p class="text-xs text-gray-500 mt-0.5">
                Ini adalah pratinjau isi proposal. Klik
                <span class="font-semibold text-amber-600">"Kembali ke TTD"</span>
                untuk menuju halaman persetujuan dan tanda tangan.
            </p>
        </div>
        <span class="hidden sm:inline-flex items-center gap-1.5 flex-shrink-0
                     px-3 py-1.5 rounded-xl text-[11px] font-semibold text-[#00C4D8]
                     bg-white border border-cyan-100 shadow-sm">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Mode Preview
        </span>
    </div>


    {{-- A4 Preview — reuse langsung dari view pengurus --}}
    @php
        // Set variabel yang dibutuhkan oleh view preview pengurus
        $isFromForm  = false;
        $proposalId  = $proposal->id;
        $backUrl     = route('pembina.proposal.show', $proposal->id);
        $formData    = null;

        // SOTK sudah dipass dari controller
        // Pastikan sotk tidak null untuk menghindari error
        $sotk = $sotk ?? [
            'pembina'    => null,
            'kaprodi'    => null,
            'ketua_hmse' => null,
            'sekretaris' => null,
        ];

        // Approvals (TTD) dari controller, keyed by approver_role
        $approvals = $approvals ?? collect();
    @endphp

    {{-- Embed isi konten A4 dari preview pengurus (tanpa layout wrapper-nya) --}}

    <div class="flex flex-col items-center gap-16 py-8">

        {{-- PAGE 1: COVER --}}
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">
            <div class="flex flex-col items-center min-h-[247mm] text-center pt-8">
                <div>
                    <p class="font-bold text-[14pt]">PROPOSAL KEGIATAN</p>
                    <p class="font-bold text-[14pt] text-red-600 mt-2">{{ strtoupper($proposal->title ?? 'NAMA KEGIATAN') }}</p>
                    <p class="font-bold text-[14pt] mt-2">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</p>
                </div>
                <div class="mt-16 text-center">
                    <img src="{{ asset('images/proposals/image1.png') }}" alt="Telkom University" class="h-32 w-auto object-contain mx-auto">
                    <p class="font-bold text-[#E3000F] text-[11pt] tracking-[0.15em] -mt-2">PURWOKERTO</p>
                </div>
                <div class="mt-16">
                    <img src="{{ asset('images/proposals/image2.jpg') }}" alt="HMSE" class="h-40 w-auto object-contain">
                </div>
                <div class="font-bold text-[14pt] mt-32">
                    <p class="mb-2">UNIT KEGIATAN MAHASISWA</p>
                    <p class="mb-2">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</p>
                    <p class="mb-2">TELKOM UNIVERSITY PURWOKERTO</p>
                    <p>{{ date('Y') }}</p>
                </div>
            </div>
        </div>

        {{-- PAGE 2: PROPOSAL BODY --}}
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">

            {{-- KOP SURAT --}}
            <div class="flex items-center justify-between border-b-[3px] border-black pb-4 mb-1">
                <div class="w-24 flex-shrink-0">
                    <img src="{{ asset('images/proposals/image1.png') }}" alt="Logo Telkom" class="w-full h-auto object-contain">
                </div>
                <div class="flex-1 text-center px-4">
                    <h2 class="text-[13pt] font-bold uppercase tracking-wide">Institut Teknologi Telkom Purwokerto</h2>
                    <h3 class="text-[12pt] font-bold uppercase tracking-wide">Fakultas Informatika</h3>
                    <h1 class="text-[14pt] font-black uppercase text-[#2C3DA6] tracking-wider mt-1 mb-1">Himpunan Mahasiswa Software Engineering</h1>
                    <p class="text-[10pt]">Kawasan Pendidikan Telkom, Jl. DI Panjaitan No.128, Purwokerto Selatan</p>
                    <p class="text-[10pt]">Kabupaten Banyumas, Jawa Tengah 53147</p>
                    <p class="text-[10pt] text-blue-800">Email: hmse@ittelkom-pwt.ac.id | Website: hmse.ittelkom-pwt.ac.id</p>
                </div>
                <div class="w-24 flex-shrink-0">
                    <img src="{{ asset('images/proposals/image2.jpg') }}" alt="Logo HMSE" class="w-full h-auto object-contain">
                </div>
            </div>
            <div class="border-b-[1px] border-black pb-1 mb-6"></div>

            <div class="mb-4">
                <p class="font-bold mb-1">A. Latar Belakang</p>
                <p class="ml-4 text-justify">{{ $proposal->background ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">B. Tema Kegiatan</p>
                <p class="ml-4 text-justify">Tema pada kegiatan ini adalah "{{ $proposal->tema_kegiatan ?? '-' }}".</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">C. Jenis Kegiatan</p>
                <p class="ml-4 text-justify">Jenis kegiatan ini adalah {{ $proposal->jenis_kegiatan ?? '-' }}.</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">D. Tujuan Kegiatan</p>
                <p class="ml-4 text-justify">{{ $proposal->objective ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">E. Manfaat Kegiatan</p>
                <p class="ml-4 text-justify">{{ $proposal->manfaat_kegiatan ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">F. Bentuk Kegiatan</p>
                <p class="ml-4 text-justify">{{ $proposal->bentuk_kegiatan ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">G. Sasaran Peserta</p>
                <p class="ml-4 text-justify">{{ $proposal->sasaran_peserta ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">H. Waktu dan Tempat</p>
                <p class="ml-4 mb-2">Kegiatan ini akan dilaksanakan pada:</p>
                <table class="ml-4 text-sm">
                    <tr>
                        <td class="pr-4">Tanggal Pelaksanaan</td>
                        <td class="pr-2">:</td>
                        <td>{{ $proposal->tanggal_pelaksanaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4">Waktu</td>
                        <td class="pr-2">:</td>
                        <td>{{ $proposal->waktu_pelaksanaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4">Tempat</td>
                        <td class="pr-2">:</td>
                        <td>{{ $proposal->tempat_pelaksanaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4">Timeline</td>
                        <td class="pr-2">:</td>
                        <td>{{ $proposal->timeline ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">I. Susunan Acara</p>
                <p class="ml-4">Terlampir (Lampiran III)</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">J. Susunan Panitia</p>
                <p class="ml-4">Terlampir (Lampiran I)</p>
            </div>
            <div class="mb-4">
                <p class="font-bold mb-1">K. Rencana Anggaran Dana</p>
                <p class="ml-4">Terlampir (Lampiran II)</p>
            </div>
            @if(($proposal->risk_level ?? 'low') === 'high')
                <div class="mb-4">
                    <p class="font-bold mb-1">L. Identifikasi dan Mitigasi Risiko</p>
                    <p class="ml-4 text-justify">{{ $proposal->risk_description }}</p>
                </div>
            @endif
            <div class="mb-8 mt-8">
                <p class="font-bold mb-2">{{ ($proposal->risk_level ?? 'low') === 'high' ? 'M. Penutup' : 'L. Penutup' }}</p>
                <p class="ml-4 text-justify">
                    {{ $proposal->penutup ?? 'Demikian proposal ini kami susun, besar harapan kami kegiatan ini dapat terlaksana dengan baik. Atas perhatian dan dukungannya kami ucapkan terima kasih.' }}
                </p>
            </div>
        </div>

        {{-- PAGE 3: HALAMAN PENGESAHAN --}}
        @php
            // Helper: cek apakah role tertentu sudah TTD
            $getSignature = function($role) use ($approvals) {
                $approval = $approvals[$role] ?? null;
                if (!$approval || $approval->status !== 'approved') return null;
                return $approval;
            };

            // Juga cek ketua_hima sebagai alias untuk ketua_hmse
            $ketuaApproval = $getSignature('ketua_hmse') ?? $getSignature('ketua_hima');
        @endphp
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">
            <div class="mt-8">
                <h2 class="text-center font-bold text-[12pt] mb-8">HALAMAN PENGESAHAN</h2>
                <p class="text-right mb-6 text-[11pt]">Purwokerto, ....................................</p>
                <div class="w-full text-center text-[11pt]">

                    {{-- Baris 1: Ketua Panitia & Sekretaris --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
                        {{-- Ketua Panitia --}}
                        <div>
                            <p class="mb-2">Ketua Panitia</p>
                            @php $kpApproval = $getSignature('ketua_panitia'); @endphp
                            @if($kpApproval && $kpApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $kpApproval->signature_data }}" alt="TTD Ketua Panitia" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $proposal->ketua_panitia ?? 'Nama Ketua Panitia' }}</p>
                            <p>NIM. ..........................</p>
                        </div>

                        {{-- Sekretaris --}}
                        <div>
                            <p class="mb-2">Sekretaris</p>
                            @php $sekApproval = $getSignature('sekretaris'); @endphp
                            @if($sekApproval && $sekApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $sekApproval->signature_data }}" alt="TTD Sekretaris" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $sotk['sekretaris']?->name ?? 'Nama Sekretaris' }}</p>
                            <p>NIM. {{ $sotk['sekretaris']?->nim_nip ?? '..........................' }}</p>
                        </div>
                    </div>

                    <p class="mb-6 font-bold">Menyetujui,</p>

                    {{-- Baris 2: Pembina & Ketua HMSE --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
                        {{-- Pembina --}}
                        <div>
                            <p>Pembina</p>
                            <p class="mb-2">Himpunan Mahasiswa Software Engineering</p>
                            @php $pembinaApproval = $getSignature('pembina'); @endphp
                            @if($pembinaApproval && $pembinaApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $pembinaApproval->signature_data }}" alt="TTD Pembina" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $sotk['pembina']?->name ?? 'Yudha Islami Sulistya, S.Kom., M.Cs' }}</p>
                            <p>NIDN. {{ $sotk['pembina']?->nim_nip ?? '0609020001' }}</p>
                        </div>

                        {{-- Ketua HMSE --}}
                        <div>
                            <p>Ketua</p>
                            <p class="mb-2">Himpunan Mahasiswa Software Engineering</p>
                            @if($ketuaApproval && $ketuaApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $ketuaApproval->signature_data }}" alt="TTD Ketua HMSE" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $sotk['ketua_hmse']?->name ?? 'Quratu Ayun Defaren' }}</p>
                            <p>NIM. {{ $sotk['ketua_hmse']?->nim_nip ?? '103122400064' }}</p>
                        </div>
                    </div>

                    <p class="mb-6 font-bold">Mengetahui,</p>

                    {{-- Baris 3: Kepala Urusan & Kaprodi --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
                        {{-- Kepala Urusan --}}
                        <div>
                            <p>Kepala Urusan</p>
                            <p class="mb-2">Kemahasiswaan, Karier dan Alumni</p>
                            <div class="flex items-center justify-center" style="min-height:80px;">
                                <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                            </div>
                            <p class="underline font-bold">Kadarisman, S.Si</p>
                            <p>NIP. 22960016</p>
                        </div>

                        {{-- Kaprodi --}}
                        <div>
                            <p>Ketua Program Studi</p>
                            <p class="mb-2">S1 Rekayasa Perangkat Lunak</p>
                            @php $kaprodiApproval = $getSignature('kaprodi'); @endphp
                            @if($kaprodiApproval && $kaprodiApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $kaprodiApproval->signature_data }}" alt="TTD Kaprodi" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $sotk['kaprodi']?->name ?? 'Abednego Dwi Septiadi, S.Kom., M.Kom' }}</p>
                            <p>NIP. {{ $sotk['kaprodi']?->nim_nip ?? '22890018' }}</p>
                        </div>
                    </div>

                    {{-- Wakil Direktur --}}
                    <div class="flex justify-center mt-8">
                        <div>
                            <p>Wakil Direktur</p>
                            <p class="mb-2">Bidang Akademik & Riset</p>
                            <div class="flex items-center justify-center" style="min-height:80px;">
                                <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                            </div>
                            <p class="underline font-bold">Dr. Catur Nugroho, S.Sos., M.I.Kom.</p>
                            <p>NIP. 14780035-1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard-pembina>
