@extends('layouts.member')

@section('title', 'Absensi Saya')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card green">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['total_hadir'] }}</div>
        <div class="stat-text">Total Hadir</div>
    </div>

    <div class="stat-card amber">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['total_izin'] }}</div>
        <div class="stat-text">Izin</div>
    </div>

    <div class="stat-card pink">
        <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['total_alfa'] }}</div>
        <div class="stat-text">Alfa</div>
    </div>

    <div class="stat-card blue">
        <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0EA5E9;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="stat-number">{{ $stats['this_month'] }}</div>
        <div class="stat-text">Bulan Ini</div>
    </div>
</div>

<!-- Quick Action -->
<div class="card" style="background: linear-gradient(135deg, var(--group-primary, #0EA5E9), var(--group-secondary, #0284C7)); color: white; border: none;">
    <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Absen Sekarang</h3>
                <p style="opacity: 0.9;">Check-in untuk kegiatan hari ini dan dapatkan poin!</p>
            </div>
            <a href="{{ route('member.attendance.checkin') }}" class="btn" style="background: white; color: var(--group-primary, #0EA5E9);">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Check-in
            </a>
        </div>
    </div>
</div>

<!-- Attendance History -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Riwayat Absensi</h2>
    </div>
    <div class="card-body">
        @if($attendances->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Poin</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $attendance->activity->title ?? 'Kegiatan Umum' }}</strong>
                                </td>
                                <td>
                                    @if($attendance->status === 'hadir')
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($attendance->status === 'izin')
                                        <span class="badge badge-warning">Izin</span>
                                    @else
                                        <span class="badge" style="background: #FEE2E2; color: #991B1B;">Alfa</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: var(--group-primary, #0EA5E9);">+{{ $attendance->points_earned }}</strong>
                                </td>
                                <td style="color: var(--neutral-600); font-size: 0.875rem;">
                                    {{ $attendance->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 1.5rem;">
                {{ $attendances->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Belum ada riwayat absensi</p>
                <p style="font-size: 0.875rem;">Mulai check-in untuk kegiatan dan kumpulkan poin!</p>
                <a href="{{ route('member.attendance.checkin') }}" class="btn btn-primary" style="margin-top: 1rem;">
                    Check-in Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
