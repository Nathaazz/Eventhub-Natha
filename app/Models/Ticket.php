<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

// IMPORT MODEL
use App\Models\Registration;
use App\Models\Event;

class Ticket extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'tickets';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'registration_id',

        'event_id',

        /*
        |--------------------------------------------------------------------------
        | TICKET
        |--------------------------------------------------------------------------
        */

        'ticket_code',

        'qr_code_path',

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        'status',

        'used_at',

    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        'status' => 'active',

    ];

    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'registration_id' => 'integer',

        'event_id' => 'integer',

        'used_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {

            /*
            |--------------------------------------------------------------------------
            | AUTO GENERATE TICKET CODE
            |--------------------------------------------------------------------------
            */

            if (empty($ticket->ticket_code)) {

                $ticket->ticket_code =

                    'EVT-' .

                    Str::upper(
                        Str::random(10)
                    );

            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    /**
     * REGISTRATION
     */
    public function registration()
    {
        return $this->belongsTo(

            Registration::class,

            'registration_id'

        );
    }

    /**
     * EVENT
     */
    public function event()
    {
        return $this->belongsTo(

            Event::class,

            'event_id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * ACTIVE
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * USED
     */
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    /**
     * CHECKED IN
     */
    public function hasCheckedIn(): bool
    {
        return !is_null($this->used_at);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * STATUS BADGE
     */
    public function getStatusBadgeAttribute(): string
    {

        return match ($this->status) {

            'used' => '

                <span class="badge bg-secondary">
                    Sudah Digunakan
                </span>

            ',

            default => '

                <span class="badge bg-success">
                    Aktif
                </span>

            ',

        };

    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    /**
     * ACTIVE TICKET
     */
    public function scopeActive($query)
    {
        return $query->where(
            'status',
            'active'
        );
    }

    /**
     * USED TICKET
     */
    public function scopeUsed($query)
    {
        return $query->where(
            'status',
            'used'
        );
    }
}