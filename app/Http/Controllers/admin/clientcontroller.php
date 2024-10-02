<?php

namespace App\Http\Controllers\admin;

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
use Auth,DB;
use App\Models\admin_history; 
use App\Models\college; 

class clientcontroller extends Controller
{
   
    private function Storehistory($userId, $mode, $action, $oldData, $newData)
    {
        $store = DB::table('admin_history')->insert([
            'user_id' => $userId,
            'name' => $mode,
            'old_value' => json_encode($oldData),
            'new_value' => json_encode($newData),
            'mode' => $action,
        ]);
    
        return true;
    }

    private function storeDeleteHistory($userId, $mode, $action, $deletedData)
    {
    
        $store = DB::table('admin_history')->insert([
            'user_id' => $userId,
            'name' => $mode,
            'old_value' => json_encode($deletedData),
            'mode' => $action,
        ]);
    
        return true;
    }

    public function viewdata(Request $request){
        $id = $request->id;

        $department = DB::table('university_master')->where('id',$id)->first();
		if($department == null)
		{
			return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
		}
		return response()->json(array('status'=>'success', 'data' => $department));

    }

    public function viewaddress(Request $request){
        $id = $request->id;

        $department = DB::table('users')->where('id',$id)->first();
		if($department == null)
		{
			return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
		}
		return response()->json(array('status'=>'success', 'data' => $department));
    }

    public function viewcollege(Request $request){
        $id = $request->id;

        $department = DB::table('college')->where('id',$id)->first();
		if($department == null)
		{
			return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
		}
		return response()->json(array('status'=>'success', 'data' => $department));
    }

    public function changestatus(Request $request){
        $id = $request->id;

        $update = DB::table('users')->where('id' , $id)->update(['status' => DB::raw('IF(status = 1, 2, 1)')]);;
        if($update == null)
		{
			return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
		}
		return response()->json(array('status'=>'success', 'message' => 'successfully Change Status'));
    }

    public function viewall(Request $request){
      $id = $request->id;

        $id = $request->id;

        $department = DB::table('users')->where('id' , $id)->get();

        if($department == null)
		{
			return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
		}
		return $department;

    }

    public function userlist(Request $request){
       
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $columnIndex = $columnIndex_arr[0]['column']; 
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];

        $userIdToExclude = Auth::user()->id;

$data = DB::table('users')->where('users.user_id' , Auth::user()->id)
    ->leftJoin('university_master', 'users.university_code', '=', 'university_master.id')
    ->leftJoin('college_master', 'users.college_code', '=', 'college_master.id')
    ->where('users.id', '!=', Auth::user()->id) 
    ->select(
        'users.id as user_id',
        'users.created_at as created_at',
        'users.name as user_name',
        'users.username as username',
        'university_master.name as university_name',
        'university_master.id as university_id',
        'college_master.name as college_name',
        'college_master.id as college_id',
        'users.email as user_email',
        'users.phone as user_phone',
        'users.address as address',
        'users.status as status',
        'users.user_type as usertype'
    );

