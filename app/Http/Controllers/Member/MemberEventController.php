<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class MemberEventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Upcoming events
        $upcomingEvents = Activity::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->paginate(12);
        
        // My events (attended)
        $myEvents = $user->attendances()
            ->with('activity')
            ->where('status', 'hadir')
            ->latest()
            ->take(6)
            ->get()
            ->pluck('activity');
        
        return view('member.events.index', compact('upcomingEvents', 'myEvents'));
    }

    public function show(Activity $event)
    {
        $user = auth()->user();
        
        // Check if user already registered
        $isRegistered = $user->attendances()
            ->where('activity_id', $event->id)
            ->exists();
        
        return view('member.events.show', compact('event', 'isRegistered'));
    }
}
