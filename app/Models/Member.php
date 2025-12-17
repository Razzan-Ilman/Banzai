<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $fillable = [
        'name',
        'class',
        'major',
        'position',
        'division_id',
        'photo',
        'initial_color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the division that the member belongs to.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Scope to get only active members.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope to get leaders (Ketua/Wakil).
     */
    public function scopeLeaders($query)
    {
        return $query->whereIn('position', ['Ketua', 'Wakil Ketua'])->orderBy('order');
    }

    /**
     * Get the first letter of member name for initial display.
     */
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Get the initial color, fallback to division color or default.
     */
    public function getDisplayColorAttribute(): string
    {
        if ($this->initial_color) {
            return $this->initial_color;
        }
        
        if ($this->division) {
            return $this->division->color;
        }
        
        return '#064E3B'; // Default primary green
    }

    /**
     * Check if member has a photo.
     */
    public function hasPhoto(): bool
    {
        return !empty($this->photo);
    }
}
