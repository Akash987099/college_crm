<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;

class LogLoginHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            LoginHistory::create([
                'user_id' => Auth::id(),
                'login_time' => now(),
                'date' => now()->toDateString(),
            ]);
        }

        return $next($request);
    }
}
