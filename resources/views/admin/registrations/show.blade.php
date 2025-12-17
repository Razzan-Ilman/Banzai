@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header flex justify-between items-center">
            <span>Detail Pendaftaran</span>
            <span class="badge badge-{{ $registration->status }}">{{ $registration->status_label }}</span>
        </div>
        <div class="card-body">
            <div style="display: grid; gap: 1rem;">
                <div>
                    <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Nama Lengkap</label>
                    <p style="font-weight: 500;">{{ $registration->name }}</p>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Kelas</label>
                        <p style="font-weight: 500;">{{ $registration->class }}</p>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Jurusan</label>
                        <p style="font-weight: 500;">{{ $registration->major }}</p>
                    </div>
                </div>
                
                <div>
                    <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Divisi Pilihan</label>
                    <p style="font-weight: 500;">{{ ucfirst($registration->preferred_division) }}</p>
                </div>
                
                <div>
                    <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Alasan Bergabung</label>
                    <p style="background: #F5F5F5; padding: 1rem; border-radius: 0.375rem; line-height: 1.6;">{{ $registration->reason }}</p>
                </div>
                
                @if($registration->phone || $registration->email)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @if($registration->phone)
                    <div>
                        <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">WhatsApp</label>
                        <p style="font-weight: 500;">{{ $registration->phone }}</p>
                    </div>
                    @endif
                    @if($registration->email)
                    <div>
                        <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Email</label>
                        <p style="font-weight: 500;">{{ $registration->email }}</p>
                    </div>
                    @endif
                </div>
                @endif
                
                <div>
                    <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Tanggal Daftar</label>
                    <p style="font-weight: 500;">{{ $registration->created_at->format('d F Y, H:i') }}</p>
                </div>
                
                @if($registration->admin_notes)
                <div>
                    <label style="font-size: 0.75rem; color: #737373; text-transform: uppercase;">Catatan Admin</label>
                    <p style="background: #FEE2E2; padding: 1rem; border-radius: 0.375rem;">{{ $registration->admin_notes }}</p>
                </div>
                @endif
            </div>
            
            @if($registration->status === 'pending')
            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #E5E5E5;">
                <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Setujui Pendaftaran</button>
                </form>
                <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST" style="display: flex; gap: 0.5rem; flex: 1;">
                    @csrf
                    <input type="text" name="admin_notes" class="form-input" placeholder="Alasan penolakan (opsional)" style="flex: 1;">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </form>
            </div>
            @endif
            
            <div style="margin-top: 1.5rem;">
                <a href="{{ route('admin.registrations.index') }}" class="btn" style="background: #E5E5E5;">← Kembali</a>
            </div>
        </div>
    </div>
@endsection
