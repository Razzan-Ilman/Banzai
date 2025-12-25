<?php

namespace App\Services\Quiz;

use App\Models\QuizResult;
use App\Models\User;

/**
 * QuizConsistencyService
 * 
 * Service untuk mengecek konsistensi kelompok user.
 * Menggunakan rolling consistency (3 dari 4 bulan terakhir).
 * 
 * @example
 * // Check konsistensi user
 * $consistency = QuizConsistencyService::check($user);
 * // Result: ['count' => 3, 'eligible' => true, 'dominant_group' => Group, 'progress' => '3/4']
 */
class QuizConsistencyService
{
    /**
     * Check rolling consistency user.
     *
     * @param User $user
     * @return array
     */
    public static function check(User $user): array
    {
        return QuizResult::getRollingConsistency($user->id);
    }

    /**
     * Check apakah user eligible untuk title.
     *
     * @param User $user
     * @return bool
     */
    public static function isEligibleForTitle(User $user): bool
    {
        $consistency = self::check($user);
        return $consistency['eligible'];
    }

    /**
     * Dapatkan progress konsistensi per bulan.
     *
     * @param User $user
     * @return array
     */
    public static function getProgress(User $user): array
    {
        $rollingMonths = config('quiz.title.rolling_months', 4);
        $results = QuizResult::getLastNMonths($user->id, $rollingMonths);
        
        $progress = [];
        $date = now();

        for ($i = 0; $i < $rollingMonths; $i++) {
            $monthResult = $results->first(function ($r) use ($date) {
                return $r->month === $date->month && $r->year === $date->year;
            });

            $progress[] = [
                'month' => $date->format('M Y'),
                'completed' => !is_null($monthResult),
                'group' => $monthResult?->group?->name,
                'group_kanji' => $monthResult?->group?->kanji,
                'is_borderline' => $monthResult?->is_borderline ?? false,
            ];

            $date = $date->subMonth();
        }

        return $progress;
    }

    /**
     * Dapatkan streak (berturut-turut kelompok sama).
     *
     * @param User $user
     * @return int
     */
    public static function getStreak(User $user): int
    {
        $results = QuizResult::getLastNMonths($user->id, 12);
        
        if ($results->isEmpty()) {
            return 0;
        }

        $streak = 1;
        $previousGroupId = $results->first()->group_id;

        foreach ($results->skip(1) as $result) {
            if ($result->group_id === $previousGroupId) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Dapatkan jumlah bulan untuk rolling check.
     *
     * @return int
     */
    public static function getRollingMonths(): int
    {
        return config('quiz.title.rolling_months', 4);
    }

    /**
     * Dapatkan minimal count untuk title.
     *
     * @return int
     */
    public static function getMinSameCount(): int
    {
        return config('quiz.title.min_same_count', 3);
    }
}
