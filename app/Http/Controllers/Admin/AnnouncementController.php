<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementTarget;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->latest()
            ->paginate(15);
        
        return view('admin.announcements.index', [
            'announcements' => $announcements,
        ]);
    }
    
    public function create()
    {
        return view('admin.announcements.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,success,event',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_published' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
            'target_type' => 'required|in:all,role,user',
            'target_value' => 'nullable|string',
        ]);
        
        $announcement = Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => $validated['is_published'] ? now() : null,
            'expires_at' => $validated['expires_at'] ?? null,
            'created_by' => auth()->id(),
        ]);
        
        // Add target
        $announcement->targets()->create([
            'target_type' => $validated['target_type'],
            'target_value' => $validated['target_value'],
        ]);
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat!');
    }
    
    public function edit(Announcement $announcement)
    {
        $announcement->load('targets');
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
        ]);
    }
    
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,success,event',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_published' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);
        
        $wasPublished = $announcement->is_published;
        $isPublished = $validated['is_published'] ?? false;
        
        $announcement->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'is_published' => $isPublished,
            'published_at' => $isPublished && !$wasPublished ? now() : $announcement->published_at,
            'expires_at' => $validated['expires_at'],
        ]);
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }
    
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }
    
    public function togglePublish(Announcement $announcement)
    {
        $announcement->update([
            'is_published' => !$announcement->is_published,
            'published_at' => !$announcement->is_published ? now() : $announcement->published_at,
        ]);
        
        return redirect()->back()
            ->with('success', $announcement->is_published ? 'Pengumuman dipublikasikan!' : 'Pengumuman di-unpublish!');
    }
}
