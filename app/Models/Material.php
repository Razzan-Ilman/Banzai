<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Material extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'title',
        'slug',
        'type',
        'content',
        'category',
        'difficulty_level',
        'thumbnail',
        'file_path',
        'external_url',
        'views_count',
        'duration_minutes',
        'created_by',
        'is_published',
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
    
    public function progress(): HasMany
    {
        return $this->hasMany(MaterialProgress::class);
    }
    
    public function userProgress($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->progress()->where('user_id', $userId)->first();
    }
    
    public function isCompletedBy($userId = null): bool
    {
        $progress = $this->userProgress($userId);
        return $progress && $progress->is_completed;
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
    
    public function scopeByDifficulty($query, string $level)
    {
        return $query->where('difficulty_level', $level);
    }
    
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
    
    public function getDifficultyLabelAttribute(): string
    {
        return match($this->difficulty_level) {
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan',
            default => $this->difficulty_level,
        };
    }
    
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'hiragana' => 'Hiragana',
            'katakana' => 'Katakana',
            'kanji' => 'Kanji',
            'grammar' => 'Tata Bahasa',
            'culture' => 'Budaya',
            'umum' => 'Umum',
            default => ucfirst($this->category),
        };
    }
    
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'text' => 'Artikel',
            'video' => 'Video',
            'pdf' => 'PDF',
            'external' => 'Link Eksternal',
            default => $this->type,
        };
    }
}
