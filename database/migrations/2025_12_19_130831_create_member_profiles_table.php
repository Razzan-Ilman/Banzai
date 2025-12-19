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
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('member_number')->unique(); // Nomor Induk Eskul
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('level')->default(1); // 1-3
            $table->integer('points')->default(0);
            $table->integer('xp')->default(0); // Experience points
            $table->boolean('is_active')->default(true);
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
