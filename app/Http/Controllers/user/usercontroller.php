<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\PasswordRule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\University;
use App\Models\Privilege;
use Auth,DB;

class usercontroller extends Controller
{
    
    public function user_index(){
        $id = Auth::user()->id;
        $university = DB::table('users')
                       ->join('university_master' , 'users.university_code' , '=' , 'university_master.id')
                       ->where('users.id' , $id)
                       ->select('university_master.*' , 'university_master.name')
                       ->get();
        return view('user.index' , compact('university'));
    }

    public function useruniversity(){
        $id = Auth::user()->id;

        $about = DB::table('about_master')->where('user_id' , $id)->first();
       
         return view('user.university' , compact('about'));
    }

    public function assigndata(){
        $id = Auth::user()->id;
        $user = DB::table('users')->where('id' , $id)->first();

        if ($user->university_code && $user->college_code) {
          
            $user = $user->college_code;

            $data = DB::table('college')->where('id' , $user)->get();

        } elseif ($user->university_code) {
          
            $user = $user->university_code;
            $data = DB::table('university_master')->where('id' , $user)->get();
        } 

        return view('user.assign-data' , compact('data'));
    }

    public function userchangepassword(){
        return view('user.user_password');
    }

    public function updatechangepassword(Request $request){
        
        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $name = Auth::user()->name;

       $oldpassword = $request->oldpassword;
       $newpassword = $request->newpassword;
       $confirmpassword = $request->confirmpassword;

       $rules = [
        'oldpassword' => [
            'required',
            function ($attribute, $value, $fail) use ($id) {
                if (!\Hash::check($value, \App\Models\User::find($id)->password)) {
                    $fail('The old password is incorrect.');
                }
            },
        ],
        'newpassword' => 'required',
        'confirmpassword' => 'required_with:required|same:newpassword',
    ];
    
       $validator = Validator::make($request->all(), $rules);
       if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $hashedPassword = Hash::make($newpassword);

        $change = DB::table('users')->where('id' , $id)->update([
            'password' => $hashedPassword,
        ]);

        if($change){

            $data=[];
            $data['name']=$name;
            $data['email']=$email;
            $data['title'] = "Welcome To Intileo's University";
            $data['newpassword'] = $newpassword;

            Mail::send('admin.mail.change', $data, function($message)use($data) {
                $message->to($data["email"], $data["name"])
                    ->subject($data["title"]);
            });

            return response()->json(['status' => 'success' , 'message' => 'success Change Password']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Fialed! Change Password']);
        }

    }

    public function userprograms(){
        $program = DB::table('program_master')->get();
        return view('user.programs' , compact('program'));
    }

    public function addabout(Request $request){
    //  dd($request->all());
       
        $about_master = $request->editorContent;
        $title = $request->title;

        $id = Auth::user()->id;

        $rules = [
            'editorContent' => 'required',
            'title' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }

         $insertedRecord = DB::table('about_master')->insert([
            'user_id' => $id,
            'title_tmp' => $title,
            'description_tmp' => $about_master,
            'approved' => "0"
        ]);

         if($insertedRecord){

            // $lastInsertId = DB::getPdo()->lastInsertId();

            // $updateStatus = DB::table('about_master')
            // ->where('id', $lastInsertId)
            // ->update([
            // 'approved' => "0"
            //    ]);
            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Fialed!']);
        }
    }

    public function bordofdirector (){
        $id = Auth::user()->id;
        $program = DB::table('program_master')->get();
        $university = DB::table('university_master')->where('id' , $id)->get();
        return view('user.bord-of-dirctor' , compact('university' , 'program'));
    }

    public function user_profile(Request $request){

        $id = Auth::user()->id;
        $user = DB::table('users')->where('id' , $id)->first();

        if ($user->university_code && $user->college_code) {
          
            $user = $user->college_code;

            $data = DB::table('college_master')->where('id' , $user)->first();

        } elseif ($user->university_code) {
          
            $user = $user->university_code;
            $data = DB::table('university_master')->where('id' , $user)->first();
        } 

        return view('user.profile' , compact('data'));
    }
}
