<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Division;
use App\Models\Member;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'members' => Member::count(),
            'divisions' => Division::count(),
            'activities' => Activity::count(),
            'pending_registrations' => Registration::pending()->count(),
        ];

        $recentRegistrations = Registration::latest()->take(5)->get();
        $recentActivities = Activity::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'recentActivities'));
    }
}
