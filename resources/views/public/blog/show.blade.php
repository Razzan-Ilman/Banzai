@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title . ' - BANZAI Blog')

@section('meta')
    <meta name="description" content="{{ $article->meta_description ?: $article->excerpt }}">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt }}">
    @if($article->thumbnail)
        <meta property="og:image" content="{{ asset('storage/' . $article->thumbnail) }}">
    @endif
@endsection

@section('content')
<div class="blog-show-page" style="padding: 4rem 0;">
    <div class="container" style="max-width: 800px;">
        <!-- Back Button -->
        <a href="{{ route('blog') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 2rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Blog
        </a>

        <!-- Article Header -->
        <article>
            <header style="margin-bottom: 2rem;">
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                    <span style="background: var(--primary-100); color: var(--primary-700); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.875rem;">
                        {{ $article->category_label }}
                    </span>
                </div>
                
                <h1 style="font-size: 2.25rem; font-weight: 700; color: var(--ink-900); margin-bottom: 1rem; line-height: 1.3;">
                    {{ $article->title }}
                </h1>
                
                <div style="display: flex; align-items: center; gap: 1rem; color: var(--neutral-500); font-size: 0.875rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #F59E0B); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.75rem;">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                        </div>
                        <span>{{ $article->author->name ?? 'Admin' }}</span>
                    </div>
                    <span>📅 {{ $article->published_at->format('d M Y') }}</span>
                    <span>⏱️ {{ $article->read_time }} min read</span>
                    <span>👁️ {{ number_format($article->views_count) }} views</span>
                </div>
            </header>

            <!-- Featured Image -->
            @if($article->thumbnail)
                <div style="margin-bottom: 2rem; border-radius: 16px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" style="width: 100%; height: auto;">
                </div>
            @endif

            <!-- Excerpt -->
            @if($article->excerpt)
                <p style="font-size: 1.25rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 2rem; padding: 1.5rem; background: var(--neutral-50); border-radius: 12px; border-left: 4px solid var(--primary-500);">
                    {{ $article->excerpt }}
                </p>
            @endif

            <!-- Content -->
            <div class="article-content" style="font-size: 1.125rem; line-height: 1.8; color: var(--ink-800);">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Share -->
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--neutral-200);">
                <h4 style="font-size: 1rem; color: var(--neutral-500); margin-bottom: 1rem;">Bagikan artikel ini</h4>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" style="padding: 0.5rem 1rem; background: #1DA1F2; color: white; border-radius: 8px; text-decoration: none; font-size: 0.875rem;">
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" style="padding: 0.5rem 1rem; background: #4267B2; color: white; border-radius: 8px; text-decoration: none; font-size: 0.875rem;">
                        Facebook
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" style="padding: 0.5rem 1rem; background: #25D366; color: white; border-radius: 8px; text-decoration: none; font-size: 0.875rem;">
                        WhatsApp
                    </a>
                </div>
            </div>
        </article>

        <!-- Related Articles -->
        @if(isset($related) && $related->count() > 0)
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--neutral-200);">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--ink-900); margin-bottom: 1.5rem;">Artikel Terkait</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                    @foreach($related as $rel)
                        <a href="{{ route('blog.show', $rel) }}" style="display: block; padding: 1rem; background: var(--neutral-50); border-radius: 12px; text-decoration: none; transition: background 0.2s;">
                            <h4 style="font-weight: 600; color: var(--ink-900); font-size: 0.875rem; margin-bottom: 0.25rem;">{{ $rel->title }}</h4>
                            <span style="font-size: 0.75rem; color: var(--neutral-500);">{{ $rel->published_at->format('d M Y') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .article-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
