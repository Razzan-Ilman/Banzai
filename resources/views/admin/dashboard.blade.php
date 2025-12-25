@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-card" style="background: linear-gradient(135deg, #667EEA, #764BA2); color: white; padding: 1.5rem; border-radius: 12px;">
            <div style="font-size: 2rem; font-weight: 700;">{{ $stats['members'] }}</div>
            <div style="opacity: 0.9;">Total Anggota</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #06B6D4, #3B82F6); color: white; padding: 1.5rem; border-radius: 12px;">
            <div style="font-size: 2rem; font-weight: 700;">{{ $stats['total_users'] ?? 0 }}</div>
            <div style="opacity: 0.9;">Total Users</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 1.5rem; border-radius: 12px;">
            <div style="font-size: 2rem; font-weight: 700;">{{ $stats['activities'] }}</div>
            <div style="opacity: 0.9;">Kegiatan</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: white; padding: 1.5rem; border-radius: 12px;">
            <div style="font-size: 2rem; font-weight: 700;">{{ $stats['pending_registrations'] }}</div>
            <div style="opacity: 0.9;">Pending</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Member Growth Chart -->
        <div class="card">
            <div class="card-header">
                <span style="font-weight: 600;">📈 Pertumbuhan Anggota (6 Bulan)</span>
            </div>
            <div class="card-body">
                <canvas id="memberGrowthChart" height="200"></canvas>
            </div>
        </div>

        <!-- Quiz Distribution Chart -->
        <div class="card">
            <div class="card-header">
                <span style="font-weight: 600;">🎌 Distribusi Kelompok</span>
            </div>
            <div class="card-body">
                <canvas id="quizDistributionChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Attendance Trend -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <span style="font-weight: 600;">📋 Tren Kehadiran (30 Hari Terakhir)</span>
        </div>
        <div class="card-body">
            <canvas id="attendanceChart" height="80"></canvas>
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

    <!-- Division Stats -->
    @if(!empty($divisionStats))
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <span style="font-weight: 600;">📊 Statistik per Divisi</span>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @foreach($divisionStats as $div)
                    <div style="flex: 1; min-width: 120px; text-align: center; padding: 1rem; background: var(--neutral-50); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-600);">{{ $div['count'] }}</div>
                        <div style="font-size: 0.875rem; color: var(--neutral-600);">{{ $div['name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Member Growth Chart
    const memberCtx = document.getElementById('memberGrowthChart').getContext('2d');
    new Chart(memberCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($memberGrowth ?? [], 'month')) !!},
            datasets: [{
                label: 'Anggota Baru',
                data: {!! json_encode(array_column($memberGrowth ?? [], 'count')) !!},
                borderColor: '#667EEA',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Quiz Distribution Chart
    const quizCtx = document.getElementById('quizDistributionChart').getContext('2d');
    new Chart(quizCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($quizStats ?? [], 'group')) !!},
            datasets: [{
                data: {!! json_encode(array_column($quizStats ?? [], 'count')) !!},
                backgroundColor: ['#6366F1', '#EC4899', '#10B981', '#F59E0B'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Attendance Trend Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($attendanceTrend ?? [], 'date')) !!},
            datasets: [{
                label: 'Kehadiran',
                data: {!! json_encode(array_column($attendanceTrend ?? [], 'count')) !!},
                backgroundColor: '#10B981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
