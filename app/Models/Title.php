<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Title extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kanji',
        'group',
        'description',
    ];

    /**
     * Get users who currently have this title
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get title history records
     */
    public function histories(): HasMany
    {
        return $this->hasMany(UserTitleHistory::class);
    }

    /**
     * Get title by group name
     */
    public static function forGroup(string $groupName): ?self
    {
        return self::where('group', $groupName)->first();
    }

    /**
     * Get display name with kanji
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name_kanji} ({$this->name})";
    }
}
