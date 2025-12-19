@extends('layouts.member')

@section('title', 'Hasil Quiz')

@section('content')
<style>
    .result-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .result-card {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        text-align: center;
        animation: scaleIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
    }

    .result-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, 
            {{ $quizResult->group->color }}, 
            {{ $quizResult->group->color }}88
        );
    }

    .result-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, 
            {{ $quizResult->group->color }}, 
            {{ $quizResult->group->color }}CC
        );
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.3s both;
        box-shadow: 0 12px 32px {{ $quizResult->group->color }}40;
    }

    .result-kanji {
        font-family: 'Noto Sans JP', serif;
        font-size: 5rem;
        font-weight: 700;
        background: linear-gradient(135deg, 
            {{ $quizResult->group->color }}, 
            {{ $quizResult->group->color }}88
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        animation: fadeInDown 0.6s ease 0.5s both;
    }

    .result-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 0.5rem;
        animation: fadeInUp 0.6s ease 0.6s both;
    }

    .result-subtitle {
        font-size: 1.25rem;
        color: #64748B;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease 0.7s both;
    }

    .result-description {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #334155;
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        border-radius: 16px;
        border-left: 4px solid {{ $quizResult->group->color }};
        animation: fadeInUp 0.6s ease 0.8s both;
    }

    .result-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        animation: fadeInUp 0.6s ease 0.9s both;
    }

    .stat-item {
        padding: 1.5rem;
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        border-color: {{ $quizResult->group->color }};
        transform: translateY(-4px);
        box-shadow: 0 8px 24px {{ $quizResult->group->color }}20;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #64748B;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: {{ $quizResult->group->color }};
    }

    .level-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, 
            {{ $quizResult->group->color }}, 
            {{ $quizResult->group->color }}CC
        );
        color: white;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease 1s both;
        box-shadow: 0 4px 16px {{ $quizResult->group->color }}40;
    }

    .btn-dashboard {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 3rem;
        background: linear-gradient(135deg, 
            {{ $quizResult->group->color }}, 
            {{ $quizResult->group->color }}CC
        );
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.125rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 24px {{ $quizResult->group->color }}40;
        animation: fadeInUp 0.6s ease 1.1s both;
    }

    .btn-dashboard:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 32px {{ $quizResult->group->color }}60;
    }

    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background: {{ $quizResult->group->color }};
        position: absolute;
        animation: confetti-fall 3s linear infinite;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    @keyframes confetti-fall {
        to {
            transform: translateY(100vh) rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .result-container {
            padding: 1rem;
        }

        .result-card {
            padding: 2rem 1.5rem;
        }

        .result-kanji {
            font-size: 3.5rem;
        }

        .result-title {
            font-size: 2rem;
        }

        .result-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="result-container">
    <div class="result-card">
        <div class="result-icon">
            @if($quizResult->group->name === 'MUSASHI')
                🥋
            @elseif($quizResult->group->name === 'AME-NO-UZUME')
                🌸
            @elseif($quizResult->group->name === 'FUJIN')
                🌪️
            @else
                🏯
            @endif
        </div>

        <div class="result-kanji">{{ $quizResult->group->kanji }}</div>
        <h1 class="result-title">{{ $quizResult->group->name }}</h1>
        <p class="result-subtitle">Kelompok Jepangmu</p>

        @if($quizResult->is_same_as_previous)
            <div class="level-badge">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span>Level {{ auth()->user()->memberProfile->level }} - 
                    @if(auth()->user()->memberProfile->level === 1)
                        Initiate
                    @elseif(auth()->user()->memberProfile->level === 2)
                        Adept
                    @else
                        Master
                    @endif
                </span>
            </div>
        @else
            <div class="level-badge">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                </svg>
                <span>Level 1 - Initiate (Kelompok Baru!)</span>
            </div>
        @endif

        <div class="result-description">
            {{ $quizResult->group->description }}
        </div>

        <div class="result-stats">
            <div class="stat-item">
                <div class="stat-label">Bulan</div>
                <div class="stat-value">{{ now()->format('M Y') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Level</div>
                <div class="stat-value">{{ auth()->user()->memberProfile->level }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">Points</div>
                <div class="stat-value">{{ auth()->user()->memberProfile->points }}</div>
            </div>
        </div>

        <a href="{{ route('member.dashboard') }}" class="btn-dashboard">
            <span>Lihat Dashboard Barumu</span>
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</div>

<script>
// Create confetti effect
function createConfetti() {
    const colors = ['{{ $quizResult->group->color }}', '{{ $quizResult->group->color }}88', '{{ $quizResult->group->color }}CC'];
    
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
            document.body.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 5000);
        }, i * 30);
    }
}

// Trigger confetti on load
window.addEventListener('load', createConfetti);
</script>
@endsection
