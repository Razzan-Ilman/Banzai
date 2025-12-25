<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetitionSubmission extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'event_id',
        'user_id',
        'title',
        'description',
        'status',
    ];
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class, 'submission_id');
    }
    
    public function scores(): HasMany
    {
        return $this->hasMany(SubmissionScore::class, 'submission_id');
    }
    
    public function getAverageScoreAttribute(): ?float
    {
        $avg = $this->scores()->avg('score');
        return $avg ? round($avg, 2) : null;
    }
    
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Terkirim',
            'reviewed' => 'Ditinjau',
            'scored' => 'Dinilai',
            default => $this->status,
        };
    }
    
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
