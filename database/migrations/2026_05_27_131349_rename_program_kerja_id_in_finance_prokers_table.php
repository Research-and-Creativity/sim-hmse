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
        Schema::table('finance_prokers', function (Blueprint $table) {
            $table->renameColumn('program_kerja_id', 'proker_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_prokers', function (Blueprint $table) {
            $table->renameColumn('proker_id', 'program_kerja_id');
        });
    }
};
