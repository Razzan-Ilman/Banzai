<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStat extends Model
{
    protected $fillable = [
        'date',
        'total_users',
        'active_users',
        'new_users',
        'attendance_count',
        'quiz_count',
        'event_registrations',
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }
    
    public function scopeForRange($query, $from, $to)
    {
        return $query->whereBetween('date', [$from, $to]);
    }
    
    public function scopeLastDays($query, int $days)
    {
        return $query->where('date', '>=', now()->subDays($days));
    }
}
