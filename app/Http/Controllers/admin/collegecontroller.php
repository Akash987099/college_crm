<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth,DB;
use App\Models\admin_history; 
use App\Models\college; 
use Illuminate\Support\Str;
use App\Models\facility; 

class collegecontroller extends Controller
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

    public function collegeadd(Request $request){
        // dd($request->all());
        $college = $request->college; // akash
        $university = $request->university;
        $address = $request->address;
        $state = $request->state;
        $city = $request->city;
        $country = $request->country;
        $zipCode = $request->zipCode;
        $Established = $request->Established;
        $college_type = $request->college_type;
        $description = $request->description;

        $rules = [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'city'=>'required', //akash
            'state'=>'required', //akash
            'country'=>'required', //akash
            'college' => 'required|unique:college_master,name,NULL,id,city,' . $request->city,
            'university' => 'required',
            'zipCode' => 'nullable|integer|min:100000|max:999999',
            'Established' => 'sometimes|nullable|integer|min:1801|max:' . date('Y'),
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        // $logoName = '';
        // $imageName = '';
    
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('college/logo'), $logoName);
        }
    
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('college'), $imageName);
        }
        
    $userID = Auth::user()->id;
        $insert = DB::table('college_master')->insert([
            'user_id' => $userID,
            'uni_id' => $university,
            'name' => $college,  
            'address' => $address,
            'state' => $state,
            'pincode' => $zipCode,
            'city' => $city,
            'image' => $imageName,
            'logo' => $logoName,
            'country'  => $country,
            'type' => $college_type,
            'established'  => $Established,
            'description'  => $description
        ]);

        if($insert){
            return response()->json(['status' => 'success', 'message' => 'successfully Added Record']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed Added Record']);
        }

    }

    public function college_view(){
        // $state = DB::table('state_master')->get();
        $Country = DB::table('country_master')->get();
        $university = DB::table('university_master')->get();
        $state = DB::table('state_master')->get();
        return view('admin.college-details' , compact('Country' , 'university' , 'state'));
    }       // akash details

    public function college_list(Request $request){
    //    dd($request->all());
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir'];

        $universitySearchValue = $request->input('university_search');
        $state_search = $request->input('state_search_input');
        $type_search_input = $request->input('type_search_input');
        $userID = Auth::user()->id;
        $data = DB::table('college_master')->where('college_master.user_id' , $userID)
        ->leftJoin('state_master', 'college_master.state', '=', 'state_master.id')
        ->leftJoin('university_master', 'college_master.uni_id', '=', 'university_master.id')
        ->select(
            'college_master.id as college_id',
            'college_master.name as college_name',
            'college_master.status as status',
            'university_master.name as university_name',
            'college_master.type as college_type',
            'college_master.Established as established',
            'state_master.state_name'
        );
        // ->orderByDesc('college_master.id');
    
        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('college_master.name', 'like', '%' . $searchValue . '%')
                      ->orWhere('college_master.type', 'like', '%' . $searchValue . '%')
                      ->orWhere('university_master.name', 'like', '%' . $searchValue . '%')
                      ->orWhere('college_master.Established', 'like', '%' . $searchValue . '%')
                      ->orWhere('state_master.state_name', 'like', '%' . $searchValue . '%');
            });
        }
        
        if ($universitySearchValue != null) {
            $data->where('university_master.name', 'like', '%' . $universitySearchValue . '%');
        }

        if ($state_search != null) {
            $data->where('college_master.state', 'like', '%' . $state_search . '%');
        }

        if ($type_search_input != null) {
            $data->where('college_master.type', 'like', '%' . $type_search_input . '%');
        }
    
    if ($columnName === 'name' && $columnSortOrder === 'asc') {
        $data->orderBy('college_master.name', 'asc');
    } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
        $data->orderBy('college_master.name', 'desc');
    }
    
    if ($columnName === 'type' && $columnSortOrder === 'asc') {
        $data->orderBy('college_master.type', 'asc');
    } elseif ($columnName === 'type' && $columnSortOrder === 'desc') {
        $data->orderBy('college_master.type', 'desc');
    }
    
        

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();
       

        $data = $data->get();
          
        $data_arr = array();
        $id = "0";
        foreach($list as $sno => $record){
                $id = $record->college_id;
                $main = $record->college_id;
                // return $main;
                // $name = $record->college_name;
                // $university_name = $record->university_name;
                $type = $record->college_type;
                $Established = $record->established;
                $status = $record->status;

                $address = " ".$record->state_name;

                $university_name = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->university_name).'">' .
                Str::limit($record->university_name, 500) .
                '</span>';

                $name = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->college_name).'">' .
                Str::limit($record->college_name, 500) .
                '</span>';

               
                // data-bs-toggle="modal" data-bs-target="#exLargeModal"
            $action = '<a href="javascript:void(0);"  class="edit" data-id="'.$main.'"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="'.$main.'"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>';

            if($status){
                $status='<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input tglbtn" data-status="' . $record->status . '" data-id="' . $id . '" id="toggalChangeStatus' . $id . '" ' . ($record->status == 1 ? 'checked' : '') . ' >
                <label class="custom-control-label" for="toggalChangeStatus' . $id . '"></label>
            </div>';
               }else{
                $status='<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input tglbtn" data-status="' . $record->status . '" data-id="' . $id . '" id="toggalChangeStatus' . $id . '" ' . ($record->status == 1 ? 'checked' : '') . ' >
                <label class="custom-control-label" for="toggalChangeStatus' . $id . '"></label>
            </div>';
               }

            $data_arr[] = array(
                "id" => ++$start,
              "name" => $name,
              "university_name" => $university_name,
              "address" => $address,
              "type"  => $type,
              'established' => $Established,
              'status' => $status,
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

    public function collegeedit(Request $request){
        $id = $request->id;
        $update = DB::table('college_master')->where('id' , $id)->get();
        // $update = DB::table('college_master')->where('id' , $id)->get();
        return $update;
         
    }

    public function collegeupdate(Request $request){
        // dd($request->all());
        $id = $request->id;
        $college = $request->college; // akash
        $university = $request->university;
        $address = $request->address;
        $Country = $request->Country;
        $state = $request->state;
        $city = $request->city;
        $zipCode = $request->zipCode;
        $Established = $request->Established;
        $college_type = $request->college_type;
        $update_description = $request->update_description;

        $rules = [

            'college' => 'required', // akash
            'university' => 'required',
            'state'=>'nullable', //akash
            'country'=>'nullable', //akash
            // 'college' => 'required|unique:college_master,name,NULL,id,city,' . $request->city,
            'zipCode' => 'nullable|integer|min:100000|max:999999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'Established' => 'sometimes|nullable|integer|min:1801|max:' . date('Y'),
          
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $updateData = [
            'name' => $college, // akash
            'uni_id' => $university,
            'address' => $address,
            'pincode' => $zipCode,
            'country' => $Country,
            'city' => $city,
            'state' => $state,
            'type' => $college_type,
            'established'  => $Established,
            'description'  => $update_description
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->logo->move(public_path('college'), $logoName);
            $updateData['image'] = $imageName;
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $request->logo->move(public_path('college/logo'), $logoName);
            $updateData['logo'] = $logoName; 
        }

        $update = DB::table('college_master')->where('id', $id)->update($updateData);


        if($update){

            $oldstate = college::find($request->id);
            
            $old = [];
            $new = [];

            $fields = ['address', 'state', 'pincode', 'country', 'type', 'Established', 'description'];

            foreach ($fields as $field) {
                $old[$field] = $oldstate->$field;
            }

            foreach ($fields as $field) {
                $new[$field] = $request->$field;
            }   
        
          
            $user_id = Auth::user()->id;
    
            $st = $this->Storehistory($user_id, 'College', 'Update', $old , $new);

            return response()->json(['status' => 'success', 'message' => 'successfully updated Record']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed updated Record']);
        }

    } 

    public function college_delete(Request $request){

        $id = $request->id;

        $exit = DB::table('users')->where('college_code' , $id)->first();

        if($exit){
         return response()->json(['status' => 'error', 'message' => "Users with this  record already exists, Record can't be deleted! "]);
        }else{

            $oldstate = college::find($request->id);
        
            if (!$oldstate) {
                return response()->json(['status' => 'error', 'message' => 'University record not found.']);
            }
        
            $deletedData = $oldstate->toArray();
        
            $delete = DB::table('college_master')->where('id', $id)->delete();
        
            if ($delete) {
                $userId = Auth::user()->id;
                $this->storeDeleteHistory($userId, 'College', 'Delete', $deletedData);
        
                return response()->json(['status' => 'success', 'message' => 'deleted Record Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete Record. Please check and try again.']);
            }
        }    

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

    public function getuniversityid(Request $request){
        $data=DB::table('university_master')->where('id',$request->id)->orderBy('name', 'asc')->get();
        if($data){
            return response()->json(array('status'=>'success', 'data' => $data));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
        }
    }

    public function facilityajax (){
        return view('admin.facility');;
    }

    public function facilityajaxlist(Request $request){
        
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $data = DB::table('facility_master');
        
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
            $image = $record->image;
        
            $action = '<a href="javascript:void(0);" class="edit" data-id="' . $main . '"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="delete" data-id="' . $main . '" style="color:red;"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "image" => $image,
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

    public function facilityajaxadd (Request $request){
          $name = $request->name;
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|unique:facility_master,name',
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }


        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('icons'), $imageName);

        $userid = Auth::user()->id;

        $insert = DB::table('facility_master')->insert([
            'user_id' => $userid,
            'name'   => $name,
            'image'  => $imageName
        ]);

        if($insert){
            return response()->json(['status' => 'success', 'message' => 'Saved Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }

    }

    public function facilityajaxedit(Request $request){
      $id = $request->id;

      $data = DB::table('facility_master')->where('id' , $id)->get();

      return $data;
    }

    public function facilityajaxdelete(Request $request){
        $id = $request->id;

            $oldstate = facility::find($id);
        
            if (!$oldstate) {
                return response()->json(['status' => 'error', 'message' => 'University record not found.']);
            }
        
            $deletedData = $oldstate->toArray();
        
            $delete = DB::table('facility_master')->where('id' , $id)->delete();
        
            if ($delete) {
              
                $userId = Auth::user()->id;
                $this->storeDeleteHistory($userId, 'Facility', 'Delete', $deletedData);
        
                return response()->json(['status' => 'success', 'message' => 'deleted Record Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete Record. Please check and try again.']);
            }
     
    }

    public function facilityajaxupdate(Request $request){
       $id_input = $request->id_input;
       $name_input = $request->name;

       $rules = [
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        'name' => 'required|unique:facility_master,name,' . $id_input,
     ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $updateData = [
        'name' => $name_input,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $request->logo->move(public_path('icons'), $imageName);
        $updateData['image'] = $imageName;
    }

    $update = DB::table('facility_master')->where('id', $id_input)->update($updateData);

        if($update){

            $oldstate = facility::find($request->id);
          
            if ($oldstate !== null) {
                $old = [];
                $new = [];
            
                $fields = ['name', 'image'];
            
                foreach ($fields as $field) {
                    $old[$field] = $oldstate->$field;
                }
            
                foreach ($fields as $field) {
                    $new[$field] = $request->$field;

                    $user_id = Auth::user()->id;
    
                    $st = $this->Storehistory($user_id, 'facility', 'Update', $old , $new);
                }      

            return response()->json(['status' => 'success', 'message' => 'Update Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }
    }
    }
    public function college_topstatus(Request $request){
        $user = DB::table('users')->where('university_code', $id)->first();
        if ($user) {
            $update = DB::table('college_master')->where('id' , $id)->update(['status' => DB::raw('IF(status = 1, 0, 1)')]);;
            if($update == null)
            {
                return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
            }
            return response()->json(array('status'=>'success', 'message' => 'successfully Change Status'));
        } else {
            return response()->json(['status' => 'error', 'message' => 'Record not found for user']);
        }


    }

}
