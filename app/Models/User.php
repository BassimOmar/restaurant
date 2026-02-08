<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    const ROLE_OWNER = 'owner';
    const ROLE_SUPERVISOR = 'supervisor';
    const ROLE_WAITER = 'waiter';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

     public function orders()
    {
        return $this->hasMany(Order::class, 'waiter_id');
    }

    // One user can have many activity log entries
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // HELPER METHODS for role checking
    public function isOwner() { return $this->role === self::ROLE_OWNER; }
    public function isSupervisor() { return $this->role === self::ROLE_SUPERVISOR; }
    public function isWaiter() { return $this->role === self::ROLE_WAITER; }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
}
