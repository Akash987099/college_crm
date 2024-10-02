<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $userType)
{
    $user = Auth::user();

    // Log or dump for debugging
    \Log::info("User Type: {$user->user_type}, Expected Type: {$userType}");

    if ($user && $user->user_type == $userType) {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}

    
}
