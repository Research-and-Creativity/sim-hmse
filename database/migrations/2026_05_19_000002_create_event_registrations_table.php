<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_kerja_id')->constrained('program_kerjas')->cascadeOnDelete();
            $table->string('name');
            $table->string('nim')->nullable();
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('prodi')->nullable();
            $table->string('semester', 10)->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('token', 64)->unique(); // untuk verifikasi / konfirmasi
            $table->timestamps();

            $table->index('program_kerja_id');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
