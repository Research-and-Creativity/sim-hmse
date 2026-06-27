<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramKerja;
use App\Models\User;

class ProgramKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil penanggung jawab dummy dari database
        $pjAkademik = User::where('email', 'head.akademik@hmse.ac.id')->first() ?? User::first();
        $pjHumas = User::where('email', 'head.humas@hmse.ac.id')->first() ?? User::first();
        $pjMedinfo = User::where('email', 'head.medinfo@hmse.ac.id')->first() ?? User::first();

        $events = [
            [
                'name' => 'SE-Fest 2026 (Software Engineering Festival)',
                'division' => 'Research and Creativity',
                'status' => 'preparation',
                'pj_user_id' => $pjAkademik->id,
                'date_start' => '2026-07-10',
                'date_end' => '2026-07-12',
                'description' => "Festival teknologi tahunan terbesar HMSE yang menyelenggarakan kompetisi Hackathon tingkat nasional, Seminar Teknologi bersama pembicara kelas dunia, serta Pameran Karya Cipta (Exhibition) mahasiswa Software Engineering.\n\nEvent ini terbuka untuk mahasiswa umum seluruh Indonesia yang ingin berinovasi dan menguji kemampuannya di bidang pengembangan perangkat lunak.",
                'location' => 'Auditorium Gedung Baru, Kampus Telkom University Purwokerto',
                'target_participants' => 300,
                'risk_level' => 'tinggi',
                'progress' => 45,
                'color' => '#2C3DA6',
                'timeline' => [
                    ['title' => 'Pendaftaran Tim', 'date' => '2026-06-15'],
                    ['title' => 'Technical Meeting', 'date' => '2026-07-08'],
                    ['title' => 'Opening & Hackathon Kickoff', 'date' => '2026-07-10'],
                    ['title' => 'Seminar & Awarding Night', 'date' => '2026-07-12'],
                ],
                'documents' => [],
                'budget_items' => [
                    ['name' => 'Hadiah Juara 1, 2, 3 Hackathon', 'qty' => 1, 'unit' => 'Paket', 'price' => 7500000],
                    ['name' => 'Honorarium Pembicara Seminar', 'qty' => 2, 'unit' => 'Orang', 'price' => 2000000],
                    ['name' => 'Konsumsi Panitia & Juri', 'qty' => 150, 'unit' => 'Box', 'price' => 25000],
                ],
                'committee_member_ids' => [$pjAkademik->id],
                'poster' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60',
                'is_public' => true,
                'open_registration' => true,
                'registration_deadline' => '2026-07-05 23:59:00',
                'registration_quota' => 300,
            ],
            [
                'name' => 'HMSE Share & Care: Sosialisasi Literasi Digital',
                'division' => 'Internal and External Communication',
                'status' => 'on-progress',
                'pj_user_id' => $pjHumas->id,
                'date_start' => '2026-08-15',
                'date_end' => '2026-08-15',
                'description' => "Bentuk kepedulian HMSE terhadap masyarakat sekitar dengan mengadakan sosialisasi literasi digital di tingkat sekolah dasar. Kami akan mengajarkan etika internet yang aman, pengenalan komputer dasar, serta logika pemrograman sederhana menggunakan Scratch.\n\nKami mengundang mahasiswa umum yang tertarik untuk bergabung menjadi volunteer (sukarelawan) pengajar dalam kegiatan sosial ini.",
                'location' => 'SD Negeri 1 Kutasari, Baturraden',
                'target_participants' => 50,
                'risk_level' => 'rendah',
                'progress' => 70,
                'color' => '#00C4D8',
                'timeline' => [
                    ['title' => 'Open Volunteer Recruitment', 'date' => '2026-07-20'],
                    ['title' => 'Briefing Panitia & Volunteer', 'date' => '2026-08-10'],
                    ['title' => 'Pelaksanaan & Pembagian Donasi', 'date' => '2026-08-15'],
                ],
                'documents' => [],
                'budget_items' => [
                    ['name' => 'Paket ATK & Buku untuk Siswa', 'qty' => 50, 'unit' => 'Paket', 'price' => 35000],
                    ['name' => 'Sewa Bus Transportasi Volunteer', 'qty' => 1, 'unit' => 'Unit', 'price' => 1200000],
                    ['name' => 'Banner Kegiatan', 'qty' => 2, 'unit' => 'Lembar', 'price' => 150000],
                ],
                'committee_member_ids' => [$pjHumas->id],
                'poster' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&auto=format&fit=crop&q=60',
                'is_public' => true,
                'open_registration' => true,
                'registration_deadline' => '2026-08-08 17:00:00',
                'registration_quota' => 40,
            ],
            [
                'name' => 'Tech Talk Series: Future of Software Engineering with AI',
                'division' => 'Creative Media and Information',
                'status' => 'preparation',
                'pj_user_id' => $pjMedinfo->id,
                'date_start' => '2026-09-05',
                'date_end' => '2026-09-05',
                'description' => "Webinar interaktif garapan Divisi Media Kreatif dan Informasi HMSE yang mengupas tuntas revolusi Artificial Intelligence (AI) di industri software engineering. Dapatkan insight eksklusif tentang bagaimana AI merubah cara kerja developer dan persiapkan dirimu menghadapi masa depan industri tech.\n\nWebinar ini GRATIS dan bersertifikat, terbuka untuk umum.",
                'location' => 'Zoom Meeting & Live Streaming YouTube HMSE',
                'target_participants' => 500,
                'risk_level' => 'sedang',
                'progress' => 20,
                'color' => '#1E2D8F',
                'timeline' => [
                    ['title' => 'Publikasi Poster & Open Registration', 'date' => '2026-08-20'],
                    ['title' => 'Gladi Bersih Panitia & Pembicara', 'date' => '2026-09-04'],
                    ['title' => 'Tech Talk Webinar Day', 'date' => '2026-09-05'],
                ],
                'documents' => [],
                'budget_items' => [
                    ['name' => 'Sewa Akun Zoom Webinar 500 Peserta', 'qty' => 1, 'unit' => 'Bulan', 'price' => 900000],
                    ['name' => 'Fee Pembicara Ahli AI', 'qty' => 1, 'unit' => 'Orang', 'price' => 1500000],
                    ['name' => 'E-Sertifikat untuk Peserta', 'qty' => 500, 'unit' => 'Lembar', 'price' => 0],
                ],
                'committee_member_ids' => [$pjMedinfo->id],
                'poster' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=60',
                'is_public' => true,
                'open_registration' => true,
                'registration_deadline' => '2026-09-04 23:59:00',
                'registration_quota' => 1000,
            ],
        ];

        foreach ($events as $event) {
            ProgramKerja::updateOrCreate(
                ['name' => $event['name']],
                $event
            );
        }
    }
}
