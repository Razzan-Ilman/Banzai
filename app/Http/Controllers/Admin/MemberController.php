<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(): View
    {
        $members = Member::with('division')->orderBy('order')->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create(): View
    {
        $divisions = Division::active()->get();
        return view('admin.members.create', compact('divisions'));
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
            'division_id' => 'nullable|exists:divisions,id',
            'initial_color' => 'nullable|string|max:20',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

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
        return view('admin.members.edit', compact('member', 'divisions'));
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
     * Remove the specified member.
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
