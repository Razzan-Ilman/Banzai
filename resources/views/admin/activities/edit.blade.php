@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header">Edit Kegiatan: {{ Str::limit($activity->title, 30) }}</div>
        <div class="card-body">
            <form action="{{ route('admin.activities.update', $activity) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title" class="form-label">Judul Kegiatan *</label>
                    <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $activity->title) }}" required>
                    @error('title')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Singkat</label>
                    <textarea id="description" name="description" class="form-input" rows="2">{{ old('description', $activity->description) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="content" class="form-label">Konten Detail</label>
                    <textarea id="content" name="content" class="form-input" rows="5">{{ old('content', $activity->content) }}</textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="date" class="form-label">Tanggal *</label>
                        <input type="date" id="date" name="date" class="form-input" value="{{ old('date', $activity->date->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" id="location" name="location" class="form-input" value="{{ old('location', $activity->location) }}">
                    </div>
                </div>
                
                <div style="display: flex; gap: 2rem; margin: 1rem 0;">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $activity->is_published) ? 'checked' : '' }}>
                        <span>Publish</span>
                    </label>
                    
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $activity->is_featured) ? 'checked' : '' }}>
                        <span>Featured</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.activities.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
