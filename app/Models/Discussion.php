<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Discussion extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'category',
        'is_pinned',
        'is_locked',
        'views_count',
        'replies_count',
        'last_reply_at',
    ];
    
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_reply_at' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . Str::random(6);
            }
        });
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class)->orderBy('created_at');
    }
    
    public function latestReply()
    {
        return $this->hasOne(DiscussionReply::class)->latest();
    }
    
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
    
    public function scopeNotPinned($query)
    {
        return $query->where('is_pinned', false);
    }
    
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
    
    public function scopeRecent($query)
    {
        return $query->orderByDesc('last_reply_at')
                     ->orderByDesc('created_at');
    }
    
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
    
    public function incrementReplies(): void
    {
        $this->increment('replies_count');
        $this->update(['last_reply_at' => now()]);
    }
    
    public function decrementReplies(): void
    {
        $this->decrement('replies_count');
    }
    
    public function isOwnedBy($userId): bool
    {
        return $this->user_id === $userId;
    }
    
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'belajar' => 'Belajar',
            'event' => 'Event',
            'off-topic' => 'Off Topic',
            'umum' => 'Umum',
            default => ucfirst($this->category),
        };
    }
    
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'belajar' => '#10B981',
            'event' => '#F59E0B',
            'off-topic' => '#6B7280',
            'umum' => '#0EA5E9',
            default => '#737373',
        };
    }
}
