<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles Dasar
        DB::table('roles')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Admin', 'created_at' => now(), 'updated_at' => now()]
        );
        
        DB::table('roles')->updateOrInsert(
            ['id' => 2],
            ['name' => 'Pengurus', 'created_at' => now(), 'updated_at' => now()]
        );

        // 2. Akun Admin Utama
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@hmse.ac.id'],
            [
                'name'              => 'Admin HMSE',
                'email'             => 'admin@hmse.ac.id',
                'password'          => Hash::make('adminHMSE2026!'),
                'role'              => 'admin',
                'role_id'           => 1,
                'jabatan'           => 'admin',
                'divisi'            => 'Administrasi',
                'nim_nip'           => 'ADMIN001',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        // 3. Panggil Seeder Tambahan (SOTK & Akun Pengurus)
        $this->call([
            UserSeeder::class,
            // Uncomment seeder berikut jika ingin mengisi data dummy untuk keperluan referensi/testing:
            // ProgramKerjaSeeder::class,
            // ProposalSeeder::class,
        ]);
    }
}
