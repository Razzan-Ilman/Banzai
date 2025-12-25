<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
    ];

    /**
     * Get the members that have this position.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get active members with this position.
     */
    public function activeMembers(): HasMany
    {
        return $this->hasMany(Member::class)->where('status', 'active');
    }

    /**
     * Scope to get only active positions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('level');
    }

    /**
     * Scope to order by hierarchy level.
     */
    public function scopeByLevel($query)
    {
        return $query->orderBy('level');
    }
}
