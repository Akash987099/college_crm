<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth,DB;
use App\Models\admin_history; 
use App\Models\University; 


class universitycontroller extends Controller
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
    
    public function universityadd(Request $request){
        // dd($request->all());
        $id = Auth::user()->id;
        $university = $request->university;
        $city = $request->city;
        $address    = $request->address;
        $state    = $request->state;
        $zipCode    = $request->zipCode;
        $Established    = $request->Established;
        $country    = $request->country;
        $university_type    = $request->university_type;
        $description    = $request->description;

        $rules = [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'university_type' => 'required',
            'university' => 'required|unique:university_master,name', // akash
            'zipCode' => 'nullable|integer|min:100000|max:999999',
            'Established' => 'sometimes|nullable|integer|min:1801|max:' . date('Y'),
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }
    
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('college/logo'), $logoName);
        }
    
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('college'), $imageName);
        }
       

        $insert = DB::table('university_master')->insert([
            'user_id' => $id,
            'name' => $university, 
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'pincode' => $zipCode,
            'country' => $country,
            'logo'    => $logoName,
            'image'   => $imageName,
            'university_type' => $university_type,
            'established'  => $Established,
            'description'  => $description
        ]);
        

        if($insert){
            return response()->json(['status' => 'success', 'message' => 'successfully Add Record']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed Delete Record']);
        // }

    }

    }

    public function universitydata(Request $request){
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
$state_search = $request->input('state_search');
$userID = Auth::user()->id;
$data = DB::table('university_master')->where('university_master.user_id' , $userID)
    ->leftJoin('city_master', 'university_master.city', '=', 'city_master.id')
    ->leftJoin('state_master', 'university_master.state', '=', 'state_master.id')
    ->select(
        'university_master.id as university_id',
        'university_master.status as status',
        'university_master.name as university_name',
        'university_master.university_type as university_type',
        'university_master.established as established',
        'city_master.city_name',
        'state_master.state_name'
    );
    // ->orderByDesc('university_master.id');

if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('university_type', 'like', '%' . $searchValue . '%')
            ->orWhere('established', 'like', '%' . $searchValue . '%')
            ->orWhere('state_name', 'like', '%' . $searchValue . '%')
            ->orWhere('country_name', 'like', '%' . $searchValue . '%');
    });
}

if ($universitySearchValue != null) {
    $data->where('university_master.university_type', 'like', '%' . $universitySearchValue . '%');
}

if ($state_search != null) {
    $data->where('university_master.state', 'like', '%' . $state_search . '%');
}

if ($columnName === 'name' && $columnSortOrder === 'asc') {
    $data->orderBy('university_master.name', 'asc');
} elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
    $data->orderBy('university_master.name', 'desc');
}

if ($columnName === 'type' && $columnSortOrder === 'asc') {
    $data->orderBy('university_type', 'asc');
} elseif ($columnName === 'type' && $columnSortOrder === 'desc') {
    $data->orderBy('university_type', 'desc');
}

$totalRecordswithFilter = $data->count();
$totalRecords = $totalRecordswithFilter;
$list = $data->skip($start)->take($length)->get();
     
        $data = $data->get();

          
        $data_arr = array();
        $id = "0";
        foreach($list as $sno => $record){
                $id = $record->university_id;
                $main = $record->university_id;
                $status = $record->status;
                // return $main;
                $name = $record->university_name;
                $type = $record->university_type;
                $Established = $record->established;

                $address = " ".$record->city_name;
                $address .= " ".$record->state_name;

               
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

    public function universitytopstatus(Request $request){
        // dd($request->all());
        $id = $request->id;

        $user = DB::table('users')->where('university_code', $id)->first();
        if ($user) {
            $update = DB::table('university_master')->where('id', $id)
                ->update(['status' => DB::raw('IF(status = 1, 0, 1)')]);
    
            if ($update !== false) {
                return response()->json(['status' => 'success', 'message' => 'Status successfully changed']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update status']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Record not found for user']);
        }
        
    }

    public function universitydelete(Request $request){
        $id = $request->id;
        // dd($request->all());

        $exit = DB::table('college_master')->where('uni_id', $id)->first();
        
        if ($exit) {
            return response()->json(['status' => 'error', 'message' => "College with this record already exists, Record can't be deleted!"]);
        } else {
           
            $oldstate = University::find($id);
        
            if (!$oldstate) {
                return response()->json(['status' => 'error', 'message' => 'University record not found.']);
            }
        
            $deletedData = $oldstate->toArray();
        
            $delete = DB::table('university_master')->where('id', $id)->delete();
        
            if ($delete) {
              
                $userId = Auth::user()->id;
                $this->storeDeleteHistory($userId, 'University Master', 'Delete', $deletedData);
        
                return response()->json(['status' => 'success', 'message' => 'Successfully deleted Record']);
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

    public function universityedit(Request $request){
       $id = $request->id;

       $update = DB::table('university_master')->where('id' , $id)->get();

       return $update;

    }

    public function universityupdate(Request $request){
        // dd($request->all());
        $id = $request->id;
        $city = $request->city;
        $university = $request->university; // akash
        $address = $request->address;
        $zipCode = $request->zipCode;
        $Established = $request->Established;
        $Country = $request->Country;
        $state = $request->state;
        $city = $request->city;
        $university_type = $request->university_type;
        $update_description = $request->update_description;

        $rules = [
            'university' => 'required', // akash
            'zipCode' => 'nullable|integer|min:100000|max:999999',
            'imageupdate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'logoupdate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'Established' => 'sometimes|nullable|integer|min:1801|max:' . date('Y'),
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $updateData = [
            'name' => $university,
            'address' => $address,
            'city' => $city,
            'pincode' => $zipCode,
            'country' => $Country,
            'state' => $state,
            'university_type' => $university_type,
            'established' => $Established,
            'description' => $update_description,
        ];

        if ($request->hasFile('imageupdate')) {
            $image = $request->file('imageupdate');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->imageupdate->move(public_path('college'), $imageName);
            $updateData['image'] = $imageName;
        }

        if ($request->hasFile('logoupdate')) {
            $logo = $request->file('logoupdate');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $request->logoupdate->move(public_path('college/logo'), $logoName);
            $updateData['logo'] = $logoName; 
        }

        $update = DB::table('university_master')->where('id', $id)->update($updateData);

        if($update){

            $oldstate = University::find($request->id);
          
            $old = [];
            $new = [];

            $fields = ['address', 'state', 'pincode', 'country', 'university_type', 'established', 'description'];

            foreach ($fields as $field) {
                $old[$field] = $oldstate->$field;
            }

            foreach ($fields as $field) {
                $new[$field] = $request->$field;
            }            
        
            $user_id = Auth::user()->id;
    
            $st = $this->Storehistory($user_id, 'University', 'Update', $old , $new);

            return response()->json(['status' => 'success', 'message' => 'Record Update successfully']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Update Record failed!']);
        }

    }

    public function getstate(Request $request){
       $id = $request->id;

       $data=DB::table('state_master')->where('country_id',$id)->orderBy('state_name', 'asc')->get();

       if($data){
        return response()->json(array('status'=>'success', 'data' => $data));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
    }

    }

    public function getcity(Request $request){
    
        $data=DB::table('city_master')->where('state_id',$request->id)->orderBy('city_name', 'asc')->get();
        if($data){
            return response()->json(array('status'=>'success', 'data' => $data));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'Record not found.'));
        }

    }

}
