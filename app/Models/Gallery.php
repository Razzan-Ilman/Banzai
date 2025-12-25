<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'event_id',
        'is_published',
        'created_by',
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order');
    }
    
    public function getPhotosCountAttribute(): int
    {
        return $this->photos()->count();
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
