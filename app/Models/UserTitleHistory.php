<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTitleHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title_id',
        'awarded_at',
        'revoked_at',
        'notes',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the title
     */
    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class);
    }

    /**
     * Check if title is currently active
     */
    public function isActive(): bool
    {
        return is_null($this->revoked_at);
    }

    /**
     * Scope for active titles
     */
    public function scopeActive($query)
    {
        return $query->whereNull('revoked_at');
    }

    /**
     * Revoke this title
     */
    public function revoke(string $reason = null): void
    {
        $this->update([
            'revoked_at' => now(),
            'notes' => $reason ? ($this->notes . ' | Revoked: ' . $reason) : $this->notes,
        ]);
    }
}
