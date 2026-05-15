<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Ticket;

class TicketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MY TICKETS
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | UNAUTHORIZED
        |--------------------------------------------------------------------------
        */

        if (!$userId) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | GET TICKETS
        |--------------------------------------------------------------------------
        */

        $tickets = Ticket::with([

                'event',
                'registration'

            ])
            ->whereHas(

                'registration',

                function ($query) use ($userId) {

                    $query->where(

                        'user_id',

                        $userId

                    );

                }

            )
            ->latest()
            ->paginate(10);

        return view(

            'user.ticket.index',

            compact('tickets')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | SHOW TICKET
    |--------------------------------------------------------------------------
    */

    public function show(
        $ticketCode
    )
    {

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | UNAUTHORIZED
        |--------------------------------------------------------------------------
        */

        if (!$userId) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | GET TICKET
        |--------------------------------------------------------------------------
        */

        $ticket = Ticket::with([

                'event',
                'registration'

            ])
            ->where(

                'ticket_code',

                $ticketCode

            )
            ->whereHas(

                'registration',

                function ($query) use ($userId) {

                    $query->where(

                        'user_id',

                        $userId

                    );

                }

            )
            ->firstOrFail();

        return view(

            'user.ticket.show',

            compact('ticket')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF
    |--------------------------------------------------------------------------
    */

    public function download(
        $ticketCode
    )
    {

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | UNAUTHORIZED
        |--------------------------------------------------------------------------
        */

        if (!$userId) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | GET TICKET
        |--------------------------------------------------------------------------
        */

        $ticket = Ticket::with([

                'event',
                'registration'

            ])
            ->where(

                'ticket_code',

                $ticketCode

            )
            ->whereHas(

                'registration',

                function ($query) use ($userId) {

                    $query->where(

                        'user_id',

                        $userId

                    );

                }

            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | LOAD PDF VIEW
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(

            'user.ticket.pdf',

            compact('ticket')

        );

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(

            'ticket-' .

            $ticket->ticket_code .

            '.pdf'

        );

    }
}