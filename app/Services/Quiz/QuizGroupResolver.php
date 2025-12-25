<?php

namespace App\Services\Quiz;

use App\Contracts\Quiz\QuizGroupResolverInterface;
use App\Models\Group;

/**
 * QuizGroupResolver
 * 
 * Service untuk menentukan kelompok berdasarkan skor quiz.
 * Menggunakan range skor dari config/quiz.php.
 * 
 * @example
 * // Tentukan kelompok dari skor
 * $result = QuizGroupResolver::resolve(25);
 * // Result: ['group' => Group, 'group_name' => 'AME-NO-UZUME', 'is_borderline' => true]
 */
class QuizGroupResolver implements QuizGroupResolverInterface
{
    /**
     * Tentukan kelompok dari skor.
     *
     * @param int $score Total skor quiz
     * @return array ['group' => Group, 'group_name' => string, 'is_borderline' => bool]
     */
    public function fromScore(int $score): array
    {
        $groupName = $this->getGroupNameFromScore($score);
        $group = Group::where('name', $groupName)->first();
        $isBorderline = $this->isBorderline($score);

        return [
            'group' => $group,
            'group_name' => $groupName,
            'is_borderline' => $isBorderline,
        ];
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function resolve(int $score): array
    {
        return (new self())->fromScore($score);
    }

    /**
     * Dapatkan nama kelompok dari skor.
     *
     * @param int $score
     * @return string
     */
    public function getGroupNameFromScore(int $score): string
    {
        $groups = config('quiz.groups', []);

        foreach ($groups as $groupName => $config) {
            if ($score >= $config['min'] && $score <= $config['max']) {
                return $groupName;
            }
        }

        // Default fallback
        $firstGroup = array_key_first($groups);
        $lastGroup = array_key_last($groups);
        
        if ($score < ($groups[$firstGroup]['min'] ?? 10)) {
            return $firstGroup;
        }
        return $lastGroup;
    }

    /**
     * Check apakah skor termasuk borderline.
     *
     * @param int $score
     * @return bool
     */
    public function isBorderline(int $score): bool
    {
        $borderlineScores = config('quiz.borderline_scores', []);
        return in_array($score, $borderlineScores);
    }

    /**
     * Dapatkan semua range kelompok.
     *
     * @return array
     */
    public function getRanges(): array
    {
        return config('quiz.groups', []);
    }

    /**
     * Dapatkan kelompok terdekat untuk borderline score.
     *
     * @param int $score
     * @return array|null
     */
    public function getNearestGroups(int $score): ?array
    {
        if (!$this->isBorderline($score)) {
            return null;
        }

        $groups = config('quiz.groups', []);
        $groupNames = array_keys($groups);
        
        foreach ($groups as $index => $config) {
            if ($score === $config['max']) {
                $currentIndex = array_search($index, $groupNames);
                $nextGroup = $groupNames[$currentIndex + 1] ?? null;
                if ($nextGroup) {
                    return [$index, $nextGroup];
                }
            }
            if ($score === $config['min']) {
                $currentIndex = array_search($index, $groupNames);
                $prevGroup = $groupNames[$currentIndex - 1] ?? null;
                if ($prevGroup) {
                    return [$prevGroup, $index];
                }
            }
        }

        return null;
    }
}
