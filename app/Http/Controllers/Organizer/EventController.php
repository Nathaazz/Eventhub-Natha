<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\Registration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Event::query()

            ->with([
                'registrations',
                'organizer',
            ])

            ->where(
                'user_id',
                Auth::id()
            );

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
                );
            });
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

        return view(
            'organizer.event.index',
            compact('events')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'organizer.event.create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|max:255',

            'category' => 'nullable|max:255',

            'description' => 'required',

            'venue' => 'required',

            'address' => 'nullable',

            'date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required',

            'max_participants' => 'nullable|integer',

            'poster' => 'nullable|image|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | POSTER
        |--------------------------------------------------------------------------
        */

        $poster = null;

        if ($request->hasFile('poster')) {

            $poster = $request->file('poster')

                ->store(
                    'events',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE EVENT
        |--------------------------------------------------------------------------
        */

        $event = new Event();

        $event->user_id = Auth::id();

        $event->title = $request->title;

        $event->category = $request->category;

        $event->slug = Str::slug(
            $request->title . '-' . time()
        );

        $event->description = $request->description;

        $event->venue = $request->venue;

        $event->address = $request->address;

        $event->date = $request->date;

        $event->start_time = $request->start_time;

        $event->end_time = $request->end_time;

        $event->max_participants = $request->max_participants;

        $event->poster_path = $poster;

        $event->status = 'akan datang';

        $event->is_active = true;

        $event->save();

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route(
                'organizer.events.index'
            )

            ->with(
                'success',
                'Event berhasil dibuat'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $event = Event::with([

                'registrations.user',

                'organizer',

            ])

            ->where(
                'user_id',
                Auth::id()
            )

            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        $participants = Registration::with('user')

            ->where(
                'event_id',
                $event->id
            )

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $approvedCount = $participants
            ->where('status', 'approved')
            ->count();

        $pendingCount = $participants
            ->where('status', 'pending')
            ->count();

        $rejectedCount = $participants
            ->where('status', 'rejected')
            ->count();

        return view(
            'organizer.event.show',
            compact(
                'event',
                'participants',
                'approvedCount',
                'pendingCount',
                'rejectedCount'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $event = Event::where(
                'user_id',
                Auth::id()
            )

            ->findOrFail($id);

        return view(
            'organizer.event.edit',
            compact('event')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $event = Event::where(
                'user_id',
                Auth::id()
            )

            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'title' => 'required|max:255',

            'category' => 'nullable|max:255',

            'description' => 'required',

            'venue' => 'required',

            'address' => 'nullable',

            'date' => 'required|date',

            'start_time' => 'required',

            'end_time' => 'required',

            'max_participants' => 'nullable|integer',

            'poster' => 'nullable|image|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | POSTER
        |--------------------------------------------------------------------------
        */

        $poster = $event->poster_path;

        if ($request->hasFile('poster')) {

            if (
                $event->poster_path &&
                Storage::disk('public')->exists($event->poster_path)
            ) {

                Storage::disk('public')
                    ->delete($event->poster_path);
            }

            $poster = $request->file('poster')

                ->store(
                    'events',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE MANUAL
        |--------------------------------------------------------------------------
        */

        $event->title = $request->title;

        $event->category = $request->category;

        $event->slug = Str::slug(
            $request->title . '-' . time()
        );

        $event->description = $request->description;

        $event->venue = $request->venue;

        $event->address = $request->address;

        $event->date = $request->date;

        $event->start_time = $request->start_time;

        $event->end_time = $request->end_time;

        $event->max_participants = $request->max_participants;

        $event->poster_path = $poster;

        $event->save();

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()

            ->route(
                'organizer.events.index'
            )

            ->with(
                'success',
                'Event berhasil diperbarui'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $event = Event::where(
                'user_id',
                Auth::id()
            )

            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | DELETE POSTER
        |--------------------------------------------------------------------------
        */

        if (
            $event->poster_path &&
            Storage::disk('public')->exists($event->poster_path)
        ) {

            Storage::disk('public')
                ->delete($event->poster_path);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE REGISTRATIONS
        |--------------------------------------------------------------------------
        */

        Registration::where(
            'event_id',
            $event->id
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | DELETE EVENT
        |--------------------------------------------------------------------------
        */

        $event->delete();

        return redirect()

            ->route('organizer.events.index')

            ->with(
                'success',
                'Event berhasil dihapus'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $event = Event::where(
                'user_id',
                Auth::id()
            )

            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | TOGGLE
        |--------------------------------------------------------------------------
        */

        $event->is_active = !$event->is_active;

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if ($event->is_active) {

            $event->status = 'akan datang';

        } else {

            $event->status = 'nonaktif';
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $event->save();

        return back()->with(
            'success',
            'Status event berhasil diperbarui'
        );
    }
}