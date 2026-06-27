<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            // Poster image path (bisa diupload dari dashboard)
            $table->string('poster')->nullable()->after('documents');
            // Apakah event ini ditampilkan ke publik (halaman News)
            $table->boolean('is_public')->default(false)->after('poster');
            // Apakah open registrasi untuk mahasiswa umum
            $table->boolean('open_registration')->default(false)->after('is_public');
            // Batas registrasi
            $table->dateTime('registration_deadline')->nullable()->after('open_registration');
            // Kuota peserta (jika berbeda dari target_participants)
            $table->unsignedInteger('registration_quota')->nullable()->after('registration_deadline');
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropColumn([
                'poster',
                'is_public',
                'open_registration',
                'registration_deadline',
                'registration_quota',
            ]);
        });
    }
};
