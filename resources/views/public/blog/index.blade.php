@extends('layouts.app')

@section('title', 'Blog - BANZAI')

@section('content')
<div class="blog-public-page" style="padding: 4rem 0;">
    <div class="container">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">📝 Blog BANZAI</h1>
            <p style="color: var(--neutral-600); font-size: 1.125rem;">Berita, tips, dan informasi seputar bahasa & budaya Jepang</p>
        </div>

        <!-- Category Filter -->
        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 2rem; flex-wrap: wrap;">
            <a href="{{ route('blog') }}" style="padding: 0.5rem 1rem; border-radius: 50px; text-decoration: none; {{ !request('category') ? 'background: var(--primary-600); color: white;' : 'background: var(--neutral-100); color: var(--neutral-700);' }}">
                Semua
            </a>
            @foreach(['berita' => '📰 Berita', 'tips' => '💡 Tips', 'budaya' => '🎌 Budaya', 'event' => '🎉 Event'] as $key => $label)
                <a href="{{ route('blog', ['category' => $key]) }}" style="padding: 0.5rem 1rem; border-radius: 50px; text-decoration: none; {{ request('category') === $key ? 'background: var(--primary-600); color: white;' : 'background: var(--neutral-100); color: var(--neutral-700);' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Articles Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            @forelse($articles as $article)
                <a href="{{ route('blog.show', $article) }}" class="article-card" style="display: block; text-decoration: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; background: white;">
                    <!-- Thumbnail -->
                    <div style="height: 180px; background: {{ $article->thumbnail ? "url('" . asset('storage/' . $article->thumbnail) . "') center/cover" : 'linear-gradient(135deg, #EC4899, #F59E0B)' }};">
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="background: var(--primary-100); color: var(--primary-700); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem;">
                                {{ $article->category_label }}
                            </span>
                            <span style="color: var(--neutral-400); font-size: 0.75rem;">
                                {{ $article->read_time }} min read
                            </span>
                        </div>
                        
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--ink-900); margin-bottom: 0.5rem; line-height: 1.4;">
                            {{ $article->title }}
                        </h3>
                        
                        @if($article->excerpt)
                            <p style="color: var(--neutral-500); font-size: 0.875rem; line-height: 1.6; margin-bottom: 1rem;">
                                {{ Str::limit($article->excerpt, 100) }}
                            </p>
                        @endif
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; color: var(--neutral-400); font-size: 0.75rem;">
                            <span>{{ $article->author->name ?? 'Admin' }}</span>
                            <span>{{ $article->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📝</div>
                    <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Belum Ada Artikel</h3>
                    <p style="color: var(--neutral-500);">Artikel akan segera hadir</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $articles->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .article-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
</style>
@endsection
