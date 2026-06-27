<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('proker')->nullable();
            $table->string('divisi')->nullable();
            $table->string('status')->default('draft');
            $table->string('ketua_panitia')->nullable();
            $table->string('sekretaris')->nullable();
            $table->text('background')->nullable();
            $table->text('objective')->nullable();
            $table->string('tema_kegiatan')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->text('manfaat_kegiatan')->nullable();
            $table->text('bentuk_kegiatan')->nullable();
            $table->string('sasaran_peserta')->nullable();
            $table->string('tanggal_pelaksanaan')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->string('tempat_pelaksanaan')->nullable();
            $table->string('timeline')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('low');
            $table->text('risk_description')->nullable();
            $table->text('penutup')->nullable();
            $table->string('file_path')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
