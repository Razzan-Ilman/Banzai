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
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Kensei, Maihime, etc
            $table->string('name_kanji');   // 剣聖, 舞姫, etc
            $table->string('group');        // MUSASHI, AME-NO-UZUME, etc
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->unique('group'); // One title per group
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titles');
    }
};
