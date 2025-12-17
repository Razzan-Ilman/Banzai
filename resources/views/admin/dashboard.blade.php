@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['members'] }}</div>
            <div class="stat-label">Total Anggota</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['divisions'] }}</div>
            <div class="stat-label">Divisi</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['activities'] }}</div>
            <div class="stat-label">Kegiatan</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #F59E0B;">{{ $stats['pending_registrations'] }}</div>
            <div class="stat-label">Pendaftaran Pending</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        <!-- Recent Registrations -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <span>Pendaftaran Terbaru</span>
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRegistrations as $reg)
                                <tr>
                                    <td>{{ $reg->name }}</td>
                                    <td>{{ $reg->class }}</td>
                                    <td>
                                        <span class="badge badge-{{ $reg->status }}">{{ $reg->status_label }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: #737373;">Belum ada pendaftaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <span>Kegiatan Terbaru</span>
                <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                                <tr>
                                    <td>{{ Str::limit($activity->title, 30) }}</td>
                                    <td>{{ $activity->date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($activity->is_published)
                                            <span class="badge badge-approved">Published</span>
                                        @else
                                            <span class="badge badge-pending">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: #737373;">Belum ada kegiatan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
