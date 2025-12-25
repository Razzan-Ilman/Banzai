<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('creator')
            ->withCount('photos')
            ->latest()
            ->paginate(12);
        
        return view('admin.galleries.index', [
            'galleries' => $galleries,
        ]);
    }
    
    public function create()
    {
        return view('admin.galleries.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);
        
        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'is_published' => $validated['is_published'] ?? false,
            'created_by' => auth()->id(),
        ]);
        
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('galleries/covers', 'public');
            $gallery->update(['cover_image' => $path]);
        }
        
        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Galeri berhasil dibuat!');
    }
    
    public function show(Gallery $gallery)
    {
        $gallery->load(['photos.uploader', 'creator']);
        
        return view('admin.galleries.show', [
            'gallery' => $gallery,
        ]);
    }
    
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', [
            'gallery' => $gallery,
        ]);
    }
    
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);
        
        $gallery->update($validated);
        
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui!');
    }
    
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus!');
    }
    
    public function uploadPhotos(Request $request, Gallery $gallery)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|max:5120',
        ]);
        
        $count = 0;
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('galleries/' . $gallery->id, 'public');
            
            GalleryPhoto::create([
                'gallery_id' => $gallery->id,
                'image_path' => $path,
                'uploaded_by' => auth()->id(),
                'sort_order' => $gallery->photos()->count(),
            ]);
            $count++;
        }
        
        return redirect()->back()
            ->with('success', "$count foto berhasil diupload!");
    }
    
    public function deletePhoto(GalleryPhoto $photo)
    {
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();
        
        return redirect()->back()
            ->with('success', 'Foto berhasil dihapus!');
    }
}
