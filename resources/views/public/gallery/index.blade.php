@extends('layouts.app')

@section('title', 'Galeri Foto - BANZAI')

@section('content')
<div class="gallery-public-page" style="padding: 4rem 0;">
    <div class="container">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">📸 Galeri Foto</h1>
            <p style="color: var(--neutral-600); font-size: 1.125rem;">Momen-momen berharga kegiatan BANZAI</p>
        </div>

        <!-- Gallery Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($galleries as $gallery)
                <a href="{{ route('gallery.show', $gallery) }}" class="gallery-card" style="display: block; text-decoration: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;">
                    <!-- Cover Image -->
                    <div style="height: 200px; background: {{ $gallery->cover_image ? "url('" . asset('storage/' . $gallery->cover_image) . "') center/cover" : 'linear-gradient(135deg, #667EEA, #764BA2)' }}; position: relative;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 1rem; background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                            <span style="background: rgba(255,255,255,0.2); color: white; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem; backdrop-filter: blur(4px);">
                                📷 {{ $gallery->photos_count }} foto
                            </span>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div style="padding: 1.25rem; background: white;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $gallery->title }}</h3>
                        @if($gallery->description)
                            <p style="color: var(--neutral-500); font-size: 0.875rem; margin-bottom: 0.5rem;">{{ Str::limit($gallery->description, 60) }}</p>
                        @endif
                        <div style="color: var(--neutral-400); font-size: 0.75rem;">{{ $gallery->created_at->format('d M Y') }}</div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📷</div>
                    <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Belum Ada Galeri</h3>
                    <p style="color: var(--neutral-500);">Galeri foto akan segera hadir</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }
</style>
@endsection
