@extends('layouts.member')

@section('title', 'Profil Saya')

@section('content')
<!-- Profile Header -->
<div class="card" style="background: linear-gradient(135deg, var(--group-primary, #0EA5E9), var(--group-secondary, #0284C7)); color: white; border: none;">
    <div class="card-body" style="padding: 2rem;">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <!-- Avatar -->
            <div style="width: 120px; height: 120px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 700; color: var(--group-primary, #0EA5E9); box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                @if($profile->photo)
                    <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            
            <!-- Info -->
            <div style="flex: 1;">
                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $user->name }}</h2>
                <div style="font-size: 1.125rem; opacity: 0.95; margin-bottom: 1rem;">
                    <span style="background: rgba(255,255,255,0.2); padding: 0.375rem 1rem; border-radius: 9999px;">
                        {{ $profile->member_number }}
                    </span>
                </div>
                <div style="display: flex; gap: 2rem; font-size: 0.9375rem;">
                    <div>
                        <div style="opacity: 0.8;">Level</div>
                        <div style="font-weight: 700; font-size: 1.25rem;">{{ $profile->level }} - {{ $profile->getLevelName() }}</div>
                    </div>
                    <div>
                        <div style="opacity: 0.8;">Poin</div>
                        <div style="font-weight: 700; font-size: 1.25rem;">{{ $profile->points }}</div>
                    </div>
                    <div>
                        <div style="opacity: 0.8;">XP</div>
                        <div style="font-weight: 700; font-size: 1.25rem;">{{ $profile->xp }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Button -->
            <div>
                <a href="{{ route('member.profile.edit') }}" class="btn" style="background: white; color: var(--group-primary, #0EA5E9);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
    <!-- Left Column -->
    <div>
        <!-- Bio -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Tentang Saya</h2>
            </div>
            <div class="card-body">
                @if($profile->bio)
                    <p style="color: var(--neutral-700); line-height: 1.6;">{{ $profile->bio }}</p>
                @else
                    <p style="color: var(--neutral-500); font-style: italic;">Belum ada bio. Klik "Edit Profil" untuk menambahkan.</p>
                @endif
            </div>
        </div>

        <!-- Current Group -->
        @if($currentGroup)
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Kelompok Aktif</h2>
                <span class="badge badge-primary">{{ $currentGroup->month_start->format('M Y') }}</span>
            </div>
            <div class="card-body">
                <div style="padding: 1.5rem; background: var(--neutral-50); border-radius: 8px; border-left: 4px solid var(--group-primary, #0EA5E9);">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">
                        {{ $currentGroup->group->name }}
                    </h3>
                    <p style="color: var(--neutral-600);">{{ $currentGroup->group->description }}</p>
                    <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--neutral-500);">
                        Periode: {{ $currentGroup->month_start->format('d M') }} - {{ $currentGroup->month_end->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column -->
    <div>
        <!-- Medals -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Medal & Pencapaian</h2>
            </div>
            <div class="card-body">
                @if($medals->count() > 0)
                    @foreach($medals as $medal)
                        <div style="padding: 1rem; background: var(--neutral-50); border-radius: 8px; margin-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="font-size: 2rem;">{{ $medal->icon ?? '🏅' }}</div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: var(--ink-900);">{{ $medal->title }}</div>
                                    @if($medal->title_jp)
                                        <div style="font-size: 0.875rem; color: var(--neutral-600);">{{ $medal->title_jp }}</div>
                                    @endif
                                    <div style="font-size: 0.75rem; color: var(--neutral-500); margin-top: 0.25rem;">
                                        {{ $medal->earned_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <p>Belum ada medal</p>
                        <p style="font-size: 0.75rem; margin-top: 0.5rem;">Ikuti kegiatan untuk mendapatkan medal!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Statistik</h2>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--neutral-600);">Divisi</span>
                        <span style="font-weight: 600;">{{ $profile->division->name ?? '-' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--neutral-600);">Status</span>
                        <span class="badge badge-success">{{ $profile->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--neutral-600);">Bergabung</span>
                        <span style="font-weight: 600;">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
