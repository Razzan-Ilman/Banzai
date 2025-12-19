@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--indigo-900), var(--indigo-800));
        padding: var(--space-4);
    }

    .auth-card {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-2xl);
        width: 100%;
        max-width: 500px;
        padding: var(--space-8);
    }

    .auth-header {
        text-align: center;
        margin-bottom: var(--space-6);
    }

    .auth-logo {
        font-family: 'Noto Sans JP', serif;
        font-size: 3rem;
        color: var(--antique-gold);
        margin-bottom: var(--space-2);
    }

    .auth-title {
        font-size: var(--h3);
        color: var(--ink-900);
        margin-bottom: var(--space-1);
    }

    .auth-subtitle {
        color: var(--ink-500);
        font-size: var(--body-small);
    }

    .form-group {
        margin-bottom: var(--space-4);
    }

    .form-label {
        display: block;
        font-weight: var(--fw-semibold);
        color: var(--ink-800);
        margin-bottom: var(--space-2);
    }

    .form-input, .form-select {
        width: 100%;
        padding: var(--space-3);
        border: 2px solid var(--ivory-300);
        border-radius: var(--radius-md);
        font-size: var(--body-base);
        transition: all var(--transition-base);
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--antique-gold);
        box-shadow: 0 0 0 3px rgba(199, 161, 74, 0.1);
    }

    .form-error {
        color: #DC2626;
        font-size: var(--body-small);
        margin-top: var(--space-1);
    }

    .btn-register {
        width: 100%;
        padding: var(--space-3);
        background: var(--antique-gold);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: var(--fw-semibold);
        font-size: var(--body-base);
        cursor: pointer;
        transition: all var(--transition-base);
    }

    .btn-register:hover {
        background: var(--gold-700);
        transform: translateY(-2px);
    }

    .role-info {
        background: var(--ivory-200);
        padding: var(--space-3);
        border-radius: var(--radius-md);
        font-size: var(--body-small);
        color: var(--ink-600);
        margin-bottom: var(--space-4);
    }

    .auth-link {
        text-align: center;
        margin-top: var(--space-4);
        color: var(--ink-600);
    }

    .auth-link a {
        color: var(--antique-gold);
        font-weight: var(--fw-semibold);
        text-decoration: none;
    }

    .auth-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">万歳</div>
            <h1 class="auth-title">Daftar Akun</h1>
            <p class="auth-subtitle">Bergabung dengan komunitas BANZAI</p>
        </div>

        <div class="role-info">
            <strong>ℹ️ Info Role:</strong><br>
            <strong>Public:</strong> Akses terbatas (lihat konten)<br>
            <strong>Member:</strong> Akses penuh (event, kegiatan)<br>
            <strong>Core:</strong> Anggota inti (akses khusus)<br>
            <strong>Admin:</strong> Kelola website (khusus pengurus)
        </div>

        @if ($errors->any())
            <div style="background: #FEE2E2; color: #991B1B; padding: var(--space-3); border-radius: var(--radius-md); margin-bottom: var(--space-4);">
                <strong>⚠️ Error:</strong>
                <ul style="margin: var(--space-1) 0 0 var(--space-4);">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.register.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input" 
                    value="{{ old('name') }}"
                    placeholder="Nama lengkap Anda"
                    required 
                    autofocus
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    required
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Minimal 8 karakter"
                    required
                >
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input" 
                    placeholder="Ketik ulang password"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="role">Pilih Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="public" {{ old('role') == 'public' ? 'selected' : '' }}>Public (Pengunjung)</option>
                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Anggota)</option>
                    <option value="core" {{ old('role') == 'core' ? 'selected' : '' }}>Core (Anggota Inti)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengurus)</option>
                </select>
                @error('role')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-register">
                Daftar Sekarang
            </button>
        </form>

        <div class="auth-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>

        <div class="auth-link" style="margin-top: var(--space-2);">
            <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
