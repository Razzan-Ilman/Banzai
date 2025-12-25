@extends('layouts.member')

@section('title', 'Hasil Quiz')

@section('content')
@php
    // Theme configuration per group
    $groupThemes = [
        'MUSASHI' => [
            'primary' => '#4F46E5',      // Indigo
            'secondary' => '#6366F1',
            'accent' => '#A5B4FC',
            'bg_gradient' => 'linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #312E81 100%)',
            'pattern' => 'katana',        // Pattern style
            'icon' => '⚔️',
            'quote' => '"剣を極める者、心も極める"',
            'quote_en' => 'Master the sword, master the mind',
        ],
        'AME-NO-UZUME' => [
            'primary' => '#EC4899',      // Pink
            'secondary' => '#F472B6',
            'accent' => '#FBCFE8',
            'bg_gradient' => 'linear-gradient(135deg, #EC4899 0%, #A855F7 50%, #7C3AED 100%)',
            'pattern' => 'sakura',
            'icon' => '🌸',
            'quote' => '"踊りは魂の言葉"',
            'quote_en' => 'Dance is the language of the soul',
        ],
        'FUJIN' => [
            'primary' => '#10B981',      // Emerald
            'secondary' => '#34D399',
            'accent' => '#A7F3D0',
            'bg_gradient' => 'linear-gradient(135deg, #10B981 0%, #06B6D4 50%, #0EA5E9 100%)',
            'pattern' => 'wind',
            'icon' => '🌀',
            'quote' => '"風のように自由に"',
            'quote_en' => 'Free as the wind',
        ],
        'YAMATO' => [
            'primary' => '#F59E0B',      // Amber
            'secondary' => '#FBBF24',
            'accent' => '#FDE68A',
            'bg_gradient' => 'linear-gradient(135deg, #F59E0B 0%, #EF4444 50%, #DC2626 100%)',
            'pattern' => 'sun',
            'icon' => '☀️',
            'quote' => '"和を以て貴しとなす"',
            'quote_en' => 'Harmony is the greatest virtue',
        ],
    ];

    $groupDescriptions = [
        'MUSASHI' => [
            'title' => 'The Strategist',
            'traits' => ['Analitis', 'Terstruktur', 'Perfeksionis', 'Fokus'],
            'description' => 'Seperti Musashi sang pendekar legendaris, kamu memiliki kecerdasan strategis dan dedikasi untuk menguasai setiap skill hingga sempurna.',
        ],
        'AME-NO-UZUME' => [
            'title' => 'The Creator',
            'traits' => ['Kreatif', 'Ekspresif', 'Artistik', 'Inspiratif'],
            'description' => 'Seperti Dewi Tari yang membawa kegembiraan, kamu memiliki jiwa seni yang dapat menginspirasi dan mencerahkan orang di sekitarmu.',
        ],
        'FUJIN' => [
            'title' => 'The Adventurer',
            'traits' => ['Dinamis', 'Adaptif', 'Energetik', 'Cepat'],
            'description' => 'Seperti Dewa Angin yang tak terbatas, kamu memiliki semangat petualangan dan kemampuan beradaptasi yang luar biasa.',
        ],
        'YAMATO' => [
            'title' => 'The Harmonizer',
            'traits' => ['Harmonis', 'Kolaboratif', 'Supportif', 'Bijaksana'],
            'description' => 'Seperti Semangat Yamato yang menyatukan, kamu adalah kekuatan pemersatu yang menjaga kebersamaan dan harmoni.',
        ],
    ];

    $groupName = $quizResult->group->name;
    $theme = $groupThemes[$groupName] ?? $groupThemes['YAMATO'];
    $info = $groupDescriptions[$groupName] ?? $groupDescriptions['YAMATO'];
@endphp

