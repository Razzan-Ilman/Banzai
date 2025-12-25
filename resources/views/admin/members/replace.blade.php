@extends('layouts.admin')

@section('title', 'Ganti Anggota')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header" style="background: #FEF3C7; border-left: 4px solid #F59E0B;">
            ⚠️ Ganti Anggota: {{ $member->name }}
        </div>
        <div class="card-body">
            {{-- Info Anggota Lama --}}
            <div style="background: #F5F5F5; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem;">
                <h3 style="font-size: 0.875rem; font-weight: 600; color: #737373; margin-bottom: 0.75rem;">ANGGOTA YANG AKAN DIGANTI (MENJADI ALUMNI)</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div><span style="color: #737373;">Nama:</span> <strong>{{ $member->name }}</strong></div>
                    <div><span style="color: #737373;">Kelas:</span> {{ $member->class }}</div>
                    <div><span style="color: #737373;">Jurusan:</span> {{ $member->major }}</div>
                    <div><span style="color: #737373;">Jabatan:</span> {{ $member->display_position ?? '-' }}</div>
                    <div><span style="color: #737373;">Divisi:</span> {{ $member->division?->name ?? '-' }}</div>
                </div>
            </div>

            {{-- Form Anggota Baru --}}
            <form action="{{ route('admin.members.replace.store', $member) }}" method="POST" id="replaceForm">
                @csrf
                
                <h3 style="font-size: 0.875rem; font-weight: 600; color: var(--primary-700); margin-bottom: 1rem;">DATA ANGGOTA BARU (PENGGANTI)</h3>
                
                <div class="form-group">
                    <label for="new_name" class="form-label">Nama Lengkap *</label>
                    <input type="text" id="new_name" name="new_name" class="form-input" value="{{ old('new_name') }}" required>
                    @error('new_name')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="new_class" class="form-label">Kelas *</label>
                        <select id="new_class" name="new_class" class="form-select" required>
                            <option value="X" {{ old('new_class') == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('new_class') == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('new_class') == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_major" class="form-label">Jurusan *</label>
                        <select id="new_major" name="new_major" class="form-select" required>
                            <option value="Kimia Analisis" {{ old('new_major') == 'Kimia Analisis' ? 'selected' : '' }}>Kimia Analisis</option>
                            <option value="Kimia Industri" {{ old('new_major') == 'Kimia Industri' ? 'selected' : '' }}>Kimia Industri</option>
                        </select>
                    </div>
                </div>
                
                <div style="background: #FEE2E2; border: 1px solid #EF4444; border-radius: 0.5rem; padding: 1rem; margin: 1.5rem 0;">
                    <p style="color: #991B1B; font-weight: 500; margin-bottom: 0.5rem;">⚠️ PERINGATAN</p>
                    <p style="color: #991B1B; font-size: 0.875rem; margin-bottom: 1rem;">
                        Tindakan ini akan:<br>
                        • Mengubah status <strong>{{ $member->name }}</strong> menjadi <strong>ALUMNI</strong><br>
                        • Membuat anggota baru dengan jabatan dan divisi yang sama<br>
                        • Data anggota lama tetap tersimpan untuk histori
                    </p>
                    
                    <label class="form-checkbox" style="background: white; padding: 0.75rem; border-radius: 0.375rem;">
                        <input type="checkbox" name="confirm_replace" value="1" id="confirmCheckbox" required>
                        <span style="color: #991B1B; font-weight: 500;">Saya yakin anggota ini sudah lulus dan ingin diganti</span>
                    </label>
                    @error('confirm_replace')<p style="color: #EF4444; font-size: 0.875rem;">{{ $message }}</p>@enderror
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-danger" id="submitBtn" disabled style="opacity: 0.5;">
                        🔄 Ganti Anggota
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn" style="background: #E5E5E5;">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('confirmCheckbox').addEventListener('change', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (this.checked) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            }
        });
    </script>
@endsection
