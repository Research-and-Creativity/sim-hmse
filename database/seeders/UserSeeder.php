<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // ── PENGURUS INTI ────────────────────────────────────────────────
            [
                'name'    => 'Quratu Ayun Defaren',
                'email'   => 'ketua@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'ketua_hmse',
                'nim_nip' => '103122400064',
                'divisi'  => 'Pimpinan',
            ],
            [
                'name'    => 'Muhammad Rasyid Ridho',
                'email'   => 'wakilketua@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'wakil_ketua_hmse',
                'nim_nip' => '103122400018',
                'divisi'  => 'Pimpinan',
            ],
            [
                'name'    => 'Andini Pratiwi',
                'email'   => 'sekretaris1@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'sekretaris',
                'nim_nip' => '103122400021',
                'divisi'  => 'Sekretaris 1',
            ],
            [
                'name'    => 'Dwi Wulan Ramadhani',
                'email'   => 'sekretaris2@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'sekretaris',
                'nim_nip' => '103122400022',
                'divisi'  => 'Sekretaris 2',
            ],
            [
                'name'    => 'Radita Putri Nuraini',
                'email'   => 'bendahara1@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'bendahara',
                'nim_nip' => '103122400033',
                'divisi'  => 'Finance 1',
            ],
            [
                'name'    => 'Salumita Ardiana',
                'email'   => 'bendahara2@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'bendahara',
                'nim_nip' => '103122400034',
                'divisi'  => 'Finance 2',
            ],
            // ── HEAD DIVISI ──────────────────────────────────────────────────
            [
                'name'    => 'Resource Management Koor',
                'email'   => 'head.psdm@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'head_divisi',
                'nim_nip' => '103122400051',
                'divisi'  => 'Resource Management',
            ],
            [
                'name'    => 'Internal & External Comm. Koor',
                'email'   => 'head.humas@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'head_divisi',
                'nim_nip' => '103122400052',
                'divisi'  => 'Internal and External Communication',
            ],
            [
                'name'    => 'Research & Creativity Koor',
                'email'   => 'head.akademik@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'ketua_panitia', // Biarkan salah satu jadi ketua_panitia untuk role pembuat proposal
                'nim_nip' => '103122400045',
                'divisi'  => 'Research and Creativity',
            ],
            [
                'name'    => 'Economy Creative Koor',
                'email'   => 'head.mikat@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'head_divisi',
                'nim_nip' => '103122400060',
                'divisi'  => 'Economy Creative',
            ],
            [
                'name'    => 'Creative Media & Info Koor',
                'email'   => 'head.medinfo@hmse.ac.id',
                'password'=> Hash::make('hmse2026'),
                'role'    => 'pengurus',
                'jabatan' => 'head_divisi',
                'nim_nip' => '103122400072',
                'divisi'  => 'Creative Media and Information',
            ],
            // ── PEMBINA & KAPRODI ────────────────────────────────────────────
            [
                'name'    => 'Yudha Islami Sulistya, S.Kom., M.Cs',
                'email'   => 'pembina@ittelkom-pwt.ac.id',
                'password'=> Hash::make('pembina2026'),
                'role'    => 'pembina',
                'jabatan' => 'pembina',
                'nim_nip' => '0609020001',
                'divisi'  => 'Pembina HMSE',
            ],
            [
                'name'    => 'Abednego Dwi Septiadi, S.Kom., M.Kom',
                'email'   => 'kaprodi@ittelkom-pwt.ac.id',
                'password'=> Hash::make('pembina2026'),
                'role'    => 'pembina',
                'jabatan' => 'kaprodi',
                'nim_nip' => '22890018',
                'divisi'  => 'Kaprodi RPL',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, [
                    'role_id'           => $user['role'] === 'pengurus' ? 2 : 1,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ])
            );
        }
    }
}
