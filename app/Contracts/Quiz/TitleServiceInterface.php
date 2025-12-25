<?php

namespace App\Contracts\Quiz;

use App\Models\User;
use App\Models\Group;

/**
 * Interface TitleServiceInterface
 * 
 * Kontrak untuk service yang mengelola title.
 * Implement interface ini jika ingin mengubah logika pemberian title.
 */
interface TitleServiceInterface
{
    /**
     * Evaluasi dan award title jika eligible.
     *
     * @param User $user
     * @param Group $group Kelompok hasil quiz saat ini
     * @return array ['awarded' => bool, 'title' => Title|null, 'message' => string]
     */
    public function evaluate(User $user, Group $group): array;

    /**
     * Cabut title dari user.
     *
     * @param User $user
     * @param string|null $reason Alasan pencabutan
     * @return void
     */
    public function revoke(User $user, ?string $reason = null): void;

    /**
     * Dapatkan progress title user.
     *
     * @param User $user
     * @return array
     */
    public function getProgress(User $user): array;
}
