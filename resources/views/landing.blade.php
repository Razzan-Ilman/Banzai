<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANZAI - Eskul Bahasa Jepang SMKN 13 Bandung</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .landing-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(160deg, #1E293B 0%, #334155 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated background */
        .landing-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, #1E293B 0%, #2D3E50 40%, #334155 100%);
            background-size: 200% 200%;
            animation: gradientDrift 45s ease-in-out infinite;
            opacity: 0.9;
        }

        @keyframes gradientDrift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Washi texture */
        .landing-container::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.04;
            filter: blur(0.5px);
            pointer-events: none;
        }

        /* Login button (top right) */
        .login-btn {
            position: absolute;
            top: 2rem;
            right: 2rem;
            padding: 0.875rem 1.75rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .login-btn svg {
            width: 18px;
            height: 18px;
            opacity: 0.85;
        }

        /* Center content */
        .landing-content {
            position: relative;
            z-index: 5;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 2rem;
        }

        .kanji-logo {
            font-family: 'Noto Sans JP', serif;
            font-size: clamp(5rem, 15vw, 10rem);
            font-weight: 700;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.2s forwards;
        }

        .main-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.4s forwards;
        }

        .subtitle {
            font-size: clamp(1rem, 2vw, 1.5rem);
            font-weight: 300;
            margin-bottom: 3rem;
            opacity: 0.9;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.6s forwards;
        }

        .enter-btn {
            display: inline-block;
            padding: 1.5rem 4rem;
            background: #C7A14A;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 40px rgba(199, 161, 74, 0.3);
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.8s forwards;
        }

        .enter-btn:hover {
            background: #A68B3A;
            transform: translateY(-4px);
            box-shadow: 0 15px 50px rgba(199, 161, 74, 0.4);
        }

        /* Register button */
        .register-btn {
            display: inline-block;
            padding: 1.5rem 4rem;
            background: transparent;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1s forwards;
        }

        .register-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-4px);
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tagline */
        .tagline {
            position: absolute;
            bottom: 3rem;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
            font-style: italic;
            z-index: 5;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1s forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-btn {
                top: 1rem;
                right: 1rem;
                padding: 0.5rem 1.5rem;
                font-size: 0.875rem;
            }

            .enter-btn {
                padding: 1.25rem 3rem;
                font-size: 1.125rem;
            }

            .tagline {
                bottom: 2rem;
                padding: 0 2rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <!-- Login Button (Top Right) -->
        <a href="{{ route('login') }}" class="login-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            <span>Login</span>
        </a>

        <!-- Center Content -->
        <div class="landing-content">
            <div class="kanji-logo">万歳</div>
            <h1 class="main-title">BANZAI</h1>
            <p class="subtitle">Eskul Bahasa Jepang SMKN 13 Bandung</p>
            <a href="{{ route('home') }}" class="enter-btn">
                Masuk ke Website
            </a>
        </div>

        <!-- Tagline -->
        <div class="tagline">
            "Controlled Expression - Calm but Alive, Minimal but Layered"
        </div>
    </div>
</body>
</html>
