<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\RoleEnum;

// IMPORT MODEL
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\Certificate;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | ROLE
    |--------------------------------------------------------------------------
    */

    public function roleEnum(): RoleEnum
    {
        return RoleEnum::from($this->role);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    // Event yang dibuat organizer
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    // Registrasi event user
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id');
    }

    // Event yang diikuti user
    public function joinedEvents()
    {
        return $this->belongsToMany(
            Event::class,
            'registrations',
            'user_id',
            'event_id'
        )->withTimestamps();
    }

    // Ticket milik user
    public function tickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            Registration::class,
            'user_id',
            'registration_id',
            'id',
            'id'
        );
    }

    // Sertifikat user
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'user_id');
    }
}