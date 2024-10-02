<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth,DB;
use Illuminate\Support\Facades\Mail;
use App\Models\City; // Make sure this import is correct
use App\Models\HistoryReport;
use App\Models\User;
use App\Models\Program;

class admincontroller extends Controller
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

public function contact(){
    return view('admin.contact');
}


    public function program(){
        return view('admin.program');
    }

    public function news(){
        return view('admin.news');
    }

    public function loginReportview(){
        $user = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
        
        return view('admin.login-report' , compact('user'));
    }

    public function contactgetdata(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $userid = Auth::user()->id;
        
        $data = DB::table('contact_master');

            if ($searchValue != null) {
                $data->where(function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%');
                });
            }
        
        
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        
        $list = $data->skip($start)->take($length)->get();
        
        $data_arr = [];
        foreach ($list as $sno => $record) {
            $id = $record->id;
            $name = $record->name;
            $email = $record->email;
            $mobile = $record->mobile;
            $city = $record->city;
            $course = $record->course;
            $college = $record->college;
            // $description = $record->description;
        
           
                $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  style="color:green;" data-id="' . $id . '" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
  
            $data_arr[] = array(
                "id" => ++$start,
                "name" => $name,
                "email" => $email,
                "mobile" => $mobile,
                "city" => $city,
                "course" => $course,
                "college" => $college,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        
        echo json_encode($response);

    }

    public function contactgetbyid(Request $request){
        $id = $request->id;
        $data = DB::table('contact_master')->where('id' , $id)->get();
        return $data;
    }

    public function loginReportlist(Request $request){
        //  dd($request->all());
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $userid = Auth::user()->id;
        
        $data = DB::table('login_history')
    ->leftJoin('users', 'login_history.user_id', '=', 'users.id')
    ->select('login_history.id', 'users.username as name', 'login_history.login_time', 'login_history.logout_time', 'login_history.created_at', 'login_history.duration_time', 'login_history.total_duration_time')
    ->orderByDesc('login_history.id');

            if ($searchValue != null) {
                $data->where(function ($query) use ($searchValue) {
                    $query->where('users.username', 'like', '%' . $searchValue . '%');
                });
            }
        
            $startDate = $request->input('user_search_startdate');
$endDate = $request->input('user_search_lastdate');

if ($startDate && $endDate) {
    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay(); 
    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay(); 

    $data->whereBetween('login_history.created_at', [$startDate, $endDate]);
}
        
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        
        $list = $data->skip($start)->take($length)->get();
        
        $data_arr = [];
        foreach ($list as $sno => $record) {
            $id = $record->id;
            $name = $record->name;
            $login = \Carbon\Carbon::parse($record->login_time)->format('H:i:s A');
            $logout = \Carbon\Carbon::parse($record->logout_time)->format('H:i:s A');
            $date = \Carbon\Carbon::parse($record->created_at)->format('d-m-Y');
            $duration = $record->duration_time;
            $duration_time = $record->total_duration_time;
        
            $action = "";
            if (EditPermission(10)) {
                $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="' . $id . '" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            }
        
            if (DeletePermission(10)) {
                $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="' . $id . '" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
        
            $data_arr[] = array(
                "id" => ++$start,
                "name" => $name,
                "login" => $login,
                "logout" => $logout,
                "date" => $date,
                "duration" => $duration,
                "duration_time" => $duration_time,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        
        echo json_encode($response);
        

    }

    public function email(){

        $to = "akash.kumar@intileo.com";
    $subject = "My subject";
    $data = ['message' => "Hello world!"];

    // Send email using the Mail::send method with a Blade view
    Mail::send('admin.email', $data, function ($message) use ($to, $subject) {
        $message->to($to)
            ->subject($subject);
    });

    

    }
    public function profile(){
        return view('admin.profile');
    }

    public function user(){

        $university = DB::table('university_master')->get();
        $college = DB::table('college_master')->get();
        $country = DB::table('country_master')->get();
        return view('admin.user' , compact('university' , 'college' , 'country'));
    }

    public function university(){
        $country = DB::table('country_master')->get();
        $state = DB::table('state_master')->get();
        return view('admin.university' ,  compact('country' , 'state'));
    }

    public function college(){
        $university = DB::table('university_master')->get();
        $state = DB::table('state_master')->get();
        return view('admin.college' , compact('university', 'state'));
    }

    public function admin(){
         $totalUser = DB::table('users')->where('user_id' , Auth::user()->id)->count();
         if(Auth::user()->user_type == 3){
             $totalCollege = DB::table('college_master')->count();
         }else{
             $totalCollege = DB::table('college_master')->where('user_id' , Auth::user()->id)->count();
         }
         
         if(Auth::user()->user_type == 3){
           $totalUniversity = DB::table('university_master')->count();
         }else{
             $totalUniversity = DB::table('university_master')->where('user_id' , Auth::user()->id)->count();
         }
         
        return view('admin.index' , compact('totalUser' , 'totalCollege' , 'totalUniversity'));
    }

    public function country(){
        return view('admin.country');
    }

    public function state(){
        return view('admin.state');
    }

    public function country_data(Request $request){
      
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $data = DB::table('country_master');
        
        // Apply search conditions
        if ($searchValue != null) {
            $data->where(function ($query) use ($searchValue) {
                $query->where('country_name', 'like', '%' . $searchValue . '%');
                // ->orWhere('country_code', 'like', '%' . $searchValue . '%');
            });
        }
        
        $totalRecords = $data->count(); // Get the total number of records
        
        // Apply pagination
        $data->skip($start)->take($length);
        
        $data = $data->get();
        
        $data_arr = array();
        $id = $start; // Start from the current page's starting index
        foreach ($data as $sno => $record) {
            $id++;
            $main = $record->id;
            $name = $record->country_name;
            $code = $record->numcode;
        
            $action = '<a href="javascript:void(0);"  class="edit" data-id="' . $main . '"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="' . $main . '" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // Assuming no additional filtering
            "data" => $data_arr,
        );
        
        echo json_encode($response);
        
    }
    

    public function country_delete(Request $request){
        $id = $request->id;

        $delete = DB::table('country_master')->where('id' , $id)->delete();

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'success delete country']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed delete country']);
        }

    }

    public function addcountry(Request $request){
        $contryname = $request->contryname;
        $countrycode = $request->countrycode;

        $rules = [

            'contryname'=>'required',
            // 'countrycode' => 'required',
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $exists = DB::table('country_master')->where('country_name', '=', $contryname)->exists();

        if($exists){
            return response()->json(['status' => 'exit', 'message' => 'This Record already exit in table']);
        }else{
            $insert = DB::table('country_master')->insert([
                'country_name' => $contryname,
                // 'country_code' => $countrycode
            ]);
    
    
    
            if($insert){
                return response()->json(['status' => 'success', 'message' => 'success add country']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'failed add country please try again' ]);
            }
        }
    }

    public function country_edit(Request $request){
        $id = $request->id;

        $update = DB::table('country_master')->where('id' , $id)->get();

        return $update;
    }

    public function country_update(Request $request){
      
        $id = $request->id_input;
        $name_input = $request->name_input;
        // $phone_input = $request->phone_input;

        $update = DB::table('country_master')->where('id' , $id)->update([
            'country_name' => $name_input,
            // 'country_code' => $phone_input,
        ]);
        if($update){
            return response()->json(['status' => 'success', 'message' => 'success Update country']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed Update country please try again' ]);
        }
    }

    public function state_data(Request $request){
      
        // Search value
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $data = DB::table('state_master');
        
        // Apply search conditions
        if ($searchValue != null) {
            $data->where(function ($query) use ($searchValue) {
                $query->where('state_name', 'like', '%' . $searchValue . '%');
            });
        }
        
        $totalRecords = $data->count(); // Get the total number of records
        
        // Apply pagination
        $data->skip($start)->take($length);
        
        $data = $data->get();
        
        $data_arr = array();
        $id = $start; // Start from the current page's starting index
        foreach ($data as $sno => $record) {
            $id++;
            $main = $record->id;
            $name = $record->state_name;
            // $code = $record->numcode;
        
            $action = '<a href="javascript:void(0);" class="edit" data-id="' . $main . '"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="' . $main . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // Assuming no additional filtering
            "data" => $data_arr,
        );
        
        echo json_encode($response);
 
     }

     public function addstate(Request $request){
        $statename = $request->statename;
        $statecode = $request->statecode;

        $rules = [

            'statename'=>'required',
            // 'statecode' => 'required',
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $exists = DB::table('state_master')->where('state_name', '=', $statename)->exists();

        if($exists){
            return response()->json(['status' => 'exit', 'message' => 'This Record already exit in table']);
        }else{
            $insert = DB::table('state_master')->insert([
                'state_name' => $statename,
            ]);
    
    
    
            if($insert){
                return response()->json(['status' => 'success', 'message' => 'successfully add State']);
            }else{
                return response()->json(['status' => 'error', 'message' => 'failed add State please try again' ]);
            }
        }
    }

    public function state_delete(Request $request){
        $id = $request->id;

        $delete = DB::table('state_master')->where('id' , $id)->delete();

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'successfully delete State']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed delete state']);
        }

    }

    public function addprogram(Request $request){
        $program = $request->program;
        
        $rules = [
            'program' => 'required|unique:program_master,name',
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $userId = Auth::user()->id;
        $insert = DB::table('program_master')->insert([
            'name' => $program,
             'user_id' => $userId
        ]);

        if($insert){
            $data = DB::table('program_master')->get();
            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully' , 'data' => $data,]);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
        
    }

    public function city(){
        return view('admin.city');
    }

    public function city_data(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $data = DB::table('city_master');
        
        // Apply search conditions
        if ($searchValue != null) {
            $data->where(function ($query) use ($searchValue) {
                $query->where('city_name', 'like', '%' . $searchValue . '%');
                // ->orWhere('country_code', 'like', '%' . $searchValue . '%');
            });
        }
        
        $totalRecords = $data->count(); // Get the total number of records
        
        // Apply pagination
        $data->skip($start)->take($length);
        
        $data = $data->get();
        
        $data_arr = array();
        $id = $start; // Start from the current page's starting index
        foreach ($data as $sno => $record) {
            $id++;
            $main = $record->id;
            $name = $record->city_name;
            $image = $record->image;
            $status = $record->status;

            if($status){
                $status='<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input tglbtn" data-status="' . $record->status . '" data-id="' . $main . '" id="toggalChangeStatus' . $main . '" ' . ($record->status == 1 ? 'checked' : '') . ' >
                <label class="custom-control-label" for="toggalChangeStatus' . $main . '"></label>
            </div>';
               }else{
                $status='<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input tglbtn" data-status="' . $record->status . '" data-id="' . $main . '" id="toggalChangeStatus' . $main . '" ' . ($record->status == 1 ? 'checked' : '') . ' >
                <label class="custom-control-label" for="toggalChangeStatus' . $main . '"></label>
            </div>';
               }
        
            $action = '<a href="javascript:void(0);" class="edit" data-id="' . $main . '"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="' . $main . '" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "image" => $image,
                "status" => $status,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // Assuming no additional filtering
            "data" => $data_arr,
        );
        
        echo json_encode($response);

    }

    public function cityadd(Request $request)
    {
        $cityname = $request->cityname;

        $rules = [
            'cityname' => 'required|unique:city_master,city_name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $insert = DB::table('city_master')->insert([
            'city_name' => $cityname,
        ]);

        if ($insert) {
            $newCity = City::where('city_name', $cityname)->first();

            // Assuming you are getting the user ID from the authenticated user
            $user_id = auth()->user()->id;

            $st = $this->Storehistory($user_id, 'City Master', 'Insert', 'ID- ' . $newCity->id . ' New City: ' . $cityname);

            return response()->json(['status' => 'success', 'message' => 'Saved Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed']);
        }
    }

    public function citydelete(Request $request){
        $id = $request->id;

        $delete = DB::table('city_master')->where('id', $id)->delete();

        if($delete){
            
            return response()->json(['status' => 'success' , 'message' => 'Delete Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
    }

    public function cityedit(Request $request){
        $id = $request->id;

        $update = DB::table('city_master')->where('id', $id)->get();

        return $update;
    }

    public function cityupdate(Request $request)
{
    $rules = [
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'name_input' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()]);
    }

    try {
        $city = City::find($request->id);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('city', $imageName, 'public');
            // Make sure 'city' is the correct storage disk for your setup
        }

        $city->update([
            'city_name' => $request->input('name_input'),
            'image' => $imageName,
        ]);

        // History Tracking
        $user_id = Auth::user()->id;
        $changes = ' ID-' . $request->id . ' ';
        $params = ['name' => $request->input('name_input')];

        foreach ($params as $key => $para) {
            if (isset($city->$key) && $city->$key !== $para) {
                $changes .= $key . ' Old Value ' . $city->$key . ' New Value ' . $para . ' ';
            }
        }

        $st = $this->Storehistory($user_id, 'City Master', 'Update', $changes);

        return response()->json(['status' => 'success', 'message' => 'Update Successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed']);
    }
}


public function citychangestatus(Request $request){
    $id = $request->id;

    $update = DB::table('city_master')->where('id' , $id)->update(['status' => DB::raw('IF(status = 1, 2, 1)')]);;
    if($update == null)
    {
        return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
    }
    return response()->json(array('status'=>'success', 'message' => 'successfully Change Status'));
}


    public function programview(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $data = DB::table('program_master');
        
        // Apply search conditions
        if ($searchValue != null) {
            $data->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
                // ->orWhere('country_code', 'like', '%' . $searchValue . '%');
            });
        }
        
        $totalRecords = $data->count(); // Get the total number of records
        
        // Apply pagination
        $data->skip($start)->take($length);
        
        $data = $data->get();
        
        $data_arr = array();
        $id = $start; // Start from the current page's starting index
        foreach ($data as $sno => $record) {
            $id++;
            $main = $record->id;
            $name = $record->name;
            // $code = $record->numcode;
        
            $action = '<a href="javascript:void(0);" class="edit" data-id="' . $main . '"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="' . $main . '"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>';
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // Assuming no additional filtering
            "data" => $data_arr,
        );
        
        echo json_encode($response);

    }

    public function deleteprogram(Request $request){
       $id = $request->id;

           $oldstate = program::find($id);
       
           if (!$oldstate) {
               return response()->json(['status' => 'error', 'message' => 'University record not found.']);
           }
       
           $deletedData = $oldstate->toArray();
       
           $delete = DB::table('program_master')->where('id' , $id)->delete();
       
           if ($delete) {
             
            $userId = Auth::user()->id;
            $this->storeDeleteHistory($userId, 'Program', 'Delete', $deletedData);
       
               return response()->json(['status' => 'success', 'message' => 'deleted Record Successfully']);
           } else {
               return response()->json(['status' => 'error', 'message' => 'Failed to delete Record. Please check and try again.']);
           }

    }

    public function editprogram(Request $request){
        $id = $request->id;

        $update = DB::table('program_master')->where('id', $id)->get();

        return $update;
    }

    public function updateprogram(Request $request){
       $id_input = $request->id_input;
       $name_input = $request->name_input;

       $update = DB::table('program_master')->where('id' , $id_input)->update([
        'name' => $name_input
]);

if($update){

    $oldstate = program::find($request->id);
    $old = [];
    $new = [];

    $fields = ['name', 'user_id'];

    foreach ($fields as $field) {
        $old[$field] = $oldstate->$field;
    }

    foreach ($fields as $field) {
        $new[$field] = $request->$field;
    }            

    $user_id = Auth::user()->id;

    $st = $this->Storehistory($user_id, 'Program', 'Update', $old , $new);

return response()->json(['status' => 'success' , 'message' => 'Update Successfully']);
}else{
return response()->json(['status' => 'error' , 'message' => 'Failed']);
}
    }

    public function state_edit (Request $request){
        $id = $request->id;

        $update = DB::table('state_master')->where('id', $id)->get();

        return $update;
    }

    public function state_update(Request $request){
       $id_input = $request->id_input;
       $name_input = $request->name_input;

       $update = DB::table('state_master')->where('id' , $id_input)->update([
        'state_name' => $name_input
]);

if($update){
return response()->json(['status' => 'success' , 'message' => 'Successfully Update Record']);
}else{
return response()->json(['status' => 'error' , 'message' => 'Failed']);
}
    }

    public function articles(){
        return view('admin.articles');
    }

}
