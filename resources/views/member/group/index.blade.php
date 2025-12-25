@extends('layouts.member')

@section('title', 'Kelompok Saya')

@section('content')
<!-- Header -->
<div class="card" style="background: linear-gradient(135deg, {{ $currentGroup ? $currentGroup->color ?? '#0EA5E9' : '#6B7280' }} 0%, #1E293B 100%); color: white; border: none;">
    <div class="card-body" style="text-align: center; padding: 2rem;">
        @if($currentGroup)
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">{{ $currentGroup->kanji ?? '🎌' }}</div>
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $currentGroup->name }}</h1>
            <p style="opacity: 0.9;">{{ $currentGroup->description ?? 'Kelompok Jepangmu' }}</p>
        @else
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">❓</div>
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem;">Belum Ada Kelompok</h1>
            <p style="opacity: 0.9;">Ikuti Quiz untuk mendapatkan kelompok Jepangmu!</p>
            <a href="{{ route('member.quiz.index') }}" class="btn" style="background: white; color: #1E293B; margin-top: 1rem;">
                🎯 Ikuti Quiz Sekarang
            </a>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
    <!-- Info Kelompok -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Info Kelompok</h2>
        </div>
        <div class="card-body">
            @if($currentGroup)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px;">
                        <span style="color: var(--neutral-600);">Nama Kelompok</span>
                        <span style="font-weight: 600;">{{ $currentGroup->name }}</span>
                    </div>
                    @if($currentGroup->kanji)
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px;">
                        <span style="color: var(--neutral-600);">Kanji</span>
                        <span style="font-weight: 600; font-size: 1.25rem;">{{ $currentGroup->kanji }}</span>
                    </div>
                    @endif
                    @if($currentAssignment)
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px;">
                        <span style="color: var(--neutral-600);">Bergabung Sejak</span>
                        <span style="font-weight: 600;">{{ $currentAssignment->month_start?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px;">
                        <span style="color: var(--neutral-600);">Skor Konsistensi</span>
                        <span style="font-weight: 600;">{{ $currentAssignment->consistency_score ?? 0 }}%</span>
                    </div>
                    @endif
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    <p>Belum ada data kelompok</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Hasil Quiz Terakhir -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Hasil Quiz Terakhir</h2>
            <a href="{{ route('member.quiz.index') }}" style="color: #0EA5E9; font-size: 0.875rem; text-decoration: none;">Ikuti Quiz →</a>
        </div>
        <div class="card-body">
            @if($latestQuizResult)
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🏆</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--ink-900);">{{ $latestQuizResult->assigned_group }}</h3>
                    <p style="color: var(--neutral-500); font-size: 0.875rem; margin-top: 0.5rem;">
                        Diambil pada {{ $latestQuizResult->created_at->format('d M Y, H:i') }}
                    </p>
                    <div style="background: var(--neutral-100); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                        <div style="font-size: 0.75rem; color: var(--neutral-500); margin-bottom: 0.25rem;">Skor Tertinggi</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-700);">
                            {{ $latestQuizResult->highest_score ?? 0 }}%
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📝</div>
                    <p>Belum pernah mengikuti quiz</p>
                    <a href="{{ route('member.quiz.index') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        Mulai Quiz
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Anggota Kelompok -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Anggota Kelompok {{ $currentGroup ? $currentGroup->name : '' }}</h2>
        <span class="badge badge-primary">{{ $groupMembers->count() + ($currentGroup ? 1 : 0) }} Anggota</span>
    </div>
    <div class="card-body">
        @if($currentGroup)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                <!-- Current User (You) -->
                <div style="padding: 1rem; background: linear-gradient(135deg, {{ $currentGroup->color ?? '#0EA5E9' }}15, {{ $currentGroup->color ?? '#0EA5E9' }}05); border: 2px solid {{ $currentGroup->color ?? '#0EA5E9' }}; border-radius: 12px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: {{ $currentGroup->color ?? '#0EA5E9' }}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 style="font-weight: 600; color: var(--ink-900);">{{ auth()->user()->name }}</h4>
                            <span class="badge" style="background: {{ $currentGroup->color ?? '#0EA5E9' }}; color: white; font-size: 0.7rem;">Kamu</span>
                        </div>
                    </div>
                </div>
                
                <!-- Other Members -->
                @forelse($groupMembers as $member)
                    <div style="padding: 1rem; background: var(--neutral-50); border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--neutral-300); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 style="font-weight: 600; color: var(--ink-900);">{{ $member->name }}</h4>
                                <span style="font-size: 0.75rem; color: var(--neutral-500);">Anggota</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 1rem; color: var(--neutral-500);">
                        Belum ada anggota lain di kelompok ini
                    </div>
                @endforelse
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                <p>Ikuti quiz untuk bergabung dengan kelompok!</p>
            </div>
        @endif
    </div>
</div>

<!-- Semua Kelompok -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Semua Kelompok Jepang</h2>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem;">
            @foreach($allGroups as $group)
                <div style="padding: 1.25rem; background: {{ $currentGroup && $currentGroup->id === $group->id ? 'linear-gradient(135deg, '.$group->color.'20, '.$group->color.'05)' : 'var(--neutral-50)' }}; border: 2px solid {{ $currentGroup && $currentGroup->id === $group->id ? $group->color : 'transparent' }}; border-radius: 12px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $group->kanji ?? '🎌' }}</div>
                    <h4 style="font-weight: 600; color: {{ $group->color ?? 'var(--ink-900)' }};">{{ $group->name }}</h4>
                    @if($currentGroup && $currentGroup->id === $group->id)
                        <span class="badge" style="background: {{ $group->color }}; color: white; margin-top: 0.5rem;">Kelompokmu</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Riwayat Kelompok -->
@if($groupHistory->count() > 0)
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Riwayat Kelompok</h2>
    </div>
    <div class="card-body" style="padding: 0;">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem 1rem; text-align: left; background: var(--neutral-50);">Kelompok</th>
                    <th style="padding: 0.75rem 1rem; text-align: left; background: var(--neutral-50);">Periode</th>
                    <th style="padding: 0.75rem 1rem; text-align: left; background: var(--neutral-50);">Status</th>
                    <th style="padding: 0.75rem 1rem; text-align: left; background: var(--neutral-50);">Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupHistory as $history)
                <tr style="border-bottom: 1px solid var(--neutral-100);">
                    <td style="padding: 0.75rem 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span>{{ $history->group?->kanji ?? '🎌' }}</span>
                            <span>{{ $history->group?->name ?? 'Unknown' }}</span>
                        </div>
                    </td>
                    <td style="padding: 0.75rem 1rem; color: var(--neutral-600);">
                        {{ $history->month_start?->format('M Y') ?? '-' }} - {{ $history->month_end?->format('M Y') ?? 'Sekarang' }}
                    </td>
                    <td style="padding: 0.75rem 1rem;">
                        @if($history->is_active)
                            <span class="badge badge-approved">Aktif</span>
                        @else
                            <span class="badge" style="background: var(--neutral-200);">Selesai</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem 1rem; font-weight: 600;">{{ $history->consistency_score ?? 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
