@extends('layouts.admin')

@section('title', $gallery->title . ' - Galeri')

@section('content')
<div class="galleries-show-page">
    <a href="{{ route('admin.galleries.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali ke Galeri
    </a>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Gallery Info -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $gallery->title }}</h2>
                    @if($gallery->description)
                        <p style="color: var(--neutral-600);">{{ $gallery->description }}</p>
                    @endif
                    <div style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--neutral-500);">
                        📷 {{ $gallery->photos->count() }} foto • 
                        @if($gallery->is_published)
                            <span style="color: #059669;">Published</span>
                        @else
                            <span style="color: #DC2626;">Draft</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn" style="background: var(--neutral-100);">✏️ Edit</a>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h3 class="card-title">📤 Upload Foto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.galleries.photos.upload', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: flex; gap: 1rem; align-items: end;">
                    <div style="flex: 1;">
                        <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
                        <small style="color: var(--neutral-500);">Bisa upload beberapa foto sekaligus (max 5MB per foto)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Photos Grid -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🖼️ Foto ({{ $gallery->photos->count() }})</h3>
        </div>
        <div class="card-body">
            @if($gallery->photos->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem;">
                    @foreach($gallery->photos as $photo)
                        <div style="position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1;">
                            <img src="{{ asset('storage/' . ($photo->thumbnail_path ?: $photo->image_path)) }}" 
                                 alt="{{ $photo->caption }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(transparent 60%, rgba(0,0,0,0.7)); display: flex; align-items: end; justify-content: center; padding: 0.5rem; opacity: 0; transition: opacity 0.2s;" class="photo-overlay">
                                <form action="{{ route('admin.galleries.photos.delete', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📷</div>
                    <p>Belum ada foto. Upload foto pertama di atas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .galleries-show-page .photo-overlay:hover,
    .galleries-show-page div:hover > .photo-overlay {
        opacity: 1;
    }
</style>
@endsection
