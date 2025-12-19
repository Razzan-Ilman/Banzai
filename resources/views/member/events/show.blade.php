@extends('layouts.member')

@section('title', $event->title)

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Detail Event</h2>
        <a href="{{ route('member.events.index') }}" class="btn btn-outline btn-sm">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <!-- Event Hero -->
        <div style="height: 300px; background: linear-gradient(135deg, var(--group-primary, #0EA5E9), var(--group-secondary, #0284C7)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem; margin-bottom: 2rem;">
            📅
        </div>

        <!-- Event Info -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column -->
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem; color: var(--ink-900);">
                    {{ $event->title }}
                </h1>

                <div style="display: flex; gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--neutral-200);">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--neutral-600); margin-bottom: 0.25rem;">Tanggal</div>
                        <div style="font-weight: 600; color: var(--ink-900);">{{ $event->date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--neutral-600); margin-bottom: 0.25rem;">Lokasi</div>
                        <div style="font-weight: 600; color: var(--ink-900);">{{ $event->location }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: var(--ink-900);">Deskripsi</h3>
                    <p style="color: var(--neutral-700); line-height: 1.7;">
                        {{ $event->description }}
                    </p>
                </div>

                @if($event->requirements)
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: var(--ink-900);">Persyaratan</h3>
                    <p style="color: var(--neutral-700); line-height: 1.7;">
                        {{ $event->requirements }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Right Column - Action Card -->
            <div>
                <div style="background: var(--neutral-50); border-radius: 12px; padding: 1.5rem; position: sticky; top: 2rem;">
                    @if($isRegistered)
                        <div style="text-align: center; padding: 2rem;">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: #D1FAE5; color: #10B981; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2.5rem;">
                                ✓
                            </div>
                            <h3 style="font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">Kamu Sudah Terdaftar!</h3>
                            <p style="color: var(--neutral-600); font-size: 0.875rem;">
                                Jangan lupa hadir ya!
                            </p>
                        </div>
                    @else
                        <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--ink-900);">Daftar Event</h3>
                        <p style="color: var(--neutral-600); font-size: 0.875rem; margin-bottom: 1.5rem;">
                            Daftar sekarang untuk ikut event ini!
                        </p>
                        
                        <form method="POST" action="{{ route('member.attendance.store') }}">
                            @csrf
                            <input type="hidden" name="activity_id" value="{{ $event->id }}">
                            
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; font-size: 0.875rem;">Catatan (Opsional)</label>
                                <textarea 
                                    name="notes" 
                                    rows="3" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--neutral-300); border-radius: 8px; font-family: inherit; resize: vertical;"
                                    placeholder="Tambahkan catatan..."
                                ></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Daftar Sekarang
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-outline {
    background: transparent;
    border: 1px solid var(--neutral-300);
    color: var(--neutral-700);
}

.btn-outline:hover {
    background: var(--neutral-50);
}
</style>
@endsection
