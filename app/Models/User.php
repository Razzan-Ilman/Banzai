<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'title_id',
        'title_awarded_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'title_awarded_at' => 'datetime',
        ];
    }

    // ==================== TITLE RELATIONS ====================

    /**
     * Get user's current title
     */
    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    /**
     * Get user's title history
     */
    public function titleHistories()
    {
        return $this->hasMany(UserTitleHistory::class)->orderBy('awarded_at', 'desc');
    }

    /**
     * Get user's quiz results
     */
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class)->orderBy('created_at', 'desc');
    }

    /**
     * Check if user has a title
     */
    public function hasTitle(): bool
    {
        return !is_null($this->title_id);
    }

    // ==================== MEMBER RELATIONS ====================

    public function memberProfile()
    {
        return $this->hasOne(MemberProfile::class);
    }

    public function groupAssignments()
    {
        return $this->hasMany(MemberGroupAssignment::class);
    }

    public function currentGroup()
    {
        return $this->hasOne(MemberGroupAssignment::class)
            ->where('is_active', true)
            ->with('group');
    }

    public function medals()
    {
        return $this->hasMany(MemberMedal::class);
    }

    public function attendances()
    {
        return $this->hasMany(MemberAttendance::class);
    }
}
