<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BANZAI - Eskul Bahasa Jepang SMKN 13 Bandung. Belajar bahasa dan budaya Jepang bersama kami.">
    <title>@yield('title', 'BANZAI') - Eskul Bahasa Jepang SMKN 13 Bandung</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
/* BANZAI Design System - Inlined for robustness */
/* ===== CSS VARIABLES ===== */
:root {
    /* Primary - Hijau Tua */
    --primary-900: #064E3B;
    --primary-800: #065F46;
    --primary-700: #047857;
    --primary-600: #059669;
    --primary-500: #10B981;
    --primary-400: #34D399;
    --primary-100: #D1FAE5;
    --primary-50: #ECFDF5;

    /* Accent - Pink */
    --accent-700: #BE185D;
    --accent-600: #DB2777;
    --accent-500: #EC4899;
    --accent-400: #F472B6;
    --accent-100: #FCE7F3;
    --accent-50: #FDF2F8;

    /* Division Colors */
    --bahasa-color: #0891B2;
    --budaya-color: #7C3AED;
    --medsos-color: #F59E0B;

    /* Neutral */
    --neutral-900: #171717;
    --neutral-800: #262626;
    --neutral-700: #404040;
    --neutral-600: #525252;
    --neutral-500: #737373;
    --neutral-400: #A3A3A3;
    --neutral-300: #D4D4D4;
    --neutral-200: #E5E5E5;
    --neutral-100: #F5F5F5;
    --neutral-50: #FAFAFA;
    --white: #FFFFFF;

    /* Typography */
    --font-heading: 'Noto Sans JP', 'Inter', sans-serif;
    --font-body: 'Inter', 'Noto Sans JP', sans-serif;

    /* Spacing */
    --space-xs: 0.25rem;
    --space-sm: 0.5rem;
    --space-md: 1rem;
    --space-lg: 1.5rem;
    --space-xl: 2rem;
    --space-2xl: 3rem;
    --space-3xl: 4rem;
    --space-4xl: 6rem;

    /* Typography Scale */
    --text-xs: 0.75rem;
    --text-sm: 0.875rem;
    --text-base: 1rem;
    --text-lg: 1.125rem;
    --text-xl: 1.25rem;
    --text-2xl: 1.5rem;
    --text-3xl: 1.875rem;
    --text-4xl: 2.25rem;
    --text-5xl: 3rem;
    --text-6xl: 3.75rem;
    --text-7xl: 4.5rem;
    --text-8xl: 6rem;

    /* Transitions */
    --transition-fast: 150ms ease;
    --transition-normal: 300ms ease;
    --transition-slow: 500ms ease;

    /* Shadows */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);

    /* Border Radius */
    --radius-sm: 0.25rem;
    --radius-md: 0.5rem;
    --radius-lg: 1rem;
    --radius-full: 9999px;

    /* Container */
    --container-max: 1200px;
    --container-hero: 1400px;
}

/* ===== RESET & BASE ===== */
*, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    font-size: 16px;
}

body {
    font-family: var(--font-body);
    font-size: var(--text-base);
    line-height: 1.6;
    color: var(--neutral-800);
    background-color: var(--neutral-50);
    overflow-x: hidden;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

a {
    text-decoration: none;
    color: inherit;
    transition: var(--transition-fast);
}

ul {
    list-style: none;
}

button {
    font-family: inherit;
    cursor: pointer;
    border: none;
    background: none;
}

/* ===== NAVIGATION ===== */
.nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    padding: var(--space-md) 0;
    background: transparent;
    transition: var(--transition-normal);
}

.nav.scrolled {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: var(--shadow-sm);
}

.nav-container {
    max-width: var(--container-max);
    margin: 0 auto;
    padding: 0 var(--space-lg);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    font-family: var(--font-heading);
    font-weight: 700;
}

.nav-logo {
    width: 45px;
    height: 45px;
    object-fit: contain;
}

.nav-brand-kanji {
    font-size: var(--text-lg);
    color: var(--white);
    opacity: 0.8;
}

.nav-brand-text {
    font-size: var(--text-xl);
    color: var(--white);
    letter-spacing: 0.15em;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: var(--space-xl);
}

.nav-link {
    font-size: var(--text-sm);
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
    position: relative;
    padding: var(--space-xs) 0;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--accent-400);
    transition: var(--transition-normal);
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 100%;
}

/* Scrolled state - white background with dark text */
.nav.scrolled .nav-brand-kanji,
.nav.light-bg .nav-brand-kanji {
    color: var(--primary-700);
}

