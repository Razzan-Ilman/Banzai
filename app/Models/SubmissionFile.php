<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionFile extends Model
{
    protected $fillable = [
        'submission_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];
    
    public function submission(): BelongsTo
    {
        return $this->belongsTo(CompetitionSubmission::class, 'submission_id');
    }
    
    public function getFileSizeFormattedAttribute(): string
    {
        $size = $this->file_size;
        if ($size < 1024) return $size . ' B';
        if ($size < 1024 * 1024) return round($size / 1024, 1) . ' KB';
        return round($size / (1024 * 1024), 1) . ' MB';
    }
}
