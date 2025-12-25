<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;
use App\Models\User;
use App\Models\Group;
use App\Services\Quiz\QuizConsistencyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizHistoryController extends Controller
{
    /**
     * Display quiz history with insights
     */
    public function index(Request $request): View
    {
        $query = QuizResult::with(['user.title', 'group'])
            ->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by group
        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        // Filter by month/year
        if ($request->filled('month') && $request->filled('year')) {
            $query->where('month', $request->month)
                  ->where('year', $request->year);
        }

        // Filter borderline only
        if ($request->boolean('borderline')) {
            $query->borderline();
        }

        $results = $query->paginate(20);

        // Add consistency data to each result
        $results->getCollection()->transform(function ($result) {
            $result->consistency = QuizConsistencyService::check($result->user);
            $result->streak = QuizConsistencyService::getStreak($result->user);
            return $result;
        });

        // Stats
        $stats = [
            'total_quizzes' => QuizResult::count(),
            'this_month' => QuizResult::where('month', now()->month)
                                       ->where('year', now()->year)
                                       ->count(),
            'borderline_count' => QuizResult::borderline()->count(),
            'title_holders' => User::whereNotNull('title_id')->count(),
        ];

        // Get users and groups for filter
        $users = User::whereHas('quizResults')
            ->orderBy('name')
            ->get(['id', 'name']);
        $groups = Group::orderBy('name')->get();

        return view('admin.quiz-history.index', compact(
            'results', 
            'stats', 
            'users', 
            'groups'
        ));
    }

    /**
     * View detailed user quiz history
     */
    public function userHistory(User $user): View
    {
        $results = QuizResult::with('group')
            ->where('user_id', $user->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $consistency = QuizConsistencyService::check($user);
        $progress = QuizConsistencyService::getProgress($user);
        $streak = QuizConsistencyService::getStreak($user);

        return view('admin.quiz-history.user', compact(
            'user',
            'results',
            'consistency',
            'progress',
            'streak'
        ));
    }
}
