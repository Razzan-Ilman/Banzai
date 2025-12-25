<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('author');
        
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        $articles = $query->orderBy('published_at', 'desc')->paginate(12);
        
        return view('public.blog.index', [
            'articles' => $articles,
        ]);
    }
    
    public function show(Article $article)
    {
        abort_unless($article->status === 'published', 404);
        
        $article->incrementViews();
        $article->load('author');
        
        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->limit(3)
            ->get();
        
        return view('public.blog.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
