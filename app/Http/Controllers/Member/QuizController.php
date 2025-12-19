<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\QuizResult;
use App\Models\MemberGroupAssignment;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Quiz questions with scoring weights
     * Format: question => [option => [group_name => score]]
     */
    private function getQuizQuestions()
    {
        return [
            [
                'question' => 'Ketika berada di dalam tim, peran apa yang paling sering kamu ambil?',
                'options' => [
                    'A' => [
                        'text' => 'Menyusun konsep dan memastikan semua detail benar',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 0, 'YAMATO' => 1]
                    ],
                    'B' => [
                        'text' => 'Menghidupkan suasana dan mengekspresikan ide kreatif',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Menyebarkan informasi dan bergerak cepat',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 0, 'FUJIN' => 3, 'YAMATO' => 1]
                    ],
                    'D' => [
                        'text' => 'Menjaga kekompakan dan arah tim',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Bagaimana cara kamu menyelesaikan masalah?',
                'options' => [
                    'A' => [
                        'text' => 'Menganalisis dengan tenang dan mencari solusi terbaik',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 1, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Mencari cara kreatif dan unik untuk menyelesaikannya',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Bertindak cepat dan adaptif',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 0, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Mengajak diskusi dan mencari konsensus',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Apa yang paling kamu nikmati saat berkontribusi di BANZAI?',
                'options' => [
                    'A' => [
                        'text' => 'Belajar hal baru dan menguasai skill',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 1]
                    ],
                    'B' => [
                        'text' => 'Mengekspresikan diri dan berkarya',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Berbagi informasi dan terhubung dengan banyak orang',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 1]
                    ],
                    'D' => [
                        'text' => 'Menjadi bagian dari keluarga besar BANZAI',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 1, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Ketika menghadapi deadline, kamu cenderung:',
                'options' => [
                    'A' => [
                        'text' => 'Menyusun rencana detail dan mengikutinya',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 1, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Bekerja dengan flow dan improvisasi',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Bergerak cepat dan multitasking',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 0, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Koordinasi dengan tim dan saling support',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Lingkungan kerja seperti apa yang membuatmu paling produktif?',
                'options' => [
                    'A' => [
                        'text' => 'Tenang, terstruktur, dan fokus',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 0, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Kreatif, bebas, dan ekspresif',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Dinamis, cepat, dan penuh energi',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Harmonis, supportif, dan kolaboratif',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Apa yang paling menggambarkan cara kamu berkomunikasi?',
                'options' => [
                    'A' => [
                        'text' => 'Jelas, to the point, dan terstruktur',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 1, 'YAMATO' => 1]
                    ],
                    'B' => [
                        'text' => 'Ekspresif, penuh cerita, dan emosional',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Cepat, ringkas, dan langsung action',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 0, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Mendengarkan dulu, lalu merespons dengan bijak',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Ketika ada ide baru, kamu biasanya:',
                'options' => [
                    'A' => [
                        'text' => 'Memikirkan detail dan kelayakannya',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 0, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Langsung excited dan ingin mengembangkannya',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Langsung share ke banyak orang',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Diskusikan dengan tim untuk feedback',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Apa yang membuatmu merasa paling bangga?',
                'options' => [
                    'A' => [
                        'text' => 'Menguasai skill baru dengan sempurna',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 1]
                    ],
                    'B' => [
                        'text' => 'Menciptakan sesuatu yang unik dan bermakna',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Menyebarkan impact ke banyak orang',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 1]
                    ],
                    'D' => [
                        'text' => 'Menjadi bagian dari pencapaian tim',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 1, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Bagaimana kamu menghadapi perubahan?',
                'options' => [
                    'A' => [
                        'text' => 'Menganalisis dulu, lalu menyesuaikan dengan hati-hati',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 0, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Melihatnya sebagai peluang untuk berkreasi',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Langsung adapt dan bergerak cepat',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Memastikan semua orang siap dan nyaman',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 0, 'YAMATO' => 3]
                    ],
                ],
            ],
            [
                'question' => 'Apa filosofi hidupmu yang paling dekat?',
                'options' => [
                    'A' => [
                        'text' => 'Konsistensi dan disiplin membawa kesempurnaan',
                        'scores' => ['MUSASHI' => 3, 'AME-NO-UZUME' => 0, 'FUJIN' => 0, 'YAMATO' => 2]
                    ],
                    'B' => [
                        'text' => 'Hidup adalah seni yang harus diekspresikan',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 3, 'FUJIN' => 1, 'YAMATO' => 0]
                    ],
                    'C' => [
                        'text' => 'Kecepatan dan adaptasi adalah kunci',
                        'scores' => ['MUSASHI' => 0, 'AME-NO-UZUME' => 1, 'FUJIN' => 3, 'YAMATO' => 0]
                    ],
                    'D' => [
                        'text' => 'Kebersamaan dan harmoni adalah segalanya',
                        'scores' => ['MUSASHI' => 1, 'AME-NO-UZUME' => 1, 'FUJIN' => 1, 'YAMATO' => 3]
                    ],
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
        if (QuizResult::hasCompletedThisMonth($user->id)) {
            return redirect()->route('member.dashboard')
                ->with('info', 'Kamu sudah menyelesaikan quiz bulan ini!');
        }
        
        $questions = $this->getQuizQuestions();
        
        return view('member.quiz.index', compact('questions'));
    }

    /**
     * Process quiz submission
     */
    public function submit(Request $request)
    {
        $user = auth()->user();
        
        // Check if already completed this month
        if (QuizResult::hasCompletedThisMonth($user->id)) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Kamu sudah menyelesaikan quiz bulan ini!');
        }
        
        // Validate answers
        $validated = $request->validate([
            'answers' => 'required|array|size:10',
            'answers.*' => 'required|in:A,B,C,D',
        ]);
        
        // Calculate scores
        $questions = $this->getQuizQuestions();
        $groupScores = [
            'MUSASHI' => 0,
            'AME-NO-UZUME' => 0,
            'FUJIN' => 0,
            'YAMATO' => 0,
        ];
        
        foreach ($validated['answers'] as $index => $answer) {
            $question = $questions[$index];
            $scores = $question['options'][$answer]['scores'];
            
            foreach ($scores as $groupName => $score) {
                $groupScores[$groupName] += $score;
            }
        }
        
        // Determine winning group
        $maxScore = max($groupScores);
        $winningGroups = array_keys($groupScores, $maxScore);
        
        // If tie, check previous result or default to YAMATO
        if (count($winningGroups) > 1) {
            $previousResult = QuizResult::getPreviousResult($user->id);
            if ($previousResult) {
                $previousGroupName = $previousResult->group->name;
                if (in_array($previousGroupName, $winningGroups)) {
                    $winningGroupName = $previousGroupName;
                } else {
                    $winningGroupName = in_array('YAMATO', $winningGroups) ? 'YAMATO' : $winningGroups[0];
                }
            } else {
                $winningGroupName = in_array('YAMATO', $winningGroups) ? 'YAMATO' : $winningGroups[0];
            }
        } else {
            $winningGroupName = $winningGroups[0];
        }
        
        // Get group
        $group = Group::where('name', $winningGroupName)->first();
        
        // Check if same as previous month
        $previousResult = QuizResult::getPreviousResult($user->id);
        $isSameAsPrevious = $previousResult && $previousResult->group_id === $group->id;
        
        // Save quiz result
        $quizResult = QuizResult::create([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'month' => now()->month,
            'year' => now()->year,
            'answers' => $validated['answers'],
            'scores' => $groupScores,
            'total_score' => $maxScore,
            'is_same_as_previous' => $isSameAsPrevious,
        ]);
        
        // Update or create group assignment
        MemberGroupAssignment::updateOrCreate(
            ['user_id' => $user->id],
            [
                'group_id' => $group->id,
                'is_active' => true,
                'assigned_at' => now(),
            ]
        );
        
        // Update member level
        $profile = $user->memberProfile;
        if ($isSameAsPrevious) {
            // Increase level (max 3)
            $profile->level = min($profile->level + 1, 3);
        } else {
            // Reset to level 1
            $profile->level = 1;
        }
        $profile->save();
        
        // Redirect to result page
        return redirect()->route('member.quiz.result', $quizResult->id);
    }

    /**
     * Show quiz result
     */
    public function result($id)
    {
        $quizResult = QuizResult::with('group')->findOrFail($id);
        
        // Make sure it's the current user's result
        if ($quizResult->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('member.quiz.result', compact('quizResult'));
    }
}
