@extends('layouts.admin')

@section('title', 'Kelola Pendaftaran')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Pendaftaran</h2>
        
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            {{-- Export Button --}}
            <a href="{{ route('admin.registrations.export', ['status' => request('status')]) }}" 
               class="btn btn-sm" 
               style="background: #10B981; color: white; display: inline-flex; align-items: center; gap: 0.375rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Export Excel
            </a>
            
            {{-- Filter Buttons --}}
            <div style="display: flex; gap: 0.375rem; margin-left: 0.5rem;">
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : '' }}" style="{{ !request('status') ? '' : 'background: #E5E5E5;' }}">Semua</a>
                <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : '' }}" style="{{ request('status') == 'pending' ? '' : 'background: #E5E5E5;' }}">Pending</a>
                <a href="{{ route('admin.registrations.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') == 'approved' ? 'btn-primary' : '' }}" style="{{ request('status') == 'approved' ? '' : 'background: #E5E5E5;' }}">Disetujui</a>
                <a href="{{ route('admin.registrations.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-primary' : '' }}" style="{{ request('status') == 'rejected' ? '' : 'background: #E5E5E5;' }}">Ditolak</a>
            </div>
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
