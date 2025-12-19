<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Load or create member profile
        $profile = $user->memberProfile;
        if (!$profile) {
            // Auto-create profile for new members
            $profile = \App\Models\MemberProfile::create([
                'user_id' => $user->id,
                'member_number' => 'BNZ-' . date('Y') . '-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                'level' => 1,
                'points' => 0,
                'xp' => 0,
            ]);
        }
        
        // Get current group assignment
        $currentGroup = $user->currentGroup;
        
        // Member statistics
        $stats = [
            'total_events' => $user->attendances()->where('status', 'hadir')->count(),
            'points' => $profile->points,
            'level' => $profile->level,
            'xp' => $profile->xp,
            'xp_progress' => $profile->getXpProgress(),
            'upcoming_events' => \App\Models\Activity::where('date', '>=', now())->take(3)->get(),
            'current_group' => $currentGroup,
            'medals' => $user->medals,
        ];

        return view('member.dashboard', compact('stats', 'profile'));
    }
}
