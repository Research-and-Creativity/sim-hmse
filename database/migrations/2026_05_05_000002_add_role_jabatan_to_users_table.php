<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: 'pengurus' | 'pembina'
            $table->string('role')->default('pengurus')->after('password');
            // jabatan menentukan urutan TTD
            // ketua_panitia | sekretaris | ketua_hmse | wakil_ketua_hmse | bendahara
            // | pembina | kaprodi | head_divisi | staff
            $table->string('jabatan')->nullable()->after('role');
            $table->string('nim_nip')->nullable()->after('jabatan');
            $table->string('divisi')->nullable()->after('nim_nip');
            $table->string('avatar')->nullable()->after('divisi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'jabatan', 'nim_nip', 'divisi', 'avatar']);
        });
    }
};
