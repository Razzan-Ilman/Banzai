@extends('layouts.app')

@section('title', 'Divisi Media Sosial')

@push('styles')
<style>
    /* ===== DIVISI MEDSOS - 動 (GERAK) ===== */
    /* Character: Dynamic, Quick, Controlled */
    
    /* Hero Section - Muted Gold/Amber */
    .medsos-hero {
        min-height: 70vh;
        background: linear-gradient(160deg, #B45309 0%, #D97706 100%);
        background-size: 200% 200%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Quick, Controlled Animation (3s) */
    .medsos-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, #B45309 0%, #F59E0B 50%, #D97706 100%);
        background-size: 200% 200%;
        animation: medsosQuick 3s ease-in-out infinite;
        opacity: 0.9;
    }

    @keyframes medsosQuick {
        0%, 100% { 
            background-position: 0% 50%;
            transform: scale(1);
        }
        50% { 
            background-position: 100% 50%;
            transform: scale(1.02);
        }
    }

    /* Brush Specks */
    .medsos-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(circle, rgba(255, 255, 255, 0.15) 1px, transparent 1px);
        background-size: 30px 30px;
        animation: brushSpecks 5s ease-in-out infinite;
        opacity: 0.4;
    }

    @keyframes brushSpecks {
        0%, 100% { 
            transform: translateX(0) rotate(0deg);
            opacity: 0.4;
        }
        50% { 
            transform: translateX(5px) rotate(2deg);
            opacity: 0.6;
        }
    }

    .medsos-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
        max-width: 800px;
    }

    .medsos-kanji {
        font-family: 'Shippori Mincho', serif;
        font-size: clamp(4rem, 10vw, 8rem);
        letter-spacing: 0.3em;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .medsos-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .medsos-subtitle {
        font-size: 1.2rem;
        opacity: 0.85;
        margin-bottom: 2rem;
    }

    /* Content Section */
    .medsos-section {
        background: var(--ivory-100);
        padding: 5rem 1.5rem;
    }

    .medsos-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 1px solid rgba(217, 119, 6, 0.1);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .medsos-card:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 8px 24px rgba(217, 119, 6, 0.15);
        border-color: rgba(217, 119, 6, 0.3);
    }

    .coordinator-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(217, 119, 6, 0.05));
        padding: 1rem 1.5rem;
        border-radius: 3rem;
        border: 1px solid rgba(217, 119, 6, 0.2);
        margin-top: 2rem;
    }

    .coordinator-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(217, 119, 6, 0.3);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="medsos-hero">
        <div class="medsos-content">
            <div class="medsos-kanji">動</div>
            <h1 class="medsos-title">Divisi Media Sosial</h1>
            <p class="medsos-subtitle">Menyebarkan semangat BANZAI ke dunia digital</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="medsos-section">
        <div class="section-container" style="max-width: 900px; margin: 0 auto;">
            
            <!-- About -->
            <div class="medsos-card">
                <h2 style="color: #D97706; font-size: 1.8rem; margin-bottom: 1rem;">Tentang Divisi Media Sosial</h2>
                <p style="color: var(--ink-700); line-height: 1.8; margin-bottom: 1rem;">
                    Divisi Media Sosial adalah jembatan antara BANZAI dan dunia luar. Kami bertanggung jawab atas dokumentasi, publikasi, dan branding organisasi di platform digital.
                </p>
                <p style="color: var(--ink-700); line-height: 1.8;">
                    Dengan kreativitas dan kecepatan yang terkendali, kami memastikan setiap momen berharga BANZAI terabadikan dan tersebar dengan cara yang menarik namun tetap elegan.
                </p>
            </div>

            <!-- What We Do -->
            <div class="medsos-card">
                <h2 style="color: #D97706; font-size: 1.8rem; margin-bottom: 1.5rem;">Yang Kami Kerjakan</h2>
                <div style="display: grid; gap: 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(217, 119, 6, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📸</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Dokumentasi</h3>
                            <p style="color: var(--ink-500);">Foto dan video kegiatan, event, dan momen penting BANZAI</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(217, 119, 6, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🎨</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Desain Grafis</h3>
                            <p style="color: var(--ink-500);">Poster, banner, dan konten visual untuk media sosial</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(217, 119, 6, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📱</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Social Media Management</h3>
                            <p style="color: var(--ink-500);">Mengelola Instagram, TikTok, dan platform media sosial lainnya</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background: rgba(217, 119, 6, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">✍️</div>
                        <div>
                            <h3 style="color: var(--ink-800); font-weight: 600; margin-bottom: 0.5rem;">Content Creation</h3>
                            <p style="color: var(--ink-500);">Membuat konten menarik dan edukatif tentang Jepang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coordinators -->
            <div style="text-align: center;">
                <h3 style="color: var(--ink-800); font-size: 1.5rem; margin-bottom: 1.5rem;">Koordinator Divisi</h3>
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                    <div class="coordinator-badge">
                        <img src="{{ asset('images/members/Kor.Medsos.jpg') }}" alt="Koordinator Medsos 1" class="coordinator-photo">
                        <div style="text-align: left;">
                            <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">Raihanisa</p>
                            <p style="font-size: 0.9rem; color: var(--ink-500);">XII KA 1</p>
                        </div>
                    </div>
                    <div class="coordinator-badge">
                        <img src="{{ asset('images/members/Kor.Medsos-2.jpg') }}" alt="Koordinator Medsos 2" class="coordinator-photo">
                        <div style="text-align: left;">
                            <p style="font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">Micky Yuhana</p>
                            <p style="font-size: 0.9rem; color: var(--ink-500);">XII KA 6</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
