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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->text('description')->nullable();
            $table->datetime('event_date');
            $table->datetime('registration_deadline')->nullable();
            $table->enum('status', ['open', 'closed', 'finished'])->default('open');
            $table->string('featured_image', 255)->nullable();
            $table->integer('max_participants')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
