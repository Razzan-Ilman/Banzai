<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Models\Discussion;
use App\Models\Article;
use App\Models\Event;
use App\Models\Gallery;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return view('search.index', ['results' => collect(), 'query' => $query]);
        }
        
        $results = collect();
        
        // Search Materials
        $materials = Material::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(fn($m) => [
                'type' => 'material',
                'icon' => '📚',
                'title' => $m->title,
                'description' => Str::limit($m->content, 100),
                'url' => route('member.materials.show', $m),
            ]);
        $results = $results->merge($materials);
        
        // Search Discussions
        $discussions = Discussion::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($d) => [
                'type' => 'discussion',
                'icon' => '💬',
                'title' => $d->title,
                'description' => Str::limit($d->content, 100),
                'url' => route('member.forum.show', $d),
            ]);
        $results = $results->merge($discussions);
        
        // Search Articles
        $articles = Article::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(fn($a) => [
                'type' => 'article',
                'icon' => '📝',
                'title' => $a->title,
                'description' => Str::limit($a->excerpt ?? $a->content, 100),
                'url' => route('blog.show', $a),
            ]);
        $results = $results->merge($articles);
        
        // Search Events
        $events = Event::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($e) => [
                'type' => 'event',
                'icon' => '🎉',
                'title' => $e->title,
                'description' => Str::limit($e->description, 100),
                'url' => route('member.events.show', $e),
            ]);
        $results = $results->merge($events);
        
        // Search Galleries
        $galleries = Gallery::published()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($g) => [
                'type' => 'gallery',
                'icon' => '📷',
                'title' => $g->title,
                'description' => Str::limit($g->description, 100),
                'url' => route('gallery.show', $g),
            ]);
        $results = $results->merge($galleries);
        
        return view('search.index', [
            'results' => $results,
            'query' => $query,
        ]);
    }
    
    /**
     * API endpoint for instant search
     */
    public function instant(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json(['results' => []]);
        }
        
        $results = collect();
        
        // Quick search across multiple models (limit to 3 each)
        $materials = Material::where('is_published', true)
            ->where('title', 'like', "%{$query}%")
            ->limit(3)
            ->get(['id', 'title', 'slug']);
            
        foreach ($materials as $m) {
            $results->push([
                'type' => 'Materi',
                'title' => $m->title,
                'url' => route('member.materials.show', $m),
            ]);
        }
        
        $articles = Article::published()
            ->where('title', 'like', "%{$query}%")
            ->limit(3)
            ->get(['id', 'title', 'slug']);
            
        foreach ($articles as $a) {
            $results->push([
                'type' => 'Artikel',
                'title' => $a->title,
                'url' => route('blog.show', $a),
            ]);
        }
        
        return response()->json(['results' => $results->take(8)]);
    }
}