.nav.scrolled .nav-brand-text,
.nav.light-bg .nav-brand-text {
    color: var(--primary-900);
}

.nav.scrolled .nav-link,
.nav.light-bg .nav-link {
    color: var(--neutral-700);
}

.nav.scrolled .nav-link::after,
.nav.light-bg .nav-link::after {
    background: var(--primary-600);
}

.nav-link:hover {
    color: var(--primary-700);
}

.nav-cta {
    background: var(--accent-600);
    color: var(--white) !important;
    padding: var(--space-sm) var(--space-lg) !important;
    border-radius: var(--radius-full);
    font-weight: 600;
}

.nav-cta::after {
    display: none;
}

.nav-cta:hover {
    background: var(--accent-700);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(219, 39, 119, 0.3);
}

/* Mobile Navigation Toggle */
.nav-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    padding: var(--space-sm);
}

.nav-toggle span {
    width: 24px;
    height: 2px;
    background: var(--neutral-800);
    transition: var(--transition-fast);
}

@media (max-width: 768px) {
    .nav-toggle {
        display: flex;
    }

    .nav-menu {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        background: var(--white);
        flex-direction: column;
        padding: var(--space-xl);
        gap: var(--space-lg);
        transform: translateY(-150%);
        opacity: 0;
        transition: var(--transition-normal);
        box-shadow: var(--shadow-lg);
    }

    .nav-menu.active {
        transform: translateY(0);
        opacity: 1;
    }

    .nav-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .nav-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .nav-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }
}

/* ===== HERO SECTION ===== */
.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: linear-gradient(135deg, var(--primary-900) 0%, var(--primary-800) 50%, var(--primary-700) 100%);
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0c16.569 0 30 13.431 30 30 0 16.569-13.431 30-30 30C13.431 60 0 46.569 0 30 0 13.431 13.431 0 30 0zm0 5C16.193 5 5 16.193 5 30s11.193 25 25 25 25-11.193 25-25S43.807 5 30 5z' fill='%23ffffff' fill-opacity='0.03'/%3E%3C/svg%3E");
    animation: waveShift 60s linear infinite;
}

@keyframes waveShift {
    0% { transform: translateX(0); }
    100% { transform: translateX(-60px); }
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--white);
    padding: var(--space-xl);
    max-width: 900px;
}

.hero-kanji {
    font-family: var(--font-heading);
    font-size: var(--text-4xl);
    opacity: 0.6;
    margin-bottom: var(--space-md);
    animation: kanjiBreath 15s ease-in-out infinite;
}

@keyframes kanjiBreath {
    0%, 100% { opacity: 0.5; transform: translateY(0); }
    50% { opacity: 0.8; transform: translateY(-3px); }
}

.hero-title {
    font-family: var(--font-heading);
    font-size: var(--text-7xl);
    font-weight: 700;
    letter-spacing: 0.3em;
    margin-bottom: var(--space-lg);
    animation: fadeInUp 1s ease-out;
}

.hero-line {
    width: 0;
    height: 2px;
    background: var(--accent-400);
    margin: 0 auto var(--space-xl);
    animation: lineGrow 1.2s cubic-bezier(0.4, 0, 0.2, 1) 0.5s forwards;
}

@keyframes lineGrow {
    to { width: 200px; }
}

.hero-subtitle {
    font-size: var(--text-lg);
    font-weight: 300;
    opacity: 0.9;
    margin-bottom: var(--space-2xl);
    animation: fadeInUp 1s ease-out 0.3s both;
}

.hero-cta {
    display: inline-block;
    background: var(--accent-600);
    color: var(--white);
    padding: var(--space-md) var(--space-2xl);
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: var(--text-lg);
    animation: fadeInUp 1s ease-out 1.5s both;
    transition: var(--transition-normal);
}

.hero-cta:hover {
    background: var(--accent-500);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(219, 39, 119, 0.4);
}

.hero-scroll {
    position: absolute;
    bottom: var(--space-2xl);
    left: 50%;
    transform: translateX(-50%);
    color: var(--white);
    opacity: 0.6;
    animation: scrollBounce 2s ease-in-out infinite;
}

@keyframes scrollBounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(8px); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: var(--text-4xl);
        letter-spacing: 0.15em;
    }

    .hero-kanji {
        font-size: var(--text-2xl);
    }
}

