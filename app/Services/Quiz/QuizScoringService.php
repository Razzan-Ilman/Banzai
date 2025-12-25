<?php

namespace App\Services\Quiz;

use App\Contracts\Quiz\QuizScoringInterface;

/**
 * QuizScoringService
 * 
 * Service untuk menghitung skor quiz kepribadian.
 * Setiap jawaban bernilai 1-4 poin.
 * 
 * @example
 * // Hitung skor
 * $score = QuizScoringService::calculate([1, 2, 3, 4, 2, 3, 4, 1, 2, 3]);
 * // Result: 25
 */
class QuizScoringService implements QuizScoringInterface
{
    /**
     * Hitung total skor dari jawaban quiz.
     *
     * @param array $answers Array nilai jawaban (1-4)
     * @return int Total skor (10-40 untuk 10 pertanyaan)
     */
    public function calculate(array $answers): int
    {
        return array_sum($answers);
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function calc(array $answers): int
    {
        return (new self())->calculate($answers);
    }

    /**
     * Validasi format jawaban.
     *
     * @param array $answers
     * @return bool True jika valid
     */
    public function validate(array $answers): bool
    {
        $questionsCount = config('quiz.questions_count', 10);
        $minScore = config('quiz.score_per_question.min', 1);
        $maxScore = config('quiz.score_per_question.max', 4);

        if (count($answers) !== $questionsCount) {
            return false;
        }

        foreach ($answers as $answer) {
            if (!is_numeric($answer) || $answer < $minScore || $answer > $maxScore) {
                return false;
            }
        }

        return true;
    }

    /**
     * Dapatkan statistik skor.
     *
     * @param int $score
     * @return array
     */
    public function getStats(int $score): array
    {
        $questionsCount = config('quiz.questions_count', 10);
        $minPerQ = config('quiz.score_per_question.min', 1);
        $maxPerQ = config('quiz.score_per_question.max', 4);
        
        $minScore = $questionsCount * $minPerQ;
        $maxScore = $questionsCount * $maxPerQ;
        
        $percentage = round((($score - $minScore) / ($maxScore - $minScore)) * 100, 1);
        
        return [
            'score' => $score,
            'min' => $minScore,
            'max' => $maxScore,
            'percentage' => $percentage,
        ];
    }
}
