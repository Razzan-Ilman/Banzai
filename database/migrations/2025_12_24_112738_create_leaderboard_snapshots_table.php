<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboard_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('period'); // weekly, monthly, alltime
            $table->json('data'); // Array of ranked users
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['period', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboard_snapshots');
    }
};
