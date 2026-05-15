<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\Registration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | EVENT LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Event::query()

            ->with([
                'organizer',
                'registrations'
            ])

            ->where('is_active', true);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'title',
                    'LIKE',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'venue',
                    'LIKE',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'description',
                    'LIKE',
                    '%' . $request->search . '%'
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        $events = $query

            ->latest()

            ->paginate(12)

            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user.event.index',
            compact('events')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL EVENT
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        $event = Event::with([

                'organizer',

                'registrations.user',

            ])

            ->where('id', $id)

            ->where('is_active', true)

            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CHECK USER JOINED
        |--------------------------------------------------------------------------
        */

        $isJoined = false;

        if (Auth::check()) {

            $isJoined = Registration::where(

                'user_id',
                Auth::id()

            )->where(

                'event_id',
                $event->id

            )->exists();
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user.event.detail',
            compact(
                'event',
                'isJoined'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | JOIN EVENT
    |--------------------------------------------------------------------------
    */

    public function join($id)
    {
        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        $event = Event::where(
                'is_active',
                true
            )

            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CHECK ALREADY JOINED
        |--------------------------------------------------------------------------
        */

        $alreadyJoined = Registration::where(

            'user_id',
            Auth::id()

        )->where(

            'event_id',
            $event->id

        )->exists();

        /*
        |--------------------------------------------------------------------------
        | ALREADY JOINED
        |--------------------------------------------------------------------------
        */

        if ($alreadyJoined) {

            return back()->with(
                'error',
                'Anda sudah terdaftar di event ini'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK LIMIT
        |--------------------------------------------------------------------------
        */

        if (

            $event->max_participants &&

            $event->registrations()->count() >= $event->max_participants

        ) {

            return back()->with(
                'error',
                'Kuota event sudah penuh'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REGISTER EVENT
        |--------------------------------------------------------------------------
        */

        Registration::create([

            'user_id' => Auth::id(),

            'event_id' => $event->id,

            'full_name' => Auth::user()->name,

            'email' => Auth::user()->email,

            'phone' => Auth::user()->phone ?? '-',

            'institution' => '-',

            'status' => 'approved',

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route('user.my.events')

            ->with(
                'success',
                'Berhasil mendaftar event'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT SAYA
    |--------------------------------------------------------------------------
    */

    public function myEvent()
    {
        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        $events = Event::with([

                'organizer',

                'registrations',

            ])

            ->whereHas('registrations', function ($query) {

                $query->where(
                    'user_id',
                    Auth::id()
                );

            })

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user.event.index',
            compact('events')
        );
    }
}