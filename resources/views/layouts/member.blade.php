<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - BANZAI Member</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Adaptive UI System -->
    <link rel="stylesheet" href="{{ asset('css/member-adaptive-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member-group-themes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member-level-system.css') }}">
    
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            /* Member Colors - More Vibrant */
            --primary: #0EA5E9;
            --primary-dark: #0284C7;
            --secondary: #EC4899;
            --accent: #F59E0B;
            --success: #10B981;
            
            /* Neutrals */
            --ink-900: #1C1C1C;
            --neutral-800: #262626;
            --neutral-700: #404040;
            --neutral-600: #525252;
            --neutral-500: #737373;
            --neutral-400: #A3A3A3;
            --neutral-300: #D4D4D4;
            --neutral-200: #E5E5E5;
            --neutral-100: #F5F5F5;
            --neutral-50: #FAFAFA;
            
            /* Backgrounds */
            --bg-main: #F8FAFC;
            --bg-card: #FFFFFF;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--ink-900);
            min-height: 100vh;
        }
        
        .member-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* SIDEBAR - Personal & Colorful */
        .member-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0EA5E9 0%, #0284C7 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            box-shadow: 2px 0 12px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            text-align: center;
        }
        
        .user-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #EC4899, #F59E0B);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .user-name {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .user-role {
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        .user-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .stat-label {
            font-size: 0.75rem;
            opacity: 0.8;
            margin-top: 0.25rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            padding: 0.75rem 1.5rem 0.5rem;
            font-size: 0.6875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            opacity: 0.7;
            font-weight: 600;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9375rem;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        
        .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-left: 4px solid #F59E0B;
            font-weight: 600;
        }
        
        /* MAIN CONTENT */
        .member-main {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }
        
        /* TOPBAR - Colorful & Dynamic */
        .member-topbar {
            background: white;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--neutral-200);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0EA5E9, #EC4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-notification {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--neutral-100);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .btn-notification:hover {
            background: var(--neutral-200);
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background: #EF4444;
            border-radius: 50%;
            font-size: 0.625rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .btn-logout {
            background: none;
            border: 1px solid var(--neutral-300);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--neutral-700);
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: var(--neutral-100);
        }
        
        /* CONTENT AREA */
        .member-content {
            padding: 2rem;
        }
        
        /* CARDS - Colorful & Dynamic */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 1px solid var(--neutral-200);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--neutral-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--ink-900);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid;
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .stat-card.blue { border-color: #0EA5E9; }
        .stat-card.pink { border-color: #EC4899; }
        .stat-card.amber { border-color: #F59E0B; }
        .stat-card.green { border-color: #10B981; }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink-900);
            margin-bottom: 0.25rem;
        }
        
        .stat-text {
            font-size: 0.875rem;
            color: var(--neutral-600);
        }
        
        /* PROGRESS BAR */
        .progress-container {
            margin: 1rem 0;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: var(--neutral-700);
        }
        
        .progress-bar {
            height: 8px;
            background: var(--neutral-200);
            border-radius: 9999px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0EA5E9, #EC4899);
            border-radius: 9999px;
            transition: width 0.3s ease;
        }
        
        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 600;
        }
        
        .badge-primary { background: #DBEAFE; color: #1E40AF; }
        .badge-success { background: #D1FAE5; color: #065F46; }
        .badge-warning { background: #FEF3C7; color: #92400E; }
        
        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0EA5E9, #0284C7);
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #EC4899, #DB2777);
            color: white;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.4);
        }
        
        /* ALERT */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #D1FAE5;
            border-color: #10B981;
            color: #065F46;
        }
        
        /* UTILITIES */
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-4 { gap: 1rem; }
    </style>
</head>
<body>
    <div class="member-layout" 
         data-group="{{ strtolower(str_replace('_', '-', auth()->user()->currentGroup->group->name ?? 'musashi')) }}" 
         data-level="{{ auth()->user()->memberProfile->level ?? 1 }}">
        <!-- SIDEBAR -->
        <aside class="member-sidebar">
            <div class="sidebar-header">
                <div class="user-avatar-large">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Member BANZAI</div>
                
                <div class="user-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ auth()->user()->memberProfile->points ?? 0 }}</div>
                        <div class="stat-label">Poin</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ auth()->user()->memberProfile->level ?? 1 }}</div>
                        <div class="stat-label">Level</div>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">Menu Utama</div>
                <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('member.profile.index') }}" class="nav-link {{ request()->routeIs('member.profile.*') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>
                
                <div class="nav-section">Kegiatan</div>
                <a href="{{ route('member.events.index') }}" class="nav-link {{ request()->routeIs('member.events.*') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Event & Lomba
                </a>
                
                <a href="{{ route('member.attendance.index') }}" class="nav-link {{ request()->routeIs('member.attendance.*') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Absensi
                </a>
                
                <div class="nav-section">Lainnya</div>
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Website
                </a>
            </nav>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="member-main">
            <header class="member-topbar">
                <div class="topbar-left">
                    <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="topbar-actions">
                    <button class="btn-notification">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notification-badge">3</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </header>
            
            <div class="member-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Adaptive UI System -->
    <script src="{{ asset('js/member-adaptive-ui.js') }}"></script>
</body>
</html>
