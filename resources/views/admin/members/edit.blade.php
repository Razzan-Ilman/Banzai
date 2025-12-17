@extends('layouts.admin')

@section('title', 'Edit Anggota')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">Edit Anggota: {{ $member->name }}</div>
        <div class="card-body">
            <form action="{{ route('admin.members.update', $member) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $member->name) }}" required>
                    @error('name')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="class" class="form-label">Kelas *</label>
                        <select id="class" name="class" class="form-select" required>
                            <option value="X" {{ old('class', $member->class) == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('class', $member->class) == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('class', $member->class) == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="major" class="form-label">Jurusan *</label>
                        <select id="major" name="major" class="form-select" required>
                            <option value="Kimia Analisis" {{ old('major', $member->major) == 'Kimia Analisis' ? 'selected' : '' }}>Kimia Analisis</option>
                            <option value="Kimia Industri" {{ old('major', $member->major) == 'Kimia Industri' ? 'selected' : '' }}>Kimia Industri</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="position" class="form-label">Jabatan</label>
                        <select id="position" name="position" class="form-select">
                            <option value="">Anggota</option>
                            <option value="Ketua" {{ old('position', $member->position) == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Wakil Ketua" {{ old('position', $member->position) == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="Koordinator" {{ old('position', $member->position) == 'Koordinator' ? 'selected' : '' }}>Koordinator</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="division_id" class="form-label">Divisi</label>
                        <select id="division_id" name="division_id" class="form-select">
                            <option value="">Tidak Ada</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id', $member->division_id) == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="initial_color" class="form-label">Warna Inisial</label>
                        <input type="color" id="initial_color" name="initial_color" value="{{ old('initial_color', $member->initial_color ?? '#064E3B') }}" style="width: 100%; height: 40px; border: none; border-radius: 0.375rem;">
                    </div>
                    
                    <div class="form-group">
                        <label for="order" class="form-label">Urutan</label>
                        <input type="number" id="order" name="order" class="form-input" value="{{ old('order', $member->order) }}" min="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                        <span>Anggota Aktif</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.members.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
