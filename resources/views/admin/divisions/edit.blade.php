@extends('layouts.admin')

@section('title', 'Edit Divisi')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">Edit Divisi: {{ $division->name }}</div>
        <div class="card-body">
            <form action="{{ route('admin.divisions.update', $division) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Divisi *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $division->name) }}" required>
                    @error('name')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label for="tagline" class="form-label">Tagline</label>
                    <input type="text" id="tagline" name="tagline" class="form-input" value="{{ old('tagline', $division->tagline) }}">
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-textarea" rows="3">{{ old('description', $division->description) }}</textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="icon" class="form-label">Icon (Emoji)</label>
                        <input type="text" id="icon" name="icon" class="form-input" value="{{ old('icon', $division->icon) }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="color" class="form-label">Warna</label>
                        <input type="color" id="color" name="color" value="{{ old('color', $division->color) }}" style="width: 100%; height: 40px; border: none; border-radius: 0.375rem;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="character" class="form-label">Karakter</label>
                        <select id="character" name="character" class="form-select">
                            <option value="">Pilih Karakter</option>
                            <option value="Scholar" {{ old('character', $division->character) == 'Scholar' ? 'selected' : '' }}>Scholar</option>
                            <option value="Artist" {{ old('character', $division->character) == 'Artist' ? 'selected' : '' }}>Artist</option>
                            <option value="Connector" {{ old('character', $division->character) == 'Connector' ? 'selected' : '' }}>Connector</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="order" class="form-label">Urutan</label>
                        <input type="number" id="order" name="order" class="form-input" value="{{ old('order', $division->order) }}" min="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $division->is_active) ? 'checked' : '' }}>
                        <span>Divisi Aktif</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.divisions.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
