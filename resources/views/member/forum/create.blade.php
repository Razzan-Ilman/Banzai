@extends('layouts.member')

@section('title', 'Buat Diskusi')

@section('content')
<div class="forum-create-page">
    <!-- Back Button -->
    <a href="{{ route('member.forum.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Forum
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">✏️ Buat Diskusi Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('member.forum.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; color: var(--ink-900); margin-bottom: 0.5rem;">
                        Kategori <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="category" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px; font-size: 1rem;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; color: var(--ink-900); margin-bottom: 0.5rem;">
                        Judul <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul diskusi..."
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px; font-size: 1rem;">
                    @error('title')
                        <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; color: var(--ink-900); margin-bottom: 0.5rem;">
                        Isi Diskusi <span style="color: #EF4444;">*</span>
                    </label>
                    <textarea name="content" required rows="8" placeholder="Tulis isi diskusi kamu..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px; font-size: 1rem; resize: vertical;">{{ old('content') }}</textarea>
                    @error('content')
                        <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                    <p style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.25rem;">Minimal 10 karakter</p>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('member.forum.index') }}" class="btn" style="background: var(--neutral-100); color: var(--neutral-700);">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Posting Diskusi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
