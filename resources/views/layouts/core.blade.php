<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - BANZAI CORE</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            /* Calm Authority Colors */
            --ink-900: #1C1C1C;
            --ink-800: #2D2D2D;
            --ink-700: #404040;
            --neutral-600: #525252;
            --neutral-500: #737373;
            --neutral-400: #A3A3A3;
            --neutral-300: #D4D4D4;
            --neutral-200: #E5E5E5;
            --neutral-100: #F5F5F5;
            --neutral-50: #FAFAFA;
            --ivory: #F7F6F3;
            --gold: #C7A14A;
            --gold-dark: #A68B3A;
            
            /* Status Colors */
            --status-pending: #F59E0B;
            --status-active: #10B981;
            --status-inactive: #6B7280;
            --status-danger: #EF4444;
            
            /* Division Colors (subtle) */
            --div-bahasa: #06B6D4;
            --div-budaya: #8B5CF6;
            --div-medsos: #F59E0B;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--neutral-100);
            color: var(--ink-900);
            min-height: 100vh;
        }
        
        .core-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* SIDEBAR - Command Center Style */
        .core-sidebar {
            width: 260px;
            background: var(--ink-900);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            border-right: 1px solid var(--ink-800);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-kanji {
            font-family: 'Noto Sans JP', serif;
            font-size: 0.875rem;
            color: var(--gold);
            margin-bottom: 0.25rem;
        }
        
        .sidebar-brand {
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        
        .sidebar-role {
            font-size: 0.75rem;
            color: var(--neutral-400);
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
            color: var(--neutral-500);
            font-weight: 600;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9375rem;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }
        
        .nav-link.active {
            background: rgba(199, 161, 74, 0.15);
            color: var(--gold);
            border-left: 3px solid var(--gold);
        }
        
        .nav-link svg {
            flex-shrink: 0;
        }
        
        /* MAIN CONTENT */
        .core-main {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }
        
        /* TOPBAR - Minimal & Functional */
        .core-topbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--neutral-200);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .topbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--ink-900);
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--neutral-600);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gold);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        .btn-logout {
            background: none;
            border: 1px solid var(--neutral-300);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--neutral-600);
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: var(--neutral-100);
            border-color: var(--neutral-400);
        }
        
        /* CONTENT AREA */
        .core-content {
            padding: 2rem;
        }
        
        /* STATS CARDS - Overview Cepat */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid var(--neutral-200);
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            border-color: var(--neutral-300);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: var(--neutral-600);
            font-weight: 500;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink-900);
            margin-bottom: 0.25rem;
        }
        
        .stat-change {
            font-size: 0.75rem;
            color: var(--neutral-500);
        }
        
        /* CARDS */
        .card {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--neutral-200);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--neutral-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink-900);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* TABLES - Clean & Structured */
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 0.875rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--neutral-200);
        }
        
        th {
            background: var(--neutral-50);
            font-weight: 600;
            font-size: 0.8125rem;
            color: var(--neutral-700);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        tr:hover {
            background: var(--neutral-50);
        }
        
        /* BADGES - Status Indicators */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-pending { background: #FEF3C7; color: #92400E; }
        .badge-active { background: #D1FAE5; color: #065F46; }
        .badge-inactive { background: #F3F4F6; color: #374151; }
        .badge-danger { background: #FEE2E2; color: #991B1B; }
        
        /* BUTTONS - Minimal & Clear */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: var(--gold);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--gold-dark);
        }
        
        .btn-secondary {
            background: var(--ink-900);
            color: white;
        }
        
        .btn-secondary:hover {
            background: var(--ink-800);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--neutral-300);
            color: var(--neutral-700);
        }
        
        .btn-outline:hover {
            background: var(--neutral-50);
            border-color: var(--neutral-400);
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }
        
        /* ALERTS */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #D1FAE5;
            border-color: #10B981;
            color: #065F46;
        }
        
        /* UTILITIES */
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
    </style>
</head>
<body>
    <div class="core-layout">
        <!-- SIDEBAR -->
        <aside class="core-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-kanji">万歳</div>
                <div class="sidebar-brand">BANZAI CORE</div>
                <div class="sidebar-role">Command Center</div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">Overview</div>
                <a href="{{ route('core.dashboard') }}" class="nav-link {{ request()->routeIs('core.dashboard') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Dashboard
                </a>
                
                <div class="nav-section">Manajemen</div>
                <a href="{{ route('core.members.index') }}" class="nav-link {{ request()->routeIs('core.members.*') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Anggota
                </a>
                
                <a href="{{ route('core.candidates.index') }}" class="nav-link {{ request()->routeIs('core.candidates.*') ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Verifikasi Candidate
                </a>
                
                <a href="#" class="nav-link">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Kegiatan & Event
                </a>
                
                <div class="nav-section">Dokumentasi</div>
                <a href="#" class="nav-link">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Timeline Jabatan
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
        <main class="core-main">
            <header class="core-topbar">
                <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>
                <div class="topbar-actions">
                    <div class="topbar-user">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </header>
            
            <div class="core-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
