<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberAttendance;
use App\Models\Activity;
use Illuminate\Http\Request;

class MemberAttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get attendance history
        $attendances = $user->attendances()
            ->with('activity')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        // Stats
        $stats = [
            'total_hadir' => $user->attendances()->where('status', 'hadir')->count(),
            'total_izin' => $user->attendances()->where('status', 'izin')->count(),
            'total_alfa' => $user->attendances()->where('status', 'alfa')->count(),
            'this_month' => $user->attendances()
                ->whereMonth('date', now()->month)
                ->where('status', 'hadir')
                ->count(),
        ];
        
        return view('member.attendance.index', compact('attendances', 'stats'));
    }

    public function checkin()
    {
        // Get today's activities
        $activities = Activity::whereDate('date', today())
            ->orWhere(function($query) {
                $query->whereDate('date', '>=', today())
                      ->whereDate('date', '<=', today()->addDays(7));
            })
            ->get();
        
        return view('member.attendance.checkin', compact('activities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        
        // Check if already checked in
        $existing = MemberAttendance::where('user_id', $user->id)
            ->where('activity_id', $validated['activity_id'])
            ->whereDate('date', today())
            ->first();
        
        if ($existing) {
            return back()->with('error', 'Kamu sudah absen untuk kegiatan ini!');
        }

        // Create attendance
        $attendance = MemberAttendance::create([
            'user_id' => $user->id,
            'activity_id' => $validated['activity_id'],
            'date' => today(),
            'status' => 'hadir',
            'notes' => $validated['notes'],
            'points_earned' => 10, // Default points
        ]);

        // Add points to profile
        $profile = $user->memberProfile;
        $profile->points += 10;
        $profile->xp += 10;
        $profile->save();

        return redirect()->route('member.attendance.index')
            ->with('success', 'Absensi berhasil! +10 poin');
    }
}
