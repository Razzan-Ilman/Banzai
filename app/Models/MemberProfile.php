<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberProfile extends Model
{
    protected $fillable = [
        'user_id',
        'member_number',
        'division_id',
        'level',
        'points',
        'xp',
        'is_active',
        'photo',
        'bio',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
        'points' => 'integer',
        'xp' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function groupAssignments(): HasMany
    {
        return $this->hasMany(MemberGroupAssignment::class, 'user_id', 'user_id');
    }

    public function currentGroup()
    {
        return $this->groupAssignments()
            ->where('is_active', true)
            ->where('month_start', '<=', now())
            ->where('month_end', '>=', now())
            ->with('group')
            ->first();
    }

    public function medals(): HasMany
    {
        return $this->hasMany(MemberMedal::class, 'user_id', 'user_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(MemberAttendance::class, 'user_id', 'user_id');
    }

    // Helper methods
    public function getLevelName(): string
    {
        return match($this->level) {
            1 => 'Initiate',
            2 => 'Adept',
            3 => 'Master',
            default => 'Unknown'
        };
    }

    public function getXpProgress(): int
    {
        $xpNeeded = $this->level * 100; // Level 1 = 100 XP, Level 2 = 200 XP, etc
        return min(100, ($this->xp / $xpNeeded) * 100);
    }
}
