@extends('layouts.member')

@section('title', 'Quiz Kelompok')

@section('content')
<style>
    .quiz-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }

    .quiz-header {
        text-align: center;
        margin-bottom: 3rem;
        animation: fadeInDown 0.6s ease;
    }

    .quiz-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #0EA5E9, #EC4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }

    .quiz-header .kanji {
        font-family: 'Noto Sans JP', serif;
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .quiz-header p {
        font-size: 1.125rem;
        color: #64748B;
        max-width: 600px;
        margin: 0 auto;
    }

    .quiz-form {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .question-card {
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        border-radius: 16px;
        border-left: 4px solid #0EA5E9;
        animation: fadeInUp 0.6s ease;
        animation-fill-mode: both;
    }

    .question-card:nth-child(1) { animation-delay: 0.1s; }
    .question-card:nth-child(2) { animation-delay: 0.15s; }
    .question-card:nth-child(3) { animation-delay: 0.2s; }
    .question-card:nth-child(4) { animation-delay: 0.25s; }
    .question-card:nth-child(5) { animation-delay: 0.3s; }

    .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #0EA5E9, #06B6D4);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .question-text {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0F172A;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .options-grid {
        display: grid;
        gap: 1rem;
    }

    .option-label {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .option-label:hover {
        border-color: #0EA5E9;
        background: #F0F9FF;
        transform: translateX(4px);
    }

    .option-label input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .option-label input[type="radio"]:checked ~ .option-content {
        color: #0EA5E9;
        font-weight: 600;
    }

    .option-label input[type="radio"]:checked ~ .option-indicator {
        background: linear-gradient(135deg, #0EA5E9, #06B6D4);
        border-color: #0EA5E9;
    }

    .option-label input[type="radio"]:checked ~ .option-indicator::after {
        opacity: 1;
        transform: scale(1);
    }

    .option-indicator {
        width: 24px;
        height: 24px;
        border: 2px solid #CBD5E1;
        border-radius: 50%;
        margin-right: 1rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
    }

    .option-indicator::after {
        content: '✓';
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        opacity: 0;
        transform: scale(0);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .option-letter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: #F1F5F9;
        color: #64748B;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.875rem;
        margin-right: 1rem;
    }

    .option-content {
        flex: 1;
        color: #334155;
        font-size: 1rem;
        line-height: 1.5;
        transition: all 0.3s ease;
    }

    .submit-section {
        margin-top: 3rem;
        text-align: center;
        padding-top: 2rem;
        border-top: 2px solid #E2E8F0;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 3rem;
        background: linear-gradient(135deg, #0EA5E9, #06B6D4);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 32px rgba(14, 165, 233, 0.4);
    }

    .btn-submit:active {
        transform: translateY(-1px) scale(0.98);
    }

    .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #0EA5E9, #EC4899);
        transition: width 0.3s ease;
        z-index: 9999;
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

    @media (max-width: 768px) {
        .quiz-container {
            padding: 1rem;
        }

        .quiz-header h1 {
            font-size: 2rem;
        }

        .quiz-header .kanji {
            font-size: 2.5rem;
        }

        .quiz-form {
            padding: 1.5rem;
        }

        .question-card {
            padding: 1.5rem;
        }

        .option-label {
            padding: 1rem;
        }
    }
</style>

<div class="progress-bar" id="progressBar"></div>

<div class="quiz-container">
    <div class="quiz-header">
        <div class="kanji">問</div>
        <h1>Quiz Kelompok BANZAI</h1>
        <p>Jawab 10 pertanyaan ini untuk mengetahui kelompok Jepang yang sesuai dengan karaktermu. Tidak ada jawaban benar atau salah, pilih yang paling menggambarkan dirimu.</p>
    </div>

    <form action="{{ route('member.quiz.submit') }}" method="POST" id="quizForm" class="quiz-form">
        @csrf

        @foreach($questions as $index => $question)
        <div class="question-card">
            <div class="question-number">{{ $index + 1 }}</div>
            <div class="question-text">{{ $question['question'] }}</div>
            
            <div class="options-grid">
                @foreach($question['options'] as $letter => $option)
                <label class="option-label">
                    <input 
                        type="radio" 
                        name="answers[{{ $index }}]" 
                        value="{{ $letter }}" 
                        required
                        onchange="updateProgress()"
                    >
                    <div class="option-indicator"></div>
                    <div class="option-letter">{{ $letter }}</div>
                    <div class="option-content">{{ $option['text'] }}</div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="submit-section">
            <button type="submit" class="btn-submit">
                <span>Lihat Hasil Kelompokku</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
function updateProgress() {
    const form = document.getElementById('quizForm');
    const totalQuestions = {{ count($questions) }};
    const answeredQuestions = form.querySelectorAll('input[type="radio"]:checked').length;
    const progress = (answeredQuestions / totalQuestions) * 100;
    
    document.getElementById('progressBar').style.width = progress + '%';
}

// Prevent accidental page leave
window.addEventListener('beforeunload', function (e) {
    const form = document.getElementById('quizForm');
    const answeredQuestions = form.querySelectorAll('input[type="radio"]:checked').length;
    
    if (answeredQuestions > 0 && answeredQuestions < {{ count($questions) }}) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Form validation
document.getElementById('quizForm').addEventListener('submit', function(e) {
    const totalQuestions = {{ count($questions) }};
    const answeredQuestions = this.querySelectorAll('input[type="radio"]:checked').length;
    
    if (answeredQuestions < totalQuestions) {
        e.preventDefault();
        alert('Mohon jawab semua pertanyaan sebelum submit!');
        
        // Scroll to first unanswered question
        const firstUnanswered = this.querySelector('.question-card:not(:has(input:checked))');
        if (firstUnanswered) {
            firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstUnanswered.style.animation = 'shake 0.5s';
        }
    }
});
</script>
@endsection
