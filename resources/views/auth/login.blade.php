@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .login-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%);
        overflow: hidden;
    }

    /* LEFT SIDE - FORM */
    .login-form-container {
        background: white;
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 10;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
    }

    .brand-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 3rem;
    }

    .brand-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #EC4899, #F472B6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
    }

    .brand-name {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #0EA5E9, #EC4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-content {
        max-width: 420px;
        margin: 0 auto;
        width: 100%;
    }

    .kanji-title {
        font-family: 'Noto Sans JP', serif;
        font-size: 4.5rem;
        text-align: center;
        background: linear-gradient(135deg, #0EA5E9, #EC4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        font-weight: 700;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% { filter: hue-rotate(0deg); }
        50% { filter: hue-rotate(10deg); }
    }

    .login-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #0F172A;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        text-align: center;
        color: #64748B;
        margin-bottom: 2.5rem;
        font-size: 1rem;
    }

    .social-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .social-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0EA5E9, #06B6D4);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.125rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    }

    .social-btn:hover {
        background: linear-gradient(135deg, #EC4899, #F472B6);
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
    }

    .divider {
        text-align: center;
        color: #94A3B8;
        font-size: 0.875rem;
        margin: 2rem 0;
        position: relative;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: linear-gradient(to right, transparent, #CBD5E1, transparent);
    }

    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #0F172A;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #E0F2FE;
        border-radius: 14px;
        font-size: 1rem;
        background: #F0F9FF;
        transition: all 0.3s ease;
        color: #0F172A;
    }

    .form-input:focus {
        outline: none;
        border-color: #0EA5E9;
        background: white;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    .form-input::placeholder {
        color: #94A3B8;
    }

    .button-group {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1.125rem;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.0625rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-login {
        background: linear-gradient(135deg, #0EA5E9, #06B6D4);
        color: white;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.4);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #0284C7, #0891B2);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.5);
    }

    .btn-signup {
        background: linear-gradient(135deg, #EC4899, #F472B6);
        color: white;
        box-shadow: 0 4px 16px rgba(236, 72, 153, 0.3);
    }

    .btn-signup:hover {
        background: linear-gradient(135deg, #DB2777, #EC4899);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(236, 72, 153, 0.4);
    }

    .back-link {
        text-align: center;
        margin-top: 2rem;
    }

    .back-link a {
        color: #64748B;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .back-link a:hover {
        color: #0EA5E9;
    }

    /* RIGHT SIDE - TOKYO 3D ILLUSTRATION */
    .login-illustration {
        background: linear-gradient(135deg, #7DD3FC 0%, #BAE6FD 50%, #E0F2FE 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animated clouds */
    .cloud {
        position: absolute;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 100px;
        animation: cloudFloat 30s linear infinite;
    }

    .cloud::before,
    .cloud::after {
        content: '';
        position: absolute;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 100px;
    }

    .cloud-1 {
        width: 100px;
        height: 40px;
        top: 15%;
        left: -100px;
        animation-delay: 0s;
    }

    .cloud-1::before {
        width: 50px;
        height: 50px;
        top: -25px;
        left: 10px;
    }

    .cloud-1::after {
        width: 60px;
        height: 40px;
        top: -15px;
        right: 10px;
    }

    .cloud-2 {
        width: 120px;
        height: 45px;
        top: 60%;
        left: -120px;
        animation-delay: 10s;
    }

    .cloud-2::before {
        width: 60px;
        height: 60px;
        top: -30px;
        left: 15px;
    }

    .cloud-2::after {
        width: 70px;
        height: 45px;
        top: -20px;
        right: 15px;
    }

    @keyframes cloudFloat {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(100vw + 200px)); }
    }

    /* Tokyo city container */
    .tokyo-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* Main Tokyo image */
    .tokyo-image {
        position: relative;
        width: 100%;
        max-width: 800px;
        animation: float 6s ease-in-out infinite;
        filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.3));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-25px) rotate(1deg); }
    }

    .tokyo-image img {
        width: 100%;
        height: auto;
        display: block;
        filter: brightness(1.1) contrast(1.05);
    }

    /* Glowing aura around image */
    .tokyo-image::before {
        content: '';
        position: absolute;
        inset: -40px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.4), rgba(236, 72, 153, 0.3), transparent 70%);
        filter: blur(40px);
        z-index: -1;
        animation: auraGlow 4s ease-in-out infinite;
    }

    @keyframes auraGlow {
        0%, 100% { opacity: 0.6; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.1); }
    }

    /* Floating elements around Tokyo */
    .floating-element {
        position: absolute;
        animation: floatAround 8s ease-in-out infinite;
    }

    .sushi-1 {
        top: 10%;
        left: 15%;
        font-size: 2.5rem;
        animation-delay: 0s;
    }

    .sushi-2 {
        top: 15%;
        right: 20%;
        font-size: 2rem;
        animation-delay: 1s;
    }

    .lantern-1 {
        bottom: 25%;
        left: 10%;
        font-size: 2rem;
        animation-delay: 2s;
    }

    .lantern-2 {
        top: 50%;
        right: 15%;
        font-size: 2.5rem;
        animation-delay: 3s;
    }

    .robot {
        bottom: 30%;
        right: 10%;
        font-size: 3rem;
        animation-delay: 1.5s;
    }

    @keyframes floatAround {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-15px) rotate(5deg); }
        75% { transform: translateY(-10px) rotate(-5deg); }
    }

    /* Glowing lights effect */
    .glow-light {
        position: absolute;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.5;
        animation: glowPulse 4s ease-in-out infinite;
    }

    .glow-pink {
        background: radial-gradient(circle, #EC4899, #F472B6);
        top: 15%;
        right: 5%;
        animation-delay: 0s;
    }

    .glow-blue {
        background: radial-gradient(circle, #0EA5E9, #06B6D4);
        bottom: 15%;
        left: 5%;
        animation-delay: 2s;
    }

    .glow-cyan {
        background: radial-gradient(circle, #06B6D4, #22D3EE);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        height: 400px;
        animation-delay: 1s;
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.3); }
    }

    /* Welcome text overlay */
    .welcome-overlay {
        position: absolute;
        bottom: 10%;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        color: white;
        z-index: 10;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #FFF, #E0F2FE);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-subtitle {
        font-size: 1.125rem;
        opacity: 0.95;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .login-page {
            grid-template-columns: 1fr;
        }

        .login-illustration {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .login-form-container {
            padding: 2rem 1.5rem;
        }

        .button-group {
            grid-template-columns: 1fr;
        }

        .kanji-title {
            font-size: 3.5rem;
        }
    }
</style>

<div class="login-page">
    <!-- LEFT SIDE - FORM -->
    <div class="login-form-container">
        <div class="brand-header">
            <div class="brand-icon">万</div>
            <span class="brand-name">BANZAI</span>
        </div>

        <div class="form-content">
            <div class="kanji-title">万歳</div>
            <h1 class="login-title">Member Login</h1>
            <p class="login-subtitle">Masuk ke akun BANZAI Anda</p>

            <div class="social-buttons">
                <a href="#" class="social-btn">G</a>
                <a href="#" class="social-btn">in</a>
                <a href="#" class="social-btn">f</a>
                <a href="#" class="social-btn">𝕏</a>
            </div>

            <div class="divider">atau gunakan email</div>

            @if ($errors->any())
                <div style="background: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 14px; margin-bottom: 1.5rem; font-size: 0.875rem;">
                    <strong>⚠️ Error:</strong>
                    <ul style="margin: 0.5rem 0 0 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        value="{{ old('email') }}"
                        placeholder="razzan"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="••••••••••••"
                        required
                    >
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-login">Login</button>
                    <a href="{{ route('auth.register') }}" class="btn btn-signup">Sign up</a>
                </div>
            </form>

            <div class="back-link">
                <a href="{{ route('landing') }}">← Kembali ke Landing</a>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE - TOKYO 3D ILLUSTRATION -->
    <div class="login-illustration">
        <!-- Glowing lights -->
        <div class="glow-light glow-pink"></div>
        <div class="glow-light glow-blue"></div>
        <div class="glow-light glow-cyan"></div>

        <!-- Animated clouds -->
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>

        <div class="tokyo-container">
            <!-- Main Tokyo 3D Image -->
            <div class="tokyo-image">
                <img src="{{ asset('images/hero/Tokyo.png') }}" alt="Tokyo City 3D">
            </div>

            <!-- Floating elements -->
            <div class="floating-element sushi-1">🍣</div>
            <div class="floating-element sushi-2">🍱</div>
            <div class="floating-element lantern-1">🏮</div>
            <div class="floating-element lantern-2">🏮</div>
            <div class="floating-element robot">🤖</div>

            <!-- Welcome text -->
            <div class="welcome-overlay">
                <h2 class="welcome-title">Selamat Datang Kembali!</h2>
                <p class="welcome-subtitle">Lanjutkan perjalanan belajar Anda</p>
            </div>
        </div>
    </div>
</div>
@endsection
