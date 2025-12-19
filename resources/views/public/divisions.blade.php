@extends('layouts.app')

@section('title', 'Divisi')

@push('styles')
<style>
@keyframes divisionRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Mobile Responsive for Divisions */
@media (max-width: 1024px) {
    /* Grid becomes single column on tablets */
    div[style*="grid-template-columns: 1fr 1.2fr"] {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 5rem 1rem 2rem !important;
    }

    .page-title {
        font-size: 1.8rem !important;
    }

    .page-subtitle {
        font-size: 0.9rem !important;
    }

    .section-container {
        padding: 0 1rem !important;
    }

    /* Division logo circle - updated for 300px */
    div[style*="width: 300px"] {
        width: 220px !important;
        height: 220px !important;
    }

    div[style*="width: 300px"] img {
        width: 140px !important;
        height: 140px !important;
    }

    /* Section titles */
    h2[style*="2.5rem"] {
        font-size: 1.6rem !important;
    }

    /* Koordinator badge */
    div[style*="width: 70px"] {
        width: 50px !important;
        height: 50px !important;
    }

    /* Text sizes */
    p[style*="text-lg"] {
        font-size: 0.95rem !important;
    }

    blockquote {
        padding-left: 1rem !important;
        font-size: 0.9rem !important;
    }
}

