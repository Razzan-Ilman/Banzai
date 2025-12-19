@extends('layouts.member')

@section('title', 'Edit Profil')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Profil</h2>
        <a href="{{ route('member.profile.index') }}" class="btn btn-outline btn-sm">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Photo Upload -->
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="display: block; font-weight: 600; margin-bottom: 1rem;">Foto Profil</label>
                
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <!-- Current Photo -->
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--neutral-100); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 700; color: var(--neutral-400); overflow: hidden;">
                        @if($profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="Current photo" id="preview" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span id="preview">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    
                    <!-- Upload Button -->
                    <div>
                        <input type="file" name="photo" id="photo" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        <label for="photo" class="btn btn-primary" style="cursor: pointer;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Upload Foto
                        </label>
                        <p style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                            Max 2MB. Format: JPG, PNG
                        </p>
                    </div>
                </div>
                @error('photo')
                    <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" for="bio">Bio</label>
                <textarea 
                    id="bio" 
                    name="bio" 
                    rows="4"
                    style="width: 100%; padding: 0.75rem; border: 2px solid var(--neutral-300); border-radius: 8px; font-family: inherit; resize: vertical;"
                    placeholder="Ceritakan tentang dirimu..."
                >{{ old('bio', $profile->bio) }}</textarea>
                <p style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.5rem;">
                    Maksimal 500 karakter
                </p>
                @error('bio')
                    <p style="color: #EF4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Read-only Info -->
            <div style="background: var(--neutral-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="font-weight: 600; margin-bottom: 1rem; color: var(--ink-900);">Informasi Akun</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.875rem; color: var(--neutral-600);">Nama</label>
                        <p style="font-weight: 600; color: var(--ink-900);">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label style="font-size: 0.875rem; color: var(--neutral-600);">Email</label>
                        <p style="font-weight: 600; color: var(--ink-900);">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label style="font-size: 0.875rem; color: var(--neutral-600);">Nomor Induk</label>
                        <p style="font-weight: 600; color: var(--ink-900);">{{ $profile->member_number }}</p>
                    </div>
                    <div>
                        <label style="font-size: 0.875rem; color: var(--neutral-600);">Level</label>
                        <p style="font-weight: 600; color: var(--ink-900);">{{ $profile->level }} - {{ $profile->getLevelName() }}</p>
                    </div>
                </div>
                <p style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 1rem;">
                    ℹ️ Untuk mengubah nama atau email, hubungi admin.
                </p>
            </div>

            <!-- Submit -->
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('member.profile.index') }}" class="btn btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = '<img src="' + e.target.result + '" id="preview" style="width: 100%; height: 100%; object-fit: cover;">';
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.btn-outline {
    background: transparent;
    border: 1px solid var(--neutral-300);
    color: var(--neutral-700);
}

.btn-outline:hover {
    background: var(--neutral-50);
    border-color: var(--neutral-400);
}
</style>
@endsection
