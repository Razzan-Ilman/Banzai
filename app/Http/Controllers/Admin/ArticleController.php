<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('author');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        $articles = $query->latest()->paginate(15);
        
        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => ['berita', 'tips', 'budaya', 'event'],
        ]);
    }
    
    public function create()
    {
        return view('admin.articles.create', [
            'categories' => ['berita', 'tips', 'budaya', 'event'],
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,scheduled,published',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'scheduled_at' => 'nullable|date|after:now',
        ]);
        
        $article = Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'author_id' => auth()->id(),
            'status' => $validated['status'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'scheduled_at' => $validated['scheduled_at'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);
        
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('articles/thumbnails', 'public');
            $article->update(['thumbnail' => $path]);
        }
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat!');
    }
    
    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => ['berita', 'tips', 'budaya', 'event'],
        ]);
    }
    
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|in:draft,scheduled,published',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'scheduled_at' => 'nullable|date',
        ]);
        
        $wasPublished = $article->status === 'published';
        $isPublished = $validated['status'] === 'published';
        
        $article->update([
            ...$validated,
            'published_at' => $isPublished && !$wasPublished ? now() : $article->published_at,
        ]);
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }
    
    public function destroy(Article $article)
    {
        $article->delete();
        
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
