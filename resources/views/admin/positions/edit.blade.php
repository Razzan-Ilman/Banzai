@extends('layouts.admin')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="card" style="max-width: 500px;">
        <div class="card-header">Edit Jabatan: {{ $position->name }}</div>
        <div class="card-body">
            <form action="{{ route('admin.positions.update', $position) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Jabatan *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $position->name) }}" required>
                    @error('name')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label for="level" class="form-label">Level Prioritas *</label>
                    <input type="number" id="level" name="level" class="form-input" value="{{ old('level', $position->level) }}" min="1" required>
                    <p style="font-size: 0.75rem; color: #737373; margin-top: 0.25rem;">Level 1 = tertinggi (Ketua). Semakin besar angka, semakin rendah prioritas.</p>
                    @error('level')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $position->is_active) ? 'checked' : '' }}>
                        <span>Jabatan Aktif</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.positions.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
