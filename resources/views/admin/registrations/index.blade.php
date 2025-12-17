@extends('layouts.admin')

@section('title', 'Kelola Pendaftaran')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Pendaftaran</h2>
        
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : '' }}" style="{{ !request('status') ? '' : 'background: #E5E5E5;' }}">Semua</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : '' }}" style="{{ request('status') == 'pending' ? '' : 'background: #E5E5E5;' }}">Pending</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') == 'approved' ? 'btn-primary' : '' }}" style="{{ request('status') == 'approved' ? '' : 'background: #E5E5E5;' }}">Disetujui</a>
            <a href="{{ route('admin.registrations.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-primary' : '' }}" style="{{ request('status') == 'rejected' ? '' : 'background: #E5E5E5;' }}">Ditolak</a>
        </div>
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
                            <th>Divisi Pilihan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr>
                                <td>{{ $reg->name }}</td>
                                <td>{{ $reg->class }}</td>
                                <td>{{ $reg->major }}</td>
                                <td>{{ ucfirst($reg->preferred_division) }}</td>
                                <td>{{ $reg->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $reg->status }}">{{ $reg->status_label }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-sm" style="background: #E5E5E5;">Detail</a>
                                        
                                        @if($reg->status === 'pending')
                                            <form action="{{ route('admin.registrations.approve', $reg) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.registrations.reject', $reg) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #737373; padding: 2rem;">
                                    Tidak ada pendaftaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $registrations->links() }}
    </div>
@endsection
