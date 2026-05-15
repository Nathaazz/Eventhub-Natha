<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| USER CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\CertificateController as UserCertificateController;

/*
|--------------------------------------------------------------------------
| PROFILE CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ORGANIZER CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\ParticipantController;
use App\Http\Controllers\Organizer\CertificateController as OrganizerCertificateController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {

        return redirect()->route('dashboard');

    }

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/login',
        [LoginController::class, 'show']
    )->name('login');

    Route::post(
        '/login',
        [LoginController::class, 'login']
    );

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/register',
        [RegisterController::class, 'show']
    )->name('register');

    Route::post(
        '/register',
        [RegisterController::class, 'register']
    )->name('register.store');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [LoginController::class, 'logout']
    )->name('logout');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            return redirect()->route(
                'admin.dashboard'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | ORGANIZER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'organizer') {

            return redirect()->route(
                'organizer.events.index'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'user.events.index'
        );

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('user')
        ->name('user.')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        Route::prefix('events')
            ->name('events.')
            ->group(function () {

                Route::get(
                    '/',
                    [UserEventController::class, 'index']
                )->name('index');

                Route::get(
                    '/{id}',
                    [UserEventController::class, 'show']
                )->name('detail');

                Route::post(
                    '/{id}/join',
                    [UserEventController::class, 'join']
                )->name('join');

            });

        /*
        |--------------------------------------------------------------------------
        | MY EVENTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/my-events',
            [RegistrationController::class, 'index']
        )->name('my.events');

        /*
        |--------------------------------------------------------------------------
        | REGISTRATIONS
        |--------------------------------------------------------------------------
        */

        Route::prefix('registrations')
            ->name('registration.')
            ->group(function () {

                Route::get(
                    '/',
                    [RegistrationController::class, 'index']
                )->name('index');

            });

        Route::get(
            '/registrations',
            [RegistrationController::class, 'index']
        )->name('registration.index');

        /*
        |--------------------------------------------------------------------------
        | TICKETS
        |--------------------------------------------------------------------------
        */

        Route::prefix('tickets')
            ->name('tickets.')
            ->group(function () {

                Route::get(
                    '/',
                    [TicketController::class, 'index']
                )->name('index');

                Route::get(
                    '/{ticketCode}',
                    [TicketController::class, 'show']
                )->name('show');

                Route::get(
                    '/{ticketCode}/download',
                    [TicketController::class, 'download']
                )->name('download');

            });

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATES
        |--------------------------------------------------------------------------
        */

        Route::prefix('certificates')
            ->name('certificates.')
            ->group(function () {

                Route::get(
                    '/',
                    [UserCertificateController::class, 'index']
                )->name('index');

                Route::get(
                    '/{certificateNumber}/download',
                    [UserCertificateController::class, 'download']
                )->name('download');

            });

        /*
        |--------------------------------------------------------------------------
        | FIX CERTIFICATE ROUTES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/certificate',
            [UserCertificateController::class, 'index']
        )->name('certificate.index');

        Route::get(
            '/certificate/{certificateNumber}/download',
            [UserCertificateController::class, 'download']
        )->name('certificate.download');

        Route::get(
            '/certificates',
            [UserCertificateController::class, 'index']
        )->name('certificates.index');

        Route::get(
            '/certificates/{certificateNumber}/download',
            [UserCertificateController::class, 'download']
        )->name('certificates.download');

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [ProfileController::class, 'edit']
        )->name('profile.edit');

        Route::put(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');

    });

    /*
    |--------------------------------------------------------------------------
    | ORGANIZER ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('organizer')
        ->name('organizer.')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        Route::prefix('events')
            ->name('events.')
            ->group(function () {

                Route::get(
                    '/',
                    [OrganizerEventController::class, 'index']
                )->name('index');

                Route::get(
                    '/create',
                    [OrganizerEventController::class, 'create']
                )->name('create');

                Route::post(
                    '/',
                    [OrganizerEventController::class, 'store']
                )->name('store');

                Route::get(
                    '/{event}',
                    [OrganizerEventController::class, 'show']
                )->name('show');

                Route::get(
                    '/{event}/edit',
                    [OrganizerEventController::class, 'edit']
                )->name('edit');

                Route::post(
                    '/{event}/update',
                    [OrganizerEventController::class, 'update']
                )->name('update');

                Route::delete(
                    '/{event}',
                    [OrganizerEventController::class, 'destroy']
                )->name('destroy');

                Route::post(
                    '/{event}/toggle',
                    [OrganizerEventController::class, 'toggleStatus']
                )->name('toggle');

            });

        /*
        |--------------------------------------------------------------------------
        | PARTICIPANTS
        |--------------------------------------------------------------------------
        */

        Route::prefix('participants')
            ->name('participants.')
            ->group(function () {

                Route::get(
                    '/',
                    [ParticipantController::class, 'index']
                )->name('index');

                Route::get(
                    '/scanner',
                    [ParticipantController::class, 'scanner']
                )->name('scanner');

                Route::post(
                    '/scan',
                    [ParticipantController::class, 'scan']
                )->name('scan');

                Route::post(
                    '/{registration}/approve',
                    [ParticipantController::class, 'approve']
                )->name('approve');

                Route::post(
                    '/{registration}/reject',
                    [ParticipantController::class, 'reject']
                )->name('reject');

                Route::delete(
                    '/{registration}',
                    [ParticipantController::class, 'destroy']
                )->name('destroy');

            });

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATES
        |--------------------------------------------------------------------------
        */

        Route::prefix('certificates')
            ->name('certificates.')
            ->group(function () {

                Route::get(
                    '/',
                    [OrganizerCertificateController::class, 'index']
                )->name('index');

                Route::get(
                    '/create/{event}',
                    [OrganizerCertificateController::class, 'create']
                )->name('create');

                Route::post(
                    '/store/{event}',
                    [OrganizerCertificateController::class, 'store']
                )->name('store');

                Route::post(
                    '/generate/{event}',
                    [OrganizerCertificateController::class, 'generate']
                )->name('generate');

            });

    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get(
                '/dashboard',
                [DashboardController::class, 'index']
            )->name('dashboard');

    });

});