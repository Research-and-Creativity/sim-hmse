<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        $proposals = [
            [
                'id' => 1,
                'title' => 'Proposal Workshop UI/UX Design 2026',
                'proker' => 'Workshop UI/UX',
                'divisi' => 'Divisi Akademik',
                'status' => 'approved',
                'ketua_panitia' => 'Ahmad Fauzi',
                'sekretaris' => 'Siti Nurhaliza',
                'background' => 'Perkembangan teknologi digital yang pesat mendorong kebutuhan akan desainer UI/UX yang kompeten. Workshop ini hadir untuk membekali mahasiswa Software Engineering dengan keterampilan desain antarmuka yang profesional dan relevan dengan industri.',
                'objective' => 'Memberikan pemahaman mendalam tentang prinsip-prinsip UI/UX Design kepada mahasiswa, serta membekali mereka dengan keterampilan praktis menggunakan tools seperti Figma.',
                'tema_kegiatan' => 'Designing Digital Tomorrow',
                'jenis_kegiatan' => 'Workshop / Pelatihan Teknis',
                'manfaat_kegiatan' => 'Peserta mampu memahami prinsip dasar UI/UX, menggunakan Figma secara mandiri, dan menghasilkan prototype yang siap dipresentasikan kepada klien atau penguji.',
                'bentuk_kegiatan' => 'Workshop intensif satu hari dengan sesi teori, demonstrasi, dan praktik langsung bersama mentor dari industri.',
                'sasaran_peserta' => 'Seluruh mahasiswa aktif Program Studi S1 Rekayasa Perangkat Lunak, diutamakan semester 3 ke atas.',
                'tanggal_pelaksanaan' => 'Selasa, 15 April 2026',
                'waktu_pelaksanaan' => '08:00 — 16:00 WIB',
                'tempat_pelaksanaan' => 'Lab Komputer Lt.3, Gedung Informatika IT Telkom Purwokerto',
                'timeline' => '1 hari (15 April 2026)',
                'budget' => 3200000,
                'risk_level' => 'low',
                'penutup' => 'Demikian proposal Workshop UI/UX Design 2026 ini kami susun. Besar harapan kami kegiatan ini dapat terlaksana dengan baik dan memberikan manfaat bagi seluruh peserta. Atas perhatian dan dukungannya kami ucapkan terima kasih.',
                'created_at' => '2026-03-10 09:00:00',
                'updated_at' => '2026-03-10 09:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Proposal Seminar Nasional Tech Week',
                'proker' => 'Seminar Tech Week',
                'divisi' => 'Divisi Eksternal',
                'status' => 'pending',
                'ketua_panitia' => 'Budi Santoso',
                'sekretaris' => 'Rini Wijayanti',
                'background' => 'Seminar Nasional Tech Week merupakan agenda tahunan HMSE yang bertujuan menghubungkan mahasiswa dengan praktisi dan akademisi di bidang teknologi informasi tingkat nasional.',
                'objective' => 'Memperluas wawasan mahasiswa tentang tren teknologi terkini, membangun relasi profesional, dan menginspirasi inovasi di lingkungan kampus.',
                'tema_kegiatan' => 'Bridging Innovation and Industry',
                'jenis_kegiatan' => 'Seminar Nasional',
                'manfaat_kegiatan' => 'Peserta mendapatkan insight langsung dari praktisi industri, membuka peluang magang dan kerja, serta memperluas jaringan profesional.',
                'bentuk_kegiatan' => 'Seminar dua hari dengan sesi keynote speaker, panel diskusi, dan networking session.',
                'sasaran_peserta' => 'Mahasiswa aktif dari berbagai perguruan tinggi di Indonesia, praktisi IT, dan akademisi.',
                'tanggal_pelaksanaan' => 'Sabtu–Minggu, 18–19 April 2026',
                'waktu_pelaksanaan' => '08:00 — 17:00 WIB',
                'tempat_pelaksanaan' => 'Auditorium Utama IT Telkom Purwokerto',
                'timeline' => '2 hari (18–19 April 2026)',
                'budget' => 15000000,
                'risk_level' => 'high',
                'risk_description' => 'Risiko kehadiran speaker dari luar kota dapat diminimalisir dengan konfirmasi 2 minggu sebelum acara dan penyediaan opsi online. Risiko anggaran diatasi dengan sponsorship dari perusahaan teknologi.',
                'penutup' => 'Demikian proposal Seminar Nasional Tech Week ini kami susun. Kami berharap kegiatan ini mendapat dukungan penuh dari seluruh pihak demi suksesnya penyelenggaraan.',
                'created_at' => '2026-03-18 10:00:00',
                'updated_at' => '2026-03-18 10:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Proposal Bootcamp Web Development',
                'proker' => 'Bootcamp Web Dev',
                'divisi' => 'Divisi Akademik',
                'status' => 'approved',
                'ketua_panitia' => 'Dian Permatasari',
                'sekretaris' => 'Eko Prasetyo',
                'background' => 'Kemampuan pengembangan web merupakan salah satu skill paling dicari di industri teknologi. Bootcamp ini dirancang untuk memberikan pengalaman belajar intensif dan praktis kepada mahasiswa.',
                'objective' => 'Membekali peserta dengan kemampuan full-stack web development menggunakan teknologi modern seperti Laravel, Vue.js, dan MySQL.',
                'tema_kegiatan' => 'Code, Build, Deploy',
                'jenis_kegiatan' => 'Bootcamp / Pelatihan Intensif',
                'manfaat_kegiatan' => 'Peserta mampu membangun aplikasi web dari nol hingga deployment, siap mengerjakan proyek freelance maupun magang industri.',
                'bentuk_kegiatan' => 'Bootcamp intensif 3 hari dengan mentoring langsung, project assignment, dan sesi review code.',
                'sasaran_peserta' => 'Mahasiswa S1 RPL semester 3–6 yang telah menguasai dasar pemrograman.',
                'tanggal_pelaksanaan' => 'Rabu–Jumat, 5–7 Februari 2026',
                'waktu_pelaksanaan' => '08:00 — 18:00 WIB',
                'tempat_pelaksanaan' => 'Lab Komputer Lt.2, Gedung Informatika IT Telkom Purwokerto',
                'timeline' => '3 hari (5–7 Februari 2026)',
                'budget' => 5500000,
                'risk_level' => 'low',
                'penutup' => 'Demikian proposal Bootcamp Web Development ini kami susun dengan sebaik-baiknya. Semoga kegiatan ini dapat memberikan manfaat yang nyata bagi peserta.',
                'created_at' => '2026-02-05 08:00:00',
                'updated_at' => '2026-02-05 08:00:00',
            ],
            [
                'id' => 4,
                'title' => 'Proposal Turnamen E-Sport HMSE Cup',
                'proker' => 'E-Sport HMSE Cup',
                'divisi' => 'Divisi Minat Bakat',
                'status' => 'draft',
                'ketua_panitia' => 'Fajar Nugroho',
                'sekretaris' => 'Gita Larasati',
                'background' => 'Olahraga elektronik (e-sport) semakin berkembang pesat di kalangan mahasiswa. HMSE Cup hadir sebagai wadah kompetisi yang sehat, sportif, dan menghibur antar mahasiswa IT Telkom Purwokerto.',
                'objective' => 'Menyediakan ajang kompetisi e-sport yang terorganisir, meningkatkan semangat sportivitas, dan mempererat hubungan antar mahasiswa lintas angkatan.',
                'tema_kegiatan' => 'Battle for Glory',
                'jenis_kegiatan' => 'Turnamen / Kompetisi',
                'manfaat_kegiatan' => 'Mahasiswa mendapatkan pengalaman berkompetisi secara sehat, membangun jiwa sportif, dan mendapatkan apresiasi atas bakat di bidang e-sport.',
                'bentuk_kegiatan' => 'Turnamen online dan offline dengan sistem eliminasi, diselenggarakan selama 2 minggu.',
                'sasaran_peserta' => 'Seluruh mahasiswa aktif IT Telkom Purwokerto dari semua program studi.',
                'tanggal_pelaksanaan' => 'Sabtu, 25 April 2026',
                'waktu_pelaksanaan' => '09:00 — 22:00 WIB',
                'tempat_pelaksanaan' => 'Aula Gedung C IT Telkom Purwokerto',
                'timeline' => '2 minggu (13–25 April 2026)',
                'budget' => 4000000,
                'risk_level' => 'low',
                'penutup' => 'Demikian proposal HMSE Cup ini kami susun. Besar harapan kami agar kegiatan ini mendapat dukungan dan dapat berjalan lancar.',
                'created_at' => '2026-03-25 14:00:00',
                'updated_at' => '2026-03-25 14:00:00',
            ],
            [
                'id' => 5,
                'title' => 'Proposal Bazaar Kewirausahaan',
                'proker' => 'Bazaar Kewirausahaan',
                'divisi' => 'Divisi Wirausaha',
                'status' => 'reviewing',
                'ketua_panitia' => 'Hana Safitri',
                'sekretaris' => 'Ivan Kusuma',
                'background' => 'Bazaar Kewirausahaan merupakan platform bagi mahasiswa untuk mengembangkan jiwa wirausaha melalui pengalaman nyata berjualan dan berinteraksi dengan konsumen di lingkungan kampus.',
                'objective' => 'Menumbuhkan jiwa kewirausahaan mahasiswa, memberikan pengalaman bisnis nyata, dan menciptakan ekosistem ekonomi kreatif di kampus.',
                'tema_kegiatan' => 'Entrepreneur Spirit, Digital Era',
                'jenis_kegiatan' => 'Bazaar / Pameran Wirausaha',
                'manfaat_kegiatan' => 'Mahasiswa mendapatkan pengalaman berwirausaha secara langsung, meningkatkan kreativitas, dan membangun mental bisnis yang kuat.',
                'bentuk_kegiatan' => 'Bazaar outdoor dengan booth tenant mahasiswa, live music, dan demo produk kreatif selama 2 hari.',
                'sasaran_peserta' => 'Mahasiswa aktif IT Telkom Purwokerto sebagai tenant dan pengunjung umum.',
                'tanggal_pelaksanaan' => 'Jumat–Sabtu, 20–21 Maret 2026',
                'waktu_pelaksanaan' => '09:00 — 17:00 WIB',
                'tempat_pelaksanaan' => 'Lapangan Tengah IT Telkom Purwokerto',
                'timeline' => '2 hari (20–21 Maret 2026)',
                'budget' => 6000000,
                'risk_level' => 'low',
                'penutup' => 'Demikian proposal Bazaar Kewirausahaan ini kami susun. Kami berharap kegiatan ini dapat berjalan meriah dan memberikan manfaat nyata bagi seluruh civitas akademika.',
                'created_at' => '2026-03-20 11:00:00',
                'updated_at' => '2026-03-20 11:00:00',
            ],
            [
                'id' => 6,
                'title' => 'Proposal Creative Content Competition',
                'proker' => 'Content Competition',
                'divisi' => 'Divisi Kreatif',
                'status' => 'rejected',
                'ketua_panitia' => 'Joko Widagdo',
                'sekretaris' => 'Karin Amelia',
                'background' => 'Kemampuan membuat konten kreatif menjadi aset penting di era digital. Kompetisi ini mendorong mahasiswa untuk mengeksplorasi kreativitas dalam berbagai format konten.',
                'objective' => 'Mendorong kreativitas mahasiswa dalam pembuatan konten digital berkualitas yang relevan, inspiratif, dan berdampak positif.',
                'tema_kegiatan' => 'Create, Inspire, Impact',
                'jenis_kegiatan' => 'Kompetisi / Lomba Kreatif',
                'manfaat_kegiatan' => 'Peserta mendapatkan pengalaman dalam pembuatan konten profesional, mendapatkan feedback dari juri berpengalaman, dan portofolio yang dapat digunakan untuk karir.',
                'bentuk_kegiatan' => 'Kompetisi pembuatan konten (video, foto, dan infografis) dengan tema tertentu, diikuti penjurian dan awarding.',
                'sasaran_peserta' => 'Mahasiswa aktif se-Jawa Tengah dan DIY.',
                'tanggal_pelaksanaan' => 'Minggu, 15 Maret 2026',
                'waktu_pelaksanaan' => '10:00 — 18:00 WIB',
                'tempat_pelaksanaan' => 'Online (Zoom) + Pengumpulan karya via Google Form',
                'timeline' => '3 minggu (1–21 Maret 2026)',
                'budget' => 2500000,
                'risk_level' => 'low',
                'rejection_reason' => 'Anggaran tidak sesuai dengan standar yang ditetapkan. Mohon revisi rancangan anggaran dan perjelas mekanisme penjurian.',
                'penutup' => 'Demikian proposal Creative Content Competition ini kami susun. Kami berharap dapat segera mendapat tanggapan dan masukan untuk perbaikan.',
                'created_at' => '2026-03-15 09:30:00',
                'updated_at' => '2026-03-15 09:30:00',
            ],
        ];

        foreach ($proposals as $proposal) {
            DB::table('proposals')->updateOrInsert(
                ['id' => $proposal['id']],
                $proposal
            );
        }

        // Seed approvals for proposals
        $usersByRole = [
            'ketua_panitia' => \App\Models\User::where('jabatan', 'ketua_panitia')->first()?->id ?? 5,
            'sekretaris'    => \App\Models\User::where('jabatan', 'sekretaris')->first()?->id ?? 3,
            'ketua_hima'    => \App\Models\User::where('jabatan', 'ketua_hmse')->first()?->id ?? 1,
            'pembina'       => \App\Models\User::where('jabatan', 'pembina')->first()?->id ?? 9,
            'kaprodi'       => \App\Models\User::where('jabatan', 'kaprodi')->first()?->id ?? 10,
        ];

        $approvalStructure = [
            ['role' => 'ketua_panitia', 'order' => 1],
            ['role' => 'sekretaris',    'order' => 2],
            ['role' => 'ketua_hima',    'order' => 3],
            ['role' => 'pembina',       'order' => 4],
            ['role' => 'kaprodi',       'order' => 5],
        ];

        foreach ($proposals as $proposalData) {
            $status = $proposalData['status'];
            
            // Delete old approvals for this proposal if any
            DB::table('proposal_approvals')->where('proposal_id', $proposalData['id'])->delete();

            foreach ($approvalStructure as $app) {
                $order = $app['order'];
                $role = $app['role'];
                
                $appStatus = 'pending';
                $signedAt = null;

                if ($status === 'approved') {
                    $appStatus = 'approved';
                    $signedAt = now()->subDays(6 - $order);
                } elseif ($status === 'pending') {
                    if ($order < 4) { // Pembina is order 4, so 1, 2, 3 are already approved
                        $appStatus = 'approved';
                        $signedAt = now()->subDays(5 - $order);
                    }
                } elseif ($status === 'reviewing') {
                    if ($order < 3) { // Ketua HMSE is order 3, so 1, 2 are approved
                        $appStatus = 'approved';
                        $signedAt = now()->subDays(4 - $order);
                    }
                }

                DB::table('proposal_approvals')->insert([
                    'proposal_id' => $proposalData['id'],
                    'approver_id' => $usersByRole[$role],
                    'approver_role' => $role,
                    'status' => $appStatus,
                    'approved_at' => $signedAt,
                    'approval_order' => $order,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
