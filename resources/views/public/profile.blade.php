@extends('layouts.app')

@section('title', 'Profil & Sejarah')

@push('styles')
<style>
/* Brush Stroke Decorations */
.profile-page {
    position: relative;
}

.brush-decoration {
    position: absolute;
    pointer-events: none;
    opacity: 0.08;
}

.brush-top-right {
    top: 100px;
    right: 5%;
    width: 200px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-900) 0%, transparent 70%);
    transform: rotate(-15deg) skewX(-20deg);
    border-radius: 50% 0 50% 0;
}

.brush-left {
    top: 40%;
    left: -50px;
    width: 120px;
    height: 300px;
    background: linear-gradient(180deg, var(--primary-600), transparent);
    transform: rotate(-5deg);
    border-radius: 60px;
}

.ink-splatter {
    position: absolute;
    width: 15px;
    height: 15px;
    background: var(--primary-800);
    border-radius: 50%;
    opacity: 0.06;
}

.ink-splatter-1 { top: 20%; left: 10%; transform: scale(1.5); }
.ink-splatter-2 { top: 35%; right: 15%; transform: scale(0.8); }
.ink-splatter-3 { top: 60%; left: 8%; transform: scale(1.2); }
.ink-splatter-4 { bottom: 30%; right: 10%; transform: scale(0.6); }

/* Kanji Watermark */
.kanji-watermark {
    position: absolute;
    font-size: 15rem;
    font-family: var(--font-heading);
    color: var(--primary-900);
    opacity: 0.03;
    pointer-events: none;
    user-select: none;
}

.kanji-watermark-1 { top: 15%; right: 5%; transform: rotate(-10deg); }
.kanji-watermark-2 { top: 55%; left: 3%; transform: rotate(5deg); }

/* Enhanced Section Styles */
.profile-section-card {
    position: relative;
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--space-2xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.profile-section-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, var(--primary-600), var(--accent-500));
}

.profile-section-card::after {
    content: '';
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, var(--primary-100) 0%, transparent 70%);
    opacity: 0.5;
}

/* Brush Underline Enhancement */
.brush-accent {
    display: inline-block;
    position: relative;
}

.brush-accent::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(90deg, var(--accent-500), transparent);
    transform: skewX(-10deg);
    opacity: 0.6;
}

/* Timeline Enhancement */
.timeline-dot {
    position: relative;
}

.timeline-dot::after {
    content: '';
    position: absolute;
    width: 30px;
    height: 30px;
    border: 2px dashed var(--primary-300);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: pulseRing 3s ease-in-out infinite;
}

@keyframes pulseRing {
    0%, 100% { opacity: 0.3; transform: translate(-50%, -50%) scale(1); }
    50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1.2); }
}
</style>
@endpush

