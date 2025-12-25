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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('title_id')->nullable()->after('role')->constrained('titles')->nullOnDelete();
            $table->timestamp('title_awarded_at')->nullable()->after('title_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['title_id']);
            $table->dropColumn(['title_id', 'title_awarded_at']);
        });
    }
};
