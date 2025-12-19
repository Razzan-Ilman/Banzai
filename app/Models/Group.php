<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kanji',
        'division_id',
        'color',
        'particle_type',
        'motion_style',
        'description',
    ];

    /**
     * Get the division that this group belongs to
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get all user states for this group
     */
    public function userStates()
    {
        return $this->hasMany(UserState::class, 'current_group_id');
    }

    /**
     * Get all group histories
     */
    public function histories()
    {
        return $this->hasMany(UserGroupHistory::class);
    }

    /**
     * Get all group levels
     */
    public function levels()
    {
        return $this->hasMany(GroupLevel::class);
    }

    /**
     * Get all medals earned for this group
     */
    public function medals()
    {
        return $this->hasMany(Medal::class);
    }
}
