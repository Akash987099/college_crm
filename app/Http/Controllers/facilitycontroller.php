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

class facilitycontroller extends Controller
{
    public function facility(){

        $id = Auth::user()->id;

        $facility = DB::table('user_facility_trans')->where('user_id' , $id)->first();

        return view('user.facility' , compact('facility'));
    }

    public function facilitylist(Request $request){

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

        $data = DB::table('user_facility')
    ->where('user_facility.user_id', $userid)
    ->join('facility_master', 'user_facility.facility_id', '=', 'facility_master.id');

    $data = $data->select('user_facility.*', 'facility_master.image as facility_image',  'facility_master.name as facility_name' ,
     'user_facility.image as image', 'user_facility.id as id' );

if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
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
        foreach($list as $sno => $record){
               $id = $record->id;
               $image = $record->image;
               $name = $record->facility_name;
          
               $action = "";
               if(EditPermission(5)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
               }
               if(DeletePermission(5)){
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
                  "name" => $name,
                  "image" => $image,
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

    public function facilityadd(Request $request){
       $about = $request->editorContent;
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

         $lastInsertId = DB::table('user_facility_trans')->insert([
            'user_id' => $id,
            'title_tmp'    => $title,
            'description_tmp' => $about,
         ]);

         if($lastInsertId){
            return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Fialed!']);
        }

    }

    public function facilityupdate(Request $request){
        // dd($request->all());
        // $id = Auth::user()->id;
        // dd($request->all());
        $editorContent = $request->editorContent;
        $id = $request->aboutid;
        $update_title = $request->update_title;
        $update_about = $request->update_about;

        $rules = [
            'editorContent' => 'required',
            'update_title' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }
        
         $update = DB::table('user_facility_trans')
             ->where('id', $id) 
             ->update([
                 'title_tmp' => $update_title,
                 'description_tmp' => $editorContent,
                 'approved' => "0",
             ]);
        
        if ($update) {
            return response()->json(['status' => 'success', 'message' => 'Update Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed!']);
        }
    }

    public function facilityserach(Request $request){
        $query = $request->get('query');
        
        $results = DB::table('facility_master')->where('name', 'like', '%' . $query . '%')->get();

        return response()->json($results);
    }

    public function facilitysave(Request $request){
        dd($request->all());
    }

    public function facilityaddsave (Request $request){
        //  dd($request->all())
        $autoCompletewithSelect2 = $request->autoCompletewithSelect2;
        $facility = $request->facility;
        $userid = Auth::user()->id;
      
        $rules = [
            'facility' => 'unique:facility_master,name',
         ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }


        if($request->image == NULL && $autoCompletewithSelect2){

            if($autoCompletewithSelect2){
 
                $userId = Auth::user()->id;
            
            $rules = [
                'autoCompletewithSelect2' => 'unique:user_facility,facility_id,NULL,id,user_id,' . $userId,
             ];

             $validator = Validator::make($request->all(), $rules);
             if ($validator->fails()) {
                 return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

            $insert = DB::table('user_facility')->insert([
                'facility_id' => $autoCompletewithSelect2,
                'user_id' => $userid,
            ]);

            if($insert){
                return response()->json(['status' => 'success' , 'message' => 'Saved Successfully']);
            }else{
                return response()->json(['status' => 'error' , 'message' => 'Failed']);
            }
        }

        return response()->json(['status' => 'error' , 'message' => 'Failed']);

        }else{


            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'facility' => 'required|unique:facility_master,name',
             ];

             $validator = Validator::make($request->all(), $rules);
             if ($validator->fails()) {
                 return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('icons'), $imageName);

          $lastInsertedId = DB::table('facility_master')->insertGetId([
            'name' => $facility,
            'user_id' => $userid,
            'image'  => $imageName
        ]);
        
        if($lastInsertedId){

            $rules = [
                'lastInsertedId' => 'unique:user_facility,facility_id',
             ];

             $validator = Validator::make($request->all(), $rules);
             if ($validator->fails()) {
                 return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

            //  if($facility === NULL){
                $insert = DB::table('user_facility')->insert([
                    'facility_id' => $lastInsertedId,
                    'user_id' => $userid,
                    'image'  => $imageName
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
      return response()->json(['status' => 'error' , 'message' => 'Failed']);

    }

    public function facilityeditajax(Request $request){
       $id = $request->id;

       $data = DB::table('user_facility')
    ->where('user_facility.id', $id)
    ->join('facility_master', 'user_facility.facility_id', '=', 'facility_master.id')
    ->select('user_facility.*', 'facility_master.name as facility_name', 'facility_master.image as facility_image' , 'user_facility.image as image')
    ->get();
       return $data;
    }

    public function facilitydeleteajax(Request $request){
        $id = $request->id;

        $delete = DB::table('user_facility')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if($delete){
            return response()->json(['status' => 'success' , 'message' => 'Delete Successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
    }

    public function facilityupdateajax(Request $request){
        // dd($request->all());
        $id_input = $request->id_input;
        $name_input = $request->name;

        $userid = Auth::user()->id;
 
        $rules = [
         'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        //  'name' => 'required|unique:facility_master,name,',
         'name' => 'required',
      ];
 
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
     }

        $imageName = null;

        if ($request->hasFile('image')) {
           $imageName = time() . '.' . $request->image->extension();
           $request->image->move(public_path('icons'), $imageName);
       }
   
       try {
           $updateData = [
               'user_id' => $userid,
           ];
       
           if ($imageName !== null) {
               $updateData['image'] = $imageName;
           }
       
           $updateResult = DB::table('user_facility')
               ->where('id', $id_input)
               ->update($updateData);
       
               if($updateResult){

                

                $update = DB::table('facility_master')->where('id' , $id_input)->update([
                    'name' => $name_input,
                ]);
                   return response()->json(['status' => 'success', 'message' => 'Update Successfully ']);
               }else{
                   return response()->json(['status' => 'error', 'message' => 'failed!']);
               }
       } catch (\Exception $e) {
           
           return response()->json(['status' => 'error' , 'message' => 'Failed']);
       }
 
         
    }

    ////////////////////////////////    start upcoming  ////////////////////////////////////////////

    public function upcoming(Request $request){
        return view('user.upcoming');
    }

    public  function upcominglist(Request $request){
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

        $data = DB::table('events_master')
    ->where('user_id', $userid);
   
if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('link', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'link' && $columnSortOrder === 'asc') {
            $data->orderBy('link', 'asc');
        } elseif ($columnName === 'link' && $columnSortOrder === 'desc') {
            $data->orderBy('link', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $image = $record->image;
               $link = $record->link;
          
               $action = "";
               if(EditPermission(7)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
        }
        if(DeletePermission(7)){
            if($record->delete_status == 1){
                $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                  }else{
                     $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                  }
            //    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }

    if($record->link  == NULL){
            $linkdata = $record->link_tmp;
    }else{
        $linkdata = $link;
    }
               

            $data_arr[] = array(
                "id" => ++$start,
                  "link" => $linkdata,
                  "image" => $image,
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

    public function upcomingadd(Request $request){
       $link = $request->link;
       $editorContent = $request->editorContent;

       $rules = [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'link' => 'required',
        'editorContent' => 'required',
     ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $userid = Auth::user()->id;

    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('events'), $imageName);

    $lastInsertId = DB::table('events_master')->insert([
        'user_id' => $userid,
        'link_tmp' => $link,
        'image' => $imageName,
        'description_tmp' => $editorContent,
        'approved' => "0",
    ]);

    if($lastInsertId){

        return response()->json(['status' => 'success', 'message' => 'Saved Successfully ']);
    }else{
        return response()->json(['status' => 'error', 'message' => 'failed!']);
    }

    }

    public function upcomingdelete(Request $request){
        $id = $request->id;

        $delete = DB::table('events_master')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'Delete Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }
    }

    public function upcomingedit(Request $request){

        $id = $request->id;

        $data = DB::table('events_master')->where('id' , $id)->get();

        $data_arr = array();
        foreach($data as $key => $val){

            $id = $val->id;
            $link = $val->link;
            $image = $val->image;
            $content = $val->content;

            if($link == NULL && $content == NULL){
                $link = $val->link_tmp;
                $content = $val->description_tmp;
            }

            $data_arr[] = array(
                  "id" => $id,
                  "link" => $link,
                  "image" => $image,
                  "content" => $content,
            );

        }
        $data = $data_arr;
        return $data;

    }

    public function upcomingupdate(Request $request){
        
        $id = $request->userupdateid;
        $link = $request->link;
        $editorContent = $request->editorContent;
        $image = $request->image;

        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'required',
            'editorContent' => 'required',
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }

         $userid = Auth::user()->id;

         $imageName = null;

         if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('events'), $imageName);
        }
    
        try {
            $updateData = [
                'user_id' => $userid,
                'link_tmp' => $link,
                'description_tmp' => $editorContent,
                'approved' => "0",
            ];
        
            if ($imageName !== null) {
                $updateData['image'] = $imageName;
            }
        
            $updateResult = DB::table('events_master')
                ->where('id', $id)
                ->update($updateData);
        
                if($updateResult){
                    return response()->json(['status' => 'success', 'message' => 'Update Successfully ']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'failed!']);
                }
        } catch (\Exception $e) {
            
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

    }
    
}
