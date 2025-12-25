<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportLog extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'filters',
        'file_path',
        'error_message',
        'completed_at',
    ];
    
    protected $casts = [
        'filters' => 'array',
        'created_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
    
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }
    
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
