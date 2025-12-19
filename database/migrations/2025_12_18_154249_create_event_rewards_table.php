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
        Schema::create('event_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('reward_type', ['level_boost', 'medal', 'title']); 
            $table->string('reward_value', 191); // e.g., "+1 level", "Gold Medal", "Event Champion"
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('event_id');
            $table->index('reward_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_rewards');
    }
};
