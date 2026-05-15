<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;

use App\Services\TicketService;

class ParticipantController extends Controller
{
    protected $ticketService;

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        TicketService $ticketService
    )
    {
        $this->ticketService = $ticketService;
    }

    /*
    |--------------------------------------------------------------------------
    | PARTICIPANT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | ORGANIZER EVENTS
        |--------------------------------------------------------------------------
        */

        $eventIds = Event::where(

                'user_id',

                Auth::id()

            )
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        $participants = Registration::with([

                'user',
                'event',
                'ticket'

            ])
            ->whereIn(

                'event_id',

                $eventIds

            )
            ->latest()
            ->paginate(20);

        return view(

            'organizer.participants.index',

            compact('participants')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | QR SCANNER PAGE
    |--------------------------------------------------------------------------
    */

    public function scanner()
    {

        return view(

            'organizer.participants.scanner'

        );

    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS QR SCAN
    |--------------------------------------------------------------------------
    */

    public function scan(
        Request $request
    )
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'ticket_code' => 'required'

        ]);

        /*
        |--------------------------------------------------------------------------
        | QR RESULT
        |--------------------------------------------------------------------------
        */

        $qrResult =
            $request->ticket_code;

        /*
        |--------------------------------------------------------------------------
        | TRY JSON DECODE
        |--------------------------------------------------------------------------
        */

        $decoded =
            json_decode(
                $qrResult,
                true
            );

        /*
        |--------------------------------------------------------------------------
        | GET REAL TICKET CODE
        |--------------------------------------------------------------------------
        */

        $ticketCode =
            $decoded['ticket_code']
            ?? $qrResult;

        /*
        |--------------------------------------------------------------------------
        | FIND TICKET
        |--------------------------------------------------------------------------
        */

        $ticket = Ticket::with([

                'registration',
                'registration.event',
                'registration.user'

            ])
            ->where(

                'ticket_code',

                $ticketCode

            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | INVALID TICKET
        |--------------------------------------------------------------------------
        */

        if (!$ticket) {

            return response()->json([

                'success' => false,

                'message' => 'Tiket tidak valid'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | EVENT OWNER VALIDATION
        |--------------------------------------------------------------------------
        */

        if (

            $ticket->event->user_id
            != Auth::id()

        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'QR bukan milik event Anda'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | REGISTRATION NOT APPROVED
        |--------------------------------------------------------------------------
        */

        if (

            $ticket->registration->status
            != 'approved'

        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Peserta belum disetujui'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | TICKET USED
        |--------------------------------------------------------------------------
        */

        if (

            $ticket->status
            === 'used'

        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Peserta sudah check-in'

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $ticket->update([

            'status' => 'used',

            'used_at' => now()

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUCCESS RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' =>
                'Check-in berhasil',

            'participant' =>

                $ticket
                    ->registration
                    ->full_name,

            'phone' =>

                $ticket
                    ->registration
                    ->phone,

            'event' =>

                $ticket
                    ->registration
                    ->event
                    ->title,

            'ticket_code' =>

                $ticket
                    ->ticket_code,

            'time' =>

                now()->format('H:i:s')

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE PARTICIPANT
    |--------------------------------------------------------------------------
    */

    public function approve(
        Registration $registration
    )
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI EVENT ORGANIZER
        |--------------------------------------------------------------------------
        */

        if (

            $registration
                ->event
                ->user_id

            != Auth::id()

        ) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $registration->update([

            'status' => 'approved'

        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTO GENERATE TICKET
        |--------------------------------------------------------------------------
        */

        if (

            !$registration->ticket

        ) {

            $this->ticketService
                ->generateForRegistration(

                    $registration

                );

        }

        return back()->with(

            'success',

            'Peserta berhasil disetujui & tiket otomatis dibuat!'

        );

    }

    /*
    |--------------------------------------------------------------------------
    | REJECT PARTICIPANT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Registration $registration
    )
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI EVENT ORGANIZER
        |--------------------------------------------------------------------------
        */

        if (

            $registration
                ->event
                ->user_id

            != Auth::id()

        ) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $registration->update([

            'status' => 'rejected'

        ]);

        return back()->with(

            'success',

            'Pendaftaran peserta berhasil ditolak!'

        );

    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PARTICIPANT
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Registration $registration
    )
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI EVENT ORGANIZER
        |--------------------------------------------------------------------------
        */

        if (

            $registration
                ->event
                ->user_id

            != Auth::id()

        ) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | DELETE TICKET
        |--------------------------------------------------------------------------
        */

        if (

            $registration->ticket

        ) {

            $registration
                ->ticket
                ->delete();

        }

        /*
        |--------------------------------------------------------------------------
        | DELETE REGISTRATION
        |--------------------------------------------------------------------------
        */

        $registration->delete();

        return back()->with(

            'success',

            'Peserta berhasil dihapus'

        );

    }
}