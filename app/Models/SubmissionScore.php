<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionScore extends Model
{
    protected $fillable = [
        'submission_id',
        'judge_id',
        'score',
        'feedback',
    ];
    
    protected $casts = [
        'score' => 'decimal:2',
    ];
    
    public function submission(): BelongsTo
    {
        return $this->belongsTo(CompetitionSubmission::class, 'submission_id');
    }
    
    public function judge(): BelongsTo
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
