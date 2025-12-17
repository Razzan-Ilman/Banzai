@extends('layouts.app')

@section('title', 'Divisi')

@push('styles')
<style>
@keyframes divisionRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
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
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: var(--space-3xl); align-items: center;">
                    
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
                            <div style="position: relative; width: 240px; height: 240px; margin: 0 auto;">
                                <!-- Rotating dashed border -->
                                <div style="position: absolute; inset: 0; border: 2px dashed {{ $division->color }}40; border-radius: 50%; animation: divisionRotate 30s linear infinite;"></div>
                                <!-- Inner frame -->
                                <div style="position: absolute; inset: 15px; border: 3px solid {{ $division->color }}; border-radius: 50%; box-shadow: 0 0 30px {{ $division->color }}30, inset 0 0 20px {{ $division->color }}10;"></div>
                                <!-- Logo container -->
                                <div style="position: absolute; inset: 20px; border-radius: 50%; background: linear-gradient(135deg, {{ $division->color }}15, {{ $division->color }}30); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($logoFile)
                                        <img src="{{ asset('images/logo/' . $logoFile) }}" alt="{{ $division->name }} Logo" style="width: 140px; height: 140px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 80px;">{{ $division->icon }}</span>
                                    @endif
                                </div>
                                <!-- Corner accent -->
                                <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); width: 30px; height: 6px; background: {{ $division->color }}; border-radius: 3px;"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div>
                        <div style="border-left: 4px solid {{ $division->color }}; padding-left: var(--space-xl);">
                            <span style="color: {{ $division->color }}; font-size: var(--text-sm); font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">{{ $division->character }}</span>
                            <h2 style="font-size: var(--text-3xl); color: var(--neutral-900); margin: var(--space-sm) 0 var(--space-lg);">{{ $division->name }}</h2>
                        </div>
                        
                        <p style="font-size: var(--text-lg); line-height: 1.9; color: var(--neutral-700); margin-bottom: var(--space-xl);">
                            {{ $division->description }}
                        </p>

                        <blockquote style="font-style: italic; color: var(--neutral-600); border-left: 2px solid {{ $division->color }}; padding-left: var(--space-lg); margin-bottom: var(--space-xl);">
                            "{{ $division->tagline }}"
                        </blockquote>

                        @php
                            $koordinatorMap = [
                                'Divisi Bahasa' => ['name' => 'Kenji Watanabe', 'photo' => 'Kor.Bahasa.jpg', 'class' => 'XI – Multimedia'],
                                'Divisi Budaya' => ['name' => 'Mei Kobayashi', 'photo' => 'Kor.Budaya.jpg', 'class' => 'XI – Tata Busana'],
                                'Divisi Media Sosial' => ['name' => 'Ren Takahashi', 'photo' => 'Kor.Medsos.jpg', 'class' => 'XI – DKV'],
                            ];
                            $koordinator = $koordinatorMap[$division->name] ?? null;
                        @endphp
                        @if($koordinator)
                            <div>
                                <h4 style="font-size: var(--text-sm); color: var(--neutral-500); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: var(--space-md);">Koordinator Divisi</h4>
                                <div style="display: flex; gap: var(--space-md); flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: var(--space-sm); background: var(--white); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-full); box-shadow: var(--shadow-sm);">
                                        <img src="{{ asset('images/members/' . $koordinator['photo']) }}" alt="{{ $koordinator['name'] }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $division->color }};">
                                        <div>
                                            <span style="font-size: var(--text-sm); font-weight: 600; display: block;">{{ $koordinator['name'] }}</span>
                                            <span style="font-size: var(--text-xs); color: var(--neutral-500);">{{ $koordinator['class'] }}</span>
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
                            <div style="position: relative; width: 240px; height: 240px; margin: 0 auto;">
                                <!-- Rotating dashed border -->
                                <div style="position: absolute; inset: 0; border: 2px dashed {{ $division->color }}40; border-radius: 50%; animation: divisionRotate 30s linear infinite;"></div>
                                <!-- Inner frame -->
                                <div style="position: absolute; inset: 15px; border: 3px solid {{ $division->color }}; border-radius: 50%; box-shadow: 0 0 30px {{ $division->color }}30, inset 0 0 20px {{ $division->color }}10;"></div>
                                <!-- Logo container -->
                                <div style="position: absolute; inset: 20px; border-radius: 50%; background: linear-gradient(135deg, {{ $division->color }}15, {{ $division->color }}30); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($logoFile)
                                        <img src="{{ asset('images/logo/' . $logoFile) }}" alt="{{ $division->name }} Logo" style="width: 140px; height: 140px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 80px;">{{ $division->icon }}</span>
                                    @endif
                                </div>
                                <!-- Corner accent -->
                                <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); width: 30px; height: 6px; background: {{ $division->color }}; border-radius: 3px;"></div>
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