<style>
    .result-wrapper {
        min-height: 100vh;
        padding: 2rem;
        background: {{ $theme['bg_gradient'] }};
        position: relative;
        overflow: hidden;
    }

    /* MUSASHI Pattern - Katana Lines */
    @if($theme['pattern'] === 'katana')
    .result-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            repeating-linear-gradient(45deg, transparent, transparent 50px, rgba(255,255,255,0.03) 50px, rgba(255,255,255,0.03) 51px),
            repeating-linear-gradient(-45deg, transparent, transparent 50px, rgba(255,255,255,0.03) 50px, rgba(255,255,255,0.03) 51px);
        pointer-events: none;
    }
    @endif

    /* AME-NO-UZUME Pattern - Sakura Petals */
    @if($theme['pattern'] === 'sakura')
    .result-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 30%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1) 0%, transparent 25%),
            radial-gradient(circle at 50% 10%, rgba(255,255,255,0.08) 0%, transparent 20%),
            radial-gradient(circle at 10% 80%, rgba(255,255,255,0.08) 0%, transparent 25%);
        pointer-events: none;
    }
    @endif

    /* FUJIN Pattern - Wind Swirls */
    @if($theme['pattern'] === 'wind')
    .result-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            repeating-linear-gradient(90deg, transparent, transparent 100px, rgba(255,255,255,0.05) 100px, rgba(255,255,255,0.05) 102px),
            repeating-linear-gradient(45deg, transparent, transparent 80px, rgba(255,255,255,0.03) 80px, rgba(255,255,255,0.03) 82px);
        animation: windMove 20s linear infinite;
        pointer-events: none;
    }
    @keyframes windMove {
        0% { transform: translateX(0); }
        100% { transform: translateX(100px); }
    }
    @endif

    /* YAMATO Pattern - Sun Rays */
    @if($theme['pattern'] === 'sun')
    .result-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: 50%;
        transform: translateX(-50%);
        width: 200%;
        height: 200%;
        background: 
            conic-gradient(from 0deg, transparent 0deg, rgba(255,255,255,0.05) 10deg, transparent 20deg);
        animation: sunRotate 60s linear infinite;
        pointer-events: none;
    }
    @keyframes sunRotate {
        0% { transform: translateX(-50%) rotate(0deg); }
        100% { transform: translateX(-50%) rotate(360deg); }
    }
    @endif

    .result-container {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .result-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 32px;
        padding: 3rem;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: cardAppear 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes cardAppear {
        0% { opacity: 0; transform: scale(0.8) translateY(50px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    .group-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        animation: iconPulse 2s ease infinite;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .group-kanji {
        font-family: 'Noto Sans JP', serif;
        font-size: 4rem;
        font-weight: 900;
        color: {{ $theme['primary'] }};
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 0 {{ $theme['accent'] }};
    }

    .group-name {
        font-size: 2rem;
        font-weight: 800;
        color: {{ $theme['primary'] }};
        letter-spacing: 0.1em;
        margin-bottom: 0.25rem;
    }

    .group-title {
        font-size: 1.25rem;
        color: {{ $theme['secondary'] }};
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .quote-box {
        background: linear-gradient(135deg, {{ $theme['primary'] }}15, {{ $theme['secondary'] }}15);
        border-left: 4px solid {{ $theme['primary'] }};
        padding: 1.25rem;
        border-radius: 12px;
        margin: 1.5rem 0;
        text-align: left;
    }

    .quote-jp {
        font-family: 'Noto Sans JP', serif;
        font-size: 1.25rem;
        color: {{ $theme['primary'] }};
        margin-bottom: 0.5rem;
    }

    .quote-en {
        font-size: 0.875rem;
        color: #6B7280;
        font-style: italic;
    }

    .traits-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        margin: 1.5rem 0;
    }

    .trait-badge {
        background: {{ $theme['primary'] }}15;
        color: {{ $theme['primary'] }};
        padding: 0.5rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid {{ $theme['primary'] }}30;
    }

    .description-text {
        color: #4B5563;
        line-height: 1.8;
        font-size: 1rem;
        margin: 1.5rem 0;
    }

    .score-section {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin: 2rem 0;
        padding: 1.5rem;
        background: #F9FAFB;
        border-radius: 16px;
    }

    .score-item {
        text-align: center;
    }

    .score-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: {{ $theme['primary'] }};
    }

    .score-label {
        font-size: 0.75rem;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .borderline-alert {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
        padding: 1rem;
        border-radius: 12px;
        margin: 1rem 0;
        font-weight: 500;
    }

    .title-celebration {
        background: linear-gradient(135deg, {{ $theme['primary'] }}, {{ $theme['secondary'] }});
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin: 2rem 0;
        animation: titleGlow 2s ease infinite;
    }

    @keyframes titleGlow {
        0%, 100% { box-shadow: 0 0 30px {{ $theme['primary'] }}50; }
        50% { box-shadow: 0 0 50px {{ $theme['primary'] }}80; }
    }

    .title-kanji {
        font-family: 'Noto Sans JP', serif;
        font-size: 3.5rem;
        margin-bottom: 0.5rem;
    }

    .consistency-bar {
        background: #E5E7EB;
        border-radius: 50px;
        height: 12px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .consistency-fill {
        background: linear-gradient(90deg, {{ $theme['primary'] }}, {{ $theme['secondary'] }});
        height: 100%;
        border-radius: 50px;
        transition: width 1s ease;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        background: {{ $theme['primary'] }};
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 2rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px {{ $theme['primary'] }}40;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px {{ $theme['primary'] }}60;
    }

    @media (max-width: 640px) {
        .result-wrapper { padding: 1rem; }
        .result-card { padding: 2rem 1.5rem; }
        .group-kanji { font-size: 3rem; }
        .traits-grid { grid-template-columns: repeat(2, 1fr); }
        .score-section { flex-direction: column; gap: 1rem; }
    }
</style>

<div class="result-wrapper">
    <div class="result-container">
        <div class="result-card">
            <div class="group-icon">{{ $theme['icon'] }}</div>
            <div class="group-kanji">{{ $quizResult->group->kanji ?? '?' }}</div>
            <div class="group-name">{{ $groupName }}</div>
            <div class="group-title">{{ $info['title'] }}</div>

            <div class="quote-box">
                <div class="quote-jp">{{ $theme['quote'] }}</div>
                <div class="quote-en">{{ $theme['quote_en'] }}</div>
            </div>

            <div class="traits-grid">
                @foreach($info['traits'] as $trait)
                    <span class="trait-badge">{{ $trait }}</span>
                @endforeach
            </div>

            <p class="description-text">{{ $info['description'] }}</p>

            <div class="score-section">
                <div class="score-item">
                    <div class="score-value">{{ $quizResult->total_score }}</div>
                    <div class="score-label">Skor Total</div>
                </div>
                <div class="score-item">
                    <div class="score-value">{{ $scoreStats['percentage'] }}%</div>
                    <div class="score-label">Persentase</div>
                </div>
            </div>

            @if($quizResult->is_borderline)
                <div class="borderline-alert">
                    ⚠️ Hasil Borderline - Kamu berada di perbatasan dua kelompok!
                </div>
            @endif

            @if($titleResult['awarded'] ?? false)
                <div class="title-celebration">
                    <h3 style="margin: 0 0 0.5rem; font-size: 1.25rem;">🎊 Selamat! Kamu Mendapat Title!</h3>
                    <div class="title-kanji">{{ $titleResult['title']->name_kanji }}</div>
                    <p style="margin: 0; font-weight: 600;">{{ $titleResult['title']->name }}</p>
                </div>
            @elseif(auth()->user()->hasTitle())
                <div style="background: {{ $theme['primary'] }}15; padding: 1rem; border-radius: 12px; margin: 1rem 0;">
                    <p style="margin: 0;">🏆 Title Aktif: <strong>{{ auth()->user()->title->display_name }}</strong></p>
                </div>
            @endif

            <div style="margin-top: 2rem;">
                <div style="font-weight: 600; color: {{ $theme['primary'] }}; margin-bottom: 0.5rem;">
                    Progress Title ({{ $consistency['progress'] }})
                </div>
                @php
                    $progressParts = explode('/', $consistency['progress']);
                    $progressPercent = (intval($progressParts[0]) / intval($progressParts[1])) * 100;
                @endphp
                <div class="consistency-bar">
                    <div class="consistency-fill" style="width: {{ $progressPercent }}%;"></div>
                </div>
                <p style="font-size: 0.875rem; color: #6B7280; margin: 0.5rem 0 0;">
                    Dapatkan kelompok sama 3 dari 4 bulan untuk title!
                </p>
            </div>

            <a href="{{ route('member.dashboard') }}" class="btn-back">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
