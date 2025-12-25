@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* ===== HERO - WARM GLOWING ATMOSPHERE ===== */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: linear-gradient(135deg, 
            #1a1a2e 0%, 
            #16213e 30%, 
            #0f3460 60%,
            #1a1a2e 100%);
        overflow: hidden;
    }

    /* Warm Animated Gradient Overlay */
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(ellipse 80% 50% at 50% 120%, rgba(251, 146, 60, 0.3) 0%, transparent 50%),
            radial-gradient(ellipse 60% 40% at 70% 10%, rgba(244, 114, 182, 0.2) 0%, transparent 40%),
            radial-gradient(ellipse 50% 50% at 20% 60%, rgba(139, 92, 246, 0.15) 0%, transparent 40%);
        animation: warmGlow 8s ease-in-out infinite alternate;
    }

    @keyframes warmGlow {
        0% { opacity: 0.8; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.05); }
    }

    /* Floating Light Orbs */
    .light-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        animation: floatOrb 20s ease-in-out infinite;
        pointer-events: none;
    }

    .light-orb-1 {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.4) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        animation-delay: 0s;
    }

    .light-orb-2 {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(244, 114, 182, 0.3) 0%, transparent 70%);
        bottom: -50px;
        left: -50px;
        animation-delay: -7s;
    }

    .light-orb-3 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.25) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        animation-delay: -14s;
    }

    .light-orb-4 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(251, 146, 60, 0.35) 0%, transparent 70%);
        bottom: 20%;
        right: 20%;
        animation-delay: -3s;
    }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(30px, -30px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(0.9); }
        75% { transform: translate(20px, 30px) scale(1.05); }
    }

    /* Sparkle Stars */
    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: white;
        border-radius: 50%;
        animation: sparkle 3s ease-in-out infinite;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    @keyframes sparkle {
        0%, 100% { opacity: 0; transform: scale(0); }
        50% { opacity: 1; transform: scale(1); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 900px;
    }

    /* Kanji with Warm Glow */
    .hero-kanji {
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: clamp(3rem, 8vw, 6rem);
        background: linear-gradient(135deg, #fcd34d 0%, #fb923c 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 0.5em;
        margin-bottom: 1rem;
        opacity: 0;
        animation: kanjiWarmReveal 2s ease-out 0.3s forwards;
        filter: drop-shadow(0 0 30px rgba(251, 191, 36, 0.5));
    }

    @keyframes kanjiWarmReveal {
        0% { 
            opacity: 0; 
            transform: scale(0.8) translateY(20px);
            filter: blur(10px) drop-shadow(0 0 0 transparent);
        }
        100% { 
            opacity: 1; 
            transform: scale(1) translateY(0);
            filter: blur(0) drop-shadow(0 0 40px rgba(251, 191, 36, 0.6));
        }
    }

    /* Animated Brush Line - Warm Colors */
    .hero-brush {
        width: 0;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent, 
            #fcd34d 20%, 
            #fb923c 50%,
            #f472b6 80%, 
            transparent);
        margin: 0 auto 2rem;
        box-shadow: 0 0 30px rgba(251, 146, 60, 0.6);
        animation: brushDrawWarm 1.5s cubic-bezier(0.4, 0, 0.2, 1) 2.5s forwards;
        border-radius: 2px;
    }

    @keyframes brushDrawWarm {
        0% { width: 0; opacity: 0; }
        20% { opacity: 1; }
        100% { width: min(350px, 70vw); opacity: 1; }
    }

    /* Title with Gradient */
    .hero-title {
        font-family: var(--font-heading);
        font-size: clamp(4rem, 12vw, 8rem);
        font-weight: 700;
        letter-spacing: 0.25em;
        margin-bottom: 1.5rem;
        background: linear-gradient(180deg, #ffffff 0%, #fef3c7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 60px rgba(251, 191, 36, 0.3);
        opacity: 0;
        animation: titleWarmReveal 1.2s ease-out 4s forwards;
    }

    @keyframes titleWarmReveal {
        0% { 
            opacity: 0; 
            transform: translateY(30px);
            letter-spacing: 0.1em;
        }
        100% { 
            opacity: 1; 
            transform: translateY(0);
            letter-spacing: 0.25em;
        }
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        font-weight: 300;
        opacity: 0;
        margin-bottom: 2.5rem;
        letter-spacing: 0.05em;
        color: rgba(255, 255, 255, 0.9);
        animation: subtitleFade 1s ease-out 5s forwards;
    }

    @keyframes subtitleFade {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 0.9; transform: translateY(0); }
    }

    /* CTA Button - Warm Gradient */
    .hero-cta {
        display: inline-block;
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 50%, #ec4899 100%);
        color: white;
        padding: 1.1rem 2.8rem;
        border-radius: 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        opacity: 0;
        animation: ctaReveal 0.8s ease-out 5.5s forwards;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 4px 20px rgba(249, 115, 22, 0.4),
            0 0 40px rgba(249, 115, 22, 0.2);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .hero-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .hero-cta:hover::before {
        opacity: 1;
    }

    @keyframes ctaReveal {
        from { opacity: 0; transform: translateY(15px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .hero-cta:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 
            0 12px 40px rgba(249, 115, 22, 0.5),
            0 0 60px rgba(249, 115, 22, 0.3);
    }

    /* Scroll Indicator */
    .hero-scroll {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(251, 191, 36, 0.7);
        opacity: 0;
        font-size: 1.5rem;
        animation: scrollReveal 1s ease-out 6s forwards, scrollBounce 2s ease-in-out 7s infinite;
    }

    @keyframes scrollReveal {
        to { opacity: 0.7; }
    }

    @keyframes scrollBounce {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(10px); }
    }

    /* ===== PHILOSOPHY BLOCKS - WARM THEME ===== */
    .philosophy-section {
        background: linear-gradient(180deg, #fffbeb 0%, #fef3c7 100%);
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

    /* ===== MOBILE RESPONSIVE ===== */
    @media (max-width: 768px) {
        /* Hero Section */
        .hero {
            min-height: 90vh;
            padding: 1rem;
        }

        .hero-kanji-bg {
            font-size: 8rem !important;
        }

        .hero-kanji {
            font-size: 1.5rem !important;
        }

        .hero-title {
            font-size: 2.5rem !important;
            letter-spacing: 0.1em;
        }

        .hero-subtitle {
            font-size: 0.9rem !important;
            padding: 0 1rem;
        }

        .hero-cta {
            padding: 0.8rem 1.5rem;
            font-size: 0.9rem;
        }

        /* Philosophy Section */
        .philosophy-section {
            padding: 3rem 1rem !important;
        }

        .philosophy-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        .philosophy-card {
            padding: 1.5rem !important;
        }

        .philosophy-kanji {
            font-size: 2rem !important;
        }

        .philosophy-title {
            font-size: 1.1rem !important;
        }

        .philosophy-desc {
            font-size: 0.85rem !important;
        }

        /* Divisions Section */
        .divisions-grid {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
            padding: 0 0.5rem;
        }

        .division-card {
            padding: 1.5rem !important;
        }

        .division-icon {
            width: 120px !important;
            height: 120px !important;
        }

        .division-icon img {
            width: 100px !important;
            height: 100px !important;
        }

        .division-title {
            font-size: 1.2rem !important;
        }

        .division-character {
            font-size: 0.8rem !important;
        }

        .division-description {
            font-size: 0.85rem !important;
        }

        .division-tagline {
            font-size: 0.75rem !important;
        }

        /* CTA Section */
        .cta-section {
            padding: 3rem 1rem !important;
        }

        .cta-title {
            font-size: 1.5rem !important;
        }

        .cta-description {
            font-size: 0.9rem !important;
        }

        .cta-btn {
            padding: 0.8rem 1.5rem;
            font-size: 0.9rem;
        }

        /* Section Headers */
        .section-title {
            font-size: 1.5rem !important;
        }

        .section-subtitle {
            font-size: 0.9rem !important;
        }

        /* Brush Divider */
        .brush-section-divider {
            height: 60px !important;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem !important;
        }

        .division-icon {
            width: 100px !important;
            height: 100px !important;
        }

        .division-icon img {
            width: 80px !important;
            height: 80px !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section - Warm Glowing Atmosphere -->
    <section class="hero">
        <!-- Floating Light Orbs -->
        <div class="light-orb light-orb-1"></div>
        <div class="light-orb light-orb-2"></div>
        <div class="light-orb light-orb-3"></div>
        <div class="light-orb light-orb-4"></div>
        
        <!-- Sparkle Stars -->
        <div class="sparkle" style="top: 20%; left: 15%; animation-delay: 0s;"></div>
        <div class="sparkle" style="top: 30%; right: 20%; animation-delay: 0.5s;"></div>
        <div class="sparkle" style="top: 60%; left: 25%; animation-delay: 1s;"></div>
        <div class="sparkle" style="top: 70%; right: 30%; animation-delay: 1.5s;"></div>
        <div class="sparkle" style="top: 40%; left: 60%; animation-delay: 2s;"></div>
        <div class="sparkle" style="top: 80%; left: 40%; animation-delay: 2.5s;"></div>
        
        <div class="hero-content">
            <div class="hero-kanji">万歳</div>
            <h1 class="hero-title">BANZAI</h1>
            <div class="hero-brush"></div>
            <p class="hero-subtitle">Eskul Bahasa Jepang SMKN 13 Bandung</p>
            <a href="{{ route('register') }}" class="hero-cta">✨ Bergabung Sekarang</a>
        </div>
        
        <div class="hero-scroll">▽</div>
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

    <!-- Japanese Quote Section (Breathing Space with Meaning) -->
    <section class="quote-section" style="padding: 5rem 1.5rem; background: linear-gradient(180deg, var(--neutral-50) 0%, var(--white) 100%); position: relative; overflow: hidden;">
        <!-- Subtle Seigaiha Pattern -->
        <div style="position: absolute; inset: 0; opacity: 0.04; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 40'%3E%3Cpath d='M0 40a40 40 0 0 1 40-40 40 40 0 0 1 40 40' fill='none' stroke='%23064E3B' stroke-width='1'/%3E%3C/svg%3E\"); background-size: 60px 30px;"></div>
        
        <div style="max-width: 800px; margin: 0 auto; text-align: center; position: relative;">
            <!-- Japanese Quote -->
            <p style="font-family: 'Shippori Mincho', serif; font-size: 1.5rem; color: var(--primary-700); opacity: 0.7; letter-spacing: 0.3em; margin-bottom: var(--space-md);">
                「言葉は文化を運ぶ」
            </p>
            <p style="font-size: var(--text-lg); color: var(--neutral-600); font-style: italic; margin-bottom: var(--space-sm);">
                "Bahasa membawa budaya"
            </p>
            <!-- Brush Underline -->
            <div style="width: 60px; height: 3px; background: linear-gradient(90deg, transparent, var(--primary-400), transparent); margin: 0 auto; opacity: 0.6;"></div>
        </div>
    </section>

    <!-- Micro Facts Section (BANZAI Identity) -->
    <section style="padding: 3rem 1.5rem; background: var(--white);">
        <div style="max-width: 900px; margin: 0 auto; display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: var(--space-sm); color: var(--neutral-500); font-size: var(--text-sm);">
                <span style="color: var(--primary-600); opacity: 0.7;">📍</span>
                <span>SMKN 13 Bandung</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-sm); color: var(--neutral-500); font-size: var(--text-sm);">
                <span style="color: var(--primary-600); opacity: 0.7;">📅</span>
                <span>Berdiri sejak 2009</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-sm); color: var(--neutral-500); font-size: var(--text-sm);">
                <span style="color: var(--primary-600); opacity: 0.7;">👥</span>
                <span>3 Divisi Aktif</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-sm); color: var(--neutral-500); font-size: var(--text-sm);">
                <span style="color: var(--primary-600); opacity: 0.7;">🇯🇵</span>
                <span>Bahasa & Budaya Jepang</span>
            </div>
        </div>
    </section>

    <!-- Narrative Divider with Kanji -->
    <div style="padding: 2rem 0; background: var(--white); text-align: center; position: relative;">
        <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-xl);">
            <div style="width: 80px; height: 1px; background: linear-gradient(90deg, transparent, var(--neutral-200));"></div>
            <span style="font-family: 'Shippori Mincho', serif; font-size: 1.2rem; color: var(--primary-600); opacity: 0.4; letter-spacing: 0.2em;">学 · 和 · 心</span>
            <div style="width: 80px; height: 1px; background: linear-gradient(90deg, var(--neutral-200), transparent);"></div>
        </div>
    </div>

    <!-- Divisions Section - Alternating Layout -->
    <section class="divisions-section" style="background: white; padding: 5rem 1.5rem;">
        <div class="section-container">
            <div class="section-header" style="text-align: center; margin-bottom: 4rem;">
                <h2 class="section-title brush-underline" style="display: inline-block;">Tiga Dunia, Satu Keluarga</h2>
                <p class="section-subtitle" style="margin: 1rem auto 0; max-width: 500px;">
                    Setiap divisi memiliki karakter dan jiwa yang berbeda, namun bersatu dalam semangat BANZAI.
                </p>
            </div>

            @php
                $photoMap = [
                    'bahasa' => 'divisions/Bahasa.jpeg',
                    'budaya' => 'divisions/Budaya.jpeg',
                    'medsos' => 'divisions/Medsos.jpeg',
                ];
                $koordinatorMap = [
                    'bahasa' => ['name' => 'Bima Ksatria', 'class' => 'XII RPL 2', 'photo' => 'Kor.Bahasa.jpg'],
                    'budaya' => ['name' => 'Razzan Ilman', 'class' => 'XII RPL 2', 'photo' => 'Kor.Budaya.jpg'],
                    'medsos' => ['name' => 'Raihanisa', 'class' => 'XII KA 1', 'photo' => 'Kor.Medsos.jpg'],
                ];
                $divisionRoutes = [
                    'bahasa' => 'division.bahasa',
                    'budaya' => 'division.budaya',
                    'medsos' => 'division.medsos',
                ];
            @endphp

            @forelse($divisions as $index => $division)
                @php
                    $isEven = $index % 2 == 0;
                    $photoFile = $photoMap[$division->slug] ?? null;
                    $koordinator = $koordinatorMap[$division->slug] ?? null;
                    $routeName = $divisionRoutes[$division->slug] ?? null;
                @endphp

                <!-- Division Row - Alternating -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; margin-bottom: 5rem; max-width: 1100px; margin-left: auto; margin-right: auto;">
                    
                    @if($isEven)
                        <!-- Photo Left -->
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <div style="width: 350px; height: 350px; border-radius: 1.5rem; overflow: hidden; border: 3px solid {{ $division->color }}20; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); position: relative;">
                                @if($photoFile)
                                    <img src="{{ asset('images/' . $photoFile) }}" alt="{{ $division->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <!-- Color Overlay -->
                                    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, {{ $division->color }}10, transparent); pointer-events: none;"></div>
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, {{ $division->color }}10, {{ $division->color }}20);">
                                        <span style="font-size: 6rem;">{{ $division->icon }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content Right -->
                        <div>
                            <h3 style="font-size: 2rem; color: var(--ink-900); font-weight: 700; margin-bottom: 0.5rem;">{{ $division->name }}</h3>
                            <p style="font-size: 1.1rem; color: {{ $division->color }}; font-weight: 600; margin-bottom: 1rem;">{{ $division->character }}</p>
                            <p style="color: var(--ink-700); line-height: 1.8; margin-bottom: 1.5rem;">{{ $division->description }}</p>
                            
                            @if($koordinator)
                                <!-- Coordinator Badge -->
                                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: linear-gradient(135deg, {{ $division->color }}05, {{ $division->color }}10); border-radius: 1rem; border: 1px solid {{ $division->color }}15; margin-bottom: 1.5rem;">
                                    <img src="{{ asset('images/members/' . $koordinator['photo']) }}" alt="{{ $koordinator['name'] }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $division->color }};">
                                    <div>
                                        <p style="font-size: 0.85rem; color: var(--ink-500); margin-bottom: 0.25rem;">Koordinator</p>
                                        <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $koordinator['name'] }}</p>
                                        <p style="font-size: 0.9rem; color: var(--ink-500);">{{ $koordinator['class'] }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($routeName)
                                <a href="{{ route($routeName) }}" class="hover-lift" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, {{ $division->color }}, {{ $division->color }}dd); color: white; padding: 0.75rem 1.5rem; border-radius: 2rem; font-weight: 600; transition: all 0.3s ease; text-decoration: none;">
                                    Selengkapnya
                                    <span style="font-size: 1.2rem;">→</span>
                                </a>
                            @endif
                        </div>
                    @else
                        <!-- Content Left -->
                        <div>
                            <h3 style="font-size: 2rem; color: var(--ink-900); font-weight: 700; margin-bottom: 0.5rem;">{{ $division->name }}</h3>
                            <p style="font-size: 1.1rem; color: {{ $division->color }}; font-weight: 600; margin-bottom: 1rem;">{{ $division->character }}</p>
                            <p style="color: var(--ink-700); line-height: 1.8; margin-bottom: 1.5rem;">{{ $division->description }}</p>
                            
                            @if($koordinator)
                                <!-- Coordinator Badge -->
                                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: linear-gradient(135deg, {{ $division->color }}05, {{ $division->color }}10); border-radius: 1rem; border: 1px solid {{ $division->color }}15; margin-bottom: 1.5rem;">
                                    <img src="{{ asset('images/members/' . $koordinator['photo']) }}" alt="{{ $koordinator['name'] }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $division->color }};">
                                    <div>
                                        <p style="font-size: 0.85rem; color: var(--ink-500); margin-bottom: 0.25rem;">Koordinator</p>
                                        <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">{{ $koordinator['name'] }}</p>
                                        <p style="font-size: 0.9rem; color: var(--ink-500);">{{ $koordinator['class'] }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($routeName)
                                <a href="{{ route($routeName) }}" class="hover-lift" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, {{ $division->color }}, {{ $division->color }}dd); color: white; padding: 0.75rem 1.5rem; border-radius: 2rem; font-weight: 600; transition: all 0.3s ease; text-decoration: none;">
                                    Selengkapnya
                                    <span style="font-size: 1.2rem;">→</span>
                                </a>
                            @endif
                        </div>

                        <!-- Photo Right -->
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <div style="width: 350px; height: 350px; border-radius: 1.5rem; overflow: hidden; border: 3px solid {{ $division->color }}20; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); position: relative;">
                                @if($photoFile)
                                    <img src="{{ asset('images/' . $photoFile) }}" alt="{{ $division->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <!-- Color Overlay -->
                                    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, {{ $division->color }}10, transparent); pointer-events: none;"></div>
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, {{ $division->color }}10, {{ $division->color }}20);">
                                        <span style="font-size: 6rem;">{{ $division->icon }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            @empty
                <div class="empty-state" style="text-align: center; padding: 3rem;">
                    <p class="empty-state-text">Divisi sedang dipersiapkan...</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Achievement Highlights Section -->
    <section style="background: linear-gradient(180deg, var(--ivory-100) 0%, var(--ivory-200) 100%); padding: 5rem 1.5rem; position: relative; overflow: hidden;">
        <!-- Subtle Pattern -->
        <div style="position: absolute; inset: 0; opacity: 0.03; background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0L45 15L30 30L15 15Z' fill='none' stroke='%231E293B' stroke-width='0.5'/%3E%3C/svg%3E\"); background-size: 60px 60px;"></div>
        
        <div class="section-container" style="position: relative;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <p style="font-family: 'Shippori Mincho', serif; font-size: 1rem; color: var(--gold-600); letter-spacing: 0.3em; margin-bottom: 0.5rem; opacity: 0.8;">実績</p>
                <h2 style="font-size: clamp(2rem, 5vw, 2.5rem); color: var(--ink-900); font-weight: 700; margin-bottom: 1rem;">Prestasi & Pencapaian</h2>
                <p style="color: var(--ink-500); max-width: 600px; margin: 0 auto;">Dedikasi kami dalam mempelajari bahasa dan budaya Jepang telah menghasilkan berbagai pencapaian membanggakan.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 1000px; margin: 0 auto;">
                <!-- Achievement Card 1 -->
                <div class="hover-lift" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; border: 1px solid rgba(30, 41, 59, 0.08); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: radial-gradient(circle, var(--gold-300), transparent); opacity: 0.2;"></div>
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
                    <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--gold-600); margin-bottom: 0.5rem;">15+</h3>
                    <p style="color: var(--ink-700); font-weight: 600; margin-bottom: 0.5rem;">Tahun Berdiri</p>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Sejak 2009, konsisten membina generasi pencinta Jepang</p>
                </div>

                <!-- Achievement Card 2 -->
                <div class="hover-lift" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; border: 1px solid rgba(30, 41, 59, 0.08); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: radial-gradient(circle, var(--plum-300), transparent); opacity: 0.2;"></div>
                    <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                    <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--plum-700); margin-bottom: 0.5rem;">100+</h3>
                    <p style="color: var(--ink-700); font-weight: 600; margin-bottom: 0.5rem;">Anggota Aktif</p>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Komunitas solid yang terus berkembang</p>
                </div>

                <!-- Achievement Card 3 -->
                <div class="hover-lift" style="background: white; padding: 2rem; border-radius: 1rem; text-align: center; border: 1px solid rgba(30, 41, 59, 0.08); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: radial-gradient(circle, var(--bahasa-accent), transparent); opacity: 0.15;"></div>
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                    <h3 style="font-size: 2.5rem; font-weight: 700; color: var(--bahasa-accent); margin-bottom: 0.5rem;">50+</h3>
                    <p style="color: var(--ink-700); font-weight: 600; margin-bottom: 0.5rem;">Kegiatan Tahunan</p>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Workshop, festival, dan pembelajaran berkelanjutan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Elements Showcase -->
    <section style="background: white; padding: 5rem 1.5rem;">
        <div class="section-container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <p style="font-family: 'Shippori Mincho', serif; font-size: 1rem; color: var(--plum-700); letter-spacing: 0.3em; margin-bottom: 0.5rem; opacity: 0.8;">文化</p>
                <h2 style="font-size: clamp(2rem, 5vw, 2.5rem); color: var(--ink-900); font-weight: 700; margin-bottom: 1rem;">Yang Kami Pelajari</h2>
                <p style="color: var(--ink-500); max-width: 600px; margin: 0 auto;">Lebih dari sekadar bahasa, kami menyelami kedalaman budaya Jepang.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto;">
                <!-- Cultural Element 1 -->
                <div style="text-align: center; padding: 1.5rem; transition: transform 0.3s ease;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; filter: grayscale(0.2);">🗾</div>
                    <h4 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Bahasa</h4>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Hiragana, Katakana, Kanji, dan tata bahasa</p>
                </div>

                <!-- Cultural Element 2 -->
                <div style="text-align: center; padding: 1.5rem; transition: transform 0.3s ease;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; filter: grayscale(0.2);">🎎</div>
                    <h4 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Tradisi</h4>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Festival, upacara, dan adat istiadat</p>
                </div>

                <!-- Cultural Element 3 -->
                <div style="text-align: center; padding: 1.5rem; transition: transform 0.3s ease;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; filter: grayscale(0.2);">🎨</div>
                    <h4 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Seni</h4>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Kaligrafi, origami, dan kerajinan</p>
                </div>

                <!-- Cultural Element 4 -->
                <div style="text-align: center; padding: 1.5rem; transition: transform 0.3s ease;">
                    <div style="font-size: 3rem; margin-bottom: 1rem; filter: grayscale(0.2);">🍱</div>
                    <h4 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Kuliner</h4>
                    <p style="color: var(--ink-500); font-size: 0.9rem;">Makanan dan etika makan Jepang</p>
                </div>
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

    <!-- Narrative Divider Before CTA -->
    <div style="padding: 3rem 0; background: var(--white); text-align: center;">
        <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-lg);">
            <div style="width: 100px; height: 1px; background: linear-gradient(90deg, transparent, var(--neutral-300));"></div>
            <span style="font-family: 'Shippori Mincho', serif; font-size: 1rem; color: var(--primary-600); opacity: 0.5;">仲間になろう</span>
            <div style="width: 100px; height: 1px; background: linear-gradient(90deg, var(--neutral-300), transparent);"></div>
        </div>
    </div>

    <!-- CTA Section (Enhanced with Japanese Pattern) -->
    <section class="cta-section" style="position: relative; overflow: hidden;">
        <!-- Subtle Asanoha Pattern -->
        <div style="position: absolute; inset: 0; opacity: 0.05; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 0L24 12L12 24L0 12Z' fill='none' stroke='%23FFFFFF' stroke-width='0.5'/%3E%3C/svg%3E\"); background-size: 30px 30px;"></div>
        
        <div class="cta-content" style="position: relative;">
            <p style="font-family: 'Shippori Mincho', serif; font-size: 1.2rem; opacity: 0.6; letter-spacing: 0.2em; margin-bottom: var(--space-sm);">一緒に学ぼう</p>
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
