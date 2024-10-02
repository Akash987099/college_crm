<?php

namespace App\Http\Controllers;

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

class bordcontroller extends Controller
{
    public function borddata(Request $request){
        // dd($request->all());
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

        $id = Auth::user()->id;

        $data = DB::table('bord_of_director')->where('user_id' , $id);

        if($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('name', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
            $data->orderBy('name', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        $id = "0";
        foreach($list as $sno => $record){
               $id = $record->id;
               $name = $record->name_tmp;
               $designation = $record->designation_tmp;
               $qualification = $record->qualification_tmp;

               if($name == NULL && $designation == NULL){
                $name = $record->name;
                $designation = $record->designation;
                $qualification = $record->qualification;
               }
                
               $action = "";
              if(EditPermission(2)){
            $action = '&nbsp;<a class="dropdown-items update" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
              }

            if(DeletePermission(2)){
             if($record->delete_status == 0){
            $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                   }else{
             $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                   }
        }

            $data_arr[] = array(
                "id" => ++$start,
                  "name" => $name,
                  "designation" => $designation,
                  "qualification" => $qualification,
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

    public function addbord (Request $request){
        // dd($request->all());
        $name = $request->name;
        $designation = $request->designation;
        $qualification = $request->qualification;
        $userid = Auth::user()->id;



        $rules = [
            'name' => 'required',
            'designation' => 'required',
            'qualification' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
         ];

         $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('image'), $imageName);

   

    $insert = DB::table('bord_of_director')->insert([
    'user_id' => $userid,
    'name_tmp' => $name,
     'image_tmp' => $imageName,
    'qualification_tmp' => $qualification,
    'designation_tmp' => $designation,
    'approved'  => "0"
]);

if ($insert) {
  
    return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
} else {
   
    return response()->json(['status' => 'error' , 'message' => 'Failed']);
} 
    }

    public function deletebord(Request $request){
        $id = $request->id;
        // dd($request->all());
  
        $delete = DB::table('bord_of_director')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if ($delete) {
  
            return response()->json(['status' => 'sussess' , 'message' => 'Delete request has been sent to admin!. Please wait ..']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

    }

    public function getidborddata(Request $request){
       $id = $request->id;

       $data = DB::table('bord_of_director')->where('id' , $id)->get();

       $data_arr = array();
       foreach($data as $key => $val){
          $id = $val->id;
          $name = $val->name;
          $qualification = $val->qualification;
          $designation = $val->designation;
          $image = $val->image;

          if($val->approved == 0){
          $name = $val->name_tmp;
          $qualification = $val->qualification_tmp;
          $designation = $val->designation_tmp;
          $image = $val->image_tmp;
          }

        $data_arr[] = array(
            "id" => $id,
           "name" => $name,
           "image" => $image,
           "qualification" => $qualification,
           "designation" => $designation,
        );
       }
         $data = $data_arr;
       return $data;
    }

    public function updatebord(Request $request){
        // dd($request->all());
       $dataid = $request->dataid;
       $update_name = $request->update_name;
       $update_designation = $request->update_designation;
       $update_qualification = $request->update_qualification;

       $rules = [
        'update_name' => 'required',
        'update_designation' => 'required',
        'update_qualification' => 'required',
        'update_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ];

     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()) {
    return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }

         $updateData = [
            'name_tmp' => $update_name,
            'qualification_tmp' => $update_qualification,
            'designation_tmp' => $update_designation,
            'approved'  => "0"
           ];

           if ($request->hasFile('update_image')) {
            $image = $request->file('update_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->update_image->move(public_path('image'), $imageName);
            $updateData['image'] = $imageName;
        }

        $update = DB::table('bord_of_director')->where('id', $dataid)->update($updateData);

        if($update){
            return response()->json(['status' => 'success', 'message' => 'Updated successfully']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Update Record failed!']);
        }
   
    }

    public function gallery(){
        return view('user.gallery');
    }

    public function uploadimage(Request $request){
        // dd($request->all());
        $ranke = $request->ranke;
        // $images = $request->file('docs');
        $userid = Auth::user()->id;

        $rules = [
            'ranke' => [
                'required',
                Rule::unique('gallery_master')->where(function ($query) use ($userid) {
                    return $query->where('user_id', $userid)
                                 ->where('ranke', request()->input('ranke'));
                }),
            ],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        //   $exit = DB::table("gallery_master")->where();

         
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

             $imageName = time() . '.' . $request->image->extension();
             $request->image->move(public_path('icons'), $imageName);

    $insert = DB::table('gallery_master')->insert([
         "ranke" => $ranke,
        "user_id" => $userid, // Use $userid instead of $assign
        "image"   => $imageName
    ]);

    if ($insert) {
  
        return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
    } else {
       
        return response()->json(['status' => 'error' , 'message' => 'Failed']);
    }

    }  

    public function gallerylist(Request $request){

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

        $data = DB::table('gallery_master')
    ->where('user_id', $userid);
    
if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('facility_name', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('facility_name', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
            $data->orderBy('facility_name', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $rank = $record->ranke;
               $image = $record->image;
          
               $action = "";
               if(EditPermission(3)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
               }
               if(DeletePermission(3)){
                 if($record->delete_status == 1){
               $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                 }else{
                    $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                 }
            }

               if($image == NULL){
                $image = $record->facility_image;
               }

            $data_arr[] = array(
                "id" => ++$start,
                  "image" => $image,
                  "rank" => $rank,
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

    public function gallerydelete(Request $request){
        $id = $request->id;

        $delete = DB::table('gallery_master')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if ($delete) {
  
            return response()->json(['status' => 'sussess' , 'message' => 'Delete request has been sent to admin!. Please wait ..']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
    }

    public function galleryedit(Request $request){
        $id = $request->id;

        $data = DB::table('gallery_master')->where('id' , $id)->get();

        return $data;
    }

    public function galleryupdate(Request $request){
        // dd($request->all());
        $ranke = $request->ranke;
        $updateid = $request->updateid;
        $userid = Auth::user()->id;

        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ];
    
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

             $exit = DB::table('gallery_master')->where('id' , $updateid)->where('ranke' , $ranke)->first();

             if($exit){

                $updateData = [
                    "ranke" => $ranke,
                    "user_id" => $userid,
                ];

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('icons'), $imageName);
                    $updateData['image'] = $imageName;
                }

                $insert = DB::table('gallery_master')->where('id' , $updateid)->update($updateData);
                if ($insert) {
  
                    return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
                } else {
                   
                    return response()->json(['status' => 'error' , 'message' => 'Failed']);
                }
             }else{

                $rules = [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                 ];
            
                 $validator = Validator::make($request->all(), $rules);
                 if ($validator->fails()) {
                return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
                     }

                $updateData = [
                    "ranke" => $ranke,
                    "user_id" => $userid,
                ];

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('icons'), $imageName);
                    $updateData['image'] = $imageName;
                }

                $insert = DB::table('gallery_master')->where('id' , $updateid)->update($updateData);
                if ($insert) {
  
                    return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
                } else {
                   
                    return response()->json(['status' => 'error' , 'message' => 'Failed']);
                }
             }

    }
}
