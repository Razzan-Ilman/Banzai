<?php

namespace App\Contracts\Quiz;

/**
 * Interface QuizScoringInterface
 * 
 * Kontrak untuk service yang menghitung skor quiz.
 * Implement interface ini jika ingin membuat algoritma scoring berbeda.
 */
interface QuizScoringInterface
{
    /**
     * Hitung total skor dari jawaban quiz.
     *
     * @param array $answers Array nilai jawaban (1-4)
     * @return int Total skor
     */
    public function calculate(array $answers): int;

    /**
     * Validasi format jawaban.
     *
     * @param array $answers
     * @return bool
     */
    public function validate(array $answers): bool;
}
