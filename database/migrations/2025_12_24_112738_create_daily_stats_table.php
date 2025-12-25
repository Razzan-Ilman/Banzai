<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->unsignedInteger('total_users')->default(0);
            $table->unsignedInteger('active_users')->default(0);
            $table->unsignedInteger('new_users')->default(0);
            $table->unsignedInteger('attendance_count')->default(0);
            $table->unsignedInteger('quiz_count')->default(0);
            $table->unsignedInteger('event_registrations')->default(0);
            $table->timestamps();
            
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_stats');
    }
};
