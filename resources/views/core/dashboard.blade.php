@extends('layouts.core')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <!-- Total Anggota Aktif -->
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Anggota Aktif</div>
            </div>
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_members'] ?? 0 }}</div>
        <div class="stat-change">Member terdaftar</div>
    </div>

    <!-- CORE Members -->
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">CORE Team</div>
            </div>
            <div class="stat-icon" style="background: rgba(199, 161, 74, 0.1); color: #C7A14A;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_core'] ?? 0 }}</div>
        <div class="stat-change">Pengurus inti</div>
    </div>

    <!-- Pending Candidates -->
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['pending_candidates'] ?? 0 }}</div>
        <div class="stat-change">Candidate pending</div>
    </div>

    <!-- Upcoming Events -->
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-label">Event Mendatang</div>
            </div>
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366F1;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['upcoming_events'] ?? 0 }}</div>
        <div class="stat-change">Kegiatan terjadwal</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Aksi Cepat</h2>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="{{ route('core.candidates.index') }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Verifikasi Candidate
            </a>
            <a href="{{ route('core.members.index') }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Anggota
            </a>
            <a href="#" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Buat Event Baru
            </a>
            <a href="#" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Upload Dokumentasi
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Aktivitas Terkini</h2>
        <a href="#" class="btn btn-sm btn-outline">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div style="color: var(--neutral-500); text-align: center; padding: 2rem;">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p>Belum ada aktivitas terbaru</p>
        </div>
    </div>
</div>

<!-- Notifications / Important Info -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Notifikasi Penting</h2>
    </div>
    <div class="card-body">
        <div style="color: var(--neutral-500); text-align: center; padding: 2rem;">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p>Tidak ada notifikasi</p>
        </div>
    </div>
</div>
@endsection
