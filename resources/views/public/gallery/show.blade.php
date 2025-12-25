@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri BANZAI')

@section('content')
<div class="gallery-show-page" style="padding: 4rem 0;">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('gallery') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 2rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Galeri
        </a>

        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">{{ $gallery->title }}</h1>
            @if($gallery->description)
                <p style="color: var(--neutral-600); font-size: 1rem; margin-bottom: 0.5rem;">{{ $gallery->description }}</p>
            @endif
            <div style="color: var(--neutral-500); font-size: 0.875rem;">
                📅 {{ $gallery->created_at->format('d M Y') }} • 📷 {{ $gallery->photos->count() }} foto
            </div>
        </div>

        <!-- Photos Grid -->
        <div class="photo-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @forelse($gallery->photos as $photo)
                <div class="photo-item" style="position: relative; border-radius: 12px; overflow: hidden; cursor: pointer;" onclick="openLightbox({{ $loop->index }})">
                    <img src="{{ asset('storage/' . ($photo->thumbnail_path ?: $photo->image_path)) }}" 
                         alt="{{ $photo->caption ?: 'Photo' }}"
                         style="width: 100%; aspect-ratio: 1; object-fit: cover; transition: transform 0.3s;">
                    @if($photo->caption)
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 0.75rem; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; font-size: 0.875rem;">
                            {{ $photo->caption }}
                        </div>
                    @endif
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📷</div>
                    <p style="color: var(--neutral-500);">Belum ada foto di galeri ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.95); z-index: 9999; align-items: center; justify-content: center;">
    <button onclick="closeLightbox()" style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; font-size: 1.5rem;">×</button>
    <button onclick="prevPhoto()" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; font-size: 1.5rem;">‹</button>
    <button onclick="nextPhoto()" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; font-size: 1.5rem;">›</button>
    <img id="lightbox-img" src="" alt="" style="max-width: 90vw; max-height: 90vh; border-radius: 8px;">
    <div id="lightbox-caption" style="position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%); color: white; text-align: center;"></div>
</div>

<script>
    const photos = @json($gallery->photos->map(fn($p) => ['src' => asset('storage/' . $p->image_path), 'caption' => $p->caption]));
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightbox').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = '';
    }

    function updateLightbox() {
        document.getElementById('lightbox-img').src = photos[currentIndex].src;
        document.getElementById('lightbox-caption').textContent = photos[currentIndex].caption || '';
    }

    function nextPhoto() {
        currentIndex = (currentIndex + 1) % photos.length;
        updateLightbox();
    }

    function prevPhoto() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length;
        updateLightbox();
    }

    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').style.display === 'flex') {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextPhoto();
            if (e.key === 'ArrowLeft') prevPhoto();
        }
    });
</script>

<style>
    .photo-item:hover img {
        transform: scale(1.05);
    }
</style>
@endsection
