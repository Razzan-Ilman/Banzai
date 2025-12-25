@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
<div class="galleries-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">📷 Galeri Foto</h2>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">+ Buat Galeri</a>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($galleries as $gallery)
            <div class="card" style="overflow: hidden;">
                <div style="height: 160px; background: {{ $gallery->cover_image ? "url('" . asset('storage/' . $gallery->cover_image) . "') center/cover" : 'linear-gradient(135deg, #667EEA, #764BA2)' }}; position: relative;">
                    <div style="position: absolute; top: 0.5rem; right: 0.5rem;">
                        @if($gallery->is_published)
                            <span style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Published</span>
                        @else
                            <span style="background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Draft</span>
                        @endif
                    </div>
                    <div style="position: absolute; bottom: 0.5rem; left: 0.5rem;">
                        <span style="background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                            📷 {{ $gallery->photos_count }} foto
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h3 style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $gallery->title }}</h3>
                    <p style="font-size: 0.875rem; color: var(--neutral-500); margin-bottom: 1rem;">{{ Str::limit($gallery->description, 60) }}</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-sm btn-primary" style="flex: 1; text-align: center;">Kelola</a>
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm" style="background: var(--neutral-100);">✏️</a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus galeri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📷</div>
                <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Belum Ada Galeri</h3>
                <p style="color: var(--neutral-500); margin-bottom: 1rem;">Buat galeri pertama untuk mengupload foto</p>
                <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">Buat Galeri</a>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div style="margin-top: 1.5rem;">{{ $galleries->links() }}</div>
    @endif
</div>
@endsection
