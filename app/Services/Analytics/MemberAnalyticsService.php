<?php

namespace App\Services\Analytics;

use App\Models\User;
use App\Models\QuizResult;
use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberAnalyticsService
{
    /**
     * Cache TTL in seconds (1 hour)
     */
    protected int $cacheTtl = 3600;
    
    /**
     * Get comprehensive analytics for a member
     */
    public function getAnalytics(User $user): array
    {
        $cacheKey = "member_analytics_{$user->id}";
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($user) {
            return [
                'attendance' => $this->getAttendanceStats($user),
                'quiz' => $this->getQuizStats($user),
                'points' => $this->getPointsStats($user),
                'activity' => $this->getActivityStats($user),
            ];
        });
    }
    
    /**
     * Get attendance statistics
     */
    public function getAttendanceStats(User $user): array
    {
        $totalMeetings = Attendance::distinct('event_id')->count();
        $attended = Attendance::where('user_id', $user->id)->count();
        
        $rate = $totalMeetings > 0 
            ? round(($attended / $totalMeetings) * 100, 1) 
            : 0;
        
        // Monthly breakdown
        $monthlyData = Attendance::where('user_id', $user->id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        
        return [
            'total_attended' => $attended,
            'total_meetings' => $totalMeetings,
            'rate' => $rate,
            'monthly' => $monthlyData,
            'streak' => $this->calculateAttendanceStreak($user),
        ];
    }
    
    /**
     * Get quiz statistics
     */
    public function getQuizStats(User $user): array
    {
        $results = QuizResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($results->isEmpty()) {
            return [
                'total_quizzes' => 0,
                'average_score' => 0,
                'highest_score' => 0,
                'latest_score' => null,
                'trend' => 'neutral',
                'history' => [],
            ];
        }
        
        $history = $results->map(fn($r) => [
            'date' => $r->created_at->format('M Y'),
            'score' => $r->total_score,
            'group' => $r->group->name ?? '-',
        ])->take(6)->toArray();
        
        // Calculate trend
        $trend = 'neutral';
        if ($results->count() >= 2) {
            $latest = $results->first()->total_score;
            $previous = $results->skip(1)->first()->total_score;
            $trend = $latest > $previous ? 'up' : ($latest < $previous ? 'down' : 'neutral');
        }
        
        return [
            'total_quizzes' => $results->count(),
            'average_score' => round($results->avg('total_score'), 1),
            'highest_score' => $results->max('total_score'),
            'latest_score' => $results->first()->total_score,
            'trend' => $trend,
            'history' => $history,
        ];
    }
    
    /**
     * Get points statistics
     */
    public function getPointsStats(User $user): array
    {
        $profile = $user->memberProfile;
        
        if (!$profile) {
            return [
                'total' => 0,
                'level' => 1,
                'rank' => null,
                'next_level_points' => 100,
                'progress' => 0,
            ];
        }
        
        // Calculate rank
        $rank = DB::table('member_profiles')
            ->where('points', '>', $profile->points)
            ->count() + 1;
        
        // Level thresholds
        $currentLevel = $profile->level;
        $levelThresholds = [100, 250, 500, 1000, 2000, 5000, 10000];
        $nextThreshold = $levelThresholds[$currentLevel] ?? 99999;
        $prevThreshold = $currentLevel > 1 ? $levelThresholds[$currentLevel - 2] : 0;
        
        $progress = min(100, round(
            (($profile->points - $prevThreshold) / ($nextThreshold - $prevThreshold)) * 100
        ));
        
        return [
            'total' => $profile->points,
            'level' => $currentLevel,
            'rank' => $rank,
            'next_level_points' => $nextThreshold,
            'progress' => $progress,
        ];
    }
    
    /**
     * Get activity statistics
     */
    public function getActivityStats(User $user): array
    {
        $joinDate = $user->created_at;
        $daysSinceJoin = $joinDate->diffInDays(now());
        
        return [
            'joined_at' => $joinDate->format('d M Y'),
            'days_as_member' => $daysSinceJoin,
            'last_active' => $user->updated_at->diffForHumans(),
        ];
    }
    
    /**
     * Calculate attendance streak
     */
    protected function calculateAttendanceStreak(User $user): int
    {
        // Simplified streak calculation
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return $attendances->count();
    }
    
    /**
     * Clear analytics cache for a user
     */
    public function clearCache(User $user): void
    {
        Cache::forget("member_analytics_{$user->id}");
    }
}
