<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\RoleEnum;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek login
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRole = $user->role;

        // Admin bebas akses
        if ($userRole === RoleEnum::ADMIN->value) {
            return $next($request);
        }

        // Cek role sesuai route
        if (!in_array($userRole, $roles)) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}