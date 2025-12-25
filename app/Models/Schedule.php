<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Schedule extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'title',
        'description',
        'type',
        'location',
        'start_date',
        'end_date',
        'is_recurring',
        'recurrence_rule',
        'created_by',
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_recurring' => 'boolean',
    ];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
            ->orderBy('start_date');
    }
    
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year);
    }
    
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
    
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'meeting' => 'Rapat',
            'event' => 'Acara',
            'practice' => 'Latihan',
            'other' => 'Lainnya',
            default => ucfirst($this->type),
        };
    }
    
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'meeting' => '#0EA5E9',
            'event' => '#EC4899',
            'practice' => '#10B981',
            'other' => '#737373',
            default => '#737373',
        };
    }
    
    public function getDurationAttribute(): string
    {
        if (!$this->end_date) return '-';
        
        $diff = $this->start_date->diff($this->end_date);
        if ($diff->h > 0) return "{$diff->h} jam";
        return "{$diff->i} menit";
    }
}
