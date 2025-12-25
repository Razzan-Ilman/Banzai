<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];
    
    /**
     * User yang melakukan aksi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Subject/model yang terpengaruh
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Scope untuk filter by action
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }
    
    /**
     * Scope untuk filter by subject type
     */
    public function scopeForSubject($query, $subject)
    {
        return $query->where('subject_type', get_class($subject))
                     ->where('subject_id', $subject->getKey());
    }
    
    /**
     * Scope untuk filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    /**
     * Scope untuk rentang waktu
     */
    public function scopeBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }
    
    /**
     * Get formatted action label
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Membuat',
            'updated' => 'Mengubah',
            'deleted' => 'Menghapus',
            'viewed' => 'Melihat',
            'login' => 'Login',
            'logout' => 'Logout',
            'exported' => 'Export',
            'registered' => 'Mendaftar',
            default => ucfirst($this->action),
        };
    }
    
    /**
     * Get subject type label
     */
    public function getSubjectLabelAttribute(): string
    {
        if (!$this->subject_type) return '-';
        
        $class = class_basename($this->subject_type);
        return match($class) {
            'User' => 'Pengguna',
            'Event' => 'Event',
            'Material' => 'Materi',
            'Discussion' => 'Diskusi',
            'Article' => 'Artikel',
            'Gallery' => 'Galeri',
            'QuizResult' => 'Hasil Quiz',
            default => $class,
        };
    }
}
