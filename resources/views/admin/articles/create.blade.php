@extends('layouts.admin')

@section('title', 'Tulis Artikel')

@section('content')
<div class="articles-create-page">
    <a href="{{ route('admin.articles.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <!-- Main Content -->
            <div>
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h2 class="card-title">📝 Tulis Artikel Baru</h2>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}" style="font-size: 1.25rem;">
                            @error('title')<span style="color: #DC2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ringkasan</label>
                            <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt') }}</textarea>
                            <small style="color: var(--neutral-500);">Maks 500 karakter</small>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Konten *</label>
                            <textarea name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
                            @error('content')<span style="color: #DC2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
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
                            <input type="text" name="meta_title" class="form-control" maxlength="60" value="{{ old('meta_title') }}">
                            <small style="color: var(--neutral-500);">Maks 60 karakter</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2" maxlength="160">{{ old('meta_description') }}</textarea>
                            <small style="color: var(--neutral-500);">Maks 160 karakter</small>
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
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="scheduled">Scheduled</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Kategori *</label>
                            <select name="category" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Jadwal Publish</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Artikel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
