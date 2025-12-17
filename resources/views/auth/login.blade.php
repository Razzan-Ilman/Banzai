<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BANZAI Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&family=Shippori+Mincho:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --matcha-deep: #1B4332;
            --matcha: #064E3B;
            --matcha-light: #10B981;
            --sakura: #FFB7C5;
            --ink: #1a1a2e;
            --paper: #FAFAFA;
            --text-muted: #9ca3af;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Ambient light - static gradient */
            background: 
                radial-gradient(ellipse at 20% 20%, rgba(16, 185, 129, 0.06), transparent 40%),
                linear-gradient(180deg, #1a1f2e, #16213e);
            color: #ffffff;
            padding: 1.5rem;
            position: relative;
        }
        
        /* Matcha Dust - spasial */
        .dust {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .dust-1 {
            width: 250px;
            height: 250px;
            top: 5%;
            left: -3%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.02), transparent 60%);
            filter: blur(10px);
            animation: dustMove 45s ease-in-out infinite;
        }
        
        @keyframes dustMove {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(15px, 10px); }
        }
        
        .login-container {
            display: flex;
            max-width: 850px;
            width: 100%;
            background: rgba(37, 43, 61, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
            animation: containerFade 0.5s ease-out;
        }
        
        @keyframes containerFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Left Panel */
        .login-image {
            flex: 1;
            background: linear-gradient(150deg, var(--matcha), var(--matcha-deep));
            min-height: 480px;
            display: flex;
            flex-direction: column;
            padding: 2rem;
            position: relative;
        }
        
        /* Subtle texture */
        .login-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: 0.015;
            pointer-events: none;
        }
        
        .login-image-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }
        
        .login-brand {
            display: flex;
            flex-direction: column;
        }
        
        .login-brand-kanji {
            font-family: 'Shippori Mincho', serif;
            font-size: 1.5rem;
            color: var(--sakura);
            opacity: 0.85;
        }
        
        .login-brand-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            letter-spacing: 0.12em;
        }
        
        .back-link {
            padding: 0.4rem 0.875rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            color: white;
            text-decoration: none;
            font-size: 0.75rem;
            transition: all 0.25s ease;
        }
        
        .back-link:hover {
            background: rgba(255, 255, 255, 0.12);
        }
        
        .image-center {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .enso {
            width: 120px;
            height: 120px;
            border: 2px solid rgba(255, 183, 197, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .enso-kanji {
            font-family: 'Shippori Mincho', serif;
            font-size: 2rem;
            color: rgba(255, 183, 197, 0.8);
        }
        
        .tagline {
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .tagline h2 {
            font-family: 'Shippori Mincho', serif;
            font-size: 1.125rem;
            font-weight: 400;
            color: white;
            line-height: 1.5;
        }
        
        .tagline h2 span {
            color: var(--sakura);
        }
        
        /* Brush divider */
        .brush-line {
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, var(--sakura), transparent);
            margin: 1rem auto 0;
            opacity: 0.6;
        }
        
        /* Right Panel - Form */
        .login-form-panel {
            flex: 1;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            margin-bottom: 1.75rem;
        }
        
        .form-header h1 {
            font-size: 1.375rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.25rem;
        }
        
        /* Brush underline */
        .form-header h1::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--matcha-light), transparent);
            margin-top: 0.5rem;
            animation: brushDraw 0.7s cubic-bezier(0.4, 0, 0.2, 1) 0.2s forwards;
        }
        
        @keyframes brushDraw {
            to { width: 60px; }
        }
        
        .form-header p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        
        .form-group {
            margin-bottom: 1.125rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.375rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(45, 53, 72, 0.7);
            border: 1px solid rgba(61, 69, 89, 0.8);
            border-radius: 0.5rem;
            color: white;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.25s ease;
        }
        
        .form-input::placeholder {
            color: #6b7280;
        }
        
        /* Focus light */
        .form-input:focus {
            outline: none;
            border-color: var(--matcha-light);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-toggle {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
        }
        
        .form-error {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 0.375rem;
        }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin: 1.25rem 0;
        }
        
        .form-checkbox input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: var(--sakura);
        }
        
        .form-checkbox label {
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        
        .login-btn {
            width: 100%;
            padding: 0.875rem;
            background: var(--sakura);
            border: none;
            border-radius: 0.5rem;
            color: var(--matcha-deep);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        
        /* Focus light on hover */
        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(255, 183, 197, 0.25);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        /* Responsive */
        @media (max-width: 700px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-image {
                min-height: 260px;
            }
            
            .enso {
                width: 90px;
                height: 90px;
            }
            
            .enso-kanji {
                font-size: 1.5rem;
            }
            
            .login-form-panel {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Matcha Dust -->
    <div class="dust dust-1"></div>
    
    <div class="login-container">
        <!-- Left Panel -->
        <div class="login-image">
            <div class="login-image-header">
                <div class="login-brand">
                    <span class="login-brand-kanji">万歳</span>
                    <span class="login-brand-text">BANZAI</span>
                </div>
                <a href="{{ route('home') }}" class="back-link">← Kembali</a>
            </div>
            
            <div class="image-center">
                <div class="enso">
                    <span class="enso-kanji">管</span>
                </div>
            </div>
            
            <div class="tagline">
                <h2>Kelola dengan <span>Ketenangan</span></h2>
                <div class="brush-line"></div>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="login-form-panel">
            <div class="form-header">
                <h1>Masuk ke Admin</h1>
                <p>Kelola website BANZAI dengan mudah</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="admin@banzai.sch.id"
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="input-toggle" onclick="togglePassword()">👁</button>
                    </div>
                </div>
                
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                
                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                
                <button type="submit" class="login-btn">Masuk</button>
            </form>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn = document.querySelector('.input-toggle');
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁';
            }
        }
    </script>
</body>
</html>
