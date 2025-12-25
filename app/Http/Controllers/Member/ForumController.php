<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $query = Discussion::with(['user', 'latestReply.user']);
        
        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Get pinned first, then recent
        $pinned = Discussion::pinned()
            ->with(['user', 'latestReply.user'])
            ->limit(5)
            ->get();
        
        $discussions = $query->notPinned()
            ->recent()
            ->paginate(15);
        
        return view('member.forum.index', [
            'pinned' => $pinned,
            'discussions' => $discussions,
            'categories' => ['umum', 'belajar', 'event', 'off-topic'],
        ]);
    }
    
    public function create()
    {
        return view('member.forum.create', [
            'categories' => ['umum', 'belajar', 'event', 'off-topic'],
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category' => 'required|string|in:umum,belajar,event,off-topic',
        ]);
        
        $discussion = Discussion::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(6),
            'content' => $validated['content'],
            'category' => $validated['category'],
        ]);
        
        return redirect()->route('member.forum.show', $discussion)
            ->with('success', 'Diskusi berhasil dibuat!');
    }
    
    public function show(Discussion $discussion)
    {
        $discussion->incrementViews();
        $discussion->load(['user', 'replies.user', 'replies.children.user']);
        
        // Get root replies only (no parent)
        $replies = $discussion->replies()
            ->whereNull('parent_id')
            ->with(['user', 'children.user'])
            ->orderBy('created_at')
            ->get();
        
        return view('member.forum.show', [
            'discussion' => $discussion,
            'replies' => $replies,
        ]);
    }
    
    public function reply(Request $request, Discussion $discussion)
    {
        if ($discussion->is_locked) {
            return redirect()->back()->with('error', 'Diskusi ini sudah dikunci.');
        }
        
        $validated = $request->validate([
            'content' => 'required|string|min:3',
            'parent_id' => 'nullable|exists:discussion_replies,id',
        ]);
        
        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);
        
        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan!');
    }
    
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete', $discussion);
        
        $discussion->delete();
        
        return redirect()->route('member.forum.index')
            ->with('success', 'Diskusi berhasil dihapus!');
    }
}
