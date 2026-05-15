<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\Certificate;
use App\Models\Registration;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $events = Event::with([

                'registrations',
                'certificates'

            ])
            ->where(

                'user_id',

                Auth::id()

            )
            ->when(

                $request->search,

                function ($query) use ($request) {

                    $query->where(

                        'title',

                        'like',

                        '%' . $request->search . '%'

                    );

                }

            )
            ->latest()
            ->paginate(10);

        return view(

            'organizer.certificate.index',

            compact('events')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | CREATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function create(Event $event)
    {

        if (

            $event->user_id != Auth::id()

        ) {

            abort(403);

        }

        return view(

            'organizer.certificate.create',

            compact('event')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | STORE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        Event $event
    )
    {

        if (

            $event->user_id != Auth::id()

        ) {

            abort(403);

        }

        $request->validate([

            'certificate_title' =>
                'required',

            'certificate_description' =>
                'required',

            'certificate_signature' =>
                'required',

            'certificate_background' =>
                'nullable|image'

        ]);

        /*
        |--------------------------------------------------------------------------
        | BACKGROUND
        |--------------------------------------------------------------------------
        */

        $background =
            $event->certificate_background;

        if (

            $request->hasFile(
                'certificate_background'
            )

        ) {

            $background = $request
                ->file(
                    'certificate_background'
                )
                ->store(

                    'certificate-backgrounds',

                    'public'

                );

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE EVENT
        |--------------------------------------------------------------------------
        */

        $event->update([

            'certificate_title' =>

                $request->certificate_title,

            'certificate_description' =>

                $request->certificate_description,

            'certificate_signature' =>

                $request->certificate_signature,

            'certificate_background' =>

                $background,

        ]);

        return redirect()

            ->route(
                'organizer.certificates.index'
            )

            ->with(

                'success',

                'Template sertifikat berhasil dibuat'

            );

    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE CERTIFICATE
    |--------------------------------------------------------------------------
    */

    public function generate(Event $event)
    {

        /*
        |--------------------------------------------------------------------------
        | CHECK OWNER
        |--------------------------------------------------------------------------
        */

        if (

            $event->user_id != Auth::id()

        ) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | TEMPLATE CHECK
        |--------------------------------------------------------------------------
        */

        if (

            !$event->certificate_title ||

            !$event->certificate_description

        ) {

            return back()->with(

                'error',

                'Buat template sertifikat terlebih dahulu'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | CREATE DIRECTORY
        |--------------------------------------------------------------------------
        */

        if (

            !Storage::disk('public')->exists(
                'certificates'
            )

        ) {

            Storage::disk('public')->makeDirectory(
                'certificates'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        $participants = Registration::with([

                'user',
                'ticket'

            ])
            ->where(

                'event_id',

                $event->id

            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANT EMPTY CHECK
        |--------------------------------------------------------------------------
        */

        if (

            $participants->count() == 0

        ) {

            return back()->with(

                'error',

                'Belum ada peserta'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | LOOP PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        foreach (

            $participants

            as $participant

        ) {

            /*
            |--------------------------------------------------------------------------
            | USER CHECK
            |--------------------------------------------------------------------------
            */

            if (

                !$participant->user

            ) {

                continue;

            }

            /*
            |--------------------------------------------------------------------------
            | CREATE CERTIFICATE
            |--------------------------------------------------------------------------
            */

            $certificate = Certificate::firstOrCreate(

                [

                    'user_id' =>

                        $participant->user_id,

                    'event_id' =>

                        $event->id,

                ],

                [

                    'registration_id' =>

                        $participant->id,

                    'name' =>

                        $participant
                            ->user
                            ->name,

                    'certificate_number' =>

                        'CERT-' .

                        strtoupper(
                            Str::random(10)
                        ),

                    'issued_at' => now(),

                ]

            );

            /*
            |--------------------------------------------------------------------------
            | GENERATE PDF
            |--------------------------------------------------------------------------
            */

            $pdf = Pdf::loadView(

                'user.certificate.template',

                [

                    'certificate' => $certificate,
                    'event' => $event,
                    'participant' => $participant

                ]

            )->setPaper(

                'a4',

                'landscape'

            );

            /*
            |--------------------------------------------------------------------------
            | FILE NAME
            |--------------------------------------------------------------------------
            */

            $fileName =

                'certificates/' .

                $certificate
                    ->certificate_number .

                '.pdf';

            /*
            |--------------------------------------------------------------------------
            | SAVE PDF
            |--------------------------------------------------------------------------
            */

            Storage::disk('public')->put(

                $fileName,

                $pdf->output()

            );

            /*
            |--------------------------------------------------------------------------
            | UPDATE DATABASE
            |--------------------------------------------------------------------------
            */

            $certificate->update([

                'file_path' =>

                    $fileName

            ]);

        }

        return back()->with(

            'success',

            'Sertifikat berhasil digenerate'

        );

    }
}