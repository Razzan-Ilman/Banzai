@extends('layouts.member')

@section('title', $discussion->title)

@section('content')
<div class="forum-show-page">
    <!-- Back Button -->
    <a href="{{ route('member.forum.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Forum
    </a>

    <!-- Main Discussion -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1.5rem;">
            <!-- Header -->
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <div style="flex-shrink: 0;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #F59E0B); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.25rem;">
                        {{ strtoupper(substr($discussion->user->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                        <span style="font-weight: 600; color: var(--ink-900);">{{ $discussion->user->name ?? 'Unknown' }}</span>
                        <span style="background: {{ $discussion->category_color }}20; color: {{ $discussion->category_color }}; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                            {{ $discussion->category_label }}
                        </span>
                        @if($discussion->is_pinned)
                            <span style="background: #FEF3C7; color: #D97706; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">📌 Disematkan</span>
                        @endif
                        @if($discussion->is_locked)
                            <span style="background: #FEE2E2; color: #DC2626; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">🔒 Dikunci</span>
                        @endif
                    </div>
                    <div style="color: var(--neutral-500); font-size: 0.875rem;">
                        {{ $discussion->created_at->format('d M Y, H:i') }} • 👁️ {{ $discussion->views_count }} views
                    </div>
                </div>
                
                @if($discussion->user_id === auth()->id())
                    <form action="{{ route('member.forum.destroy', $discussion) }}" method="POST" onsubmit="return confirm('Hapus diskusi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">Hapus</button>
                    </form>
                @endif
            </div>

            <!-- Title & Content -->
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 1rem;">
                {{ $discussion->title }}
            </h1>
            <div style="line-height: 1.8; color: var(--ink-800);">
                {!! nl2br(e($discussion->content)) !!}
            </div>
        </div>
    </div>

    <!-- Replies Section -->
    <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; color: var(--ink-900); margin-bottom: 1rem;">
            💬 {{ $discussion->replies_count }} Balasan
        </h3>

        @forelse($replies as $reply)
            <div class="card" style="margin-bottom: 1rem;" id="reply-{{ $reply->id }}">
                <div class="card-body" style="padding: 1.25rem;">
                    <div style="display: flex; gap: 1rem;">
                        <div style="flex-shrink: 0;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #06B6D4, #3B82F6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                {{ strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <div>
                                    <span style="font-weight: 600; color: var(--ink-900);">{{ $reply->user->name ?? 'Unknown' }}</span>
                                    <span style="color: var(--neutral-500); font-size: 0.875rem; margin-left: 0.5rem;">
                                        {{ $reply->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div style="color: var(--ink-800); line-height: 1.6;">
                                {!! nl2br(e($reply->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body" style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    Belum ada balasan. Jadilah yang pertama!
                </div>
            </div>
        @endforelse
    </div>

    <!-- Reply Form -->
    @if(!$discussion->is_locked)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tulis Balasan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('member.forum.reply', $discussion) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <textarea name="content" required rows="4" placeholder="Tulis balasan kamu..."
                                  style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                        @error('content')
                            <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                </form>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 1.5rem; background: var(--neutral-50); color: var(--neutral-600);">
                🔒 Diskusi ini sudah dikunci dan tidak menerima balasan baru.
            </div>
        </div>
    @endif
</div>
@endsection
