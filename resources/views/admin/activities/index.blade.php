@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Kegiatan</h2>
        <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">+ Tambah Kegiatan</a>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ Str::limit($activity->title, 40) }}</strong>
                                        @if($activity->is_featured)
                                            <span class="badge" style="background: #FEF3C7; color: #92400E; margin-left: 0.5rem;">⭐ Featured</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $activity->date->format('d M Y') }}</td>
                                <td>{{ $activity->location ?? '-' }}</td>
                                <td>
                                    @if($activity->is_published)
                                        <span class="badge badge-approved">Published</span>
                                    @else
                                        <span class="badge badge-pending">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #737373; padding: 2rem;">
                                    Belum ada kegiatan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $activities->links() }}
    </div>
@endsection
