<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionReply extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
        'parent_id',
    ];
    
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(DiscussionReply::class, 'parent_id');
    }
    
    public function isOwnedBy($userId): bool
    {
        return $this->user_id === $userId;
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($reply) {
            $reply->discussion->incrementReplies();
        });
        
        static::deleted(function ($reply) {
            $reply->discussion->decrementReplies();
        });
    }
}
