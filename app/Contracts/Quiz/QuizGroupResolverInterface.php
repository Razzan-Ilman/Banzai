<?php

namespace App\Contracts\Quiz;

use App\Models\Group;

/**
 * Interface QuizGroupResolverInterface
 * 
 * Kontrak untuk service yang menentukan kelompok dari skor.
 * Implement interface ini jika ingin mengubah logika penentuan kelompok.
 */
interface QuizGroupResolverInterface
{
    /**
     * Tentukan kelompok dari skor.
     *
     * @param int $score Total skor quiz
     * @return array ['group' => Group, 'group_name' => string, 'is_borderline' => bool]
     */
    public function fromScore(int $score): array;

    /**
     * Check apakah skor termasuk borderline.
     *
     * @param int $score
     * @return bool
     */
    public function isBorderline(int $score): bool;
}
