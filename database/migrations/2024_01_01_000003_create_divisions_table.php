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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('tagline', 255)->nullable();
            $table->string('icon', 50)->default('📚');
            $table->string('color', 20)->default('#0891B2');
            $table->string('character', 50)->nullable(); // Scholar, Artist, Connector
            $table->string('motion_type', 50)->default('slide-left'); // slide-left, fade-scale, snap-right
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
