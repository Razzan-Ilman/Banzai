<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bergabung - BANZAI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;600;700&family=Shippori+Mincho:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            /* Controlled Expression Palette */
            --matcha-deep: #1B4332;
            --matcha: #064E3B;
            --matcha-light: #10B981;
            
            --sakura: #FFB7C5;
            --sakura-soft: #FFD9E0;
            
            --ink: #1a1a2e;
            --paper: #FAFAFA;
            --paper-warm: #FAF6F0;
            
            --text-primary: #262626;
            --text-muted: #737373;
        }
        
        /* ===== BASE - Clean, Breathable ===== */
        body {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
            min-height: 100vh;
            /* Gradient sebagai nafas visual - 2 warna, opacity rendah */
            background: 
                radial-gradient(ellipse at 0% 0%, rgba(16, 185, 129, 0.08), transparent 50%),
                radial-gradient(ellipse at 100% 100%, rgba(255, 183, 197, 0.05), transparent 50%),
                linear-gradient(180deg, #FAFAFA, #F5F5F5);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }
        
        /* ===== MATCHA DUST - Spasial, hampir tidak terlihat ===== */
        .matcha-dust {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .matcha-dust-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -5%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.03), transparent 70%);
            filter: blur(12px);
            animation: dustFloat 50s ease-in-out infinite;
        }
        
        .matcha-dust-2 {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: 5%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.02), transparent 70%);
            filter: blur(16px);
            animation: dustFloat 60s ease-in-out infinite reverse;
        }
        
        @keyframes dustFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -15px); }
        }
        
        /* ===== MAIN CONTAINER ===== */
        .register-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: var(--paper-warm);
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 
                0 4px 6px rgba(0, 0, 0, 0.02),
                0 20px 40px rgba(0, 0, 0, 0.04);
            position: relative;
            z-index: 1;
            animation: containerReveal 0.6s ease-out;
        }
        
        @keyframes containerReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* ===== LEFT PANEL - Tenang, Fokus ===== */
        .register-image {
            flex: 0 0 40%;
            background: linear-gradient(160deg, var(--matcha), var(--matcha-deep));
            min-height: 600px;
            display: flex;
            flex-direction: column;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Tekstur Washi - sangat halus */
        .register-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            opacity: 0.02;
            pointer-events: none;
        }
        
        .register-image-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }
        
        .register-brand {
            display: flex;
            flex-direction: column;
        }
        
        .register-brand-kanji {
            font-family: 'Shippori Mincho', serif;
            font-size: 1.75rem;
            color: var(--sakura);
            opacity: 0.9;
        }
        
        .register-brand-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            letter-spacing: 0.15em;
            margin-top: 0.125rem;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 2rem;
            color: white;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(-2px);
        }
        
        /* Central Element - Enso sederhana */
        .art-center {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .enso {
            width: 140px;
            height: 140px;
            border: 3px solid rgba(255, 183, 197, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        /* Brush stroke effect - subtle */
        .enso::before {
            content: '';
            position: absolute;
            top: -3px;
            right: -3px;
            width: 20px;
            height: 20px;
            background: var(--matcha);
            border-radius: 50%;
        }
        
        .enso-kanji {
            font-family: 'Shippori Mincho', serif;
            font-size: 2.5rem;
            color: var(--sakura-soft);
        }
        
        .tagline {
            text-align: center;
            margin-top: auto;
            position: relative;
            z-index: 1;
        }
        
        .tagline-jp {
            font-family: 'Shippori Mincho', serif;
            font-size: 1.25rem;
            color: white;
            margin-bottom: 0.25rem;
        }
        
        .tagline-id {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
        }
        
        /* Brush divider - structural */
        .brush-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--sakura), transparent);
            margin: 1.5rem auto 0;
            opacity: 0.7;
        }
        
        /* ===== RIGHT PANEL - Form ===== */
        .register-form-panel {
            flex: 1;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            background: white;
        }
        
        .form-header {
            margin-bottom: 1.5rem;
        }
        
        .form-header h1 {
            font-family: 'Shippori Mincho', 'Noto Sans JP', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--matcha);
            margin-bottom: 0.25rem;
        }
        
        /* Brush underline - animated once */
        .form-header h1::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--matcha-light), transparent);
            margin-top: 0.5rem;
            animation: brushDraw 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.3s forwards;
        }
        
        @keyframes brushDraw {
            to { width: 80px; }
        }
        
        .form-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.375rem;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--paper);
            border: 1px solid #E5E5E5;
            border-radius: 0.5rem;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23737373' stroke-width='2'%3E%3Cpolyline points='6,9 12,15 18,9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        
        .form-textarea {
            min-height: 90px;
            resize: vertical;
        }
        
        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #A3A3A3;
        }
        
        /* Focus Light - subtle glow */
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--matcha-light);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
        }
        
        .form-error {
            color: #DC2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        /* Submit Button - Sakura accent */
        .register-btn {
            width: 100%;
            padding: 0.875rem;
            background: var(--sakura);
            border: none;
            border-radius: 0.5rem;
            color: var(--matcha-deep);
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Noto Sans JP', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Focus light on hover */
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255, 183, 197, 0.3);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        .form-footer a {
            color: var(--matcha);
            text-decoration: none;
            font-weight: 500;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        /* Alert */
        .alert-success {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--matcha);
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            font-size: 0.9rem;
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .register-container {
                flex-direction: column;
            }
            
            .register-image {
                min-height: 280px;
                flex: none;
            }
            
            .enso {
                width: 100px;
                height: 100px;
            }
            
            .enso-kanji {
                font-size: 1.75rem;
            }
            
            .register-form-panel {
                padding: 1.75rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Matcha Dust - Spasial -->
    <div class="matcha-dust matcha-dust-1"></div>
    <div class="matcha-dust matcha-dust-2"></div>
    
    <div class="register-container">
        <!-- Left Panel -->
        <div class="register-image">
            <div class="register-image-header">
                <div class="register-brand">
                    <span class="register-brand-kanji">万歳</span>
                    <span class="register-brand-text">BANZAI</span>
                </div>
                <a href="{{ route('home') }}" class="back-link">← Kembali</a>
            </div>
            
            <div class="art-center">
                <div class="enso">
                    <span class="enso-kanji">入</span>
                </div>
            </div>
            
            <div class="tagline">
                <p class="tagline-jp">一期一会</p>
                <p class="tagline-id">Satu kesempatan, satu pertemuan</p>
                <div class="brush-divider"></div>
            </div>
        </div>
        
        <!-- Right Panel - Form -->
        <div class="register-form-panel">
            <div class="form-header">
                <h1>Daftar Anggota Baru</h1>
                <p>Mulai perjalananmu bersama BANZAI</p>
            </div>
            
            @if(session('success'))
                <div class="alert-success">✓ {{ session('success') }}</div>
            @endif
            
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input" 
                           placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="class" class="form-label">Kelas</label>
                        <select id="class" name="class" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                        @error('class')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="major" class="form-label">Jurusan</label>
                        <input type="text" id="major" name="major" class="form-input" 
                               placeholder="Contoh: RPL" value="{{ old('major') }}" required>
                        @error('major')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="preferred_division" class="form-label">Divisi yang Diminati</label>
                    <select id="preferred_division" name="preferred_division" class="form-select" required>
                        <option value="">Pilih Divisi</option>
                        <option value="bahasa" {{ old('preferred_division') == 'bahasa' ? 'selected' : '' }}>Divisi Bahasa — 静</option>
                        <option value="budaya" {{ old('preferred_division') == 'budaya' ? 'selected' : '' }}>Divisi Budaya — 華</option>
                        <option value="medsos" {{ old('preferred_division') == 'medsos' ? 'selected' : '' }}>Divisi Media Sosial — 動</option>
                    </select>
                    @error('preferred_division')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">WhatsApp</label>
                        <input type="tel" id="phone" name="phone" class="form-input" 
                               placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" 
                               placeholder="email@example.com" value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="reason" class="form-label">Alasan Bergabung</label>
                    <textarea id="reason" name="reason" class="form-textarea" 
                              placeholder="Ceritakan mengapa kamu tertarik..." required>{{ old('reason') }}</textarea>
                    @error('reason')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                
                <button type="submit" class="register-btn">Daftar Sekarang</button>
            </form>
            
            <p class="form-footer">
                <a href="{{ route('home') }}">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</body>
</html>
