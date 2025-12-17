@extends('layouts.admin')

@section('title', 'Kelola Anggota')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Anggota</h2>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span style="width: 32px; height: 32px; border-radius: 50%; background: {{ $member->display_color }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600;">
                                            {{ $member->initial }}
                                        </span>
                                        {{ $member->name }}
                                    </div>
                                </td>
                                <td>{{ $member->class }}</td>
                                <td>{{ $member->major }}</td>
                                <td>{{ $member->position ?? '-' }}</td>
                                <td>{{ $member->division?->name ?? '-' }}</td>
                                <td>
                                    @if($member->is_active)
                                        <span class="badge badge-approved">Aktif</span>
                                    @else
                                        <span class="badge badge-pending">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #737373; padding: 2rem;">
                                    Belum ada anggota
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $members->links() }}
    </div>
@endsection
