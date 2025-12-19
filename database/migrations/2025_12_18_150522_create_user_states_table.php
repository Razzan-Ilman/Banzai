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
        Schema::create('user_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('current_group_id')->nullable()->constrained('groups')->onDelete('set null');
            $table->string('current_cycle', 7);     // "2025-01"
            $table->boolean('quiz_completed')->default(false);
            $table->timestamp('last_quiz_at')->nullable();
            $table->enum('state', ['new', 'active', 'expired', 'reset_pending'])->default('new');
            $table->timestamps();
            
            // Indexes
            $table->index('current_group_id');
            $table->index('current_cycle');
            $table->index('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_states');
    }
};
