<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL EVENTS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $events = Event::active()

            /*
            |--------------------------------------------------------------------------
            | FIXED RELATION
            |--------------------------------------------------------------------------
            */

            ->with([
                'organizer'
            ])

            ->latest()

            ->paginate(10);


        return response()->json([

            'success' => true,

            'message' => 'Daftar event berhasil diambil',

            'data' => $events

        ], 200);
    }



    /*
    |--------------------------------------------------------------------------
    | GET SINGLE EVENT
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $event = Event::active()

            /*
            |--------------------------------------------------------------------------
            | FIND BY SLUG
            |--------------------------------------------------------------------------
            */

            ->where('slug', $slug)

            /*
            |--------------------------------------------------------------------------
            | FIXED RELATION
            |--------------------------------------------------------------------------
            */

            ->with([

                'organizer',

                'registrations.user'

            ])

            ->first();


        /*
        |--------------------------------------------------------------------------
        | EVENT NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (!$event) {

            return response()->json([

                'success' => false,

                'message' => 'Event tidak ditemukan'

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' => 'Detail event berhasil diambil',

            'data' => $event

        ], 200);
    }
}