<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documentation extends Model
{
    protected $fillable = [
        'title',
        'image',
        'activity_id',
        'description',
        'taken_at',
        'is_published',
        'order',
    ];

    protected $casts = [
        'taken_at' => 'date',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the activity that the documentation belongs to.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Scope to get only published documentations.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('order')->orderBy('created_at', 'desc');
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }
}
