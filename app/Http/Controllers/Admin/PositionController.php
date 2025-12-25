<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * Display a listing of positions.
     */
    public function index(): View
    {
        $positions = Position::withCount(['members' => function ($query) {
            $query->where('status', 'active');
        }])->orderBy('level')->paginate(15);
        
        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new position.
     */
    public function create(): View
    {
        $maxLevel = Position::max('level') ?? 0;
        return view('admin.positions.create', compact('maxLevel'));
    }

    /**
     * Store a newly created position.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'level' => [
                'required',
                'integer',
                'min:1',
            ],
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Position::create($validated);

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a position.
     */
    public function edit(Position $position): View
    {
        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified position.
     */
    public function update(Request $request, Position $position): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'level' => [
                'required',
                'integer',
                'min:1',
            ],
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $position->update($validated);

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified position (soft delete).
     * Block if position still has active members.
     */
    public function destroy(Position $position): RedirectResponse
    {
        // Check if position has active members
        $activeMembersCount = $position->members()->where('status', 'active')->count();
        
        if ($activeMembersCount > 0) {
            return redirect()->route('admin.positions.index')
                ->with('error', "Tidak bisa menghapus jabatan ini karena masih digunakan oleh {$activeMembersCount} anggota aktif.");
        }

        $position->delete(); // Soft delete

        return redirect()->route('admin.positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
