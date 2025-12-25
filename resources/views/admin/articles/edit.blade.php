@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="articles-edit-page">
    <a href="{{ route('admin.articles.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <!-- Main Content -->
            <div>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h2 class="card-title">✏️ Edit Artikel</h2>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title', $article->title) }}" style="font-size: 1.25rem;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ringkasan</label>
                            <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt', $article->excerpt) }}</textarea>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Konten *</label>
                            <textarea name="content" class="form-control" rows="15" required>{{ old('content', $article->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SEO -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">🔍 SEO</h3>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" maxlength="60" value="{{ old('meta_title', $article->meta_title) }}">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2" maxlength="160">{{ old('meta_description', $article->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan</h3>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Status *</label>
                            <select name="status" class="form-control" required>
                                @foreach(['draft' => 'Draft', 'published' => 'Published', 'scheduled' => 'Scheduled'] as $key => $label)
                                    <option value="{{ $key }}" {{ $article->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Kategori *</label>
                            <select name="category" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $article->category === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Jadwal Publish</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ $article->scheduled_at?->format('Y-m-d\TH:i') }}">
                        </div>

                        @if($article->thumbnail)
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Thumbnail Saat Ini</label>
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" style="width: 100%; border-radius: 8px;">
                            </div>
                        @endif

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ganti Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Update Artikel</button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="card">
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center;">
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">{{ number_format($article->views_count) }}</div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">Views</div>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">{{ $article->read_time }}</div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">Min Read</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
