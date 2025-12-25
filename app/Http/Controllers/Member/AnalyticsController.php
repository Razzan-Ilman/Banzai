<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\Analytics\MemberAnalyticsService;
use App\Services\Leaderboard\LeaderboardService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(
        protected MemberAnalyticsService $analyticsService,
        protected LeaderboardService $leaderboardService
    ) {}

    /**
     * Display member analytics dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $analytics = $this->analyticsService->getAnalytics($user);
        $position = $this->leaderboardService->getUserPosition($user);
        
        return view('member.analytics.index', [
            'analytics' => $analytics,
            'position' => $position,
            'user' => $user,
        ]);
    }
    
    /**
     * Refresh analytics cache
     */
    public function refresh(Request $request)
    {
        $this->analyticsService->clearCache($request->user());
        
        return redirect()->route('member.analytics.index')
            ->with('success', 'Statistik berhasil diperbarui!');
    }
}
