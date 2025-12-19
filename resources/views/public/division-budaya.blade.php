@extends('layouts.app')

@section('title', 'Divisi Budaya')

@push('styles')
<style>
    /* ===== DIVISI BUDAYA - 華 (EKSPRESI) ===== */
    /* Character: Expressive, Organic, Flowing */
    
    /* Hero Section - Soft Plum/Violet */
    .budaya-hero {
        min-height: 70vh;
        background: linear-gradient(160deg, #5B21B6 0%, #6D28D9 100%);
        background-size: 200% 200%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Organic, Flowing Animation (6s) */
    .budaya-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, #5B21B6 0%, #7C3AED 50%, #6D28D9 100%);
        background-size: 200% 200%;
        animation: budayaOrganic 6s ease-in-out infinite;
        opacity: 0.9;
    }

    @keyframes budayaOrganic {
        0%, 100% { 
            background-position: 0% 50%;
            transform: scale(1);
        }
        33% { 
            background-position: 50% 30%;
            transform: scale(1.02) rotate(0.5deg);
        }
        66% { 
            background-position: 100% 70%;
            transform: scale(0.98) rotate(-0.5deg);
        }
    }

    /* Sakura Particles (Outline only) */
    .budaya-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(circle, var(--sakura-particle) 2px, transparent 2px),
            radial-gradient(circle, var(--sakura-particle) 1px, transparent 1px);
        background-size: 80px 80px, 120px 120px;
        background-position: 0 0, 40px 40px;
        animation: sakuraFloat 20s linear infinite;
        opacity: 0.4;
    }

    @keyframes sakuraFloat {
        0% { transform: translateY(0) translateX(0); }
        100% { transform: translateY(100px) translateX(20px); }
    }

    .budaya-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 800px;
    }

    .budaya-kanji {
        font-family: 'Shippori Mincho', serif;
        font-size: clamp(4rem, 10vw, 8rem);
        letter-spacing: 0.3em;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .budaya-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .budaya-subtitle {
        font-size: 1.2rem;
        opacity: 0.85;
        margin-bottom: 2rem;
    }

    /* Content Section */
    .budaya-section {
        background: var(--ivory-100);
        padding: 5rem 1.5rem;
    }

    .budaya-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 1px solid rgba(109, 40, 217, 0.1);
        margin-bottom: 2rem;
        transition: all 0.4s ease;
    }

    .budaya-card:hover {
        transform: translateY(-3px) rotate(0.5deg);
        box-shadow: 0 8px 24px rgba(109, 40, 217, 0.15);
        border-color: rgba(109, 40, 217, 0.3);
    }

    .coordinator-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, rgba(109, 40, 217, 0.1), rgba(109, 40, 217, 0.05));
        padding: 1rem 1.5rem;
        border-radius: 3rem;
        border: 1px solid rgba(109, 40, 217, 0.2);
        margin-top: 2rem;
    }

    .coordinator-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(109, 40, 217, 0.3);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="budaya-hero">
        <div class="budaya-content">
            <div class="budaya-kanji">華</div>
            <h1 class="budaya-title">Divisi Budaya</h1>
            <p class="budaya-subtitle">Mengekspresikan keindahan tradisi Jepang</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="budaya-section">
        <div class="section-container" style="max-width: 900px; margin: 0 auto;">
            
            <!-- About -->
            <div class="budaya-card">
                <h2 style="color: #6D28D9; font-size: 1.8rem; margin-bottom: 1rem;">Tentang Divisi Budaya</h2>
                <p style="color: var(--ink-700); line-height: 1.8; margin-bottom: 1rem;">
                    Divisi Budaya adalah jendela menuju keindahan tradisi Jepang. Kami mengeksplorasi seni, festival, dan adat istiadat yang membentuk identitas budaya Jepang.
                </p>
                <p style="color: var(--ink-700); line-height: 1.8;">
                    Melalui praktik langsung dan apresiasi mendalam, kami tidak hanya belajar tentang budaya, tetapi merasakannya dengan seluruh jiwa.
                </p>
            </div>

            <!-- What We Learn -->
            <div class="budaya-card">
                <h2 style="color: #6D28D9; font-size: 1.8rem; margin-bottom: 1.5rem;">Yang Kami Pelajari</h2>
                <div style="display: grid; gap: 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(109, 40, 217, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🎎</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Festival & Tradisi</h3>
                            <p style="color: var(--ink-500);">Matsuri, Hanami, Tanabata, dan perayaan tradisional lainnya</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(109, 40, 217, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🎨</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Seni Tradisional</h3>
                            <p style="color: var(--ink-500);">Kaligrafi (Shodo), Origami, Ikebana, dan kerajinan tangan</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(109, 40, 217, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👘</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Pakaian & Etika</h3>
                            <p style="color: var(--ink-500);">Kimono, Yukata, dan tata krama dalam budaya Jepang</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(109, 40, 217, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🏯</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Sejarah & Arsitektur</h3>
                            <p style="color: var(--ink-500);">Kuil, kastil, dan bangunan bersejarah Jepang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coordinator -->
            <div style="text-align: center;">
                <h3 style="color: var(--ink-800); font-size: 1.5rem; margin-bottom: 1.5rem;">Koordinator Divisi</h3>
                <div class="coordinator-badge">
                    <img src="{{ asset('images/members/Kor.Budaya.jpg') }}" alt="Koordinator Budaya" class="coordinator-photo">
                    <div style="text-align: left;">
                        <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">Razzan Ilman</p>
                        <p style="font-size: 0.9rem; color: var(--ink-500);">XII RPL 2</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
