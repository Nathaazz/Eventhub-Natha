<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Services\TicketService;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    protected $ticketService;

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /*
    |--------------------------------------------------------------------------
    | PENDAFTARAN SAYA
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $registrations = Registration::with([
                'event',
                'ticket',
                'certificate'
            ])
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'user.registration.index',
            compact('registrations')
        );

    }

    /*
    |--------------------------------------------------------------------------
    | STORE REGISTRATION
    |--------------------------------------------------------------------------
    */

    public function store(
        RegistrationRequest $request,
        Event $event
    )
    {

        $userId = Auth::id();

        if (!$userId) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | CEGAH DOUBLE REGISTER
        |--------------------------------------------------------------------------
        */

        $existing = Registration::where(
                'user_id',
                $userId
            )
            ->where(
                'event_id',
                $event->id
            )
            ->first();

        if ($existing) {

            return back()->with(
                'error',
                'Anda sudah terdaftar di event ini.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATED DATA
        |--------------------------------------------------------------------------
        */

        $data = $request->validated();

        if (!is_array($data)) {

            $data = [];

        }

        /*
        |--------------------------------------------------------------------------
        | AUTO FILL
        |--------------------------------------------------------------------------
        */

        $data['user_id'] = $userId;

        $data['event_id'] = $event->id;

        $data['status'] = 'approved';

        /*
        |--------------------------------------------------------------------------
        | AUTO FILL USER DATA
        |--------------------------------------------------------------------------
        */

        $data['full_name'] = Auth::user()->name;

        $data['email'] = Auth::user()->email;

        $data['phone'] = Auth::user()->phone;

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CREATE REGISTRATION
            |--------------------------------------------------------------------------
            */

            $registration = $event
                ->registrations()
                ->create($data);

            /*
            |--------------------------------------------------------------------------
            | GENERATE TICKET
            |--------------------------------------------------------------------------
            */

            $this->ticketService
                ->generateForRegistration(
                    $registration
                );

            DB::commit();

            return redirect()
                ->route(
                    'user.registration.index'
                )
                ->with(
                    'success',
                    'Pendaftaran berhasil! Tiket berhasil dibuat.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Terjadi kesalahan, coba lagi.'
            );

        }

    }
}