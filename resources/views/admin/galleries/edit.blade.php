@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="galleries-edit-page">
    <a href="{{ route('admin.galleries.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">✏️ Edit Galeri</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $gallery->title) }}">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ $gallery->is_published ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Galeri</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
