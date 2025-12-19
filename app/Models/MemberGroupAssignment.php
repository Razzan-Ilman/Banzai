<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberGroupAssignment extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'month_start',
        'month_end',
        'is_active',
        'consistency_score',
    ];

    protected $casts = [
        'month_start' => 'date',
        'month_end' => 'date',
        'is_active' => 'boolean',
        'consistency_score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
