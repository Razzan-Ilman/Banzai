<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\Leaderboard\LeaderboardService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __construct(
        protected LeaderboardService $leaderboardService
    ) {}

    /**
     * Display leaderboard
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'alltime');
        
        $leaderboard = $this->leaderboardService->getLeaderboard($period, 20);
        $userPosition = $this->leaderboardService->getUserPosition($request->user(), $period);
        
        return view('member.leaderboard.index', [
            'leaderboard' => $leaderboard,
            'userPosition' => $userPosition,
            'period' => $period,
            'user' => $request->user(),
        ]);
    }
}
