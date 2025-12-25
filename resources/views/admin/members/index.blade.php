@extends('layouts.admin')

@section('title', 'Kelola Anggota')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Anggota</h2>
            {{-- Status Filter --}}
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.members.index', ['status' => 'active']) }}" 
                   class="btn btn-sm" 
                   style="{{ $status === 'active' ? 'background: var(--primary-700); color: white;' : 'background: #E5E5E5;' }}">
                    Aktif
                </a>
                <a href="{{ route('admin.members.index', ['status' => 'alumni']) }}" 
                   class="btn btn-sm" 
                   style="{{ $status === 'alumni' ? 'background: var(--primary-700); color: white;' : 'background: #E5E5E5;' }}">
                    Alumni
                </a>
                <a href="{{ route('admin.members.index', ['status' => 'all']) }}" 
                   class="btn btn-sm" 
                   style="{{ $status === 'all' ? 'background: var(--primary-700); color: white;' : 'background: #E5E5E5;' }}">
                    Semua
                </a>
            </div>
        </div>
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
                                <td>{{ $member->display_position ?? '-' }}</td>
                                <td>{{ $member->division?->name ?? '-' }}</td>
                                <td>
                                    @if($member->status === 'alumni')
                                        <span class="badge" style="background: #E5E5E5; color: #404040;">Alumni</span>
                                    @elseif($member->is_active)
                                        <span class="badge badge-approved">Aktif</span>
                                    @else
                                        <span class="badge badge-pending">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        @if($member->status === 'active')
                                            <a href="{{ route('admin.members.replace', $member) }}" class="btn btn-sm" style="background: #FEF3C7; color: #92400E;">Ganti</a>
                                        @endif
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
        {{ $members->appends(['status' => $status])->links() }}
    </div>
@endsection

