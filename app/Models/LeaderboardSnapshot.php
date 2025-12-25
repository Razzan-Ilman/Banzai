<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardSnapshot extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'period',
        'data',
    ];
    
    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];
    
    public function scopePeriod($query, string $period)
    {
        return $query->where('period', $period);
    }
}
