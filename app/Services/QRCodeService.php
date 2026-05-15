<?php

namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

use App\Models\Ticket;

use Carbon\Carbon;

class QRCodeService
{
    /*
    |--------------------------------------------------------------------------
    | GENERATE SVG STRING
    |--------------------------------------------------------------------------
    */

    public function generate(
        $data
    ): string
    {

        $renderer = new ImageRenderer(

            new RendererStyle(400),

            new SvgImageBackEnd()

        );

        $writer = new Writer($renderer);

        return $writer->writeString($data);

    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE & STORE
    |--------------------------------------------------------------------------
    */

    public function generateAndStore(
        $data,
        $filename
    ): string
    {

        /*
        |--------------------------------------------------------------------------
        | CLEAN FILE NAME
        |--------------------------------------------------------------------------
        */

        $filename = str_replace(

            ['/', '\\', ' '],

            '-',

            $filename

        );

        /*
        |--------------------------------------------------------------------------
        | GENERATE QR
        |--------------------------------------------------------------------------
        */

        $qr = $this->generate($data);

        /*
        |--------------------------------------------------------------------------
        | ABSOLUTE DIRECTORY
        |--------------------------------------------------------------------------
        */

        $directory =
            storage_path(
                'app/public/qrcodes'
            );

        /*
        |--------------------------------------------------------------------------
        | CREATE DIRECTORY
        |--------------------------------------------------------------------------
        */

        if (!file_exists($directory)) {

            mkdir(
                $directory,
                0777,
                true
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILE PATH
        |--------------------------------------------------------------------------
        */

        $filePath =
            $directory .
            '/' .
            $filename .
            '.svg';

        /*
        |--------------------------------------------------------------------------
        | SAVE FILE MANUAL
        |--------------------------------------------------------------------------
        */

        file_put_contents(
            $filePath,
            $qr
        );

        /*
        |--------------------------------------------------------------------------
        | RETURN DB PATH
        |--------------------------------------------------------------------------
        */

        return
            'qrcodes/' .
            $filename .
            '.svg';

    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE TICKET QR
    |--------------------------------------------------------------------------
    */

    public function generateTicketQR(
        Ticket $ticket
    ): string
    {

        $ticket->loadMissing([

            'registration',
            'registration.user',
            'registration.event'

        ]);

        $event = $ticket->registration->event;

        $user = $ticket->registration->user;

        /*
        |--------------------------------------------------------------------------
        | QR PAYLOAD
        |--------------------------------------------------------------------------
        */

        $data = json_encode([

            'ticket_code' =>
                $ticket->ticket_code,

            'participant' =>
                $user->name,

            'event' =>
                $event->title,

            'date' =>
                Carbon::parse(
                    $event->date
                )->format('d M Y'),

            'venue' =>
                $event->venue,

        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATE QR
        |--------------------------------------------------------------------------
        */

        $qrPath = $this->generateAndStore(

            $data,

            $ticket->ticket_code

        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $ticket->update([

            'qr_code_path' =>
                $qrPath

        ]);

        return $qrPath;

    }

    /*
    |--------------------------------------------------------------------------
    | GET QR URL
    |--------------------------------------------------------------------------
    */

    public function getQRUrl(
        $path
    ): string
    {

        return asset(
            'storage/' . $path
        );

    }
}