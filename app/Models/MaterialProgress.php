<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialProgress extends Model
{
    protected $table = 'material_progress';
    
    protected $fillable = [
        'user_id',
        'material_id',
        'is_completed',
        'completed_at',
    ];
    
    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
    
    public function markComplete(): self
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);
        return $this;
    }
}
