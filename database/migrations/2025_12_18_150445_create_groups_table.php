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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);           // MUSASHI, AME-NO-UZUME, FUJIN, YAMATO
            $table->string('kanji', 10);            // 武蔵, 天宇受売, 風神, 大和
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null');
            $table->string('color', 7);             // Hex color
            $table->string('particle_type', 50);    // sakura, light_dust, brush_specks
            $table->string('motion_style', 50);     // slow_steady, organic_flow, quick_dynamic
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->unique('name');
            $table->index('division_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
