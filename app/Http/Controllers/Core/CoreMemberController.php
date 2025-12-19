<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CoreMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['member', 'core']);

        // Filter by division if provided
        if ($request->has('division')) {
            $query->where('division_id', $request->division);
        }

        // Filter by status
        if ($request->has('status')) {
            // Add status filter logic here
        }

        $members = $query->orderBy('name')->paginate(20);

        return view('core.members.index', compact('members'));
    }

    public function show(User $member)
    {
        return view('core.members.show', compact('member'));
    }
}
