<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['info', 'warning', 'success', 'event'])->default('info');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_published', 'expires_at']);
            $table->index('priority');
        });
        
        // Target table for role/user targeting
        Schema::create('announcement_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained()->cascadeOnDelete();
            $table->enum('target_type', ['all', 'role', 'user'])->default('all');
            $table->string('target_value')->nullable(); // role name or user_id
            $table->timestamps();
            
            $table->index(['announcement_id', 'target_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_targets');
        Schema::dropIfExists('announcements');
    }
};
