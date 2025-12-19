<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberMedal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'title_jp',
        'icon',
        'description',
        'earned_at',
    ];

    protected $casts = [
        'earned_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
