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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('class', 20); // X, XI, XII
            $table->string('major', 100); // Kimia Analisis, Kimia Industri, etc
            $table->string('position', 50)->nullable(); // Ketua, Wakil Ketua, Anggota
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->string('photo', 255)->nullable();
            $table->string('initial_color', 20)->nullable(); // Color for initial letter
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
        Schema::dropIfExists('members');
    }
};
