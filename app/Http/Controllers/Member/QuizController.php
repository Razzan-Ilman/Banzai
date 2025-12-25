<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\QuizResult;
use App\Models\MemberGroupAssignment;
use App\Services\Quiz\QuizScoringService;
use App\Services\Quiz\QuizGroupResolver;
use App\Services\Quiz\QuizConsistencyService;
use App\Services\Quiz\TitleService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Personality quiz questions
     * Each answer has a point value (1-4)
     * Lower scores = analytical/structured personality (MUSASHI)
     * Higher scores = harmonious/collaborative personality (YAMATO)
     */
    private function getQuizQuestions(): array
    {
        return [
            [
                'question' => 'Ketika menghadapi masalah yang rumit, apa yang biasanya kamu lakukan pertama kali?',
                'options' => [
                    ['text' => 'Menganalisis dengan tenang, menyusun langkah-langkah detail', 'score' => 1],
                    ['text' => 'Mencari cara kreatif dan out of the box', 'score' => 2],
                    ['text' => 'Bertindak cepat dan beradaptasi seiring waktu', 'score' => 3],
                    ['text' => 'Berdiskusi dengan orang lain untuk mencari solusi bersama', 'score' => 4],
                ],
            ],
            [
                'question' => 'Bagaimana cara kamu menjalin pertemanan baru?',
                'options' => [
                    ['text' => 'Perlahan dan selektif, lebih suka hubungan mendalam', 'score' => 1],
                    ['text' => 'Melalui aktivitas kreatif atau hobi bersama', 'score' => 2],
                    ['text' => 'Mudah bergaul dan cepat akrab dengan siapa saja', 'score' => 3],
                    ['text' => 'Ramah dan terbuka, senang membantu orang lain', 'score' => 4],
                ],
            ],
            [
                'question' => 'Apa yang membuatmu merasa paling bersemangat?',
                'options' => [
                    ['text' => 'Menguasai skill baru hingga sempurna', 'score' => 1],
                    ['text' => 'Menciptakan sesuatu yang unik dan personal', 'score' => 2],
                    ['text' => 'Petualangan dan pengalaman baru', 'score' => 3],
                    ['text' => 'Membuat orang lain bahagia', 'score' => 4],
                ],
            ],
            [
                'question' => 'Ketika bekerja dalam tim, peran apa yang paling nyaman untukmu?',
                'options' => [
                    ['text' => 'Perencana/strategist yang menyusun konsep', 'score' => 1],
                    ['text' => 'Creative director yang membawa ide segar', 'score' => 2],
                    ['text' => 'Eksekutor yang bergerak cepat', 'score' => 3],
                    ['text' => 'Perantara yang menjaga harmoni tim', 'score' => 4],
                ],
            ],
            [
                'question' => 'Bagaimana kamu menghabiskan waktu luang idealmu?',
                'options' => [
                    ['text' => 'Membaca, belajar, atau mengasah kemampuan', 'score' => 1],
                    ['text' => 'Berkreasi: menggambar, musik, atau kerajinan', 'score' => 2],
                    ['text' => 'Jalan-jalan, eksplor tempat baru, atau olahraga', 'score' => 3],
                    ['text' => 'Quality time bersama keluarga atau teman', 'score' => 4],
                ],
            ],
            [
                'question' => 'Apa yang paling menggangumu?',
                'options' => [
                    ['text' => 'Ketidakteraturan dan kurangnya perencanaan', 'score' => 1],
                    ['text' => 'Kebosanan dan rutinitas monoton', 'score' => 2],
                    ['text' => 'Proses yang lambat dan tidak efisien', 'score' => 3],
                    ['text' => 'Konflik dan ketidakharmonisan', 'score' => 4],
                ],
            ],
            [
                'question' => 'Ketika menerima kritik, bagaimana responmu?',
                'options' => [
                    ['text' => 'Menganalisis objektif: mana yang valid, mana yang tidak', 'score' => 1],
                    ['text' => 'Melihatnya sebagai perspektif berbeda, menarik untuk direnungkan', 'score' => 2],
                    ['text' => 'Langsung action untuk perbaikan jika memang benar', 'score' => 3],
                    ['text' => 'Mencoba memahami konteks dan perasaan pemberi kritik', 'score' => 4],
                ],
            ],
            [
                'question' => 'Apa filosofi hidupmu yang paling dekat?',
                'options' => [
                    ['text' => 'Ketekunan dan kesempurnaan adalah kunci kesuksesan', 'score' => 1],
                    ['text' => 'Hidup adalah kanvas untuk diekspresikan', 'score' => 2],
                    ['text' => 'Kesempatan datang pada yang berani bertindak', 'score' => 3],
                    ['text' => 'Kebersamaan dan harmoni adalah segalanya', 'score' => 4],
                ],
            ],
            [
                'question' => 'Bagaimana cara kamu menghadapi perubahan mendadak?',
                'options' => [
                    ['text' => 'Hati-hati, perlu waktu untuk menyesuaikan rencana', 'score' => 1],
                    ['text' => 'Excited! Melihatnya sebagai peluang baru', 'score' => 2],
                    ['text' => 'Santai, langsung beradaptasi tanpa banyak pikir', 'score' => 3],
                    ['text' => 'Fokus menjaga agar semua orang tetap nyaman', 'score' => 4],
                ],
            ],
            [
                'question' => 'Apa yang paling membuatmu bangga pada diri sendiri?',
                'options' => [
                    ['text' => 'Keahlian dan pengetahuan yang sudah dikuasai', 'score' => 1],
                    ['text' => 'Karya dan kreasi yang sudah dibuat', 'score' => 2],
                    ['text' => 'Pengalaman dan pencapaian yang sudah diraih', 'score' => 3],
                    ['text' => 'Hubungan baik dengan orang-orang di sekitar', 'score' => 4],
                ],
            ],
        ];
    }

    /**
     * Show quiz page
     */
    public function index()
    {
        $user = auth()->user();
        
        // Check if already completed this month
        $existingResult = QuizResult::getLatestThisMonth($user->id);
        if ($existingResult) {
            return redirect()->route('member.quiz.result', $existingResult->id)
                ->with('info', 'Kamu sudah menyelesaikan quiz bulan ini!');
        }
        
        $questions = $this->getQuizQuestions();
        $titleProgress = TitleService::getProgress($user);
        
        return view('member.quiz.index', compact('questions', 'titleProgress'));
    }

    /**
     * Process quiz submission
     */
    public function submit(Request $request)
    {
        $user = auth()->user();
        
        // Validate answers (10 answers, each 1-4)
        $validated = $request->validate([
            'answers' => 'required|array|size:10',
            'answers.*' => 'required|integer|between:1,4',
        ]);
        
        // Calculate score using service
        $score = QuizScoringService::calculate($validated['answers']);
        
        // Resolve group using service
        $resolution = QuizGroupResolver::fromScore($score);
        $group = $resolution['group'];
        $isBorderline = $resolution['is_borderline'];
        
        // Check previous result
        $previousResult = QuizResult::getPreviousResult($user->id);
        $isSameAsPrevious = $previousResult && $previousResult->group_id === $group->id;
        
        // Delete existing this month (if re-taking)
        QuizResult::where('user_id', $user->id)
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->delete();
        
        // Save quiz result
        $quizResult = QuizResult::create([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'month' => now()->month,
            'year' => now()->year,
            'answers' => $validated['answers'],
            'scores' => [
                'total' => $score,
                'breakdown' => $validated['answers'],
            ],
            'total_score' => $score,
            'is_same_as_previous' => $isSameAsPrevious,
            'is_borderline' => $isBorderline,
        ]);
        
        // Update group assignment
        MemberGroupAssignment::updateOrCreate(
            ['user_id' => $user->id],
            [
                'group_id' => $group->id,
                'is_active' => true,
                'assigned_at' => now(),
            ]
        );
        
        // Evaluate and award title using service
        $titleResult = TitleService::evaluate($user->fresh(), $group);
        
        // Store title result in session for result page
        session(['quiz_title_result' => $titleResult]);
        
        return redirect()->route('member.quiz.result', $quizResult->id);
    }

    /**
     * Show quiz result
     */
    public function result($id)
    {
        $quizResult = QuizResult::with('group', 'user.title')->findOrFail($id);
        
        // Ensure it's the user's own result
        if ($quizResult->user_id !== auth()->id()) {
            abort(403);
        }
        
        $user = auth()->user();
        $titleResult = session('quiz_title_result', [
            'awarded' => false,
            'title' => null,
            'message' => null,
            'progress' => TitleService::getProgress($user)['progress'],
        ]);
        
        $consistency = QuizConsistencyService::check($user);
        $scoreStats = QuizScoringService::getStats($quizResult->total_score);
        
        return view('member.quiz.result', compact(
            'quizResult', 
            'titleResult', 
            'consistency',
            'scoreStats'
        ));
    }
}
