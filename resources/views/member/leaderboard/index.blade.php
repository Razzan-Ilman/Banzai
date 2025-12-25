@extends('layouts.member')

@section('title', 'Leaderboard')

@section('content')
<div class="leaderboard-page">
    <!-- Header -->
    <div class="page-header-section" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.25rem;">🏆 Leaderboard</h2>
                <p style="color: var(--neutral-600); font-size: 0.875rem;">Ranking member BANZAI berdasarkan poin</p>
            </div>
            
            <!-- Period Filter -->
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('member.leaderboard.index', ['period' => 'weekly']) }}" 
                   class="btn btn-sm {{ $period === 'weekly' ? 'btn-primary' : '' }}" 
                   style="{{ $period !== 'weekly' ? 'background: var(--neutral-100); color: var(--neutral-700);' : '' }}">
                    Mingguan
                </a>
                <a href="{{ route('member.leaderboard.index', ['period' => 'monthly']) }}" 
                   class="btn btn-sm {{ $period === 'monthly' ? 'btn-primary' : '' }}"
                   style="{{ $period !== 'monthly' ? 'background: var(--neutral-100); color: var(--neutral-700);' : '' }}">
                    Bulanan
                </a>
                <a href="{{ route('member.leaderboard.index', ['period' => 'alltime']) }}" 
                   class="btn btn-sm {{ $period === 'alltime' ? 'btn-primary' : '' }}"
                   style="{{ $period !== 'alltime' ? 'background: var(--neutral-100); color: var(--neutral-700);' : '' }}">
                    Semua Waktu
                </a>
            </div>
        </div>
    </div>

    <!-- User Position Card -->
    @if($userPosition)
    <div class="card" style="margin-bottom: 2rem; background: linear-gradient(135deg, #0EA5E9, #0284C7); color: white;">
        <div class="card-body" style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 700;">{{ $user->name }}</div>
                        <div style="opacity: 0.9; font-size: 0.875rem;">Posisi Kamu Saat Ini</div>
                    </div>
                </div>
                <div style="display: flex; gap: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 2rem; font-weight: 700;">#{{ $userPosition['rank'] }}</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Peringkat</div>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: 700;">{{ number_format($userPosition['points']) }}</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Poin</div>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: 700;">{{ $userPosition['percentile'] }}%</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Percentile</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Leaderboard Table -->
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--neutral-50);">
                        <th style="padding: 1rem; text-align: center; width: 80px;">Rank</th>
                        <th style="padding: 1rem; text-align: left;">Member</th>
                        <th style="padding: 1rem; text-align: center;">Level</th>
                        <th style="padding: 1rem; text-align: right;">Poin</th>
                        <th style="padding: 1rem; text-align: center; width: 60px;">Trend</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaderboard as $entry)
                        @php
                            $isCurrentUser = $entry['user_id'] === $user->id;
                            $rankStyle = match($entry['rank']) {
                                1 => 'background: linear-gradient(135deg, #FCD34D, #F59E0B); color: white;',
                                2 => 'background: linear-gradient(135deg, #9CA3AF, #6B7280); color: white;',
                                3 => 'background: linear-gradient(135deg, #F97316, #EA580C); color: white;',
                                default => 'background: var(--neutral-100);'
                            };
                            $rowStyle = $isCurrentUser ? 'background: #EFF6FF;' : '';
                        @endphp
                        <tr style="border-bottom: 1px solid var(--neutral-200); {{ $rowStyle }}">
                            <td style="padding: 1rem; text-align: center;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; font-weight: 700; {{ $rankStyle }}">
                                    @if($entry['rank'] === 1) 🥇
                                    @elseif($entry['rank'] === 2) 🥈
                                    @elseif($entry['rank'] === 3) 🥉
                                    @else {{ $entry['rank'] }}
                                    @endif
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #F59E0B); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                        {{ strtoupper(substr($entry['name'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--ink-900);">
                                            {{ $entry['name'] }}
                                            @if($isCurrentUser)
                                                <span style="background: #DBEAFE; color: #2563EB; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.625rem; margin-left: 0.5rem;">KAMU</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <span style="background: var(--neutral-100); padding: 0.25rem 0.75rem; border-radius: 50px; font-weight: 600;">
                                    Lv.{{ $entry['level'] }}
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: right; font-weight: 700; color: var(--primary);">
                                {{ number_format($entry['points']) }}
                            </td>
                            <td style="padding: 1rem; text-align: center; font-size: 1.25rem;">
                                @if($entry['trend'] === 'up') 🔼
                                @elseif($entry['trend'] === 'down') 🔽
                                @elseif($entry['trend'] === 'new') ✨
                                @else ➖
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                                Belum ada data leaderboard
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
