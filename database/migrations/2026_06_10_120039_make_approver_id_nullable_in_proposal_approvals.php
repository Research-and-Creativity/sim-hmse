<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat approver_id nullable sehingga approval bisa dibuat
     * sebelum approver di-assign secara eksplisit.
     */
    public function up(): void
    {
        Schema::table('proposal_approvals', function (Blueprint $table) {
            $table->unsignedBigInteger('approver_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('proposal_approvals', function (Blueprint $table) {
            $table->unsignedBigInteger('approver_id')->nullable(false)->change();
        });
    }
};
