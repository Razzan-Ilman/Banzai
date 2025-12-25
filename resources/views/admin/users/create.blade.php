@extends('layouts.admin')

@section('title', 'Tambah Akun Baru')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Tambah Akun Baru</h2>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: #E5E5E5;">← Kembali</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap <span style="color: #DC2626;">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: #DC2626;">*</span></label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{ old('email') }}" placeholder="nama@example.com" required>
                    @error('email')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="role" class="form-label">Role <span style="color: #DC2626;">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="public" {{ old('role') == 'public' ? 'selected' : '' }}>Public (Pengunjung)</option>
                        <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Anggota)</option>
                        <option value="core" {{ old('role') == 'core' ? 'selected' : '' }}>Core (Anggota Inti)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengurus)</option>
                    </select>
                    @error('role')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                    
                    <div style="margin-top: 0.5rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.375rem; font-size: 0.75rem; color: #6B7280;">
                        <strong>Info Role:</strong><br>
                        • <strong>Public:</strong> Akses terbatas (lihat konten)<br>
                        • <strong>Member:</strong> Akses penuh (event, kegiatan)<br>
                        • <strong>Core:</strong> Anggota inti (akses khusus)<br>
                        • <strong>Admin:</strong> Kelola website (akses penuh)
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password <span style="color: #DC2626;">*</span></label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span style="color: #DC2626;">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                           placeholder="Ketik ulang password" required>
                </div>
                
                <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                    <a href="{{ route('admin.users.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
