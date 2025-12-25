@extends('layouts.admin')

@section('title', 'Tambah Jabatan')

@section('content')
    <div class="card" style="max-width: 500px;">
        <div class="card-header">Tambah Jabatan Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.positions.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Jabatan *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Contoh: Ketua, Wakil Ketua, Koordinator">
                    @error('name')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label for="level" class="form-label">Level Prioritas *</label>
                    <input type="number" id="level" name="level" class="form-input" value="{{ old('level', $maxLevel + 1) }}" min="1" required>
                    <p style="font-size: 0.75rem; color: #737373; margin-top: 0.25rem;">Level 1 = tertinggi (Ketua). Semakin besar angka, semakin rendah prioritas.</p>
                    @error('level')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span>Jabatan Aktif</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.positions.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