/* ===== MA SPACE (Breathing Space) ===== */
.ma-space {
    min-height: 30vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--space-4xl) var(--space-lg);
    background: var(--neutral-50);
}

.ma-content {
    text-align: center;
    max-width: 700px;
}

.ma-quote {
    font-family: var(--font-heading);
    font-size: var(--text-2xl);
    font-weight: 300;
    font-style: italic;
    color: var(--neutral-700);
    line-height: 1.8;
}

.ma-attribution {
    margin-top: var(--space-lg);
    font-size: var(--text-sm);
    color: var(--neutral-500);
}

/* ===== SECTIONS ===== */
.section {
    padding: var(--space-4xl) var(--space-lg);
}

.section-container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.section-header {
    margin-bottom: var(--space-3xl);
}

.section-title {
    font-family: var(--font-heading);
    font-size: var(--text-4xl);
    font-weight: 600;
    color: var(--primary-900);
    margin-bottom: var(--space-md);
}

.section-subtitle {
    font-size: var(--text-lg);
    color: var(--neutral-600);
    max-width: 600px;
}

/* Asymmetric Section Header */
.section-header--asymmetric {
    text-align: left;
    padding-left: var(--space-xl);
    border-left: 4px solid var(--primary-600);
}

/* ===== PAGE HEADER (for non-hero pages) ===== */
.page-header {
    /* Dynamic padding: min 70px on mobile, max 80px on desktop */
    padding-top: clamp(calc(60px + var(--space-xl)), 12vh, calc(80px + var(--space-3xl)));
    padding-bottom: clamp(var(--space-lg), 4vh, var(--space-2xl));
    padding-left: var(--space-lg);
    padding-right: var(--space-lg);
    background: linear-gradient(135deg, var(--primary-50), var(--neutral-50));
    border-bottom: 1px solid var(--neutral-200);
}

.page-header .container {
    max-width: var(--container-max);
    margin: 0 auto;
}

.page-title {
    font-family: var(--font-heading);
    /* Dynamic font size: 1.75rem on mobile, 2.25rem on desktop */
    font-size: clamp(1.75rem, 4vw, var(--text-4xl));
    font-weight: 600;
    color: var(--primary-900);
    margin-bottom: var(--space-sm);
}

.page-subtitle {
    /* Dynamic font size */
    font-size: clamp(0.9rem, 2vw, var(--text-lg));
    color: var(--neutral-600);
    max-width: 600px;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .page-header {
        padding-left: var(--space-md);
        padding-right: var(--space-md);
    }
}

/* ===== DIVISION CARDS ===== */
.divisions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-xl);
}

.division-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--space-2xl);
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.division-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--card-color, var(--primary-600));
}

.division-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-xl);
}

.division-card--bahasa { --card-color: var(--bahasa-color); }
.division-card--budaya { --card-color: var(--budaya-color); }
.division-card--medsos { --card-color: var(--medsos-color); }

.division-icon {
    font-size: var(--text-4xl);
    margin-bottom: var(--space-lg);
}

.division-title {
    font-family: var(--font-heading);
    font-size: var(--text-xl);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--space-sm);
}

.division-character {
    font-size: var(--text-sm);
    color: var(--card-color, var(--neutral-500));
    font-style: italic;
    margin-bottom: var(--space-md);
}

.division-description {
    color: var(--neutral-600);
    line-height: 1.7;
}

.division-tagline {
    margin-top: var(--space-lg);
    padding-top: var(--space-md);
    border-top: 1px solid var(--neutral-200);
    font-size: var(--text-sm);
    color: var(--neutral-500);
    font-style: italic;
}

/* ===== MEMBER CARDS ===== */
.members-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-lg);
}

.member-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: var(--transition-normal);
    border-left: 4px solid var(--member-color, var(--primary-600));
}

.member-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.member-initial {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-full);
    background: var(--member-color, var(--primary-100));
    color: var(--white);
    font-family: var(--font-heading);
    font-size: var(--text-2xl);
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-lg);
}

.member-name {
    font-family: var(--font-heading);
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--space-xs);
}

.member-position {
    font-size: var(--text-sm);
    color: var(--member-color, var(--primary-600));
    font-weight: 500;
    margin-bottom: var(--space-md);
}

.member-info {
    font-size: var(--text-sm);
    color: var(--neutral-500);
}

/* ===== ACTIVITY CARDS ===== */
.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: var(--space-xl);
}

.activity-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
}

.activity-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.activity-image {
    height: 200px;
    background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-600);
    font-size: var(--text-4xl);
}

