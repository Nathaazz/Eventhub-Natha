<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// IMPORT MODEL
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Certificate;

class Registration extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'registrations';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'user_id',
        'event_id',

        'full_name',
        'email',
        'phone',
        'institution',

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        /*
        |--------------------------------------------------------------------------
        | DEFAULT PENDING
        |--------------------------------------------------------------------------
        */

        'status' => 'pending',

    ];

    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'user_id'  => 'integer',

        'event_id' => 'integer',

        'status' => 'string',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    /**
     * USER
     */
    public function user()
    {
        return $this->belongsTo(

            User::class,

            'user_id'

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

    /**
     * TICKET
     */
    public function ticket()
    {
        return $this->hasOne(

            Ticket::class,

            'registration_id'

        );
    }

    /**
     * CERTIFICATE
     */
    public function certificate()
    {
        return $this->hasOne(

            Certificate::class,

            'registration_id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * CEK TICKET
     */
    public function hasTicket(): bool
    {
        return $this->ticket()->exists();
    }

    /**
     * CEK CERTIFICATE
     */
    public function hasCertificate(): bool
    {
        return $this->certificate()->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CHECK
    |--------------------------------------------------------------------------
    */

    /**
     * APPROVED
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * PENDING
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * REJECTED
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS BADGE
    |--------------------------------------------------------------------------
    */

    public function getStatusBadgeAttribute(): string
    {

        return match ($this->status) {

            'approved' => '

                <span class="badge bg-success">
                    Approved
                </span>

            ',

            'rejected' => '

                <span class="badge bg-danger">
                    Rejected
                </span>

            ',

            default => '

                <span class="badge bg-warning text-dark">
                    Pending
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
     * PENDING ONLY
     */
    public function scopePending($query)
    {
        return $query->where(
            'status',
            'pending'
        );
    }

    /**
     * APPROVED ONLY
     */
    public function scopeApproved($query)
    {
        return $query->where(
            'status',
            'approved'
        );
    }

    /**
     * REJECTED ONLY
     */
    public function scopeRejected($query)
    {
        return $query->where(
            'status',
            'rejected'
        );
    }
}