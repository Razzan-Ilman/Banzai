<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - BANZAI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Phase 0: UI Foundation -->
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    <!-- Phase 9: No-JS Fallback -->
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/no-js.css') }}">
    </noscript>
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- NO NAVIGATION - Clean layout for auth pages -->
    
    @yield('content')

    @stack('scripts')
</body>
</html>
