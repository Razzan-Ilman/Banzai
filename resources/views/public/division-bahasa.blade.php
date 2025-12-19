@extends('layouts.app')

@section('title', 'Divisi Bahasa')

@push('styles')
<style>
    /* ===== DIVISI BAHASA - 静 (TENANG) ===== */
    /* Character: Calm, Steady, Intellectual */
    
    /* Hero Section - Cyan Cool Tones */
    .bahasa-hero {
        min-height: 70vh;
        background: linear-gradient(160deg, #0E7490 0%, #0891B2 100%);
        background-size: 200% 200%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Slow, Steady Animation (8s) */
    .bahasa-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, #0E7490 0%, #155E75 50%, #0891B2 100%);
        background-size: 200% 200%;
        animation: bahasaFlow 8s ease-in-out infinite;
        opacity: 0.9;
    }

    @keyframes bahasaFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Light Dust Particles */
    .bahasa-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: lightDust 12s linear infinite;
        opacity: 0.3;
    }

    @keyframes lightDust {
        0% { transform: translateY(0); }
        100% { transform: translateY(-50px); }
    }

    .bahasa-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 800px;
    }

    .bahasa-kanji {
        font-family: 'Shippori Mincho', serif;
        font-size: clamp(4rem, 10vw, 8rem);
        letter-spacing: 0.3em;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .bahasa-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .bahasa-subtitle {
        font-size: 1.2rem;
        opacity: 0.85;
        margin-bottom: 2rem;
    }

    /* Content Section */
    .bahasa-section {
        background: var(--ivory-100);
        padding: 5rem 1.5rem;
    }

    .bahasa-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 1px solid rgba(8, 145, 178, 0.1);
        margin-bottom: 2rem;
        transition: all 0.4s ease;
    }

    .bahasa-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(8, 145, 178, 0.15);
        border-color: rgba(8, 145, 178, 0.3);
    }

    .coordinator-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, rgba(8, 145, 178, 0.1), rgba(8, 145, 178, 0.05));
        padding: 1rem 1.5rem;
        border-radius: 3rem;
        border: 1px solid rgba(8, 145, 178, 0.2);
        margin-top: 2rem;
    }

    .coordinator-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(8, 145, 178, 0.3);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="bahasa-hero">
        <div class="bahasa-content">
            <div class="bahasa-kanji">静</div>
            <h1 class="bahasa-title">Divisi Bahasa</h1>
            <p class="bahasa-subtitle">Menguasai bahasa dengan tenang dan disiplin</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="bahasa-section">
        <div class="section-container" style="max-width: 900px; margin: 0 auto;">
            
            <!-- About -->
            <div class="bahasa-card">
                <h2 style="color: #0891B2; font-size: 1.8rem; margin-bottom: 1rem;">Tentang Divisi Bahasa</h2>
                <p style="color: var(--ink-700); line-height: 1.8; margin-bottom: 1rem;">
                    Divisi Bahasa adalah jantung pembelajaran di BANZAI. Kami fokus pada penguasaan bahasa Jepang secara sistematis dan mendalam, mulai dari Hiragana, Katakana, hingga Kanji.
                </p>
                <p style="color: var(--ink-700); line-height: 1.8;">
                    Dengan pendekatan yang tenang namun konsisten, kami membimbing anggota untuk tidak hanya menghafal, tetapi memahami struktur dan filosofi di balik bahasa Jepang.
                </p>
            </div>

            <!-- What We Learn -->
            <div class="bahasa-card">
                <h2 style="color: #0891B2; font-size: 1.8rem; margin-bottom: 1.5rem;">Yang Kami Pelajari</h2>
                <div style="display: grid; gap: 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(8, 145, 178, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0891B2; font-weight: 700;">あ</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Hiragana & Katakana</h3>
                            <p style="color: var(--ink-500);">Fondasi dasar sistem penulisan Jepang yang wajib dikuasai</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(8, 145, 178, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0891B2; font-weight: 700;">漢</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Kanji</h3>
                            <p style="color: var(--ink-500);">Karakter Cina yang digunakan dalam bahasa Jepang</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(8, 145, 178, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0891B2; font-weight: 700;">文</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Tata Bahasa</h3>
                            <p style="color: var(--ink-500);">Struktur kalimat, partikel, dan pola bahasa Jepang</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(8, 145, 178, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0891B2; font-weight: 700;">話</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Percakapan</h3>
                            <p style="color: var(--ink-500);">Praktik berbicara dalam situasi sehari-hari</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coordinator -->
            <div style="text-align: center;">
                <h3 style="color: var(--ink-800); font-size: 1.5rem; margin-bottom: 1.5rem;">Koordinator Divisi</h3>
                <div class="coordinator-badge">
                    <img src="{{ asset('images/members/Kor.Bahasa.jpg') }}" alt="Koordinator Bahasa" class="coordinator-photo">
                    <div style="text-align: left;">
                        <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">Bima Ksatria</p>
                        <p style="font-size: 0.9rem; color: var(--ink-500);">XII RPL 2</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
