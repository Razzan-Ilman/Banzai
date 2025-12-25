<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request): View
    {
        $query = Member::with(['division', 'positionRole']);
        
        // Filter by status
        $status = $request->get('status', 'active');
        if ($status === 'alumni') {
            $query->alumni();
        } elseif ($status === 'all') {
            // Show all
        } else {
            $query->active();
        }
        
        $members = $query->orderBy('order')->paginate(15);
        
        return view('admin.members.index', compact('members', 'status'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create(): View
    {
        $divisions = Division::active()->get();
        $positions = Position::active()->get();
        
        return view('admin.members.create', compact('divisions', 'positions'));
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'class' => 'required|string|max:20',
            'major' => 'required|string|max:100',
            'position' => 'nullable|string|max:50',
            'position_id' => 'nullable|exists:positions,id',
            'division_id' => 'nullable|exists:divisions,id',
            'initial_color' => 'nullable|string|max:20',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['status'] = 'active';
        $validated['start_date'] = now();

        Member::create($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a member.
     */
    public function edit(Member $member): View
    {
        $divisions = Division::active()->get();
        $positions = Position::active()->get();
        
        return view('admin.members.edit', compact('member', 'divisions', 'positions'));
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'class' => 'required|string|max:20',
            'major' => 'required|string|max:100',
            'position' => 'nullable|string|max:50',
            'position_id' => 'nullable|exists:positions,id',
            'division_id' => 'nullable|exists:divisions,id',
            'initial_color' => 'nullable|string|max:20',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $member->update($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified member (soft delete).
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Show the form to replace a member (graduate and add new).
     */
    public function replaceForm(Member $member): View
    {
        $divisions = Division::active()->get();
        $positions = Position::active()->get();
        
        return view('admin.members.replace', compact('member', 'divisions', 'positions'));
    }

    /**
     * Replace the old member with a new one.
     * Old member becomes alumni, new member is created fresh.
     */
    public function replace(Request $request, Member $member): RedirectResponse
    {
        // Validate confirmation checkbox
        $request->validate([
            'confirm_replace' => 'required|accepted',
            'new_name' => 'required|string|max:100',
            'new_class' => 'required|string|max:20',
            'new_major' => 'required|string|max:100',
        ]);

        // Mark old member as alumni
        $member->update([
            'status' => 'alumni',
            'is_active' => false,
            'end_date' => now(),
        ]);

        // Create new member with same position/division
        Member::create([
            'name' => $request->input('new_name'),
            'class' => $request->input('new_class'),
            'major' => $request->input('new_major'),
            'position' => $member->position,
            'position_id' => $member->position_id,
            'division_id' => $member->division_id,
            'order' => $member->order,
            'is_active' => true,
            'status' => 'active',
            'start_date' => now(),
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', "Anggota {$member->name} berhasil diganti dengan {$request->input('new_name')}.");
    }
}
