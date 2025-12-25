@extends('layouts.admin')

@section('title', 'Kelola Akun Pengguna')

@section('content')
    {{-- Stats Cards --}}
    <div class="stats-grid" style="margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Akun</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #DC2626;">{{ $stats['admin'] }}</div>
            <div class="stat-label">Admin</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #7C3AED;">{{ $stats['core'] }}</div>
            <div class="stat-label">Core</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #2563EB;">{{ $stats['member'] }}</div>
            <div class="stat-label">Member</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #737373;">{{ $stats['public'] }}</div>
            <div class="stat-label">Public</div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600;">Daftar Akun</h2>
            
            {{-- Role Filter --}}
            <div style="display: flex; gap: 0.375rem;">
                <a href="{{ route('admin.users.index', ['role' => 'all']) }}" 
                   class="btn btn-sm" 
                   style="{{ $role === 'all' ? 'background: var(--primary-700); color: white;' : 'background: #E5E5E5;' }}">
                    Semua
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                   class="btn btn-sm" 
                   style="{{ $role === 'admin' ? 'background: #DC2626; color: white;' : 'background: #E5E5E5;' }}">
                    Admin
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'core']) }}" 
                   class="btn btn-sm" 
                   style="{{ $role === 'core' ? 'background: #7C3AED; color: white;' : 'background: #E5E5E5;' }}">
                    Core
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'member']) }}" 
                   class="btn btn-sm" 
                   style="{{ $role === 'member' ? 'background: #2563EB; color: white;' : 'background: #E5E5E5;' }}">
                    Member
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'public']) }}" 
                   class="btn btn-sm" 
                   style="{{ $role === 'public' ? 'background: #737373; color: white;' : 'background: #E5E5E5;' }}">
                    Public
                </a>
            </div>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah Akun</a>
    </div>

    {{-- Search Form --}}
    <div class="card" style="margin-bottom: 1rem;">
        <div class="card-body" style="padding: 0.75rem 1rem;">
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="hidden" name="role" value="{{ $role }}">
                <input type="text" name="search" class="form-input" placeholder="Cari nama atau email..." 
                       value="{{ request('search') }}" style="max-width: 300px;">
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index', ['role' => $role]) }}" class="btn btn-sm" style="background: #E5E5E5;">Reset</a>
                @endif
            </form>
        </div>
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
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span style="width: 32px; height: 32px; border-radius: 50%; background: {{ $user->id === auth()->id() ? '#10B981' : '#6B7280' }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        <span>
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span style="font-size: 0.7rem; color: #10B981;">(Anda)</span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @switch($user->role)
                                        @case('admin')
                                            <span class="badge" style="background: #FEE2E2; color: #DC2626;">Admin</span>
                                            @break
                                        @case('core')
                                            <span class="badge" style="background: #EDE9FE; color: #7C3AED;">Core</span>
                                            @break
                                        @case('member')
                                            <span class="badge" style="background: #DBEAFE; color: #2563EB;">Member</span>
                                            @break
                                        @default
                                            <span class="badge" style="background: #F3F4F6; color: #6B7280;">Public</span>
                                    @endswitch
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="background: #E5E5E5;">Edit</a>
                                        
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Reset password untuk {{ $user->name }}?')" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" style="background: #FEF3C7; color: #92400E;">🔑 Reset</button>
                                            </form>
                                            
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $user->name }}?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #737373; padding: 2rem;">
                                    Tidak ada akun ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $users->appends(['role' => $role, 'search' => request('search')])->links() }}
    </div>
@endsection
