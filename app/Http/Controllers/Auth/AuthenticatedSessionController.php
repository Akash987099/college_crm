<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use App\Models\LoginHistory;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Convert seconds to a human-readable format.
     *
     * @param int $seconds
     * @return string
     */
    function seconds2human($seconds)
    {
        $dtF = new Carbon('@0');
        $dtT = new Carbon("@$seconds");
    
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes, %s seconds');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response|RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $userId = Auth::id();

    // Call the loginReport function from your controller
    $this->loginReport($userId);

    // Rest of your logic
    if (Auth::user()->user_type == 2  && Auth::user()->status == 1) {
        // Your existing logic
        if (Auth::user()->university_code && Auth::user()->college_code) {
            return redirect('/user');
        } elseif (Auth::user()->university_code) {
            return redirect('/user');
        } else {
            Auth::logout();
            return redirect('/login')->with('message', 'college && university one field is required');
        }
    } elseif (Auth::user()->user_type == 1 || Auth::user()->user_type == 3 && Auth::user()->status == 1) {
        return redirect()->intended(RouteServiceProvider::HOME);
    } else {
        Auth::logout();
        return redirect('/login')->with('message', 'Your Account is inactive. Please contact the Administrator.');
    }
}
    /**
     * Report the login and update the login history.
     */
    public function loginReport($userId): void
    {
        $obj = LoginHistory::where('user_id', $userId)->where('logout', 0)->first();

        if ($obj == null) {
            $datetime = now();
            LoginHistory::create(['user_id' => $userId, 'login_time' => $datetime]);
        } else {
            if ($obj->logout == 0) {
                $pkid = $obj->id;
                $datetime1 = Carbon::parse($obj->login_time); // Parse the login_time as a Carbon instance
                // $datetime2 = now();
                $datetime2 = date('Y-m-d H:i:s');

                $diff = $datetime1->diffInSeconds($datetime2);
                $difftext = $this->seconds2human($diff);
                $durationCount = LoginHistory::where('user_id', $userId)->sum('duration');

                $updateData = [
                    'logout_time' => $datetime2,
                    'duration' => $diff,
                    'duration_time' => $difftext,
                    'total_duration' => $durationCount + $diff,
                    'total_duration_time' => $this->seconds2human($durationCount + $diff),
                    'logout' => 1,
                ];

                $isUpdate = LoginHistory::where('id', $pkid)->update($updateData);

                if ($isUpdate) {
                    $datetime = now();
                    LoginHistory::create(['user_id' => $userId, 'login_time' => $datetime]);
                }
            } else {
                $datetime = now();
                LoginHistory::create(['user_id' => $userId, 'login_time' => $datetime]);
            }
        }
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');
        // return view('auth.login');
    }
}

