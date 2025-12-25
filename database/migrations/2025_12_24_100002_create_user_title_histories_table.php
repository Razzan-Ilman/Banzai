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
        Schema::create('user_title_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('title_id')->constrained()->onDelete('cascade');
            $table->timestamp('awarded_at');
            $table->timestamp('revoked_at')->nullable();
            $table->text('notes')->nullable(); // Reason for award/revoke
            $table->timestamps();
            
            $table->index(['user_id', 'title_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_title_histories');
    }
};
