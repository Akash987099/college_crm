<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Captcha\Facades\Captcha;

class LoginController extends Controller
{
    // ... (existing code)

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Validate the captcha
        if (!Captcha::check($request->captcha)) {
            Auth::logout(); // Log out the user if captcha validation fails
            return back()->withErrors(['captcha' => 'Captcha validation failed. Please try again.']);
        }

        // Redirect based on user_type
        if ($user->user_type == 'admin') {
            return redirect('/admin');
        } else {
            return redirect('/user');
        }
    }

    
}
