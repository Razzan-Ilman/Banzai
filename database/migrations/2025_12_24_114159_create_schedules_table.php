<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['meeting', 'event', 'practice', 'other'])->default('meeting');
            $table->string('location')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable(); // FREQ=WEEKLY;BYDAY=MO,FR
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['start_date', 'end_date']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
