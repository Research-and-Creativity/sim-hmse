<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('roles')->updateOrInsert([
            'id' => 1,
            'name' => 'Admin',
        ]);  
        
        \App\Models\Role::create([
            'id' => 2,
            'name' => 'Pengurus',
        ]); 
    
        // Akun Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@hmse.ac.id'],
            [
                'name' => 'Admin HMSE',
                'email' => 'admin@hmse.ac.id',
                'password' => bcrypt('adminHMSE2026!'),
                'role_id' => 1,
                'role' => 'admin',
                'jabatan' => 'admin',
                'divisi' => 'Administrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Akun Pengurus
        \App\Models\User::create([
            'name' => 'Pengurus HMSE',
            'email' => 'pengurus@example.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
        ]);
    }
}
