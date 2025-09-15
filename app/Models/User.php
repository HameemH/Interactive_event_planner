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

    // Role constants
    const ROLE_ORGANIZER = 'organizer'; // Organizer acts as admin
    const ROLE_GUEST = 'guest';

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

    /**
     * Check if user is an organizer (admin)
     */
    public function isOrganizer(): bool
    {
        return $this->role === self::ROLE_ORGANIZER;
    }

    /**
     * Check if user is an admin (alias for organizer)
     */
    public function isAdmin(): bool
    {
        return $this->isOrganizer();
    }

    /**
     * Check if user is a guest
     */
    public function isGuest(): bool
    {
        return $this->role === self::ROLE_GUEST;
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Promote user to organizer (admin)
     */
    public function promoteToAdmin(): bool
    {
        $this->role = self::ROLE_ORGANIZER;
        return $this->save();
    }

    /**
     * Demote user to guest
     */
    public function demoteToGuest(): bool
    {
        $this->role = self::ROLE_GUEST;
        return $this->save();
    }

    /**
     * Get all available roles
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_ORGANIZER,
            self::ROLE_GUEST,
        ];
    }
}
