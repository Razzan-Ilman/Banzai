<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'class',
        'major',
        'position',
        'division_id',
        'position_id',
        'photo',
        'initial_color',
        'order',
        'is_active',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the division that the member belongs to.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the position that the member has.
     */
    public function positionRole(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * Scope to get only active members.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', 'active')->orderBy('order');
    }

    /**
     * Scope to get alumni members.
     */
    public function scopeAlumni($query)
    {
        return $query->where('status', 'alumni')->orderBy('end_date', 'desc');
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

    /**
     * Check if member is alumni.
     */
    public function isAlumni(): bool
    {
        return $this->status === 'alumni';
    }

    /**
     * Get display position name (from Position model or legacy field).
     */
    public function getDisplayPositionAttribute(): ?string
    {
        if ($this->positionRole) {
            return $this->positionRole->name;
        }
        return $this->position;
    }
}
