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
use Auth,DB;
use App\Models\admin_history; 
use App\Models\Program; 

class programcontroller extends Controller
{
     private function Storehistory($user_id, $program, $mode, $desc)
    {
        $store = DB::table('admin_history')->insert([
            'user_id' => $user_id,
            'name' => $program,
            'data' => $desc,
            'mode' => $mode,
        ]);
    
        return true;
    }

    public function saveprogram(Request $request)
    {
        // dd($request->all());

        $formData = $request->program;
        $selectedValues = $request->autoCompletewithSelect2;
        $userid = Auth::user()->id;

    if($selectedValues != NULL){

        $rules = [
            'autoCompletewithSelect2' => 'required|unique:user_program,program_id,NULL,id,user_id,' . $userid,
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $insert = DB::table('user_program')->insert([
            'user_id' => $userid,
            'program_id' => $selectedValues,
        ]);
        if($insert){
            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed! Save Record!']);
        }
    }

    if($formData != NULL){

        $rules = [
            'program' => 'required|unique:program_master,name,',
         ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $lastInsertedId = DB::table('program_master')->insertGetId([
            'user_id' => $userid,
            'name' => $formData,
        ]);
        
        if($lastInsertedId){
         
            $insert = DB::table('user_program')->insert([
                'program_id' => $lastInsertedId,
                'user_id' => $userid
            ]);

            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed! Save Record!']);
        }
    }

    return response()->json(['status' => 'error' , 'message' => 'Failed! Save Record!']);

    }
    

    public function addprogramajax(Request $request){
       $program = $request->dynamicInput;
    //    dd($request->all());
       $userid = Auth::user()->id;

       $rules = [
        'program' => 'required|unique:program_master,name',
     ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $lastInsertedId = DB::table('program_master')->insertGetId([
        'name' => $program,
        'user_id' => $userid
    ]);
    

    if($lastInsertedId){
       
        $insert = DB::table('user_program')->insert([
            'program_id' => $lastInsertedId,
            'user_id' => $userid
        ]);

        if($insert){
            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

        return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
    }else{
        return response()->json(['status' => 'error' , 'message' => 'Failed']);
    }

    }

    public function programlist(Request $request){

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

        $userid = Auth::user()->id;

        $data = DB::table('user_program')
    ->where('user_program.user_id', $userid)
    ->join('program_master', 'user_program.program_id', '=', 'program_master.id');

    $data = $data->select('user_program.*', 'program_master.name as program_name' , 'user_program.id as id' );

if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('program_master.name', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('program_master.name', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
            $data->orderBy('program_master.name', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $name = $record->program_name;
          
               $action = "";
               if(DeletePermission(4)){
               if($record->delete_status == 1){
                $action .= '&nbsp;<a class="dropdown-items deleteprogram" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                  }else{
                     $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                  }
            }

            $data_arr[] = array(
                "id" => ++$start,
                  "name" => $name,
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


    public function deleteprogram(Request $request){
        $id = $request->id;
 
        $userid = Auth::user()->id;

                $rules = [
               'id' => 'required|unique:user_program,program_id,NULL,id,user_id,' . $userid,
           ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $exit = DB::table('courses')->where('program_id' , $id)->get();
        if($exit){
            return response()->json(['status' => 'error', 'message' => "Course with this record already exists, Record can't be deleted!"]);
        }else{

        $delete = DB::table('user_program')->where('id' , $id)->delete();
        if ($delete) {
      
            return response()->json(['status' => 'sussess' , 'message' => 'Delete Successfully!']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
    }

    }

    public function getprogramview(Request $request){
        $id = $request->id;

        $data = DB::table('program_master')->where('id' , $id)->get();

        return $data;

    }

    public function updateprogramdata(Request $request){
        // dd($request->all());
        $update_program = $request->update_program;
        $dataid = $request->dataid;
  
        $rules = [
            'update_program' => 'required|unique:program_master,name',
         ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $update = DB::table('program_master')->where('id' , $dataid)->update([
            'name' => $update_program
        ]);
    

        if ($update) {
      
            return response()->json(['status' => 'sussess' , 'message' => 'Update Successfully!']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

    }

    public function searchprogram(Request $request)
    {
        $query = $request->get('query');

        // $results = YourModel::where('program_name', 'like', '%' . $query . '%')->get();
        
        $results = DB::table('program_master')->where('name', 'like', '%' . $query . '%')->get();

        return response()->json($results);
    }
}
