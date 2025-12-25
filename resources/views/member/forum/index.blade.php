@extends('layouts.member')

@section('title', 'Forum Diskusi')

@section('content')
<div class="forum-page">
    <!-- Header -->
    <div class="page-header-section" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.25rem;">💬 Forum Diskusi</h2>
                <p style="color: var(--neutral-600); font-size: 0.875rem;">Diskusi dan berbagi dengan sesama member</p>
            </div>
            <a href="{{ route('member.forum.create') }}" class="btn btn-primary">
                + Buat Diskusi
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1rem;">
            <form action="{{ route('member.forum.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari diskusi..." 
                           style="width: 100%; padding: 0.5rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px;">
                </div>
                <select name="category" style="padding: 0.5rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <!-- Pinned Discussions -->
    @if($pinned->count() > 0)
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 0.875rem; color: var(--neutral-500); margin-bottom: 0.75rem;">📌 Disematkan</h3>
            @foreach($pinned as $discussion)
                <a href="{{ route('member.forum.show', $discussion) }}" class="card" style="display: block; margin-bottom: 0.75rem; text-decoration: none; border-left: 3px solid #F59E0B;">
                    <div class="card-body" style="padding: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="background: {{ $discussion->category_color }}20; color: {{ $discussion->category_color }}; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem; margin-right: 0.5rem;">
                                    {{ $discussion->category_label }}
                                </span>
                                <span style="font-weight: 600; color: var(--ink-900);">{{ $discussion->title }}</span>
                            </div>
                            <span style="color: var(--neutral-500); font-size: 0.875rem;">{{ $discussion->replies_count }} balasan</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    <!-- Discussions List -->
    <div class="card">
        <div class="card-body" style="padding: 0;">
            @forelse($discussions as $discussion)
                <a href="{{ route('member.forum.show', $discussion) }}" style="display: block; padding: 1.25rem; border-bottom: 1px solid var(--neutral-200); text-decoration: none; transition: background 0.2s;">
                    <div style="display: flex; gap: 1rem;">
                        <!-- Avatar -->
                        <div style="flex-shrink: 0;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #F59E0B); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                {{ strtoupper(substr($discussion->user->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <span style="background: {{ $discussion->category_color }}20; color: {{ $discussion->category_color }}; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                                    {{ $discussion->category_label }}
                                </span>
                            </div>
                            <h3 style="font-size: 1rem; font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">
                                {{ $discussion->title }}
                            </h3>
                            <p style="color: var(--neutral-500); font-size: 0.875rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ Str::limit($discussion->content, 100) }}
                            </p>
                            <div style="display: flex; gap: 1rem; margin-top: 0.5rem; color: var(--neutral-500); font-size: 0.75rem;">
                                <span>{{ $discussion->user->name ?? 'Unknown' }}</span>
                                <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                <span>👁️ {{ $discussion->views_count }}</span>
                                <span>💬 {{ $discussion->replies_count }}</span>
                            </div>
                        </div>

                        <!-- Latest Reply -->
                        @if($discussion->latestReply)
                            <div style="flex-shrink: 0; text-align: right; color: var(--neutral-500); font-size: 0.75rem;">
                                <div>Terakhir dibalas</div>
                                <div>{{ $discussion->last_reply_at?->diffForHumans() }}</div>
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div style="padding: 3rem; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
                    <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Belum Ada Diskusi</h3>
                    <p style="color: var(--neutral-500); margin-bottom: 1rem;">Jadilah yang pertama memulai diskusi!</p>
                    <a href="{{ route('member.forum.create') }}" class="btn btn-primary">Buat Diskusi</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($discussions->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $discussions->withQueryString()->links() }}
        </div>
    @endif
</div>

<style>
    .forum-page .card:hover {
        background: var(--neutral-50);
    }
</style>
@endsection
