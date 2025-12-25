<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DivisionController extends Controller
{
    /**
     * Display a listing of divisions.
     */
    public function index(): View
    {
        $divisions = Division::withCount(['members' => function ($query) {
            $query->where('status', 'active');
        }])->orderBy('order')->paginate(15);
        
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new division.
     */
    public function create(): View
    {
        return view('admin.divisions.create');
    }

    /**
     * Store a newly created division.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'tagline' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'character' => 'nullable|string|max:50',
            'motion_type' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Division::create($validated);

        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a division.
     */
    public function edit(Division $division): View
    {
        return view('admin.divisions.edit', compact('division'));
    }

    /**
     * Update the specified division.
     */
    public function update(Request $request, Division $division): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'tagline' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'character' => 'nullable|string|max:50',
            'motion_type' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $division->update($validated);

        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified division (soft delete).
     * Block if division still has active members.
     */
    public function destroy(Division $division): RedirectResponse
    {
        // Check if division has active members
        $activeMembersCount = $division->members()->where('status', 'active')->count();
        
        if ($activeMembersCount > 0) {
            return redirect()->route('admin.divisions.index')
                ->with('error', "Tidak bisa menghapus divisi ini karena masih memiliki {$activeMembersCount} anggota aktif.");
        }

        $division->delete(); // Soft delete

        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
