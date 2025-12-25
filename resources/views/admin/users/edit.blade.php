@extends('layouts.admin')

@section('title', 'Edit Akun')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Edit Akun: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: #E5E5E5;">← Kembali</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            @if($user->id === auth()->id())
                <div class="alert" style="background: #FEF3C7; color: #92400E; margin-bottom: 1rem;">
                    ⚠️ Anda sedang mengedit akun Anda sendiri. Berhati-hatilah saat mengubah role.
                </div>
            @endif
            
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap <span style="color: #DC2626;">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: #DC2626;">*</span></label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{ old('email', $user->email) }}" placeholder="nama@example.com" required>
                    @error('email')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="role" class="form-label">Role <span style="color: #DC2626;">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="public" {{ old('role', $user->role) == 'public' ? 'selected' : '' }}>Public (Pengunjung)</option>
                        <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member (Anggota)</option>
                        <option value="core" {{ old('role', $user->role) == 'core' ? 'selected' : '' }}>Core (Anggota Inti)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Pengurus)</option>
                    </select>
                    @error('role')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid #E5E5E5;">
                
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: #6B7280;">
                        <strong>Ganti Password</strong> (kosongkan jika tidak ingin mengubah)
                    </p>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                           placeholder="Ketik ulang password baru">
                </div>
                
                <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Account Info --}}
    <div class="card" style="max-width: 600px; margin-top: 1rem;">
        <div class="card-body" style="padding: 1rem;">
            <p style="font-size: 0.75rem; color: #6B7280;">
                <strong>Info Akun:</strong><br>
                Dibuat: {{ $user->created_at->format('d M Y H:i') }}<br>
                Terakhir diubah: {{ $user->updated_at->format('d M Y H:i') }}
            </p>
        </div>
    </div>
@endsection
