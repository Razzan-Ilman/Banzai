@extends('layouts.member')

@section('title', 'Statistik Saya')

@section('content')
<div class="analytics-page">
    <!-- Header -->
    <div class="page-header-section" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.25rem;">📊 Statistik Saya</h2>
                <p style="color: var(--neutral-600); font-size: 0.875rem;">Pantau perkembangan dan aktivitasmu di BANZAI</p>
            </div>
            <form action="{{ route('member.analytics.refresh') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn" style="background: var(--neutral-100); color: var(--neutral-700);">
                    🔄 Refresh
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid" style="margin-bottom: 2rem;">
        <!-- Kehadiran -->
        <div class="stat-card blue">
            <div class="stat-icon" style="background: #DBEAFE; color: #2563EB;">📅</div>
            <div class="stat-number">{{ $analytics['attendance']['rate'] }}%</div>
            <div class="stat-text">Tingkat Kehadiran</div>
            <div style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                {{ $analytics['attendance']['total_attended'] }} dari {{ $analytics['attendance']['total_meetings'] }} pertemuan
            </div>
        </div>

        <!-- Quiz -->
        <div class="stat-card pink">
            <div class="stat-icon" style="background: #FCE7F3; color: #DB2777;">📝</div>
            <div class="stat-number">{{ $analytics['quiz']['total_quizzes'] }}</div>
            <div class="stat-text">Quiz Selesai</div>
            @if($analytics['quiz']['latest_score'])
                <div style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                    Skor terakhir: {{ $analytics['quiz']['latest_score'] }}
                    @if($analytics['quiz']['trend'] === 'up') 🔼
                    @elseif($analytics['quiz']['trend'] === 'down') 🔽
                    @endif
                </div>
            @endif
        </div>

        <!-- Poin -->
        <div class="stat-card amber">
            <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">⭐</div>
            <div class="stat-number">{{ number_format($analytics['points']['total']) }}</div>
            <div class="stat-text">Total Poin</div>
            <div style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                Level {{ $analytics['points']['level'] }}
            </div>
        </div>

        <!-- Rank -->
        <div class="stat-card green">
            <div class="stat-icon" style="background: #D1FAE5; color: #059669;">🏆</div>
            <div class="stat-number">#{{ $position['rank'] ?? '-' }}</div>
            <div class="stat-text">Peringkat</div>
            @if($position)
                <div style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                    Top {{ 100 - ($position['percentile'] ?? 0) }}% dari {{ $position['total_users'] }} member
                </div>
            @endif
        </div>
    </div>

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Quiz History -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📈 Riwayat Quiz</h3>
            </div>
            <div class="card-body">
                @if(count($analytics['quiz']['history']) > 0)
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($analytics['quiz']['history'] as $quiz)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px;">
                                <div>
                                    <div style="font-weight: 600; color: var(--ink-900);">{{ $quiz['date'] }}</div>
                                    <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ $quiz['group'] }}</div>
                                </div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">{{ $quiz['score'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                        Belum ada quiz yang dikerjakan
                    </div>
                @endif
            </div>
        </div>

        <!-- Level Progress -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">🎯 Progress Level</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;">🎖️</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">Level {{ $analytics['points']['level'] }}</div>
                </div>
                
                <div class="progress-container">
                    <div class="progress-label">
                        <span>Progress ke Level {{ $analytics['points']['level'] + 1 }}</span>
                        <span>{{ $analytics['points']['progress'] }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $analytics['points']['progress'] }}%;"></div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 1rem; font-size: 0.875rem; color: var(--neutral-600);">
                    {{ number_format($analytics['points']['next_level_points'] - $analytics['points']['total']) }} poin lagi untuk naik level
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📋 Info Keanggotaan</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📆</div>
                    <div style="font-weight: 600; color: var(--ink-900);">{{ $analytics['activity']['joined_at'] }}</div>
                    <div style="font-size: 0.75rem; color: var(--neutral-500);">Tanggal Bergabung</div>
                </div>
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">⏱️</div>
                    <div style="font-weight: 600; color: var(--ink-900);">{{ $analytics['activity']['days_as_member'] }} Hari</div>
                    <div style="font-size: 0.75rem; color: var(--neutral-500);">Lama Keanggotaan</div>
                </div>
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🟢</div>
                    <div style="font-weight: 600; color: var(--ink-900);">{{ $analytics['activity']['last_active'] }}</div>
                    <div style="font-size: 0.75rem; color: var(--neutral-500);">Terakhir Aktif</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
