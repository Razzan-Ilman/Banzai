@extends('layouts.member')

@section('title', 'Check-in Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Check-in Kegiatan</h2>
        <a href="{{ route('member.attendance.index') }}" class="btn btn-outline btn-sm">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
    <div class="card-body">
        @if($activities->count() > 0)
            <p style="color: var(--neutral-600); margin-bottom: 2rem;">
                Pilih kegiatan untuk check-in dan dapatkan <strong style="color: var(--group-primary, #0EA5E9);">+10 poin</strong>!
            </p>

            <div style="display: grid; gap: 1rem;">
                @foreach($activities as $activity)
                    <div style="border: 2px solid var(--neutral-200); border-radius: 12px; padding: 1.5rem; transition: all 0.2s ease;" class="activity-card">
                        <div style="display: flex; justify-content: space-between; align-items: start; gap: 1.5rem;">
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">
                                    {{ $activity->title }}
                                </h3>
                                <p style="color: var(--neutral-600); margin-bottom: 1rem;">
                                    {{ $activity->description }}
                                </p>
                                <div style="display: flex; gap: 1.5rem; font-size: 0.875rem; color: var(--neutral-500);">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $activity->date->format('d M Y') }}
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $activity->location }}
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('member.attendance.store') }}">
                                @csrf
                                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                                <button type="submit" class="btn btn-primary">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Check-in
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Tidak ada kegiatan hari ini</p>
                <p style="font-size: 0.875rem;">Check kembali nanti untuk kegiatan mendatang!</p>
            </div>
        @endif
    </div>
</div>

<style>
.activity-card:hover {
    border-color: var(--group-primary, #0EA5E9);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

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
