@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="schedules-edit-page">
    <a href="{{ route('admin.schedules.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">✏️ Edit Jadwal</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Judul *</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $schedule->title) }}">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $schedule->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tipe *</label>
                        <select name="type" class="form-control" required>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ $schedule->type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $schedule->location) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tanggal Mulai *</label>
                        <input type="datetime-local" name="start_date" class="form-control" required value="{{ $schedule->start_date->format('Y-m-d\TH:i') }}">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tanggal Selesai</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ $schedule->end_date?->format('Y-m-d\TH:i') }}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Update Jadwal</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn" style="background: var(--neutral-100);">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
