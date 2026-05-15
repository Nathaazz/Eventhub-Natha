<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\QRCodeService;
use App\Services\TicketService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 🔥 Binding QR Code Service
        $this->app->singleton(QRCodeService::class, function ($app) {
            return new QRCodeService();
        });

        // 🔥 Binding Ticket Service (inject QR)
        $this->app->singleton(TicketService::class, function ($app) {
            return new TicketService(
                $app->make(QRCodeService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔥 Fix MySQL index error (xampp)
        Schema::defaultStringLength(191);
    }
}