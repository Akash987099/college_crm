<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // app/Http/Middleware/AdminMiddleware.php

public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->user_type == 1 || Auth::user()->user_type == 3) {
        return $next($request);
    }

    return redirect('/');
}

}
