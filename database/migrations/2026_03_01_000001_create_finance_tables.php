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
        // Tabel untuk Kas Internal HMSE (Iuran, Perlengkapan, dll)
        Schema::create('finance_internals', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date'); // Tanggal transaksi
            $table->string('title'); // Contoh: "Bayar Kas April"
            $table->enum('type', ['income', 'outcome']); 
            $table->decimal('amount', 15, 2); 
            $table->string('method')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users'); // Siapa yang input
            $table->timestamps();
        });

        // Tabel untuk Keuangan per Program Kerja
        Schema::create('finance_prokers', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date'); // Tanggal transaksi  
            $table->foreignId('program_kerja_id')->constrained('program_kerjas')->onDelete('cascade');
            $table->string('title'); // Contoh: "Sponsorship Bank Jateng"
            $table->enum('type', ['income', 'outcome']);
            $table->decimal('amount', 15, 2);
            $table->string('method')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_prokers');
        Schema::dropIfExists('finance_internals');
    }
};
