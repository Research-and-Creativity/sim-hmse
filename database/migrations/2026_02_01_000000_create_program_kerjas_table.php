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
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('division');
            $table->enum('status', ['draft', 'preparation', 'on-progress', 'completed', 'cancelled'])->default('draft');
            $table->unsignedBigInteger('pj_user_id');
            $table->date('date_start');
            $table->date('date_end');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('target_participants')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->string('color', 20)->default('#2C3DA6');
            $table->json('timeline')->nullable();
            $table->json('documents')->nullable();
            $table->json('budget_items')->nullable();
            $table->json('committee_member_ids')->nullable();
            $table->timestamps();

            $table->index('division');
            $table->index('status');
            $table->index('pj_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kerjas');
    }
};
