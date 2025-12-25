<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialProgress;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::published()
            ->with('creator')
            ->withCount(['progress as completed_count' => function($q) {
                $q->where('is_completed', true);
            }]);
        
        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $materials = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get user progress
        $userProgress = MaterialProgress::where('user_id', auth()->id())
            ->pluck('is_completed', 'material_id');
        
        return view('member.materials.index', [
            'materials' => $materials,
            'userProgress' => $userProgress,
            'categories' => ['hiragana', 'katakana', 'kanji', 'grammar', 'culture', 'umum'],
            'difficulties' => ['beginner', 'intermediate', 'advanced'],
            'types' => ['text', 'video', 'pdf', 'external'],
        ]);
    }
    
    public function show(Material $material)
    {
        $this->authorize('view', $material);
        
        $material->incrementViews();
        $material->load('creator');
        
        $progress = $material->userProgress();
        
        // Related materials
        $related = Material::published()
            ->where('id', '!=', $material->id)
            ->where('category', $material->category)
            ->limit(4)
            ->get();
        
        return view('member.materials.show', [
            'material' => $material,
            'progress' => $progress,
            'related' => $related,
        ]);
    }
    
    public function markProgress(Request $request, Material $material)
    {
        MaterialProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'material_id' => $material->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );
        
        return redirect()->back()->with('success', 'Materi ditandai selesai!');
    }
}
