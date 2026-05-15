<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// IMPORT MODEL
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * Relasi ke users
     * user.role (string) = role.slug
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role', 'slug');
    }
}