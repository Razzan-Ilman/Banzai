@extends('layouts.admin')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="announcements-create-page">
    <a href="{{ route('admin.announcements.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📢 Buat Pengumuman Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tipe</label>
                        <select name="type" class="form-control" required>
                            <option value="info">Info</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                            <option value="event">Event</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Prioritas</label>
                        <select name="priority" class="form-control" required>
                            <option value="low">Rendah</option>
                            <option value="normal" selected>Normal</option>
                            <option value="high">Tinggi</option>
                            <option value="urgent">Mendesak</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                    @error('title')<span style="color: #DC2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Isi Pengumuman *</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                    @error('content')<span style="color: #DC2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Target</label>
                        <select name="target_type" class="form-control">
                            <option value="all">Semua Member</option>
                            <option value="role">Role Tertentu</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Kadaluarsa</label>
                        <input type="datetime-local" name="expires_at" class="form-control">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1">
                        <span>Langsung Publish</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Simpan Pengumuman</button>
                    <a href="{{ route('admin.announcements.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
