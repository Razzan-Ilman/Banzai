@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
<div class="announcements-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">📢 Pengumuman</h2>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">+ Buat Pengumuman</a>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--neutral-50); border-bottom: 1px solid var(--neutral-200);">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--ink-900);">Judul</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--ink-900);">Tipe</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--ink-900);">Prioritas</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--ink-900);">Status</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--ink-900);">Dibuat</th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--ink-900);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                        <tr style="border-bottom: 1px solid var(--neutral-100);">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 500; color: var(--ink-900);">{{ $announcement->title }}</div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ Str::limit($announcement->content, 50) }}</div>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="background: {{ $announcement->type_color }}20; color: {{ $announcement->type_color }}; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="font-size: 0.875rem; color: var(--ink-800);">{{ $announcement->priority_label }}</span>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                @if($announcement->is_published)
                                    <span style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Published</span>
                                @else
                                    <span style="background: var(--neutral-100); color: var(--neutral-600); padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Draft</span>
                                @endif
                            </td>
                            <td style="padding: 1rem; font-size: 0.875rem; color: var(--neutral-600);">
                                {{ $announcement->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <form action="{{ route('admin.announcements.toggle', $announcement) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm" style="background: var(--neutral-100);">
                                            {{ $announcement->is_published ? '⏸️' : '▶️' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm" style="background: var(--neutral-100);">✏️</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                                Belum ada pengumuman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($announcements->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection
