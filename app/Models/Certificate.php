<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| IMPORT MODELS
|--------------------------------------------------------------------------
*/

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;

class Certificate extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'certificates';



    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'user_id',
        'event_id',
        'registration_id',

        'certificate_number',

        'name',

        'certificate_path',

        'issued_at',

    ];



    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'issued_at' => 'datetime',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {

            /*
            |--------------------------------------------------------------------------
            | AUTO CERTIFICATE NUMBER
            |--------------------------------------------------------------------------
            */

            if (empty($certificate->certificate_number)) {

                $certificate->certificate_number =
                    'CERT-' .
                    now()->format('Ymd') .
                    '-' .
                    strtoupper(Str::random(6));

            }



            /*
            |--------------------------------------------------------------------------
            | AUTO NAME
            |--------------------------------------------------------------------------
            */

            if (
                empty($certificate->name) &&
                $certificate->registration
            ) {

                $certificate->name =
                    $certificate->registration->full_name;

            }



            /*
            |--------------------------------------------------------------------------
            | AUTO ISSUED DATE
            |--------------------------------------------------------------------------
            */

            if (empty($certificate->issued_at)) {

                $certificate->issued_at = now();

            }

        });
    }



    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /*
    |--------------------------------------------------------------------------
    | EVENT
    |--------------------------------------------------------------------------
    */

    public function event()
    {
        return $this->belongsTo(Event::class);
    }



    /*
    |--------------------------------------------------------------------------
    | REGISTRATION
    |--------------------------------------------------------------------------
    */

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }



    /*
    |--------------------------------------------------------------------------
    | CERTIFICATE URL
    |--------------------------------------------------------------------------
    */

    public function getCertificateUrlAttribute()
    {

        if (!$this->certificate_path) {

            return null;

        }



        return asset(
            'storage/' .
            $this->certificate_path
        );
    }



    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD URL
    |--------------------------------------------------------------------------
    */

    public function getDownloadUrlAttribute()
    {

        return route(
            'user.certificate.download',
            $this->certificate_number
        );
    }
}