<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Event → Listener mapping
     */
    protected $listen = [
        // Contoh:
        // \App\Events\Registered::class => [
        //     \App\Listeners\SendEmailVerificationNotification::class,
        // ],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kalau nanti mau register event manual
        // Event::listen(...);
    }

    /**
     * Auto-discover events (opsional, biar Laravel detect otomatis)
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}