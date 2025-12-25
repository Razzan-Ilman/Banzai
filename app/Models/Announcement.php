<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'is_published',
        'published_at',
        'expires_at',
        'created_by',
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function targets(): HasMany
    {
        return $this->hasMany(AnnouncementTarget::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }
    
    public function scopeForUser($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->whereHas('targets', function ($t) {
                $t->where('target_type', 'all');
            })
            ->orWhereHas('targets', function ($t) use ($user) {
                $t->where('target_type', 'role')
                  ->where('target_value', $user->role);
            })
            ->orWhereHas('targets', function ($t) use ($user) {
                $t->where('target_type', 'user')
                  ->where('target_value', $user->id);
            });
        });
    }
    
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'info' => '#0EA5E9',
            'warning' => '#F59E0B',
            'success' => '#10B981',
            'event' => '#EC4899',
            default => '#737373',
        };
    }
    
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak',
            default => $this->priority,
        };
    }
}