@media (max-width: 480px) {
    div[style*="width: 300px"] {
        width: 180px !important;
        height: 180px !important;
    }

    div[style*="width: 300px"] img {
        width: 120px !important;
        height: 120px !important;
    }
}
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-title brush-underline">Divisi BANZAI</h1>
            <p class="page-subtitle">Tiga karakter, tiga dunia, satu keluarga</p>
        </div>
    </header>

    <!-- Divisions -->
    @foreach($divisions as $index => $division)
        <section class="section" style="{{ $index % 2 == 1 ? 'background: var(--neutral-100);' : '' }}">
            <div class="section-container">
                <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: var(--space-4xl); align-items: center;">
                    
                    @if($index % 2 == 0)
                        <!-- Logo/Visual -->
                        <div style="text-align: center;">
                            @php
                                $logoMap = [
                                    'Divisi Bahasa' => 'Bahasa-logo.png',
                                    'Divisi Budaya' => 'Budaya-Logo.png',
                                    'Divisi Media Sosial' => 'Medsos-Logo.png',
                                    'Divisi Medsos' => 'Medsos-Logo.png'
                                ];
                                $logoFile = $logoMap[$division->name] ?? null;
                            @endphp
                            <!-- Outer decorative frame -->
                            <div style="position: relative; width: 300px; height: 300px; margin: 0 auto;">
                                <!-- Rotating dashed border -->
                                <div style="position: absolute; inset: 0; border: 2px dashed {{ $division->color }}40; border-radius: 50%; animation: divisionRotate 30s linear infinite;"></div>
                                <!-- Inner frame -->
                                <div style="position: absolute; inset: 15px; border: 3px solid {{ $division->color }}; border-radius: 50%; box-shadow: 0 0 30px {{ $division->color }}30, inset 0 0 20px {{ $division->color }}10;"></div>
                                <!-- Logo container -->
                                <div style="position: absolute; inset: 20px; border-radius: 50%; background: linear-gradient(135deg, {{ $division->color }}15, {{ $division->color }}30); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($logoFile)
                                        <img src="{{ asset('images/logo/' . $logoFile) }}" alt="{{ $division->name }} Logo" style="width: 180px; height: 180px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 100px;">{{ $division->icon }}</span>
                                    @endif
                                </div>
                                <!-- Corner accent -->
                                <!-- <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); width: 40px; height: 8px; background: {{ $division->color }}; border-radius: 4px;"></div> -->
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div>
                        <div style="border-left: 4px solid {{ $division->color }}; padding-left: var(--space-xl);">
                            <span style="color: {{ $division->color }}; font-size: var(--text-xs); font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em;">{{ $division->character }}</span>
                            <h2 style="font-size: 2.5rem; color: var(--neutral-900); margin: var(--space-sm) 0 var(--space-lg); font-weight: 700; line-height: 1.2;">{{ $division->name }}</h2>
                        </div>
                        
                        <p style="font-size: var(--text-lg); line-height: 1.9; color: var(--neutral-600); margin-bottom: var(--space-xl);">
                            {{ $division->description }}
                        </p>

                        <blockquote style="font-style: italic; color: var(--neutral-500); border-left: 3px solid {{ $division->color }}60; padding-left: var(--space-lg); margin-bottom: var(--space-xl); font-size: var(--text-base);">
                            "{{ $division->tagline }}"
                        </blockquote>

                        @php
                            $koordinatorMap = [
                                'Divisi Bahasa' => ['name' => 'Bima Ksatria', 'photo' => 'Kor.Bahasa.jpg', 'class' => 'XII TKJ 1'],
                                'Divisi Budaya' => ['name' => 'Razzan Ilman', 'photo' => 'Kor.Budaya.jpg', 'class' => 'XII RPL 1'],
                                'Divisi Media Sosial' => ['name' => 'Raihanisa', 'photo' => 'Kor.Medsos.jpg', 'class' => 'XII KA 6'],
                            ];
                            $koordinator = $koordinatorMap[$division->name] ?? null;
                        @endphp
                        @if($koordinator)
                            <div>
                                <h4 style="font-size: var(--text-xs); color: var(--neutral-400); text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: var(--space-md); font-weight: 600;">Koordinator Divisi</h4>
                                <div style="display: flex; gap: var(--space-md); flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: var(--space-lg); background: var(--white); padding: var(--space-md) var(--space-xl); border-radius: var(--radius-full); box-shadow: var(--shadow-md); border: 1px solid var(--neutral-100);">
                                        <img src="{{ asset('images/members/' . $koordinator['photo']) }}" alt="{{ $koordinator['name'] }}" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid {{ $division->color }};">
                                        <div>
                                            <span style="font-size: var(--text-lg); font-weight: 600; display: block; color: var(--neutral-800);">{{ $koordinator['name'] }}</span>
                                            <span style="font-size: var(--text-sm); color: var(--neutral-500);">{{ $koordinator['class'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($index % 2 == 1)
                        <!-- Logo/Visual -->
                        <div style="text-align: center;">
                            @php
                                $logoMap = [
                                    'Divisi Bahasa' => 'Bahasa-logo.png',
                                    'Divisi Budaya' => 'Budaya-Logo.png',
                                    'Divisi Media Sosial' => 'Medsos-Logo.png',
                                    'Divisi Medsos' => 'Medsos-Logo.png'
                                ];
                                $logoFile = $logoMap[$division->name] ?? null;
                            @endphp
                            <!-- Outer decorative frame -->
                            <div style="position: relative; width: 300px; height: 300px; margin: 0 auto;">
                                <!-- Rotating dashed border -->
                                <div style="position: absolute; inset: 0; border: 2px dashed {{ $division->color }}40; border-radius: 50%; animation: divisionRotate 30s linear infinite;"></div>
                                <!-- Inner frame -->
                                <div style="position: absolute; inset: 15px; border: 3px solid {{ $division->color }}; border-radius: 50%; box-shadow: 0 0 30px {{ $division->color }}30, inset 0 0 20px {{ $division->color }}10;"></div>
                                <!-- Logo container -->
                                <div style="position: absolute; inset: 20px; border-radius: 50%; background: linear-gradient(135deg, {{ $division->color }}15, {{ $division->color }}30); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($logoFile)
                                        <img src="{{ asset('images/logo/' . $logoFile) }}" alt="{{ $division->name }} Logo" style="width: 180px; height: 180px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 100px;">{{ $division->icon }}</span>
                                    @endif
                                </div>
                                <!-- Corner accent -->
                                <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); width: 40px; height: 8px; background: {{ $division->color }}; border-radius: 4px;"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endforeach

    <!-- CTA -->
    <section class="section" style="text-align: center; background: linear-gradient(135deg, var(--primary-800), var(--primary-900)); color: white;">
        <div class="section-container">
            <h2 style="font-size: var(--text-3xl); margin-bottom: var(--space-md);">Temukan Divisi Anda</h2>
            <p style="opacity: 0.9; margin-bottom: var(--space-xl); max-width: 500px; margin-left: auto; margin-right: auto;">
                Tidak yakin divisi mana yang cocok? Bergabunglah dulu, dan temukan passion Anda bersama kami!
            </p>
            <a href="{{ route('register') }}" class="hero-cta">Daftar Sekarang</a>
        </div>
    </section>
@endsection
