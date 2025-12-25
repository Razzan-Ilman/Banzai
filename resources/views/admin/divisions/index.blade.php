@extends('layouts.admin')

@section('title', 'Kelola Divisi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Divisi</h2>
        <a href="{{ route('admin.divisions.create') }}" class="btn btn-primary">+ Tambah Divisi</a>
    </div>

    @if(session('error'))
        <div class="alert" style="background: #FEE2E2; color: #991B1B; margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Icon</th>
                            <th>Warna</th>
                            <th>Anggota Aktif</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisions as $division)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span style="font-size: 1.5rem;">{{ $division->icon }}</span>
                                        <div>
                                            <div style="font-weight: 500;">{{ $division->name }}</div>
                                            <div style="font-size: 0.75rem; color: #737373;">{{ $division->tagline }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $division->icon }}</td>
                                <td>
                                    <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                        <span style="width: 20px; height: 20px; border-radius: 4px; background: {{ $division->color }};"></span>
                                        {{ $division->color }}
                                    </span>
                                </td>
                                <td>{{ $division->members_count }}</td>
                                <td>
                                    @if($division->is_active)
                                        <span class="badge badge-approved">Aktif</span>
                                    @else
                                        <span class="badge badge-pending">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST" onsubmit="return confirm('Hapus divisi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #737373; padding: 2rem;">
                                    Belum ada divisi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $divisions->links() }}
    </div>
@endsection
