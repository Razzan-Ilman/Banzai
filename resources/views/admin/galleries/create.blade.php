@extends('layouts.admin')

@section('title', 'Buat Galeri')

@section('content')
<div class="galleries-create-page">
    <a href="{{ route('admin.galleries.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📷 Buat Galeri Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                    @error('title')<span style="color: #DC2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1">
                        <span>Langsung Publish</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Buat Galeri</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
