<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['text', 'video', 'pdf', 'external'])->default('text');
            $table->text('content')->nullable();
            $table->string('category')->default('umum'); // hiragana, katakana, kanji, grammar, culture
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('thumbnail')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['category', 'difficulty_level']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
