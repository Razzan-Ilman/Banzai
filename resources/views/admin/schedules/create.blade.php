@extends('layouts.admin')

@section('title', 'Buat Jadwal')

@section('content')
<div class="schedules-create-page">
    <a href="{{ route('admin.schedules.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📅 Buat Jadwal Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
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

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tipe *</label>
                        <select name="type" class="form-control" required>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tanggal Mulai *</label>
                        <input type="datetime-local" name="start_date" class="form-control" required value="{{ old('start_date') }}">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tanggal Selesai</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
