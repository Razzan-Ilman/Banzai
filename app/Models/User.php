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
        ];
    }

    // Member relationships
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
            ->where('month_start', '<=', now())
            ->where('month_end', '>=', now())
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
