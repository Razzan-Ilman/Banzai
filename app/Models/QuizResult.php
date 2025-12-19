<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'month',
        'year',
        'answers',
        'scores',
        'total_score',
        'is_same_as_previous',
    ];

    protected $casts = [
        'answers' => 'array',
        'scores' => 'array',
        'is_same_as_previous' => 'boolean',
    ];

    /**
     * Get the user that owns the quiz result
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the group assigned by this quiz
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Check if user has taken quiz this month
     */
    public static function hasCompletedThisMonth($userId)
    {
        return self::where('user_id', $userId)
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->exists();
    }

    /**
     * Get previous month's result
     */
    public static function getPreviousResult($userId)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Get previous month
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
        
        if ($previousMonth < 1) {
            $previousMonth = 12;
            $previousYear--;
        }
        
        return self::where('user_id', $userId)
            ->where('month', $previousMonth)
            ->where('year', $previousYear)
            ->first();
    }
}
