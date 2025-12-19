<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;

class CoreDashboardController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'total_core' => User::where('role', 'core')->count(),
            'pending_candidates' => User::where('role', 'candidate')->count(),
            'upcoming_events' => Activity::where('date', '>=', now())->count(),
        ];

        return view('core.dashboard', compact('stats'));
    }
}