@section('content')
    <div class="profile-page">
        <!-- Decorative Elements -->
        <div class="brush-decoration brush-top-right"></div>
        <div class="brush-decoration brush-left"></div>
        <div class="ink-splatter ink-splatter-1"></div>
        <div class="ink-splatter ink-splatter-2"></div>
        <div class="ink-splatter ink-splatter-3"></div>
        <div class="ink-splatter ink-splatter-4"></div>
        <div class="kanji-watermark kanji-watermark-1">万</div>
        <div class="kanji-watermark kanji-watermark-2">歳</div>

        <!-- Page Header -->
        <header class="page-header" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M50 0 Q60 50 50 100 Q40 50 50 0\" fill=\"none\" stroke=\"%23064E3B\" stroke-width=\"0.5\" opacity=\"0.05\"/%3E%3C/svg%3E'); opacity: 0.3;"></div>
            <div class="container" style="position: relative;">
                <h1 class="page-title brush-underline">Profil BANZAI</h1>
                <p class="page-subtitle">Mengenal lebih dekat eskul Bahasa Jepang SMKN 13 Bandung</p>
            </div>
        </header>

        <!-- Profile Section -->
        <section class="section">
            <div class="section-container">
                <div class="section-header section-header--asymmetric">
                    <h2 class="section-title"><span class="brush-accent">Tentang Kami</span></h2>
                </div>

                <div class="profile-section-card" style="max-width: 800px;">
                    <p style="font-size: var(--text-lg); line-height: 1.9; color: var(--neutral-700); margin-bottom: var(--space-xl);">
                        <strong>BANZAI</strong> (万歳) adalah eskul Bahasa Jepang di SMKN 13 Bandung yang berdiri sejak tahun 
                        <strong style="color: var(--accent-600);">2009</strong>. Nama "BANZAI" diambil dari seruan tradisional Jepang yang berarti 
                        "sepuluh ribu tahun" — melambangkan harapan, semangat, dan keabadian.
                    </p>

                    <p style="font-size: var(--text-lg); line-height: 1.9; color: var(--neutral-700);">
                        Kami hadir sebagai wadah bagi siswa-siswi SMKN 13 Bandung yang memiliki minat dan ketertarikan 
                        terhadap bahasa dan budaya Jepang. Melalui berbagai kegiatan edukatif dan kreatif, kami berupaya 
                        memfasilitasi pembelajaran yang menyenangkan dan bermakna.
                    </p>
                </div>
            </div>
        </section>

    <!-- Guru Pembina -->
    <section class="section" style="background: var(--neutral-100);">
        <div class="section-container">
            <div style="display: flex; gap: var(--space-2xl); align-items: center; flex-wrap: wrap;">
                <div style="flex: 0 0 150px;">
                    <div style="width: 150px; height: 150px; border-radius: 50%; background: var(--primary-100); display: flex; align-items: center; justify-content: center; font-size: var(--text-5xl); color: var(--primary-600);">
                        👩‍🏫
                    </div>
                </div>
                <div style="flex: 1; min-width: 300px;">
                    <h3 style="font-size: var(--text-2xl); color: var(--primary-900); margin-bottom: var(--space-sm);">Indah Sensei</h3>
                    <p style="color: var(--accent-600); font-weight: 500; margin-bottom: var(--space-md);">Guru Pembina BANZAI</p>
                    <p style="color: var(--neutral-600); line-height: 1.8;">
                        Dengan dedikasi dan kecintaan terhadap budaya Jepang, Indah Sensei telah membimbing 
                        generasi demi generasi anggota BANZAI untuk terus berkembang dan mencintai bahasa Jepang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah Timeline -->
    <section class="section">
        <div class="section-container">
            <div class="section-header section-header--asymmetric">
                <h2 class="section-title">Sejarah</h2>
                <p class="section-subtitle">Perjalanan BANZAI dari awal hingga sekarang</p>
            </div>

            <div style="max-width: 700px; position: relative; padding-left: var(--space-2xl);">
                <!-- Timeline line -->
                <div style="position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: var(--primary-200);"></div>

                <!-- 2009 -->
                <div style="position: relative; margin-bottom: var(--space-2xl);">
                    <div style="position: absolute; left: calc(-1 * var(--space-2xl) + 2px); width: 14px; height: 14px; border-radius: 50%; background: var(--primary-600);"></div>
                    <div style="background: var(--white); padding: var(--space-xl); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
                        <span style="color: var(--accent-600); font-weight: 600;">2009</span>
                        <h4 style="font-size: var(--text-lg); color: var(--neutral-900); margin: var(--space-xs) 0;">Awal Mula</h4>
                        <p style="color: var(--neutral-600);">BANZAI didirikan oleh sekelompok siswa pecinta Jepang di SMKN 13 Bandung.</p>
                    </div>
                </div>

                <!-- 2015 -->
                <div style="position: relative; margin-bottom: var(--space-2xl);">
                    <div style="position: absolute; left: calc(-1 * var(--space-2xl) + 2px); width: 14px; height: 14px; border-radius: 50%; background: var(--primary-600);"></div>
                    <div style="background: var(--white); padding: var(--space-xl); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
                        <span style="color: var(--accent-600); font-weight: 600;">2015</span>
                        <h4 style="font-size: var(--text-lg); color: var(--neutral-900); margin: var(--space-xs) 0;">Pembentukan Divisi</h4>
                        <p style="color: var(--neutral-600);">Struktur organisasi diperbaharui dengan 3 divisi utama: Bahasa, Budaya, dan Media Sosial.</p>
                    </div>
                </div>

                <!-- Sekarang -->
                <div style="position: relative;">
                    <div style="position: absolute; left: calc(-1 * var(--space-2xl) + 2px); width: 14px; height: 14px; border-radius: 50%; background: var(--accent-600);"></div>
                    <div style="background: var(--white); padding: var(--space-xl); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
                        <span style="color: var(--accent-600); font-weight: 600;">{{ date('Y') }}</span>
                        <h4 style="font-size: var(--text-lg); color: var(--neutral-900); margin: var(--space-xs) 0;">Terus Berkembang</h4>
                        <p style="color: var(--neutral-600);">BANZAI terus aktif mengembangkan program pembelajaran dan kegiatan budaya Jepang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="section" style="background: var(--primary-900); color: white;">
        <div class="section-container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-3xl);">
                <div>
                    <h3 style="font-size: var(--text-2xl); margin-bottom: var(--space-lg); opacity: 0.9;">Visi</h3>
                    <p style="font-size: var(--text-lg); line-height: 1.8; opacity: 0.85;">
                        Menjadi wadah pengembangan minat dan bakat siswa dalam bahasa serta budaya Jepang yang 
                        berkualitas, inspiratif, dan berkontribusi bagi sekolah.
                    </p>
                </div>
                <div>
                    <h3 style="font-size: var(--text-2xl); margin-bottom: var(--space-lg); opacity: 0.9;">Misi</h3>
                    <ul style="font-size: var(--text-lg); line-height: 2; opacity: 0.85; list-style: disc; padding-left: var(--space-xl);">
                        <li>Menyelenggarakan pembelajaran bahasa Jepang yang sistematis</li>
                        <li>Melestarikan dan memperkenalkan budaya Jepang</li>
                        <li>Mengembangkan kreativitas anggota melalui kegiatan</li>
                        <li>Membangun karakter disiplin ala budaya Jepang</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
