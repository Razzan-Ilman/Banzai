<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'date',
        'image',
        'location',
        'is_published',
        'is_featured',
    ];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the documentations for the activity.
     */
    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }

    /**
     * Scope to get only published activities.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('date', 'desc');
    }

    /**
     * Scope to get featured activities.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_published', true);
    }

    /**
     * Generate slug from title.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });
    }

    /**
     * Get formatted date in Indonesian.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->translatedFormat('d F Y');
    }
}
