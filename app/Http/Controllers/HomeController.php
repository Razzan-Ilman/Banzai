<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Division;
use App\Models\Member;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $divisions = Division::active()->get();
        $featuredActivities = Activity::featured()->take(3)->get();
        $leaders = Member::leaders()->active()->get();

        return view('public.home', compact('divisions', 'featuredActivities', 'leaders'));
    }

    /**
     * Display the profile and history page.
     */
    public function profile(): View
    {
        return view('public.profile');
    }

    /**
     * Display the divisions page.
     */
    public function divisions(): View
    {
        $divisions = Division::active()->with('activeMembers')->get();

        return view('public.divisions', compact('divisions'));
    }

    /**
     * Display the members/structure page.
     */
    public function members(): View
    {
        $leaders = Member::leaders()->active()->get();
        $divisions = Division::active()->with('activeMembers')->get();

        return view('public.members', compact('leaders', 'divisions'));
    }

    /**
     * Display the activities page.
     */
    public function activities(): View
    {
        $activities = Activity::published()->paginate(9);

        return view('public.activities', compact('activities'));
    }

    /**
     * Display the gallery page.
     */
    public function gallery(): View
    {
        return view('public.gallery');
    }
}
