@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="card" style="background: linear-gradient(135deg, #0EA5E9 0%, #EC4899 100%); color: white; border: none;">
    <div class="card-body">
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">
            Selamat Datang, {{ auth()->user()->name }}! 👋
        </h2>
        <p style="opacity: 0.95; font-size: 1.0625rem;">
            Semangat belajar bahasa Jepang hari ini!
        </p>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Event Diikuti -->
    <div class="stat-card blue">
        <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0EA5E9;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['total_events'] }}</div>
        <div class="stat-text">Event Diikuti</div>
    </div>

    <!-- Total Poin -->
    <div class="stat-card amber">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['points'] }}</div>
        <div class="stat-text">Total Poin</div>
    </div>

    <!-- Level -->
    <div class="stat-card pink">
        <div class="stat-icon" style="background: rgba(236, 72, 153, 0.1); color: #EC4899;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['level'] }}</div>
        <div class="stat-text">Level {{ $profile->getLevelName() }}</div>
    </div>

    <!-- XP Progress -->
    <div class="stat-card green">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['xp'] }}</div>
        <div class="stat-text">Experience Points</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <!-- Left Column -->
    <div>
        <!-- Progress Level -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Progress Level</h2>
                <span class="badge badge-primary">Level {{ $stats['level'] }}</span>
            </div>
            <div class="card-body">
                <div class="progress-container">
                    <div class="progress-label">
                        <span>{{ $stats['xp'] }} / {{ $stats['level'] * 100 }} XP</span>
                        <span>{{ number_format($stats['xp_progress'], 0) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $stats['xp_progress'] }}%"></div>
                    </div>
                </div>
                <p style="color: var(--neutral-600); font-size: 0.875rem; margin-top: 1rem;">
                    Ikuti event dan kegiatan untuk mendapatkan XP dan naik level!
                </p>
            </div>
        </div>

        <!-- Event Mendatang -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Event Mendatang</h2>
                <a href="#" style="color: #0EA5E9; font-size: 0.875rem; text-decoration: none;">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($stats['upcoming_events']->count() > 0)
                    @foreach($stats['upcoming_events'] as $event)
                        <div style="padding: 1rem; background: var(--neutral-50); border-radius: 8px; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <h3 style="font-weight: 600; color: var(--ink-900);">{{ $event->title }}</h3>
                                <span class="badge badge-primary">Upcoming</span>
                            </div>
                            <p style="color: var(--neutral-600); font-size: 0.875rem; margin-bottom: 0.75rem;">
                                {{ $event->description }}
                            </p>
                            <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.8125rem; color: var(--neutral-500);">
                                <span>📅 {{ $event->date->format('d M Y') }}</span>
                                <span>📍 {{ $event->location }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>Belum ada event mendatang</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="#" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Daftar Event
                </a>
                <a href="#" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Absen Sekarang
                </a>
            </div>
        </div>

        <!-- Achievements -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Achievements</h2>
            </div>
            <div class="card-body">
                <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <p>Belum ada achievement</p>
                    <p style="font-size: 0.75rem; margin-top: 0.5rem;">Ikuti kegiatan untuk unlock!</p>
                </div>
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Leaderboard</h2>
            </div>
            <div class="card-body">
                <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <p>Leaderboard coming soon</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
