<?php

namespace App\Services\Leaderboard;

use App\Models\User;
use App\Models\LeaderboardSnapshot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LeaderboardService
{
    protected int $cacheTtl = 3600; // 1 hour
    
    /**
     * Get leaderboard for a period
     */
    public function getLeaderboard(string $period = 'alltime', int $limit = 20): array
    {
        $cacheKey = "leaderboard_{$period}_{$limit}";
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($period, $limit) {
            // Try to get from snapshot first
            $snapshot = LeaderboardSnapshot::where('period', $period)
                ->latest('created_at')
                ->first();
            
            if ($snapshot && $snapshot->created_at->isToday()) {
                return $this->formatSnapshotData($snapshot, $limit);
            }
            
            // Calculate live
            return $this->calculateLive($period, $limit);
        });
    }
    
    /**
     * Calculate leaderboard live from database
     */
    protected function calculateLive(string $period, int $limit): array
    {
        $query = DB::table('member_profiles')
            ->join('users', 'member_profiles.user_id', '=', 'users.id')
            ->select([
                'users.id',
                'users.name',
                'member_profiles.points',
                'member_profiles.level',
            ])
            ->orderByDesc('member_profiles.points');
        
        // Apply period filter
        if ($period === 'monthly') {
            $query->where('member_profiles.updated_at', '>=', now()->startOfMonth());
        } elseif ($period === 'weekly') {
            $query->where('member_profiles.updated_at', '>=', now()->startOfWeek());
        }
        
        $results = $query->limit($limit)->get();
        
        return $results->map(function ($user, $index) {
            return [
                'rank' => $index + 1,
                'user_id' => $user->id,
                'name' => $user->name,
                'points' => $user->points,
                'level' => $user->level,
                'trend' => 'neutral', // No trend for live calculation
            ];
        })->toArray();
    }
    
    /**
     * Format snapshot data
     */
    protected function formatSnapshotData(LeaderboardSnapshot $snapshot, int $limit): array
    {
        $data = $snapshot->data;
        return array_slice($data, 0, $limit);
    }
    
    /**
     * Get user position in leaderboard
     */
    public function getUserPosition(User $user, string $period = 'alltime'): ?array
    {
        $profile = $user->memberProfile;
        if (!$profile) return null;
        
        // Calculate rank
        $rank = DB::table('member_profiles')
            ->where('points', '>', $profile->points)
            ->count() + 1;
        
        $totalUsers = DB::table('member_profiles')->count();
        
        return [
            'rank' => $rank,
            'points' => $profile->points,
            'total_users' => $totalUsers,
            'percentile' => round((($totalUsers - $rank) / $totalUsers) * 100, 1),
        ];
    }
    
    /**
     * Generate and store leaderboard snapshot
     */
    public function generateSnapshot(string $period = 'alltime'): LeaderboardSnapshot
    {
        $data = $this->calculateLive($period, 100);
        
        // Add trend calculation
        $previousSnapshot = LeaderboardSnapshot::where('period', $period)
            ->latest('created_at')
            ->first();
        
        if ($previousSnapshot) {
            $previousData = collect($previousSnapshot->data)->keyBy('user_id');
            
            foreach ($data as &$entry) {
                $prev = $previousData->get($entry['user_id']);
                if ($prev) {
                    if ($entry['rank'] < $prev['rank']) {
                        $entry['trend'] = 'up';
                    } elseif ($entry['rank'] > $prev['rank']) {
                        $entry['trend'] = 'down';
                    } else {
                        $entry['trend'] = 'neutral';
                    }
                } else {
                    $entry['trend'] = 'new';
                }
            }
        }
        
        return LeaderboardSnapshot::create([
            'period' => $period,
            'data' => $data,
        ]);
    }
    
    /**
     * Clear leaderboard cache
     */
    public function clearCache(): void
    {
        Cache::forget('leaderboard_alltime_20');
        Cache::forget('leaderboard_monthly_20');
        Cache::forget('leaderboard_weekly_20');
    }
}
