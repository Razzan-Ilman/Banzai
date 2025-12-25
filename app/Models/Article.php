<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'thumbnail',
        'author_id',
        'status',
        'meta_title',
        'meta_description',
        'published_at',
        'scheduled_at',
        'views_count',
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
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
    
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }
    
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
    
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
    
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'berita' => 'Berita',
            'tips' => 'Tips & Trik',
            'budaya' => 'Budaya Jepang',
            'event' => 'Liputan Event',
            default => ucfirst($this->category),
        };
    }
    
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'scheduled' => 'Terjadwal',
            'published' => 'Terbit',
            default => $this->status,
        };
    }
    
    public function getReadTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // 200 words per minute
    }
}
