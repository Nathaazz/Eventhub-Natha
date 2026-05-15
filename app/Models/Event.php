<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// IMPORT MODEL
use App\Models\User;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\Certificate;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | BASIC
        |--------------------------------------------------------------------------
        */

        'title',
        'category',
        'slug',
        'description',

        /*
        |--------------------------------------------------------------------------
        | ORGANIZER
        |--------------------------------------------------------------------------
        */

        'user_id',

        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        'venue',
        'address',
        'date',
        'start_time',
        'end_time',
        'max_participants',
        'poster_path',
        'status',
        'is_active',

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE
        |--------------------------------------------------------------------------
        */

        'certificate_title',
        'certificate_description',
        'certificate_signature',
        'certificate_background',

    ];

    protected $casts = [

        'date' => 'date',

        // TIME ONLY
        'start_time' => 'string',
        'end_time'   => 'string',

        'is_active' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ORGANIZER
    |--------------------------------------------------------------------------
    */

    public function organizer()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTRATIONS
    |--------------------------------------------------------------------------
    */

    public function registrations()
    {
        return $this->hasMany(
            Registration::class,
            'event_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PARTICIPANTS
    |--------------------------------------------------------------------------
    */

    public function participants()
    {
        return $this->belongsToMany(
            User::class,
            'registrations',
            'event_id',
            'user_id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | TICKETS
    |--------------------------------------------------------------------------
    */

    public function tickets()
    {
        return $this->hasManyThrough(

            Ticket::class,

            Registration::class,

            'event_id',

            'registration_id',

            'id',

            'id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICATES
    |--------------------------------------------------------------------------
    */

    public function certificates()
    {
        return $this->hasMany(
            Certificate::class,
            'event_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getParticipantsCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function getStatusBadgeAttribute()
    {
        return function_exists('statusBadge')

            ? statusBadge($this->status)

            : $this->status;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query
            ->whereDate('date', '>=', now());
    }
}