           if($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                      ->orWhere('email', 'like', '%' . $searchValue . '%')
                      ->orWhere('phone', 'like', '%' . $searchValue . '%')
                      ->orWhere('address', 'like', '%' . $searchValue . '%');
            });
        }

        if ($columnName === 'user_name' && $columnSortOrder === 'asc') {
            $data->orderBy('users.name', 'asc');
        } elseif ($columnName === 'user_name' && $columnSortOrder === 'desc') {
            $data->orderBy('users.name', 'desc');
        }
        
        if ($columnName === 'university' && $columnSortOrder === 'asc') {
            $data->orderBy('university_name', 'asc');
        } elseif ($columnName === 'university' && $columnSortOrder === 'desc') {
            $data->orderBy('university_name', 'desc');
        }

        if ($columnName === 'college' && $columnSortOrder === 'asc') {
            $data->orderBy('college_name', 'asc');
        } elseif ($columnName === 'college' && $columnSortOrder === 'desc') {
            $data->orderBy('college_name', 'desc');
        }
        
        
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        $id = "0";
        foreach($list as $sno => $record){
                $id = $record->user_id;
                $created_at = $record->created_at;
                $view = $record->university_id;
                $collegeid = $record->college_id;
                $main = $record->user_id;
                $name = $record->user_name;
                // return $main;
                // $university = $record->university_name;
                // $college = $record->college_name;
                $email = $record->user_email;
                $phone = $record->user_phone;
                $username = $record->username;
                $status = $record->status;
                
                if($record->usertype == 1){
                    $usertype = "Admin";
                }else{
                     $usertype = "user";
                }

                $college = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->college_name).'">' .
                Str::limit($record->college_name, 500) .
                '</span>';

                $university = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->university_name).'">' .
                Str::limit($record->university_name, 500) .
                '</span>';
  

                $address = '<a class="dropdown-items viewaddress" href="javascript:void(0);" style="float:left; color:#000 !important; cursor: pointer !important;" data-id="'.$id.'" title="'.e($record->address).'">
                '.Str::limit($record->address, 500, '...').'
                </a>';


                if($status){
                    $status='<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input tglbtn" data-status="' . $record->status . '" data-id="' . $id . '" id="toggalChangeStatus' . $id . '" ' . ($record->status == 1 ? 'checked' : '') . ' >
                    <label class="custom-control-label" for="toggalChangeStatus' . $id . '"></label>
                </div>';
                   }

            $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; color:green;" data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);"  class="edit" data-id="'.$main.'"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="'.$main.'"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>';

            

            $data_arr[] = array(
                "id" => ++$start,
              "university" => $university,
              "college" => $college,
              "user_name" => $name,
              "email"  => $email,
              "usertype" => $usertype,
              'phone' => $phone,
              'username' => $username,
              'created_at' => date('Y-m-d', strtotime($created_at)),
              'status'  => $status,
              "action" => $action,
            );
         }

        $response = array(
            "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr,
        );

        // dd($response);
        echo json_encode($response); 

    }

    public function usercreate(Request $request){
        // dd($request->all());
       $name = $request->name;
      $userplan = $request->userplan;
       $username = $request->username;
       $email = $request->email;
       $Phone = $request->Phone;
       $address = $request->address;
       $country = $request->country;
       $state = $request->state;
       $city = $request->city;
       $zipCode = $request->zipCode;
       $university = $request->university;
       $college = $request->college;

       
       $password = Str::random(10);
       $hashedPassword = Hash::make($password);
    //    return $hashedPassword;
           $rules = [
            'name' => 'required',
            'userplan' => 'required',
            'username' => ['required', 'regex:/^[A-Z][a-zA-Z0-9_]{4,14}$/'],
            'university' => 'required_without:college',
            'college' => 'required_without:university',
            'email' => 'required|email|unique:users,email|email:rfc,dns',
            'zipCode' => 'nullable|integer|min:100000|max:999999',
            'nullable', 'regex:/^(?:\+\d{1,3}[-.])?\(?(?:\d{1,4})?\)?[-.\d]*$/'
        ];

        $messages = [
            'username.regex' => 'The username must start with a capital letter and only contain letters, numbers, or underscores. It should be between 5 and 15 characters.',
        ];

       
    $validator = Validator::make($request->all(), $rules , $messages);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $user = DB::table('users')->where('username', $username)->first();

if($user) {
    return response()->json(['status' => 'error', 'message' => 'Username already exists']);
}

    
    $data=[];
        $data['name']=$request->input('name');
        $data['username']=$request->input('username');
        $data['email']=$request->input('email');
        $data['title'] = "Welcome To Edulinker";
        $data['password'] = $password;

     $userID = Auth::user()->id;

            $insert = DB::table('users')->insert([
                'user_id' => $userID,
                'name' => $name,
                'user_type' => $userplan,
                'username' => $username,
                'email' => $email,
                'phone' => $Phone,
                'address' => $address,
                'country' => $country,
                'state'   => $state,
                'city'  => $city,
                'pincode' => $zipCode,
                'university_code' => $university,
                'college_code' => $college,
                'password'  => $hashedPassword,
            ]);
    
            if($insert){

                Mail::send('admin.mail.mail', $data, function($message)use($data) {
                    $message->to($data["email"], $data["name"])
                        ->subject($data["title"]);
                });

                return response()->json(['status' => 'success', 'message' => 'Successfully Create User']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'failed!']);
            }
    }

