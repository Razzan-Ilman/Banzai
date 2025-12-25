<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Division;
use App\Models\Member;
use App\Models\Registration;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\QuizResult;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with enhanced charts.
     */
    public function index(): View
    {
        // Basic Stats
        $stats = [
            'members' => Member::count(),
            'divisions' => Division::count(),
            'activities' => Activity::count(),
            'pending_registrations' => Registration::pending()->count(),
            'total_users' => User::count(),
            'active_events' => Event::where('event_date', '>=', now())->count(),
        ];

        // Chart Data: Member Growth (Last 6 months)
        $memberGrowth = $this->getMemberGrowthData();
        
        // Chart Data: Registration by Division
        $divisionStats = $this->getDivisionStats();
        
        // Chart Data: Attendance Trend (Last 30 days)
        $attendanceTrend = $this->getAttendanceTrend();
        
        // Chart Data: Quiz Performance
        $quizStats = $this->getQuizStats();

        $recentRegistrations = Registration::latest()->take(5)->get();
        $recentActivities = Activity::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentRegistrations', 
            'recentActivities',
            'memberGrowth',
            'divisionStats',
            'attendanceTrend',
            'quizStats'
        ));
    }

    private function getMemberGrowthData(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Member::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $months->push([
                'month' => $date->format('M Y'),
                'count' => $count,
            ]);
        }
        return $months->toArray();
    }

    private function getDivisionStats(): array
    {
        return Division::withCount('members')
            ->get()
            ->map(fn($d) => ['name' => $d->name, 'count' => $d->members_count])
            ->toArray();
    }

    private function getAttendanceTrend(): array
    {
        $days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Attendance::whereDate('created_at', $date)->count();
            $days->push([
                'date' => $date->format('d M'),
                'count' => $count,
            ]);
        }
        return $days->toArray();
    }

    private function getQuizStats(): array
    {
        $groups = ['MUSASHI', 'AME-NO-UZUME', 'FUJIN', 'YAMATO'];
        $stats = [];
        
        foreach ($groups as $group) {
            $stats[] = [
                'group' => $group,
                'count' => QuizResult::where('assigned_group', $group)->count(),
            ];
        }
        
        return $stats;
    }
}
