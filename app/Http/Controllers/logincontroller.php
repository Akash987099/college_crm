<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\PasswordRule;
use App\Models\LoginHistory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Auth, DB;

class logincontroller extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Convert seconds to a human-readable format.
     *
     * @param int $seconds
     * @return string
     */
    private function seconds2human($seconds)
    {
        $dtF = new Carbon('@0');
        $dtT = new Carbon("@$seconds");

        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes, %s seconds');
    }

    public function loginReport($userId)
    {
        $obj = LoginHistory::where('user_id', $userId)->where('logout', 0)->first();

        if ($obj == null) {
            $datetime = now();
            LoginHistory::create(['user_id' => $userId, 'login_time' => $datetime]);
        } else {
            if ($obj->logout == 0) {
                $pkid = $obj->id;
                $datetime1 = $obj->login_time;
                $datetime2 = now();

                $time1 = strtotime($datetime1);
                $time2 = strtotime($datetime2);

                $diff = abs(strtotime($datetime1) - strtotime($datetime2));
                $difftext = $this->seconds2human($diff);
                $durationCount = 0;

                $result = LoginHistory::where('user_id', $userId)->get();
                foreach ($result as $resultdata) {
                    $durationCount += $resultdata->duration;
                }

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

        // Additional logic if needed

        // Rest of your logic
    }
}