public function userdelete(Request $request)
{
    $id = $request->id;

    $oldstate = User::find($id);

    if (!$oldstate) {
        return response()->json(['status' => 'error', 'message' => 'User record not found.']);
    }

    $deletedData = $oldstate->toArray();

    $userId = Auth::user()->id;

    $checkAboutMaster = DB::table('about_master')->where('user_id', $userId)->get();
    $checkCourses = DB::table('courses')->where('user_id', $userId)->get();

    if ($checkAboutMaster || $checkCourses) {
        return response()->json(['status' => 'error', 'message' => "User with related records exists, Record can't be deleted!"]);
    } else {
        $delete = DB::table('users')->where('id', $id)->delete();

        if ($delete) {
            $this->storeDeleteHistory($userId, 'User', 'Delete', $deletedData);

            return response()->json(['status' => 'success', 'message' => 'Deleted Record Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete record!']);
        }
    }
}

    public function useredit(Request $request){
        $id = $request->id;

        $data = DB::table('users')->where('id' , $id)->get();

        return $data;
    }

    public function universityid(Request $request){
        $data=DB::table('university_master')->where('id',$request->id)->orderBy('name', 'asc')->get();
        if($data){
            return response()->json(array('status'=>'success', 'data' => $data));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
        }
    }

    public function getcollegebyuniid(Request $request){
        $data=DB::table('college_master')->where('uni_id',$request->id)->orderBy('name', 'asc')->get();
        if($data){
            return response()->json(array('status'=>'success', 'data' => $data));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
        }
    }

    public function collegeid(Request $request){
        $data=DB::table('college_master')->where('id',$request->id)->orderBy('name', 'asc')->get();
        if($data){
            return response()->json(array('status'=>'success', 'data' => $data));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
        }
    }

    public function userupdate(Request $request){
        $id = $request->id;
       $name = $request->name;
       $userplan = $request->userplanupdate;
       $update_email = $request->update_email;
    //    $email = $request->email;
       $phone = $request->phone;
       $address = $request->address;
       $Country = $request->Country;
       $state = $request->state;
       $city = $request->city;
       $zipCode = $request->zipCode;
       $university = $request->university;
       $college = $request->college;

       $rules = [
        'name' => 'required',
        'userplanupdate' => 'required',
        'university' => 'required_without:college',
        'college' => 'required_without:university',
        'update_email' => 'required|email|unique:users,email|email:rfc,dns',
        'zipCode' => 'nullable|integer|min:100000|max:999999',
        'phone' => ['nullable', 'regex:/^(\(\d{3}\) ?|\d{3}-?)?\d{3}-?\d{4}$/'],
        'update_email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
            'email:rfc,dns',
        ],
    ];

    
    
    $validator = Validator::make($request->all(), $rules); 
             if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
            }

            $update = DB::table('users')->where('id' , $id)->update([
                'name' => $name,
                'user_type' => $userplan,
                'email' => $update_email,
                'phone' => $phone,
                'address' => $address,
                'country' => $Country,
                'state'   => $state,
                'city'  => $city,
                'pincode' => $zipCode,
                'university_code' => $university,
                'college_code' => $college,
            ]);
    
            if($update){

                $oldstate = User::find($request->id);

                $old = [];
                $new = [];

                $fields = ['name', 'username', 'phone', 'email', 'address', 'state', 'country' , 'city' , 'pincode' , 'university_code' , 'college_code' , 'status'];

            foreach ($fields as $field) {
                $old[$field] = $oldstate->$field;
            }

            foreach ($fields as $field) {
                $new[$field] = $request->$field;
            }            
        
            $user_id = Auth::user()->id;
    
            $st = $this->Storehistory($user_id, 'University', 'Update', $old , $new);
                
                return response()->json(['status' => 'success', 'message' => 'Successfully Update Record']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'failed!']);
            }

    }

    public function changepassword(){
       return view('admin.change_password');
    }

    public function update_password(Request $request){
        $id = Auth::user()->id;

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
            
            return response()->json(['status' => 'success' , 'message' => 'Success Change Password']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Fialed! Change Password']);
        }

    }

}
