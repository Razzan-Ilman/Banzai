@extends('layouts.admin')

@section('title', 'Jadwal Kegiatan')

@section('content')
<div class="schedules-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">📅 Jadwal Kegiatan</h2>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">+ Buat Jadwal</a>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Upcoming -->
    @if($upcoming->count() > 0)
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title">🔜 Jadwal Mendatang</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                @foreach($upcoming as $schedule)
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--neutral-100);">
                        <div style="width: 50px; height: 50px; background: {{ $schedule->type_color }}20; color: {{ $schedule->type_color }}; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span style="font-size: 1.25rem; font-weight: 700;">{{ $schedule->start_date->format('d') }}</span>
                            <span style="font-size: 0.625rem; text-transform: uppercase;">{{ $schedule->start_date->format('M') }}</span>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--ink-900);">{{ $schedule->title }}</div>
                            <div style="font-size: 0.875rem; color: var(--neutral-500);">
                                {{ $schedule->start_date->format('H:i') }} • {{ $schedule->location ?? 'TBD' }}
                            </div>
                        </div>
                        <span style="background: {{ $schedule->type_color }}20; color: {{ $schedule->type_color }}; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                            {{ $schedule->type_label }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Schedules -->
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--neutral-50); border-bottom: 1px solid var(--neutral-200);">
                        <th style="padding: 1rem; text-align: left;">Jadwal</th>
                        <th style="padding: 1rem; text-align: left;">Tipe</th>
                        <th style="padding: 1rem; text-align: left;">Tanggal</th>
                        <th style="padding: 1rem; text-align: left;">Lokasi</th>
                        <th style="padding: 1rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr style="border-bottom: 1px solid var(--neutral-100);">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 500; color: var(--ink-900);">{{ $schedule->title }}</div>
                                @if($schedule->description)
                                    <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ Str::limit($schedule->description, 40) }}</div>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                <span style="background: {{ $schedule->type_color }}20; color: {{ $schedule->type_color }}; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                                    {{ $schedule->type_label }}
                                </span>
                            </td>
                            <td style="padding: 1rem; font-size: 0.875rem; color: var(--ink-800);">
                                {{ $schedule->start_date->format('d M Y, H:i') }}
                            </td>
                            <td style="padding: 1rem; font-size: 0.875rem; color: var(--neutral-600);">
                                {{ $schedule->location ?? '-' }}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm" style="background: var(--neutral-100);">✏️</a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                                Belum ada jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($schedules->hasPages())
        <div style="margin-top: 1.5rem;">{{ $schedules->links() }}</div>
    @endif
</div>
@endsection
