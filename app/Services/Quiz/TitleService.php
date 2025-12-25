<?php

namespace App\Services\Quiz;

use App\Contracts\Quiz\TitleServiceInterface;
use App\Models\Group;
use App\Models\Title;
use App\Models\User;
use App\Models\UserTitleHistory;

/**
 * TitleService
 * 
 * Service untuk mengelola title user.
 * Title diberikan jika user konsisten mendapat kelompok sama 3 dari 4 bulan.
 * 
 * @example
 * // Evaluasi dan award title
 * $result = TitleService::evaluate($user, $group);
 * // Result: ['awarded' => true, 'title' => Title, 'message' => '...']
 */
class TitleService implements TitleServiceInterface
{
    /**
     * Evaluasi dan award title jika eligible.
     *
     * @param User $user
     * @param Group $group Kelompok hasil quiz saat ini
     * @return array ['awarded' => bool, 'title' => Title|null, 'message' => string, 'progress' => string]
     */
    public function evaluate(User $user, Group $group): array
    {
        $consistency = QuizConsistencyService::check($user);

        // Belum eligible
        if (!$consistency['eligible']) {
            return [
                'awarded' => false,
                'title' => null,
                'message' => "Progress title: {$consistency['progress']}",
                'progress' => $consistency['progress'],
            ];
        }

        // Cari title untuk kelompok dominan
        $title = Title::forGroup($consistency['dominant_group']->name);

        if (!$title) {
            return [
                'awarded' => false,
                'title' => null,
                'message' => 'Title tidak ditemukan untuk kelompok',
                'progress' => $consistency['progress'],
            ];
        }

        // Sudah punya title ini
        if ($user->title_id === $title->id) {
            return [
                'awarded' => false,
                'title' => $title,
                'message' => 'Sudah memiliki title ini',
                'progress' => $consistency['progress'],
            ];
        }

        // Award title baru
        return $this->award($user, $title);
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function evaluateUser(User $user, Group $group): array
    {
        return (new self())->evaluate($user, $group);
    }

    /**
     * Award title ke user.
     *
     * @param User $user
     * @param Title $title
     * @return array
     */
    public function award(User $user, Title $title): array
    {
        // Cabut title sebelumnya jika ada
        if ($user->hasTitle()) {
            $this->revoke($user, 'Mendapat title baru');
        }

        // Update user
        $user->update([
            'title_id' => $title->id,
            'title_awarded_at' => now(),
        ]);

        // Buat history record
        UserTitleHistory::create([
            'user_id' => $user->id,
            'title_id' => $title->id,
            'awarded_at' => now(),
            'notes' => 'Achieved ' . QuizConsistencyService::getMinSameCount() . 
                       '/' . QuizConsistencyService::getRollingMonths() . 
                       ' month consistency',
        ]);

        return [
            'awarded' => true,
            'title' => $title,
            'message' => "Selamat! Kamu mendapat title {$title->display_name}!",
            'progress' => QuizConsistencyService::getMinSameCount() . 
                         '/' . QuizConsistencyService::getRollingMonths(),
        ];
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function awardTitle(User $user, Title $title): array
    {
        return (new self())->award($user, $title);
    }

    /**
     * Cabut title dari user.
     *
     * @param User $user
     * @param string|null $reason Alasan pencabutan
     * @return void
     */
    public function revoke(User $user, ?string $reason = null): void
    {
        if (!$user->hasTitle()) {
            return;
        }

        // Update history
        $activeHistory = UserTitleHistory::where('user_id', $user->id)
            ->where('title_id', $user->title_id)
            ->active()
            ->first();

        if ($activeHistory) {
            $activeHistory->revoke($reason);
        }

        // Hapus title dari user
        $user->update([
            'title_id' => null,
            'title_awarded_at' => null,
        ]);
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function revokeCurrentTitle(User $user, ?string $reason = null): void
    {
        (new self())->revoke($user, $reason);
    }

    /**
     * Dapatkan progress title user.
     *
     * @param User $user
     * @return array
     */
    public function getProgress(User $user): array
    {
        $consistency = QuizConsistencyService::check($user);
        
        return [
            'has_title' => $user->hasTitle(),
            'current_title' => $user->title,
            'progress' => $consistency['progress'],
            'eligible' => $consistency['eligible'],
            'dominant_group' => $consistency['dominant_group'],
            'months_detail' => QuizConsistencyService::getProgress($user),
        ];
    }

    /**
     * Static helper untuk backward compatibility.
     */
    public static function getTitleProgress(User $user): array
    {
        return (new self())->getProgress($user);
    }
}
