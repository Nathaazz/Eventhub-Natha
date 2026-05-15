<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapping policy model (opsional, isi kalau pakai policy)
     */
    protected $policies = [
        // Contoh:
        // \App\Models\Event::class => \App\Policies\EventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register policy otomatis
        $this->registerPolicies();

        // Contoh Gate (opsional)
        // Gate::define('admin', function ($user) {
        //     return $user->role === 'admin';
        // });
    }
}