<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'scored'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['event_id', 'status']);
        });
        
        // Submission files (multi-file support)
        Schema::create('submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('competition_submissions')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->timestamps();
        });
        
        // Submission scores (multi-judge support)
        Schema::create('submission_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('competition_submissions')->cascadeOnDelete();
            $table->foreignId('judge_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('score', 5, 2);
            $table->text('feedback')->nullable();
            $table->timestamps();
            
            $table->unique(['submission_id', 'judge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_scores');
        Schema::dropIfExists('submission_files');
        Schema::dropIfExists('competition_submissions');
    }
};