.activity-content {
    padding: var(--space-xl);
}

.activity-date {
    font-size: var(--text-sm);
    color: var(--accent-600);
    font-weight: 500;
    margin-bottom: var(--space-sm);
}

.activity-title {
    font-family: var(--font-heading);
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--neutral-900);
    margin-bottom: var(--space-sm);
}

.activity-description {
    font-size: var(--text-sm);
    color: var(--neutral-600);
    line-height: 1.7;
}

/* ===== FORMS ===== */
.form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: var(--space-lg);
}

.form-label {
    display: block;
    font-weight: 500;
    color: var(--neutral-700);
    margin-bottom: var(--space-sm);
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: var(--space-md);
    border: 2px solid var(--neutral-200);
    border-radius: var(--radius-md);
    font-size: var(--text-base);
    font-family: inherit;
    transition: var(--transition-fast);
    background: var(--white);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-500);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-textarea {
    min-height: 150px;
    resize: vertical;
}

.form-error {
    color: #EF4444;
    font-size: var(--text-sm);
    margin-top: var(--space-xs);
}

.form-submit {
    width: 100%;
    background: var(--accent-600);
    color: var(--white);
    padding: var(--space-md) var(--space-xl);
    border: none;
    border-radius: var(--radius-md);
    font-size: var(--text-lg);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-normal);
}

.form-submit:hover {
    background: var(--accent-700);
    transform: translateY(-2px);
}

/* ===== ALERTS ===== */
.alert {
    padding: var(--space-lg);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-xl);
}

.alert-success {
    background: var(--primary-50);
    border: 1px solid var(--primary-200);
    color: var(--primary-800);
}

.alert-error {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #991B1B;
}

/* ===== FOOTER ===== */
.footer {
    background: var(--primary-900);
    color: var(--white);
    padding: var(--space-4xl) var(--space-lg) var(--space-xl);
}

.footer-container {
    max-width: var(--container-max);
    margin: 0 auto;
    text-align: center;
}

.footer-brand {
    margin-bottom: var(--space-2xl);
}

.footer-kanji {
    font-family: var(--font-heading);
    font-size: var(--text-3xl);
    opacity: 0.7;
    display: block;
    margin-bottom: var(--space-sm);
}

.footer-text {
    font-family: var(--font-heading);
    font-size: var(--text-2xl);
    font-weight: 700;
    letter-spacing: 0.2em;
}

.footer-tagline {
    margin-top: var(--space-sm);
    opacity: 0.7;
    font-size: var(--text-sm);
}

.footer-info {
    display: flex;
    justify-content: center;
    gap: var(--space-2xl);
    flex-wrap: wrap;
    margin-bottom: var(--space-2xl);
}
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="nav {{ !request()->routeIs('home') ? 'light-bg' : '' }}" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-brand">
                <img src="{{ asset('images/logo/Banzai-logo-removebg-preview.png') }}" alt="BANZAI Logo" class="nav-logo">
                <span class="nav-brand-kanji">万歳</span>
                <span class="nav-brand-text">BANZAI</span>
            </a>
            
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a></li>
                <li><a href="{{ route('divisions') }}" class="nav-link {{ request()->routeIs('divisions') ? 'active' : '' }}">Divisi</a></li>
                <li><a href="{{ route('members') }}" class="nav-link {{ request()->routeIs('members') ? 'active' : '' }}">Anggota</a></li>
                <li><a href="{{ route('activities') }}" class="nav-link {{ request()->routeIs('activities') ? 'active' : '' }}">Kegiatan</a></li>
                <li><a href="{{ route('register') }}" class="nav-link nav-cta {{ request()->routeIs('register') ? 'active' : '' }}">Bergabung</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <span class="footer-kanji">万歳</span>
                <span class="footer-text">BANZAI</span>
                <p class="footer-tagline">Eskul Bahasa Jepang SMKN 13 Bandung</p>
            </div>
            
            <div class="footer-info">
                <p>📍 SMKN 13 Bandung</p>
                <p>👩‍🏫 Pembina: Indah Sensei</p>
                <p>📅 Berdiri sejak 2009</p>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} BANZAI. Dibuat dengan ❤️ untuk pecinta Jepang.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile navigation toggle
        document.getElementById('navToggle')?.addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
            this.classList.toggle('active');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    
    <!-- Living Japanese Digital Space -->
    <script src="/js/living-space.js"></script>
    
    @stack('scripts')
</body>
</html>
