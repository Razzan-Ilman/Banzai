@extends('layouts.app')

@section('title', 'Pengurus BANZAI')

@push('styles')
<style>
    /* ===== PAGE HEADER - LIVING COMMUNITY SPACE ===== */
    .members-header {
        padding-top: calc(80px + 4rem);
        padding-bottom: 3rem;
        background: linear-gradient(160deg, var(--indigo-900), var(--indigo-800));
        background-size: 200% 200%;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* Living Background - Warm Glow Shift (45s loop) */
    .members-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(251, 191, 36, 0.12), transparent 60%),
                    radial-gradient(ellipse at 70% 50%, rgba(16, 185, 129, 0.08), transparent 50%);
        animation: warmGlow 45s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes warmGlow {
        0%, 100% { 
            opacity: 0.6;
            transform: scale(1) translateX(0);
        }
        50% { 
            opacity: 1;
            transform: scale(1.1) translateX(20px);
        }
    }

    /* Asanoha Pattern - Community Structure */
    .members-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0L45 15L30 30L15 15Z M30 30L45 45L30 60L15 45Z M0 30L15 15L30 30L15 45Z M30 30L45 15L60 30L45 45Z' fill='none' stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.04'/%3E%3C/svg%3E");
        background-size: 60px 60px;
        opacity: 0.5;
        animation: patternStable 90s linear infinite;
    }

    @keyframes patternStable {
        0% { transform: translateX(0) translateY(0); }
        100% { transform: translateX(60px) translateY(60px); }
    }

    .members-header-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .members-title {
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: clamp(2rem, 5vw, 3rem);
        color: white;
        margin-bottom: 0.5rem;
    }

    .members-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    /* ===== MAIN SECTION ===== */
    .members-section {
        padding: 4rem 1.5rem;
        background: linear-gradient(180deg, var(--neutral-50), white);
        position: relative;
    }

    /* Matcha texture */
    .members-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        opacity: 0.015;
        pointer-events: none;
    }

    .members-container {
        max-width: 1100px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ===== KETUA CARD (LARGEST) ===== */
    .leader-spotlight {
        display: flex;
        justify-content: center;
        margin-bottom: 4rem;
    }

    .member-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.4s ease;
    }

    .member-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
    }

    /* Ketua - Largest & Sun Symbol */
    .member-card--ketua {
        max-width: 320px;
    }

    .member-card--ketua .member-symbol {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 183, 197, 0.12), rgba(255, 183, 197, 0.03) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: sunGlow 4s ease-in-out infinite;
    }

    @keyframes sunGlow {
        0%, 100% { opacity: 0.8; transform: translateX(-50%) scale(1); }
        50% { opacity: 1; transform: translateX(-50%) scale(1.05); }
    }

    /* Wakil - Moon Symbol */
    .member-card--wakil .member-symbol {
        position: absolute;
        top: 0;
        right: -10px;
        width: 80px;
        height: 80px;
        border: 2px solid rgba(16, 185, 129, 0.1);
        border-radius: 50%;
        border-left-color: transparent;
        border-bottom-color: transparent;
        transform: rotate(-45deg);
        pointer-events: none;
    }

    /* Sekretaris - Grid Lines */
    .member-card--sekretaris .member-symbol {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        background: 
            linear-gradient(90deg, rgba(16, 185, 129, 0.08) 1px, transparent 1px),
            linear-gradient(rgba(16, 185, 129, 0.08) 1px, transparent 1px);
        background-size: 10px 10px;
        pointer-events: none;
    }

    /* Bendahara - Ensō */
    .member-card--bendahara .member-symbol {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 50px;
        height: 50px;
        border: 2px solid rgba(16, 185, 129, 0.1);
        border-radius: 50%;
        border-top-color: transparent;
        pointer-events: none;
    }

    /* Koordinator - Division accent */
    .member-card--koordinator .member-symbol {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, var(--accent-color, var(--primary-500)), transparent);
        opacity: 0.5;
    }

    /* ===== PHOTO FRAME ===== */
    .member-photo-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 1.5rem;
    }

    .member-card--ketua .member-photo-wrapper {
        width: 180px;
        height: 180px;
    }

    /* ===== UNIQUE FRAME DESIGNS PER POSITION ===== */
    
    .member-photo-frame {
        position: absolute;
        inset: -8px;
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 50%;
        transition: all 0.4s ease;
    }

    /* KETUA - Golden Sun Frame */
    .member-card--ketua .member-photo-frame {
        border: 3px solid rgba(255, 183, 197, 0.4);
        box-shadow: 
            0 0 0 4px rgba(255, 215, 0, 0.1),
            0 0 30px rgba(255, 183, 197, 0.2);
    }

    .member-card--ketua .member-photo-frame::before {
        content: '';
        position: absolute;
        inset: -12px;
        border: 1px dashed rgba(255, 183, 197, 0.3);
        border-radius: 50%;
        animation: sunRotate 20s linear infinite;
    }

    .member-card--ketua .member-photo-frame::after {
        content: '☀';
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.25rem;
        opacity: 0.6;
    }

    @keyframes sunRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* WAKIL - Crescent Moon Frame */
    .member-card--wakil .member-photo-frame {
        border: 2px solid rgba(16, 185, 129, 0.3);
        border-right-width: 4px;
        border-right-color: rgba(16, 185, 129, 0.5);
    }

    .member-card--wakil .member-photo-frame::before {
        content: '';
        position: absolute;
        top: -5px;
        right: -5px;
        width: 30px;
        height: 30px;
        background: radial-gradient(circle at 30% 30%, rgba(16, 185, 129, 0.15), transparent 70%);
        border-radius: 50%;
    }

    .member-card--wakil .member-photo-frame::after {
        content: '🌙';
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 1rem;
        opacity: 0.7;
    }

    /* BENDAHARA - Ensō Circle Frame */
    .member-card--bendahara .member-photo-frame {
        border: 3px solid rgba(16, 185, 129, 0.4);
        border-top-color: transparent;
        border-right-color: rgba(16, 185, 129, 0.2);
    }

    .member-card--bendahara .member-photo-frame::before {
        content: '';
        position: absolute;
        inset: -15px;
        border: 2px solid rgba(16, 185, 129, 0.15);
        border-radius: 50%;
        border-top-color: transparent;
        border-right-color: transparent;
    }

    .member-card--bendahara .member-photo-frame::after {
        content: '◯';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1rem;
        color: var(--primary-500);
        opacity: 0.5;
    }

    /* KOORDINATOR BAHASA - Wave Pattern Frame */
    .member-card--koordinator[style*="#0891B2"] .member-photo-frame {
        border: 2px solid rgba(8, 145, 178, 0.3);
        box-shadow: 0 0 15px rgba(8, 145, 178, 0.1);
    }

    .member-card--koordinator[style*="#0891B2"] .member-photo-frame::before {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 10%;
        right: 10%;
        height: 6px;
        background: 
            radial-gradient(circle at 10px 3px, rgba(8, 145, 178, 0.3) 3px, transparent 3px),
            radial-gradient(circle at 20px 3px, rgba(8, 145, 178, 0.2) 3px, transparent 3px),
            radial-gradient(circle at 30px 3px, rgba(8, 145, 178, 0.3) 3px, transparent 3px);
    }

    .member-card--koordinator[style*="#0891B2"] .member-photo-frame::after {
        content: '〜';
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.25rem;
        color: #0891B2;
        opacity: 0.5;
    }

    /* KOORDINATOR BUDAYA - Sakura Petals Frame */
    .member-card--koordinator[style*="#7C3AED"] .member-photo-frame {
        border: 2px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 0 15px rgba(124, 58, 237, 0.1);
    }

    .member-card--koordinator[style*="#7C3AED"] .member-photo-frame::before {
        content: '🌸';
        position: absolute;
        top: -10px;
        left: 10px;
        font-size: 0.875rem;
        opacity: 0.6;
    }

    .member-card--koordinator[style*="#7C3AED"] .member-photo-frame::after {
        content: '✿';
        position: absolute;
        bottom: -8px;
        right: 10px;
        font-size: 0.875rem;
        color: #7C3AED;
        opacity: 0.5;
    }

    /* KOORDINATOR MEDSOS - Digital/Motion Frame */
    .member-card--koordinator[style*="#F59E0B"] .member-photo-frame {
        border: 2px solid rgba(245, 158, 11, 0.3);
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.1);
    }

    .member-card--koordinator[style*="#F59E0B"] .member-photo-frame::before {
        content: '';
        position: absolute;
        top: -6px;
        left: 20%;
        right: 20%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #F59E0B, transparent);
        opacity: 0.5;
        animation: digitalPulse 2s ease-in-out infinite;
    }

    .member-card--koordinator[style*="#F59E0B"] .member-photo-frame::after {
        content: '◈';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1rem;
        color: #F59E0B;
        opacity: 0.6;
    }

    @keyframes digitalPulse {
        0%, 100% { opacity: 0.3; transform: scaleX(0.8); }
        50% { opacity: 0.7; transform: scaleX(1); }
    }

    /* Hover effects per position */
    .member-card--ketua:hover .member-photo-frame {
        border-color: rgba(255, 183, 197, 0.6);
        box-shadow: 0 0 0 6px rgba(255, 215, 0, 0.15), 0 0 40px rgba(255, 183, 197, 0.3);
    }

    .member-card--wakil:hover .member-photo-frame {
        border-color: rgba(16, 185, 129, 0.5);
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);
    }

    .member-card--bendahara:hover .member-photo-frame {
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);
    }

    .member-card--koordinator:hover .member-photo-frame {
        box-shadow: 0 0 25px rgba(var(--accent-color, 16, 185, 129), 0.2);
    }

    .member-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: linear-gradient(135deg, var(--primary-100), var(--neutral-200));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--primary-600);
    }

    .member-card--ketua .member-photo {
        font-size: 4rem;
    }

    /* ===== MEMBER INFO ===== */
    .member-name {
        font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--neutral-900);
        margin-bottom: 0.25rem;
    }

    .member-card--ketua .member-name {
        font-size: 1.5rem;
    }

    .member-class {
        font-size: 0.85rem;
        color: var(--neutral-500);
        margin-bottom: 0.5rem;
    }

    .member-position {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--primary-700);
        background: var(--primary-50);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
    }

    .member-card--ketua .member-position {
        background: linear-gradient(135deg, var(--accent-100), var(--primary-100));
        color: var(--primary-800);
    }

    /* ===== GRID LAYOUT ===== */
    .members-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .members-row {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .members-row .member-card {
        flex: 0 0 auto;
        width: 260px;
    }

    /* ===== SECTION TITLES ===== */
    .section-label {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-label-text {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--neutral-500);
        position: relative;
        padding: 0 2rem;
    }

    .section-label-text::before,
    .section-label-text::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--neutral-300));
    }

    .section-label-text::before {
        left: 0;
        background: linear-gradient(90deg, transparent, var(--neutral-300));
    }

    .section-label-text::after {
        right: 0;
        background: linear-gradient(90deg, var(--neutral-300), transparent);
    }

    /* ===== CTA ===== */
    .members-cta {
        text-align: center;
        padding: 3rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-800), var(--primary-900));
        color: white;
    }

    .members-cta h2 {
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .members-cta p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-btn {
        display: inline-block;
        background: var(--sakura, #FFB7C5);
        color: var(--primary-900);
        padding: 0.875rem 2rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 183, 197, 0.4);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .members-header {
            padding-top: calc(70px + 3rem);
        }

        .member-card--ketua .member-photo-wrapper {
            width: 150px;
            height: 150px;
        }

        .members-row {
            flex-direction: column;
            align-items: center;
        }

        .members-row .member-card {
            width: 100%;
            max-width: 300px;
        }

        .member-card--ketua .member-symbol {
            width: 140px;
            height: 140px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <header class="members-header">
        <div class="members-header-content">
            <h1 class="members-title brush-underline" style="display: inline-block;">Pengurus Inti BANZAI</h1>
            <p class="members-subtitle">Periode {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>
    </header>

    <!-- Members Section -->
    <section class="members-section">
        <div class="members-container">

            <!-- Ketua -->
            <div class="section-label">
                <span class="section-label-text">Pimpinan</span>
            </div>

            <div class="leader-spotlight">
                <div class="member-card member-card--ketua">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Ketua.jpg') }}" alt="Ketua" class="member-photo">
                    </div>
                    <h3 class="member-name">Aditya Setiawan</h3>
                    <p class="member-class">XII RPL 1</p>
                    <span class="member-position">Ketua Umum</span>
                </div>
            </div>

            <!-- Wakil & Sekretaris & Bendahara -->
            <div class="section-label">
                <span class="section-label-text">Wakil & Sekretariat</span>
            </div>

            <div class="members-row">
                <div class="member-card member-card--wakil">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Wakil-Ketua.jpeg') }}" alt="Wakil Ketua" class="member-photo">
                    </div>
                    <h3 class="member-name">Silvani</h3>
                    <p class="member-class">XII KA 3</p>
                    <span class="member-position">Wakil Ketua</span>
                </div>

                <div class="member-card member-card--koordinator" style="--accent-color: #F59E0B;">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Kor.Medsos-2.jpg') }}" alt="Koordinator Medsos 2" class="member-photo">
                    </div>
                    <h3 class="member-name">Micky Yuhana</h3>
                    <p class="member-class">XII KA 6</p>
                    <span class="member-position">Koordinator Medsos 2</span>
                </div>

                <div class="member-card member-card--bendahara">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Bendahara.jpg') }}" alt="Bendahara" class="member-photo">
                    </div>
                    <h3 class="member-name">Siti Jasmine</h3>
                    <p class="member-class">XII KA 6</p>
                    <span class="member-position">Bendahara</span>
                </div>
            </div>

            <!-- Koordinator Divisi -->
            <div class="section-label">
                <span class="section-label-text">Koordinator Divisi</span>
            </div>

            <div class="members-row">
                <div class="member-card member-card--koordinator" style="--accent-color: #0891B2;">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Kor.Bahasa.jpg') }}" alt="Koordinator Bahasa" class="member-photo">
                    </div>
                    <h3 class="member-name">Bima Ksatria</h3>
                    <p class="member-class">XII TKJ 1</p>
                    <span class="member-position">Koordinator Bahasa</span>
                </div>

                <div class="member-card member-card--koordinator" style="--accent-color: #7C3AED;">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Kor.Budaya.jpg') }}" alt="Koordinator Budaya" class="member-photo">
                    </div>
                    <h3 class="member-name">Razzan Ilman</h3>
                    <p class="member-class">XII RPL 1</p>
                    <span class="member-position">Koordinator Budaya</span>
                </div>

                <div class="member-card member-card--koordinator" style="--accent-color: #F59E0B;">
                    <div class="member-symbol"></div>
                    <div class="member-photo-wrapper">
                        <div class="member-photo-frame"></div>
                        <img src="{{ asset('images/members/Kor.Medsos.jpg') }}" alt="Koordinator Medsos" class="member-photo">
                    </div>
                    <h3 class="member-name">Raihanisa</h3>
                    <p class="member-class">XII KA 6</p>
                    <span class="member-position">Koordinator Medsos</span>
                </div>
            </div>

            <!-- Divisi Bahasa -->
            <div class="section-label" style="margin-top: 3rem;">
                <span class="section-label-text" style="color: #0891B2;">Divisi Bahasa 言語</span>
            </div>

            <div class="members-grid">
                <div class="member-card member-card--anggota" style="--accent-color: #0891B2;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Yuto Sato</h3>
                    <p class="member-class">X – RPL</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #0891B2;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Aoi Kimura</h3>
                    <p class="member-class">X – TKJ</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #0891B2;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Haruki Ito</h3>
                    <p class="member-class">XI – MM</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
            </div>

            <!-- Divisi Budaya -->
            <div class="section-label" style="margin-top: 3rem;">
                <span class="section-label-text" style="color: #7C3AED;">Divisi Budaya 文化</span>
            </div>

            <div class="members-grid">
                <div class="member-card member-card--anggota" style="--accent-color: #7C3AED;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Hinata Mori</h3>
                    <p class="member-class">X – Tata Busana</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #7C3AED;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Riku Hayashi</h3>
                    <p class="member-class">XI – DKV</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #7C3AED;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Sora Fujita</h3>
                    <p class="member-class">X – AKL</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
            </div>

            <!-- Divisi Medsos -->
            <div class="section-label" style="margin-top: 3rem;">
                <span class="section-label-text" style="color: #F59E0B;">Divisi Media Sosial 発信</span>
            </div>

            <div class="members-grid">
                <div class="member-card member-card--anggota" style="--accent-color: #F59E0B;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Kaito Ogawa</h3>
                    <p class="member-class">X – MM</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #F59E0B;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Mio Ishida</h3>
                    <p class="member-class">XI – DKV</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
                <div class="member-card member-card--anggota" style="--accent-color: #F59E0B;">
                    <div class="member-photo-wrapper" style="width: 100px; height: 100px;">
                        <div class="member-photo-frame"></div>
                        <div class="member-photo" style="font-size: 2rem;">👤</div>
                    </div>
                    <h3 class="member-name" style="font-size: 1rem;">Tsubasa Endo</h3>
                    <p class="member-class">X – RPL</p>
                    <span class="member-position" style="font-size: 0.7rem;">Anggota</span>
                </div>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="members-cta">
        <h2>Ingin Bergabung?</h2>
        <p>Jadilah bagian dari keluarga BANZAI dan kembangkan potensimu!</p>
        <a href="{{ route('register') }}" class="cta-btn">Daftar Sekarang</a>
    </section>
@endsection
