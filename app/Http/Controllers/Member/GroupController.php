<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\MemberGroupAssignment;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * Display the member's group page
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Get current active group assignment
        $currentAssignment = MemberGroupAssignment::with('group')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->first();
        
        // If no assignment, check quiz results for group determination
        $latestQuizResult = QuizResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $currentGroup = null;
        $groupMembers = collect();
        $allGroups = Group::all();
        
        if ($currentAssignment && $currentAssignment->group) {
            $currentGroup = $currentAssignment->group;
        } elseif ($latestQuizResult) {
            // Get group from quiz result
            $currentGroup = Group::where('name', $latestQuizResult->assigned_group)->first();
        }
        
        // Get fellow group members if user has a group
        if ($currentGroup) {
            $groupMemberIds = MemberGroupAssignment::where('group_id', $currentGroup->id)
                ->where('is_active', true)
                ->pluck('user_id');
            
            $groupMembers = User::whereIn('id', $groupMemberIds)
                ->where('id', '!=', $user->id)
                ->get();
        }
        
        // Get group history
        $groupHistory = MemberGroupAssignment::with('group')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('member.group.index', compact(
            'currentGroup',
            'currentAssignment',
            'groupMembers',
            'latestQuizResult',
            'groupHistory',
            'allGroups'
        ));
    }
}
