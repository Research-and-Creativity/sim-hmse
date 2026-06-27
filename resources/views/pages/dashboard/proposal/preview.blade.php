<x-layouts.dashboard title="Preview Proposal">

    @php
        // Deteksi apakah preview dari form create (plain object) atau dari DB (Eloquent model)
        $isFromForm  = !isset($proposal->id) || $proposal->id === null;
        $proposalId  = $isFromForm ? null : $proposal->id;
        $backUrl     = $isFromForm
            ? route('dashboard.proposal.create')
            : route('dashboard.proposal.show', $proposalId);
    @endphp

    {{-- Top Action Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ $backUrl }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-black text-gray-800">Preview Proposal</h2>
                <p class="text-sm text-gray-400">{{ $isFromForm ? 'Preview sementara — belum disimpan' : 'Periksa sebelum finalisasi' }}</p>
            </div>
        </div>

        {{-- Download DOCX Button --}}
        <div class="flex gap-3">
            <form action="{{ route('dashboard.proposal.download-docx') }}" method="POST">
                @csrf
                @if(isset($formData))
                    @foreach($formData as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                @elseif(!$isFromForm)
                    {{-- Preview dari DB: kirim semua field proposal sebagai form data --}}
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
                @endif
                <button type="submit"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-[#2C3DA6] rounded-xl hover:bg-[#2C3DA6]/90 shadow-lg shadow-[#2C3DA6]/20 transition-all hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    📄 Download DOCX (Template HMSE)
                </button>
            </form>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3">
        <svg class="w-5 h-5 text-[#2C3DA6] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-[#2C3DA6]">Preview & Download Template</p>
            <p class="text-xs text-gray-500 mt-0.5">Ini adalah preview HTML dari data proposal. Klik tombol <strong>"Download DOCX"</strong> di atas untuk mengunduh dokumen proposal menggunakan template resmi HMSE ({{ ($proposal->risk_level ?? 'low') === 'high' ? 'Risiko Tinggi' : 'Risiko Sedang/Rendah' }}).</p>
        </div>
    </div>

    {{-- A4 Preview --}}
    <div class="flex flex-col items-center gap-16 py-8">
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">

            {{-- COVER PAGE --}}
            <div class="flex flex-col items-center min-h-[247mm] text-center pt-8">
                {{-- Top Text --}}
                <div>
                    <p class="font-bold text-[14pt]">PROPOSAL KEGIATAN</p>
                    <p class="font-bold text-[14pt] text-red-600 mt-2">{{ strtoupper($proposal->title ?? 'NAMA KEGIATAN') }}</p>
                    <p class="font-bold text-[14pt] mt-2">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</p>
                </div>

                {{-- Telkom Logo --}}
                <div class="mt-16 text-center">
                    <img src="{{ asset('images/proposals/image1.png') }}" alt="Telkom University" class="h-32 w-auto object-contain mx-auto">
                    <p class="font-bold text-[#E3000F] text-[11pt] tracking-[0.15em] -mt-2">PURWOKERTO</p>
                </div>

                {{-- HMSE Logo --}}
                <div class="mt-16">
                    <img src="{{ asset('images/proposals/image2.jpg') }}" alt="HMSE" class="h-40 w-auto object-contain">
                </div>

                {{-- Bottom Text --}}
                <div class="font-bold text-[14pt] mt-32">
                    <p class="mb-2">UNIT KEGIATAN MAHASISWA</p>
                    <p class="mb-2">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</p>
                    <p class="mb-2">TELKOM UNIVERSITY PURWOKERTO</p>
                    <p>2026</p>
                </div>
            </div>
        </div>

        {{-- PAGE 2: PROPOSAL BODY --}}
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">

            {{-- HEADER / KOP SURAT --}}
            <div class="flex items-center justify-between border-b-[3px] border-black pb-4 mb-1">
                {{-- Logo Kiri (Telkom) --}}
                <div class="w-24 flex-shrink-0">
                    <img src="{{ asset('images/proposals/image1.png') }}" alt="Logo Telkom" class="w-full h-auto object-contain">
                </div>
                
                {{-- Teks Tengah --}}
                <div class="flex-1 text-center px-4">
                    <h2 class="text-[13pt] font-bold uppercase tracking-wide">Institut Teknologi Telkom Purwokerto</h2>
                    <h3 class="text-[12pt] font-bold uppercase tracking-wide">Fakultas Informatika</h3>
                    <h1 class="text-[14pt] font-black uppercase text-[#2C3DA6] tracking-wider mt-1 mb-1">Himpunan Mahasiswa Software Engineering</h1>
                    <p class="text-[10pt]">Kawasan Pendidikan Telkom, Jl. DI Panjaitan No.128, Purwokerto Selatan</p>
                    <p class="text-[10pt]">Kabupaten Banyumas, Jawa Tengah 53147</p>
                    <p class="text-[10pt] text-blue-800">Email: hmse@ittelkom-pwt.ac.id | Website: hmse.ittelkom-pwt.ac.id</p>
                </div>

                {{-- Logo Kanan (HMSE) --}}
                <div class="w-24 flex-shrink-0">
                    <img src="{{ asset('images/proposals/image2.jpg') }}" alt="Logo HMSE" class="w-full h-auto object-contain">
                </div>
            </div>
            <div class="border-b-[1px] border-black pb-1 mb-6"></div>

            {{-- Section A: Latar Belakang --}}
            <div class="mb-4">
                <p class="font-bold mb-1">A. Latar Belakang</p>
                <p class="ml-4 text-justify">{{ $proposal->background ?? '-' }}</p>
            </div>

            {{-- Section B: Tema Kegiatan --}}
            <div class="mb-4">
                <p class="font-bold mb-1">B. Tema Kegiatan</p>
                <p class="ml-4 text-justify">Tema pada kegiatan ini adalah "{{ $proposal->tema_kegiatan ?? '-' }}".</p>
            </div>

            {{-- Section C: Jenis Kegiatan --}}
            <div class="mb-4">
                <p class="font-bold mb-1">C. Jenis Kegiatan</p>
                <p class="ml-4 text-justify">Jenis kegiatan ini adalah {{ $proposal->jenis_kegiatan ?? '-' }}.</p>
            </div>

            {{-- Section D: Tujuan Kegiatan --}}
            <div class="mb-4">
                <p class="font-bold mb-1">D. Tujuan Kegiatan</p>
                <p class="ml-4 text-justify">Tujuan dari kegiatan ini adalah: {{ $proposal->objective ?? '-' }}</p>
            </div>

            {{-- Section E: Manfaat Kegiatan --}}
            <div class="mb-4">
                <p class="font-bold mb-1">E. Manfaat Kegiatan</p>
                <p class="ml-4 text-justify">{{ $proposal->manfaat_kegiatan ?? '-' }}</p>
            </div>

            {{-- Section F: Bentuk Kegiatan --}}
            <div class="mb-4">
                <p class="font-bold mb-1">F. Bentuk Kegiatan</p>
                <p class="ml-4 text-justify">{{ $proposal->bentuk_kegiatan ?? '-' }}</p>
            </div>

            {{-- Section G: Sasaran Peserta --}}
            <div class="mb-4">
                <p class="font-bold mb-1">G. Sasaran Peserta</p>
                <p class="ml-4 text-justify">{{ $proposal->sasaran_peserta ?? '-' }}</p>
            </div>

            {{-- Section H: Waktu dan Tempat --}}
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
                        <td class="pr-4">Timeline Pelaksanaan</td>
                        <td class="pr-2">:</td>
                        <td>{{ $proposal->timeline ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Section I: Susunan Acara --}}
            <div class="mb-4">
                <p class="font-bold mb-1">I. Susunan Acara</p>
                <p class="ml-4 text-justify">Terlampir (Lampiran III)</p>
            </div>

            {{-- Section J: Susunan Panitia --}}
            <div class="mb-4">
                <p class="font-bold mb-1">J. Susunan Panitia</p>
                <p class="ml-4 text-justify">Terlampir (Lampiran I)</p>
            </div>

            {{-- Section K: Rencana Anggaran Dana --}}
            <div class="mb-4">
                <p class="font-bold mb-1">K. Rencana Anggaran Dana</p>
                <p class="ml-4 text-justify">Terlampir (Lampiran II)</p>
            </div>

            @if(($proposal->risk_level ?? 'low') === 'high')
            {{-- Section L: Mitigasi Risiko --}}
            <div class="mb-4">
                <p class="font-bold mb-1">L. Identifikasi dan Mitigasi Risiko</p>
                <p class="ml-4 text-justify">{{ $proposal->risk_description }}</p>
            </div>
            @endif

            {{-- Penutup --}}
            <div class="mb-8 mt-8">
                <p class="font-bold mb-2">{{ ($proposal->risk_level ?? 'low') === 'high' ? 'M. Penutup' : 'L. Penutup' }}</p>
                <p class="ml-4 text-justify">
                    {{ $proposal->penutup ?? 'Demikian proposal ini kami susun, besar harapan kami kegiatan ini dapat terlaksana dengan baik. Atas perhatian dan dukungannya kami ucapkan terima kasih.' }}
                </p>
            </div>
        </div>

        {{-- PAGE: HALAMAN PENGESAHAN --}}
        @php
            $approvals = $approvals ?? collect();
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
            {{-- HALAMAN PENGESAHAN --}}
            <div class="mt-8">
                <h2 class="text-center font-bold text-[12pt] mb-8">HALAMAN PENGESAHAN</h2>
                <p class="text-right mb-6 text-[11pt]">Purwokerto, ....................................</p>

                <div class="w-full text-center text-[11pt]">
                    {{-- Row 1: Panitia --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
                        <div>
                            <p class="mb-2">Ketua Panitia</p>
                            @php
                                $ketuaName = $proposal->ketua_panitia ?? 'Nama Ketua';
                                $ketuaNim = 'NIM. ..........................';
                                if (isset($formData['panitia_jabatan'])) {
                                    foreach ($formData['panitia_jabatan'] as $index => $jabatan) {
                                        if (strtolower(trim($jabatan)) === 'ketua panitia') {
                                            $ketuaName = $formData['panitia_nama'][$index];
                                            $ketuaNim = 'NIM. ' . $formData['panitia_nim'][$index];
                                            break;
                                        }
                                    }
                                }
                                $kpApproval = $getSignature('ketua_panitia');
                            @endphp
                            @if($kpApproval && $kpApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $kpApproval->signature_data }}" alt="TTD Ketua Panitia" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $ketuaName }}</p>
                            <p>{{ $ketuaNim }}</p>
                        </div>
                        <div>
                            <p class="mb-2">Sekretaris</p>
                            @php
                                $sekretarisName = $sotk['sekretaris']->name ?? 'Nama Sekretaris';
                                $sekretarisNim = isset($sotk['sekretaris']->nim_nip) ? 'NIM. ' . $sotk['sekretaris']->nim_nip : 'NIM. ..........................';
                                if (isset($formData['panitia_jabatan'])) {
                                    foreach ($formData['panitia_jabatan'] as $index => $jabatan) {
                                        if (strtolower(trim($jabatan)) === 'sekretaris') {
                                            $sekretarisName = $formData['panitia_nama'][$index];
                                            $sekretarisNim = 'NIM. ' . $formData['panitia_nim'][$index];
                                            break;
                                        }
                                    }
                                }
                                $sekApproval = $getSignature('sekretaris');
                            @endphp
                            @if($sekApproval && $sekApproval->signature_data)
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <img src="{{ $sekApproval->signature_data }}" alt="TTD Sekretaris" style="height:60px; max-width:140px; object-fit:contain;">
                                </div>
                            @else
                                <div class="flex items-center justify-center" style="height:80px;">
                                    <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                                </div>
                            @endif
                            <p class="underline font-bold">{{ $sekretarisName }}</p>
                            <p>{{ $sekretarisNim }}</p>
                        </div>
                    </div>

                    <p class="mb-6 font-bold">Menyetujui,</p>

                    {{-- Row 2: Pembina & Ketua Hima --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
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
                            <p class="underline font-bold">{{ $sotk['pembina']->name ?? 'Yudha Islami Sulistya, S.Kom., M.Cs' }}</p>
                            <p>NIDN. {{ $sotk['pembina']->nim_nip ?? '0609020001' }}</p>
                        </div>
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
                            <p class="underline font-bold">{{ $sotk['ketua_hmse']->name ?? 'Quratu Ayun Defaren' }}</p>
                            <p>NIM. {{ $sotk['ketua_hmse']->nim_nip ?? '103122400064' }}</p>
                        </div>
                    </div>

                    <p class="mb-6 font-bold">Mengetahui,</p>

                    {{-- Row 3: Kemahasiswaan & Kaprodi --}}
                    <div class="grid grid-cols-2 gap-8 mb-6">
                        <div>
                            <p>Kepala Urusan</p>
                            <p class="mb-2">Kemahasiswaan, Karier dan Alumni</p>
                            <div class="flex items-center justify-center" style="min-height:80px;">
                                <span class="text-gray-300 text-xs italic">— belum ditandatangani —</span>
                            </div>
                            <p class="underline font-bold">Kadarisman, S.Si</p>
                            <p>NIP. 22960016</p>
                        </div>
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
                            <p class="underline font-bold">{{ $sotk['kaprodi']->name ?? 'Abednego Dwi Septiadi, S.Kom., M.Kom' }}</p>
                            <p>NIP. {{ $sotk['kaprodi']->nim_nip ?? '22890018' }}</p>
                        </div>
                    </div>

                    {{-- Row 4: Wadir --}}
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

        {{-- PAGE: LAMPIRAN I --}}
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">
            {{-- LAMPIRAN I: Susunan Panitia --}}
            <div class="mt-8">
                <p class="mb-4">Lampiran I Susunan Panitia Institusi Berisiko Sedang/Rendah</p>
                
                <div class="text-center mb-8">
                    <h2 class="font-bold underline text-[12pt]">SUSUNAN PANITIA KEGIATAN</h2>
                    <h3 class="font-bold text-[12pt] mt-1">{{ strtoupper($proposal->title ?? 'NAMA KEGIATAN') }}</h3>
                    <h3 class="font-bold text-[12pt]">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</h3>
                    <h3 class="font-bold text-[12pt]">TELKOM UNIVERSITY PURWOKERTO</h3>
                </div>

                <table class="w-full text-sm">
                    <tr><td class="w-48 py-1">Pelindung</td><td class="w-4">:</td><td>Wakil Direktur Bidang Akademik & Riset</td></tr>
                    <tr><td class="py-1">Pengarah</td><td>:</td><td>Kepala Urusan Kemahasiswaan, Karier dan Alumni</td></tr>
                    <tr><td class="py-1">Penanggung Jawab</td><td>:</td><td>Kepala Program Studi</td></tr>
                    
                    <tr><td class="py-1 align-top">Pembina</td><td class="align-top">:</td>
                        <td>
                            <div class="flex"><span class="w-6">1.</span><span>Yudha Islami Sulistya, S.Kom,.M.Cs<br>[NIDN. 0609020001]</span></div>
                            <div class="flex mt-2"><span class="w-6">2.</span><span>Gita Fadila Fitriana, S.Kom., M.Kom.<br>[NIDN.0620039302]</span></div>
                        </td>
                    </tr>
                    
                    <tr><td class="py-1 align-top pt-4 font-bold" colspan="3">Steering Committee</td></tr>
                    <tr><td class="py-1 align-top"></td><td class="align-top"></td>
                        <td>
                            <div class="flex"><span class="w-6">1.</span><span>Quratu Ayun Defaren<br>[NIM. 103122400064]</span></div>
                            <div class="flex mt-2"><span class="w-6">2.</span><span>Muhammad Rasyid Ridho<br>[NIM. 103122400018]</span></div>
                            <div class="flex mt-2"><span class="w-6">3.</span><span>[Nama Kadep Proker]<br>[NIM]</span></div>
                        </td>
                    </tr>

                    <tr><td class="py-1 align-top pt-4 font-bold" colspan="3">Pelaksana</td></tr>
                    @if(isset($formData['panitia_jabatan']))
                        @foreach($formData['panitia_jabatan'] as $index => $jabatan)
                            <tr>
                                <td class="py-1">{{ $jabatan }}</td>
                                <td>:</td>
                                <td>{{ $formData['panitia_nama'][$index] ?? '-' }} [NIM. {{ $formData['panitia_nim'][$index] ?? '-' }}]</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td class="py-1">Ketua Panitia</td><td>:</td><td>{{ isset($proposal->user) ? $proposal->user->name : 'Mahasiswa' }} [NIM]</td></tr>
                        <tr><td class="py-1">Wakil</td><td>:</td><td>Mahasiswa [NIM]</td></tr>
                        <tr><td class="py-1">Sekretaris</td><td>:</td><td>Nama Sekretaris [NIM]</td></tr>
                        <tr><td class="py-1 pr-4">Bendahara <br><span class="text-xs font-normal">(apabila menggunakan anggaran besar, dibagian bendahara perlu melibatkan dosen)</span></td><td class="align-top">:</td><td class="align-top">Mahasiswa [NIM]</td></tr>
                        <tr><td class="py-1 align-top pt-2">Seksi-Seksi</td><td class="align-top pt-2">:</td><td class="pt-2">Mahasiswa [NIM]</td></tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- PAGE: LAMPIRAN II --}}
        <div class="bg-white shadow-xl border border-gray-300 rounded-sm w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">
            {{-- LAMPIRAN II: RANCANGAN ANGGARAN --}}
            <div class="mt-8">
                <p class="mb-4">Lampiran II</p>
                
                <div class="text-center mb-8">
                    <h2 class="font-bold underline text-[12pt]">RANCANGAN ANGGARAN</h2>
                    <h3 class="font-bold text-[12pt] mt-1">{{ strtoupper($proposal->title ?? 'NAMA KEGIATAN') }}</h3>
                    <h3 class="font-bold text-[12pt]">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</h3>
                    <h3 class="font-bold text-[12pt]">TELKOM UNIVERSITY PURWOKERTO</h3>
                </div>

                <table class="w-full border border-black text-xs text-center">
                    <tr class="font-bold">
                        <td class="border border-black p-2 w-8">No</td>
                        <td class="border border-black p-2">Tanggal</td>
                        <td class="border border-black p-2">Rincian</td>
                        <td class="border border-black p-2 w-8">Vol</td>
                        <td class="border border-black p-2">Satuan</td>
                        <td class="border border-black p-2">Harga</td>
                        <td class="border border-black p-2">Sub Total</td>
                        <td class="border border-black p-2">Keterangan</td>
                    </tr>
                    
                    {{-- PEMASUKAN --}}
                    <tr><td colspan="8" class="border border-black p-1 text-left font-bold bg-gray-100">PEMASUKAN</td></tr>
                    @php $totalPemasukan = 0; @endphp
                    @if(isset($formData['pemasukan_rincian']))
                        @foreach($formData['pemasukan_rincian'] as $i => $rincian)
                            @php 
                                $vol = $formData['pemasukan_vol'][$i] ?? 0;
                                $harga = $formData['pemasukan_harga'][$i] ?? 0;
                                $subtotal = $vol * $harga;
                                $totalPemasukan += $subtotal;
                            @endphp
                            <tr>
                                <td class="border border-black p-2">{{ $i + 1 }}</td>
                                <td class="border border-black p-2">-</td>
                                <td class="border border-black p-2 text-left">{{ $rincian }}</td>
                                <td class="border border-black p-2">{{ $vol }}</td>
                                <td class="border border-black p-2">{{ $formData['pemasukan_satuan'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="border border-black p-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="border border-black p-2"></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border border-black p-2">1</td>
                            <td class="border border-black p-2"></td>
                            <td class="border border-black p-2 text-left">Subsidi Institusi</td>
                            <td class="border border-black p-2">1</td>
                            <td class="border border-black p-2">Paket</td>
                            <td class="border border-black p-2">Rp {{ number_format($proposal->budget ?? 0, 0, ',', '.') }}</td>
                            <td class="border border-black p-2">Rp {{ number_format($proposal->budget ?? 0, 0, ',', '.') }}</td>
                            <td class="border border-black p-2"></td>
                        </tr>
                        @php $totalPemasukan = $proposal->budget ?? 0; @endphp
                    @endif
                    <tr>
                        <td colspan="6" class="border border-black p-2 text-right font-bold">Total Pemasukan</td>
                        <td class="border border-black p-2 font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        <td class="border border-black p-2"></td>
                    </tr>

                    {{-- PENGELUARAN --}}
                    <tr><td colspan="8" class="border border-black p-1 text-left font-bold bg-gray-100">PENGELUARAN</td></tr>
                    @php $totalPengeluaran = 0; @endphp
                    @if(isset($formData['pengeluaran_rincian']))
                        @foreach($formData['pengeluaran_rincian'] as $i => $rincian)
                            @php 
                                $vol = $formData['pengeluaran_vol'][$i] ?? 0;
                                $harga = $formData['pengeluaran_harga'][$i] ?? 0;
                                $subtotal = $vol * $harga;
                                $totalPengeluaran += $subtotal;
                            @endphp
                            <tr>
                                <td class="border border-black p-2">{{ $i + 1 }}</td>
                                <td class="border border-black p-2">-</td>
                                <td class="border border-black p-2 text-left">
                                    @if(!empty($formData['pengeluaran_divisi'][$i]))
                                        <strong>[{{ $formData['pengeluaran_divisi'][$i] }}]</strong><br>
                                    @endif
                                    {{ $rincian }}
                                </td>
                                <td class="border border-black p-2">{{ $vol }}</td>
                                <td class="border border-black p-2">{{ $formData['pengeluaran_satuan'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="border border-black p-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="border border-black p-2"></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border border-black p-2">1</td>
                            <td class="border border-black p-2"></td>
                            <td class="border border-black p-2 text-left">Total Anggaran Kegiatan</td>
                            <td class="border border-black p-2">1</td>
                            <td class="border border-black p-2">Paket</td>
                            <td class="border border-black p-2">Rp {{ number_format($proposal->budget ?? 0, 0, ',', '.') }}</td>
                            <td class="border border-black p-2">Rp {{ number_format($proposal->budget ?? 0, 0, ',', '.') }}</td>
                            <td class="border border-black p-2"></td>
                        </tr>
                        @php $totalPengeluaran = $proposal->budget ?? 0; @endphp
                    @endif
                    <tr>
                        <td colspan="6" class="border border-black p-2 text-right font-bold">Total Pengeluaran</td>
                        <td class="border border-black p-2 font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td class="border border-black p-2"></td>
                    </tr>
                    
                    {{-- SELISIH --}}
                    <tr>
                        <td colspan="6" class="border border-black p-2 text-right font-bold">Selisih Pemasukan & Pengeluaran</td>
                        <td class="border border-black p-2 font-bold {{ ($totalPemasukan - $totalPengeluaran) < 0 ? 'text-red-600' : '' }}">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
                        <td class="border border-black p-2"></td>
                    </tr>
                </table>
                <div class="mt-4 text-xs">
                    <p class="font-bold">Pemasukan</p>
                    <p class="ml-4 text-justify">Pemasukan harus logic, sponsor/danus yang terlalu besar apabila sebatas baru rencana tidak diperbolehkan, kecuali dana sudah tersedia. Untuk tarikan/iuran kepada mahasiswa sifatnya tidak boleh mewajibkan.</p>
                    <p class="font-bold mt-2">Pengeluaran</p>
                    <p class="ml-4 text-justify">Antara pemasukan dan pengeluaran harus sama nilainya atau dengan kata lain tidak ada selisih kekurangan, Harus ada kepastian anggaran sebelum kegiatan dilakukan.</p>
                </div>
            </div>
        </div>

        {{-- PAGE: LAMPIRAN III --}}
        <div class="bg-white shadow-lg border border-gray-200 rounded-lg w-full max-w-[210mm] min-h-[297mm]"
             style="padding:25mm; font-family:'Times New Roman', serif; font-size:12pt;">
            {{-- LAMPIRAN III: SUSUNAN ACARA --}}
            <div class="mt-8">
                <p class="mb-4">Lampiran III</p>
                
                <div class="text-center mb-8">
                    <h2 class="font-bold underline text-[12pt]">SUSUNAN ACARA KEGIATAN</h2>
                    <h3 class="font-bold text-[12pt] mt-1">{{ strtoupper($proposal->title ?? 'NAMA KEGIATAN') }}</h3>
                    <h3 class="font-bold text-[12pt]">HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</h3>
                    <h3 class="font-bold text-[12pt]">TELKOM UNIVERSITY PURWOKERTO</h3>
                </div>

                <table class="w-full border border-black text-sm text-center">
                    <tr class="font-bold bg-gray-100">
                        <td class="border border-black p-2 w-12">No</td>
                        <td class="border border-black p-2">Waktu</td>
                        <td class="border border-black p-2">Durasi</td>
                        <td class="border border-black p-2">Kegiatan</td>
                        <td class="border border-black p-2">Lokasi</td>
                        <td class="border border-black p-2">PIC</td>
                        <td class="border border-black p-2">Deskripsi</td>
                    </tr>
                    @if(isset($formData['rundown_kegiatan']))
                        @foreach($formData['rundown_kegiatan'] as $i => $kegiatan)
                            <tr>
                                <td class="border border-black p-2">{{ $i + 1 }}</td>
                                <td class="border border-black p-2">{{ $formData['rundown_waktu_mulai'][$i] ?? '-' }} - {{ $formData['rundown_waktu_selesai'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2">{{ $formData['rundown_durasi'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2 text-left">{{ $kegiatan }}</td>
                                <td class="border border-black p-2">{{ $formData['rundown_lokasi'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2">{{ $formData['rundown_pic'][$i] ?? '-' }}</td>
                                <td class="border border-black p-2 text-left">{{ $formData['rundown_deskripsi'][$i] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border border-black p-2">1</td>
                            <td class="border border-black p-2">{{ $proposal->waktu_pelaksanaan ?? '-' }}</td>
                            <td class="border border-black p-2">-</td>
                            <td class="border border-black p-2 text-left">Pelaksanaan Acara</td>
                            <td class="border border-black p-2">-</td>
                            <td class="border border-black p-2">-</td>
                            <td class="border border-black p-2">-</td>
                        </tr>
                    @endif
                </table>
            </div>

        </div>
    </div>

</x-layouts.dashboard>