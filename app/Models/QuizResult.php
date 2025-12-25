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
        'is_borderline',
    ];

    protected $casts = [
        'answers' => 'array',
        'scores' => 'array',
        'is_same_as_previous' => 'boolean',
        'is_borderline' => 'boolean',
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
     * Get latest result for this month (handles multiple submissions)
     */
    public static function getLatestThisMonth($userId)
    {
        return self::where('user_id', $userId)
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->latest()
            ->first();
    }

    /**
     * Get last N months results for rolling consistency
     */
    public static function getLastNMonths($userId, int $months = 4)
    {
        $results = collect();
        $date = now();

        for ($i = 0; $i < $months; $i++) {
            $result = self::where('user_id', $userId)
                ->where('month', $date->month)
                ->where('year', $date->year)
                ->latest()
                ->first();

            if ($result) {
                $results->push($result);
            }

            $date = $date->subMonth();
        }

        return $results;
    }

    /**
     * Get rolling consistency data (3 out of 4 months)
     */
    public static function getRollingConsistency($userId): array
    {
        $results = self::getLastNMonths($userId, 4);
        
        if ($results->isEmpty()) {
            return [
                'count' => 0,
                'eligible' => false,
                'dominant_group' => null,
                'progress' => '0/4',
            ];
        }

        // Count group frequency
        $groupCounts = $results->groupBy('group_id')
            ->map(fn($items) => $items->count())
            ->sortDesc();

        $dominantGroupId = $groupCounts->keys()->first();
        $dominantCount = $groupCounts->first();
        
        // Get group name
        $dominantGroup = Group::find($dominantGroupId);

        return [
            'count' => $dominantCount,
            'eligible' => $dominantCount >= 3,
            'dominant_group' => $dominantGroup,
            'progress' => "{$dominantCount}/4",
        ];
    }

    /**
     * Get previous month's result
     */
    public static function getPreviousResult($userId)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
        
        if ($previousMonth < 1) {
            $previousMonth = 12;
            $previousYear--;
        }
        
        return self::where('user_id', $userId)
            ->where('month', $previousMonth)
            ->where('year', $previousYear)
            ->latest()
            ->first();
    }

    /**
     * Scope for borderline results
     */
    public function scopeBorderline($query)
    {
        return $query->where('is_borderline', true);
    }
}
