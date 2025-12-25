@extends('layouts.admin')

@section('title', 'Kelola Jabatan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Jabatan</h2>
        <a href="{{ route('admin.positions.create') }}" class="btn btn-primary">+ Tambah Jabatan</a>
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
                            <th>Level</th>
                            <th>Nama Jabatan</th>
                            <th>Anggota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($positions as $position)
                            <tr>
                                <td>
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: var(--primary-100); color: var(--primary-900); font-weight: 600;">
                                        {{ $position->level }}
                                    </span>
                                </td>
                                <td style="font-weight: 500;">{{ $position->name }}</td>
                                <td>{{ $position->members_count }}</td>
                                <td>
                                    @if($position->is_active)
                                        <span class="badge badge-approved">Aktif</span>
                                    @else
                                        <span class="badge badge-pending">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.positions.edit', $position) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        <form action="{{ route('admin.positions.destroy', $position) }}" method="POST" onsubmit="return confirm('Hapus jabatan ini?')">
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
                                    Belum ada jabatan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $positions->links() }}
    </div>
@endsection
