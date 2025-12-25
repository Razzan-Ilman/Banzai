@extends('layouts.member')

@section('title', 'Notifikasi')

@section('content')
<div class="notifications-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">🔔 Notifikasi</h2>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('member.notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm" style="background: var(--neutral-100);">
                    ✓ Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body" style="padding: 0;">
            @forelse($notifications as $notification)
                @php
                    $typeColors = [
                        'info' => '#3B82F6',
                        'success' => '#10B981',
                        'warning' => '#F59E0B',
                        'error' => '#EF4444',
                    ];
                    $color = $typeColors[$notification->data['type'] ?? 'info'] ?? '#3B82F6';
                @endphp
                <div style="display: flex; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--neutral-100); {{ !$notification->read_at ? 'background: #F0F9FF;' : '' }}">
                    <div style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; background: {{ $color }}20; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 1.25rem;">
                            @switch($notification->data['type'] ?? 'info')
                                @case('success') ✅ @break
                                @case('warning') ⚠️ @break
                                @case('error') ❌ @break
                                @default 🔔
                            @endswitch
                        </span>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: {{ !$notification->read_at ? '600' : '500' }}; color: var(--ink-900); margin-bottom: 0.25rem;">
                            {{ $notification->data['title'] ?? 'Notifikasi' }}
                        </div>
                        <p style="font-size: 0.875rem; color: var(--neutral-600); margin-bottom: 0.5rem;">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <span style="font-size: 0.75rem; color: var(--neutral-400);">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->data['action_url'] ?? null)
                                <a href="{{ $notification->data['action_url'] }}" style="font-size: 0.75rem; color: var(--primary-600);">
                                    {{ $notification->data['action_text'] ?? 'Lihat' }} →
                                </a>
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                        @if(!$notification->read_at)
                            <form action="{{ route('member.notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: var(--neutral-100);" title="Tandai dibaca">✓</button>
                            </form>
                        @endif
                        <form action="{{ route('member.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;" title="Hapus">×</button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔔</div>
                    <p>Belum ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($notifications->hasPages())
        <div style="margin-top: 1.5rem;">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
