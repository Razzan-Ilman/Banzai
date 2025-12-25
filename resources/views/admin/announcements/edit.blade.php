@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="announcements-edit-page">
    <a href="{{ route('admin.announcements.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">✏️ Edit Pengumuman</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tipe</label>
                        <select name="type" class="form-control" required>
                            @foreach(['info', 'warning', 'success', 'event'] as $type)
                                <option value="{{ $type }}" {{ $announcement->type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Prioritas</label>
                        <select name="priority" class="form-control" required>
                            @foreach(['low' => 'Rendah', 'normal' => 'Normal', 'high' => 'Tinggi', 'urgent' => 'Mendesak'] as $key => $label)
                                <option value="{{ $key }}" {{ $announcement->priority === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $announcement->title) }}">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Isi Pengumuman *</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ old('content', $announcement->content) }}</textarea>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Kadaluarsa</label>
                    <input type="datetime-local" name="expires_at" class="form-control" value="{{ $announcement->expires_at?->format('Y-m-d\TH:i') }}">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ $announcement->is_published ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Pengumuman</button>
                    <a href="{{ route('admin.announcements.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
