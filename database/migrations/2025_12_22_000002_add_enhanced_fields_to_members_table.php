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
        Schema::table('members', function (Blueprint $table) {
            // Status: active, alumni, inactive
            $table->enum('status', ['active', 'alumni', 'inactive'])->default('active')->after('is_active');
            
            // Date tracking for member period
            $table->date('start_date')->nullable()->after('status');
            $table->date('end_date')->nullable()->after('start_date');
            
            // Position relation (foreign key)
            $table->foreignId('position_id')->nullable()->after('division_id')->constrained()->nullOnDelete();
            
            // Soft deletes for history preservation
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn(['status', 'start_date', 'end_date', 'position_id', 'deleted_at']);
        });
    }
};
