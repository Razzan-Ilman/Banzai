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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->integer('month'); // 1-12
            $table->integer('year'); // 2025, 2026, etc
            $table->json('answers'); // Store all quiz answers
            $table->json('scores'); // Scores per group: {musashi: 5, ame-no-uzume: 3, ...}
            $table->integer('total_score');
            $table->boolean('is_same_as_previous')->default(false); // For level calculation
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'month', 'year']);
            $table->unique(['user_id', 'month', 'year']); // One quiz per month per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
