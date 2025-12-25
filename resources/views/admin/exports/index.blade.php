@extends('layouts.admin')

@section('title', 'Export Data')

@section('content')
<div class="exports-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">📤 Export Data</h2>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 1rem; background: #FEE2E2; color: #DC2626; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Export Types -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @php
            $exportTypes = [
                'users' => ['icon' => '👥', 'title' => 'Data Member', 'desc' => 'Export semua data member'],
                'attendance' => ['icon' => '📋', 'title' => 'Kehadiran', 'desc' => 'Export rekap kehadiran'],
                'quiz_results' => ['icon' => '📝', 'title' => 'Hasil Quiz', 'desc' => 'Export hasil quiz member'],
                'events' => ['icon' => '🎉', 'title' => 'Events', 'desc' => 'Export data events'],
            ];
        @endphp
        
        @foreach($exportTypes as $type => $info)
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $info['icon'] }}</div>
                    <h3 style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $info['title'] }}</h3>
                    <p style="font-size: 0.875rem; color: var(--neutral-500); margin-bottom: 1rem;">{{ $info['desc'] }}</p>
                    <form action="{{ route('admin.exports.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">Export</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Export History -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📁 Riwayat Export</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--neutral-50); border-bottom: 1px solid var(--neutral-200);">
                        <th style="padding: 1rem; text-align: left;">Tipe</th>
                        <th style="padding: 1rem; text-align: left;">Status</th>
                        <th style="padding: 1rem; text-align: left;">Progress</th>
                        <th style="padding: 1rem; text-align: left;">Dibuat</th>
                        <th style="padding: 1rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exports as $export)
                        <tr style="border-bottom: 1px solid var(--neutral-100);">
                            <td style="padding: 1rem;">
                                <span style="font-weight: 500; color: var(--ink-900);">{{ ucfirst(str_replace('_', ' ', $export->type)) }}</span>
                            </td>
                            <td style="padding: 1rem;">
                                @if($export->status === 'completed')
                                    <span style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Selesai</span>
                                @elseif($export->status === 'processing')
                                    <span style="background: #FEF3C7; color: #D97706; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Memproses</span>
                                @elseif($export->status === 'failed')
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Gagal</span>
                                @else
                                    <span style="background: var(--neutral-100); color: var(--neutral-600); padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Menunggu</span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                <div style="width: 100px; height: 8px; background: var(--neutral-100); border-radius: 50px; overflow: hidden;">
                                    <div style="width: {{ $export->progress }}%; height: 100%; background: var(--primary-500);"></div>
                                </div>
                            </td>
                            <td style="padding: 1rem; font-size: 0.875rem; color: var(--neutral-600);">
                                {{ $export->created_at->format('d M Y H:i') }}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                @if($export->status === 'completed' && $export->file_path)
                                    <a href="{{ route('admin.exports.download', $export) }}" class="btn btn-sm btn-primary">⬇️ Download</a>
                                @else
                                    <span style="color: var(--neutral-400);">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                                Belum ada riwayat export
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($exports->hasPages())
        <div style="margin-top: 1.5rem;">{{ $exports->links() }}</div>
    @endif
</div>
@endsection
