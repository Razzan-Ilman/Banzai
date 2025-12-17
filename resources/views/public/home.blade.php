@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* ===== HERO - Full Identity ===== */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: linear-gradient(160deg, var(--primary-900) 0%, var(--primary-800) 40%, var(--primary-700) 100%);
        overflow: hidden;
    }

    /* Japanese Pattern Overlay - Seigaiha waves */
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='50' viewBox='0 0 100 50'%3E%3Ccircle cx='0' cy='50' r='40' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.05'/%3E%3Ccircle cx='0' cy='50' r='30' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.04'/%3E%3Ccircle cx='0' cy='50' r='20' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.03'/%3E%3Ccircle cx='50' cy='50' r='40' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.05'/%3E%3Ccircle cx='50' cy='50' r='30' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.04'/%3E%3Ccircle cx='50' cy='50' r='20' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.03'/%3E%3Ccircle cx='100' cy='50' r='40' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.05'/%3E%3Ccircle cx='100' cy='50' r='30' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.04'/%3E%3Ccircle cx='100' cy='50' r='20' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.03'/%3E%3C/svg%3E");
        animation: patternDrift 60s linear infinite;
        opacity: 0.6;
    }

    @keyframes patternDrift {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100px); }
    }

    /* Radial breathing light */
    .hero::after {
        content: '';
        position: absolute;
        width: 120%;
        height: 120%;
        top: -10%;
        left: -10%;
        background: radial-gradient(ellipse at 30% 40%, rgba(255, 183, 197, 0.15), transparent 50%),
                    radial-gradient(ellipse at 70% 60%, rgba(16, 185, 129, 0.1), transparent 40%);
        animation: breathingLight 8s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes breathingLight {
        0%, 100% { opacity: 0.7; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.05); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 900px;
    }

    /* Kanji as background layer */
    .hero-kanji-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: clamp(15rem, 30vw, 25rem);
        color: rgba(255, 255, 255, 0.03);
        pointer-events: none;
        z-index: 1;
        user-select: none;
    }

    .hero-kanji {
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: clamp(2rem, 5vw, 3rem);
        color: var(--sakura, #FFB7C5);
        opacity: 0.9;
        margin-bottom: 0.5rem;
        animation: kanjiReveal 1s ease-out 0.5s both;
    }

    @keyframes kanjiReveal {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 0.9; transform: translateY(0); }
    }

    .hero-title {
        font-family: var(--font-heading);
        font-size: clamp(3.5rem, 10vw, 6rem);
        font-weight: 700;
        letter-spacing: 0.2em;
        margin-bottom: 1rem;
        animation: titleReveal 1s ease-out 0.8s both;
        text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    }

    @keyframes titleReveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-brush {
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--sakura, #FFB7C5), transparent);
        margin: 0 auto 1.5rem;
        animation: brushDraw 1s ease-out 1.2s forwards;
    }

    @keyframes brushDraw {
        to { width: min(200px, 50vw); }
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        font-weight: 300;
        opacity: 0;
        margin-bottom: 2rem;
        animation: subtitleReveal 0.8s ease-out 1.5s forwards;
    }

    @keyframes subtitleReveal {
        to { opacity: 0.9; }
    }

    .hero-cta {
        display: inline-block;
        background: var(--sakura, #FFB7C5);
        color: var(--primary-900);
        padding: 1rem 2.5rem;
        border-radius: 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        opacity: 0;
        animation: ctaReveal 0.8s ease-out 1.8s forwards;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 183, 197, 0.3);
    }

    @keyframes ctaReveal {
        to { opacity: 1; }
    }

    .hero-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(255, 183, 197, 0.5);
    }

    .hero-scroll {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        opacity: 0;
        animation: scrollReveal 1s ease-out 2.2s forwards, scrollBounce 2s ease-in-out 3s infinite;
    }

    @keyframes scrollReveal {
        to { opacity: 0.5; }
    }

    @keyframes scrollBounce {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(8px); }
    }

    /* ===== PHILOSOPHY BLOCKS ===== */
    .philosophy-section {
        background: var(--neutral-50);
        padding: 5rem 1.5rem;
        position: relative;
    }

    .philosophy-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .philosophy-card {
        text-align: center;
        padding: 2.5rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.4s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .philosophy-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .philosophy-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .philosophy-kanji {
        font-family: 'Shippori Mincho', serif;
        font-size: 3rem;
        color: var(--primary-700);
        margin-bottom: 0.5rem;
    }

    .philosophy-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--neutral-800);
        margin-bottom: 0.5rem;
    }

    .philosophy-desc {
        font-size: 0.9rem;
        color: var(--neutral-600);
        line-height: 1.7;
    }

    /* ===== BRUSH SECTION DIVIDER ===== */
    .brush-section-divider {
        height: 60px;
        background: linear-gradient(180deg, var(--neutral-50), white);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .brush-stroke-divider {
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--primary-600), transparent);
        position: relative;
    }

    .brush-stroke-divider.animate {
        animation: brushExpand 1s ease-out forwards;
    }

    @keyframes brushExpand {
        to { width: min(300px, 60vw); }
    }

    .brush-stroke-divider::before {
        content: '◇';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: var(--primary-500);
        font-size: 0.75rem;
        background: white;
        padding: 0 1rem;
    }

    /* ===== MA SPACE (Enhanced) ===== */
    .ma-space {
        min-height: 35vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1.5rem;
        background: linear-gradient(180deg, white, var(--neutral-50));
        position: relative;
    }

    .ma-space::before {
        content: '和';
        position: absolute;
        font-family: 'Shippori Mincho', serif;
        font-size: 15rem;
        color: rgba(16, 185, 129, 0.02);
        pointer-events: none;
    }

    .ma-content {
        text-align: center;
        max-width: 700px;
        position: relative;
        z-index: 1;
    }

    .ma-quote {
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: clamp(1.25rem, 3vw, 1.75rem);
        font-weight: 400;
        font-style: italic;
        color: var(--neutral-700);
        line-height: 1.8;
    }

    .ma-attribution {
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: var(--neutral-500);
    }

    /* ===== DIVISIONS (Visual-Driven) ===== */
    .divisions-section {
        padding: 5rem 1.5rem;
        background: var(--neutral-100);
    }

    .divisions-section .section-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .divisions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
    }

    .division-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.4s ease;
        border-left: 4px solid var(--card-color, var(--primary-600));
    }

    .division-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle at center, var(--card-color, var(--primary-600)), transparent 70%);
        opacity: 0.05;
        transform: translate(30%, -30%);
    }

    .division-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    .division-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .division-title {
        font-family: var(--font-heading);
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--neutral-900);
        margin-bottom: 0.25rem;
    }

    .division-character {
        font-size: 0.9rem;
        color: var(--card-color, var(--primary-600));
        font-style: italic;
        margin-bottom: 1rem;
    }

    .division-description {
        color: var(--neutral-600);
        line-height: 1.7;
        font-size: 0.95rem;
    }

    .division-tagline {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--neutral-200);
        font-size: 0.85rem;
        color: var(--neutral-500);
        font-style: italic;
    }

    /* ===== CTA SECTION (Enhanced) ===== */
    .cta-section {
        padding: 5rem 1.5rem;
        background: linear-gradient(135deg, var(--accent-600), var(--accent-700));
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Ccircle cx='40' cy='40' r='30' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.1'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .cta-content {
        position: relative;
        z-index: 1;
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: clamp(1.75rem, 4vw, 2.25rem);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .cta-desc {
        opacity: 0.9;
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .cta-btn {
        display: inline-block;
        background: white;
        color: var(--accent-700);
        padding: 1rem 2.5rem;
        border-radius: 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section - Full Identity -->
    <section class="hero">
        <!-- Background Kanji -->
        <div class="hero-kanji-bg">万歳</div>
        
        <div class="hero-content">
            <div class="hero-kanji ritual-text">万歳</div>
            <h1 class="hero-title ritual-text">BANZAI</h1>
            <div class="hero-brush ritual-light"></div>
            <p class="hero-subtitle ritual-text">Eskul Bahasa Jepang SMKN 13 Bandung</p>
            <a href="{{ route('register') }}" class="hero-cta ritual-text">Bergabung Sekarang</a>
        </div>
        
        <div class="hero-scroll ritual-light">▽</div>
    </section>

    <!-- Philosophy Blocks -->
    <section class="philosophy-section">
        <div class="philosophy-grid">
            <div class="philosophy-card" data-delay="0">
                <div class="philosophy-kanji">言語</div>
                <h3 class="philosophy-title">Bahasa</h3>
                <p class="philosophy-desc">Mempelajari bahasa Jepang dengan metode yang menyenangkan dan sistematis.</p>
            </div>
            <div class="philosophy-card" data-delay="150">
                <div class="philosophy-kanji">文化</div>
                <h3 class="philosophy-title">Budaya</h3>
                <p class="philosophy-desc">Mengenal tradisi, seni, dan cara hidup masyarakat Jepang.</p>
            </div>
            <div class="philosophy-card" data-delay="300">
                <div class="philosophy-kanji">表現</div>
                <h3 class="philosophy-title">Ekspresi</h3>
                <p class="philosophy-desc">Mengekspresikan kreativitas melalui media dan karya digital.</p>
            </div>
        </div>
    </section>

    <!-- Brush Divider -->
    <div class="brush-section-divider">
        <div class="brush-stroke-divider"></div>
    </div>

    <!-- MA Space - Breathing Section -->
    <section class="ma-space">
        <div class="ma-content">
            <p class="ma-quote">"Belajar bahasa adalah belajar cara berpikir."</p>
            <p class="ma-attribution">— 言葉の力</p>
        </div>
    </section>

    <!-- Brush Divider -->
    <div class="brush-section-divider">
        <div class="brush-stroke-divider"></div>
    </div>

    <!-- Divisions Section -->
    <section class="divisions-section">
        <div class="section-container">
            <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                <h2 class="section-title brush-underline" style="display: inline-block;">Tiga Dunia, Satu Keluarga</h2>
                <p class="section-subtitle" style="margin: 1rem auto 0; max-width: 500px;">
                    Setiap divisi memiliki karakter dan jiwa yang berbeda, namun bersatu dalam semangat BANZAI.
                </p>
            </div>

            <div class="divisions-grid">
                @forelse($divisions as $division)
                    @php
                        $logoMap = [
                            'bahasa' => 'Bahasa-logo.png',
                            'budaya' => 'Budaya-Logo.png',
                            'medsos' => 'Medsos-Logo.png',
                        ];
                        $logoFile = $logoMap[$division->slug] ?? null;
                    @endphp
                    <div class="division-card" style="--card-color: {{ $division->color }}">
                        <div class="division-icon" style="width: 180px; height: 180px; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-lg); background: linear-gradient(135deg, {{ $division->color }}10, {{ $division->color }}25); border-radius: var(--radius-full); border: 3px solid {{ $division->color }}30;">
                            @if($logoFile)
                                <img src="{{ asset('images/logo/' . $logoFile) }}" alt="{{ $division->name }}" style="width: 150px; height: 150px; object-fit: contain;">
                            @else
                                <span style="font-size: 4rem;">{{ $division->icon }}</span>
                            @endif
                        </div>
                        <h3 class="division-title">{{ $division->name }}</h3>
                        <p class="division-character">{{ $division->character }}</p>
                        <p class="division-description">{{ $division->description }}</p>
                        <p class="division-tagline">"{{ $division->tagline }}"</p>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <p class="empty-state-text">Divisi sedang dipersiapkan...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Activities (if any) -->
    @if($featuredActivities->count() > 0)
    <section class="section" style="background: white; padding: 5rem 1.5rem;">
        <div class="section-container">
            <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                <h2 class="section-title brush-underline" style="display: inline-block;">Kegiatan Terbaru</h2>
                <p class="section-subtitle" style="margin: 1rem auto 0;">Aktivitas dan pembelajaran terkini.</p>
            </div>

            <div class="activities-grid">
                @foreach($featuredActivities as $activity)
                    <article class="activity-card">
                        <div class="activity-image">🌸</div>
                        <div class="activity-content">
                            <p class="activity-date">{{ $activity->formatted_date }}</p>
                            <h3 class="activity-title">{{ $activity->title }}</h3>
                            <p class="activity-description">{{ Str::limit($activity->description, 120) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="{{ route('activities') }}" class="hero-cta" style="background: var(--primary-700); color: white;">Lihat Semua</a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Tertarik Bergabung?</h2>
            <p class="cta-desc">
                Jadilah bagian dari keluarga BANZAI dan jelajahi keindahan bahasa serta budaya Jepang bersama kami.
            </p>
            <a href="{{ route('register') }}" class="cta-btn">Daftar Sekarang</a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Philosophy cards animation on scroll
    const philosophyCards = document.querySelectorAll('.philosophy-card');
    const brushDividers = document.querySelectorAll('.brush-stroke-divider');

    const observerOptions = { threshold: 0.3 };

    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, delay);
            }
        });
    }, observerOptions);

    philosophyCards.forEach(card => cardObserver.observe(card));

    const brushObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, { threshold: 0.5 });

    brushDividers.forEach(divider => brushObserver.observe(divider));
</script>
@endpush
