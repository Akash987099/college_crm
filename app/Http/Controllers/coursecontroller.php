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

class coursecontroller extends Controller
{
    public function course(){
        $userid = Auth::user()->id;
        $program = DB::table('user_program')->where('user_program.user_id' , $userid)
                         ->join('program_master' , 'user_program.program_id' , '=' , 'program_master.id')
                         ->get();
        return view('user.course' , compact('program'));
    } 

    public function courseadd(Request $request){
        // dd($request->all());
        $rank = $request->rank;
        $fees = $request->fees;
        $seat = $request->seat;
        $duration = $request->duration;
        $eligibility = $request->eligibility;
        $coursetype = $request->coursetype;
        $courselevel = $request->courselevel;
        $editorContent = $request->editorContent;

        // feespdf
        // admissionpdf
        // eligibilitypdf

        $rules = [
            
            

            'rank'  => 'required',
            'fees'  => 'required',
            'seat'  => 'required',
            'duration'  => 'required',
            'eligibility'  => 'required',
            'coursetype'  => 'required',
            'courselevel'  => 'required',
            'editorContent'  => 'required',

         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
             }

             $userid = Auth::user()->id;

             

        $lastInsertId = DB::table('courses')->insert([
            'user_id' => $userid,
            'program_id' => $rank,
            'fees'  => $fees,
            'duration' => $duration,
            'eligibility' => $eligibility,
            'course_type' => $coursetype,
            'level'     => $courselevel,
            'seat'    => $seat,
            'description_tmp'    => $editorContent,
            'approved' => "0",
        ]);

        if ($lastInsertId) {
            return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

    }

    public function courselist(Request $request){

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

        $data = DB::table('courses')
    ->where('courses.user_id', $id)
    // ->join('user_program', 'courses.program_id', '=', 'user_program.program_id')
    ->join('program_master', 'courses.program_id', '=', 'program_master.id')
    ->select('courses.*', 'program_master.name as name', 'courses.fees as fees' , 'courses.course_type as type',
        'courses.level as level' , 'courses.seat as seat' ,'courses.id as course_id');


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
               $id = $record->course_id;
               $name = $record->name;
               $fees = $record->fees;
               $type = $record->type;
               $level = $record->level;
               $seat = $record->seat;
                
               $action = "";
                if(EditPermission(6)){
           $action = '&nbsp;<a class="dropdown-items update" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
                }
                if(DeletePermission(6)){
                    if($record->delete_status == 1){
                        $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                          }else{
                             $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                          }
        //    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

            $data_arr[] = array(
                "id" => ++$start,
                  "name" => $name,
                  "fees" => $fees,
                  "type" => $type,
                  "level" => $level,
                  "seat" => $seat,
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

    public function coursedelte(Request $request){
        $id = $request->id;

        $delete = DB::table('courses')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if ($delete) {
  
            return response()->json(['status' => 'sussess' , 'message' => 'Saved Successfully!']);
        } else {
           
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }

    }

    public function courseedit(Request $request){
        $id = $request->id;
        $data = DB::table('courses')
        ->where('courses.id', $id)
        ->join('program_master', 'courses.program_id', '=', 'program_master.id')
        ->select('courses.*', 'program_master.name as name', 'courses.fees as fees' , 'courses.course_type as type',
            'courses.level as level' , 'courses.id as id' , 'courses.program_id as program_id')->get();
            $data_arr = array();
            foreach ($data as $key => $val) {
                    $id = $val->id;
                    $name = $val->name;
                    $fees = $val->fees;
                    $type = $val->type;
                    $level = $val->level;
                    $program_id = $val->program_id;
                    $seat = $val->seat;
                    $duration = $val->duration;
                    $eligibility = $val->eligibility;
                    $coursetype = $val->course_type;

                    if($val->approved == "0"){
                        $description = $val->description_tmp;
                    }else{
                        $description = $val->description;
                    }

                $data_arr[] = array(
                      "id" => $id,
                      "name" => $name,
                      "fees" => $fees,
                      "type" => $type,
                      "level" => $level,
                     "program_id" => $program_id,
                     "seat" => $seat,
                     "duration" => $duration,
                     "eligibility" => $eligibility,
                     "course_type" => $coursetype,
                     "description" => $description,
                );

            }
                 return $data = $data_arr;
            return $data;

    }

    public function courseupdate(Request $request){
        // dd($request->all());
        $id = $request->updateid;
        $rank = $request->rank;
        $fees = $request->fees;
        $seat = $request->seat;
        $duration = $request->duration;
        $eligibility = $request->updateeligibility;
        $coursetype = $request->coursetype;
        $courselevel = $request->courselevel;
        $editorContent = $request->editorContent;

        $rules = [
            
            'feespdf' => 'mimes:pdf|max:2048',
            'admissionpdf' => 'mimes:pdf|max:2048',
            'eligibilitypdf' => 'mimes:pdf|max:2048',

           'rank'  => 'required',
           'fees'  => 'required',
           'seat'  => 'required',
           'duration'  => 'required',
           'updateeligibility'  => 'required',
           'coursetype'  => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
       return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
            }

            $userid = Auth::user()->id;

            $feespdf = null;
            $admissionpdf = null;
            $eligibilitypdf = null;
            
            if ($request->hasFile('feespdf')) {
                $feespdf = time() . '.' . $request->feespdf->extension();
                $request->feespdf->move(public_path('pdf'), $feespdf);
            }
            
            if ($request->hasFile('admissionpdf')) {
                $admissionpdf = time() . '.' . $request->admissionpdf->extension();
                $request->admissionpdf->move(public_path('pdf'), $admissionpdf);
            }
            
            if ($request->hasFile('eligibilitypdf')) {
                $eligibilitypdf = time() . '.' . $request->eligibilitypdf->extension();
                $request->eligibilitypdf->move(public_path('pdf'), $eligibilitypdf);
            }
            
            try {
                $updateData = [
                    'user_id' => $userid,
                    'program_id' => $rank,
                    'fees'  => $fees,
                    'duration' => $duration,
                    'eligibility' => $eligibility,
                    'course_type' => $coursetype,
                    'level'     => $courselevel,
                    'seat'    => $seat,
                    'description_tmp'    => $editorContent,
                    'approved' => "0",
                ];
            
                if ($feespdf !== null) {
                    $updateData['fees_pdf'] = $feespdf;
                }
            
                if ($admissionpdf !== null) {
                    $updateData['admission_pdf'] = $admissionpdf;
                }
            
                if ($eligibilitypdf !== null) {
                    $updateData['eligibility_pdf'] = $eligibilitypdf;
                }
            
                $updateResult = DB::table('courses')
                    ->where('id', $id)
                    ->update($updateData);
            
                if (!$updateResult) {
                    throw new \Exception("Failed to update record in the database.");
                }
            } catch (\Exception $e) {
                
                return response()->json(['status' => 'error' , 'message' => 'Failed']);
            }

       if ($updateResult) {
 
           return response()->json(['status' => 'sussess' , 'message' => 'Update Successfully!']);
       } else {
          
           return response()->json(['status' => 'error' , 'message' => 'Failed']);
       }
        
    }

    ///////////////////////// admission start ///////////////////////

    public function addmission(Request $request){
        return view('user.admission');
    }

    public function addmissionadd(Request $request){

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

    $lastInsertId = DB::table('admission_master')->insert([
        'user_id' => $userid,
        'link_tmp' => $link,
        'image' => $imageName,
        'approved' => "0",
        'description_tmp' => $editorContent,
    ]);

    if($lastInsertId){
       
        return response()->json(['status' => 'success', 'message' => 'Saved Successfully ']);
    }else{
        return response()->json(['status' => 'error', 'message' => 'failed!']);
    }

    }

    public function addmissionlist(Request $request){

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

        $data = DB::table('admission_master')
    ->where('user_id', $userid)
    // ->orderByDesc('events_master.id');
;   
if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('link', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('link', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
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

               if($link == NULL){
                $link = $record->link_tmp;
               }
          
               $action = "";

               if(EditPermission(8)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
               }

               if(DeletePermission(8)){
                if($record->delete_status == 1){
                    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                      }else{
                         $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                      }
             }
               

            $data_arr[] = array(
                "id" => ++$start,
                  "link" => $link,
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

    public function addmissiondelete(Request $request){
        $id = $request->id;

        $delete = DB::table('admission_master')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'Delete Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }
    }

    public function addmissionedit(Request $request){
        $id = $request->id;

        $data = DB::table('admission_master')->where('id' , $id)->get();
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

    public function addmissionupdate(Request $request){
        // dd($request->all());
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
                'approved' => "0",
                'description_tmp' => $editorContent,
            ];
        
            if ($imageName !== null) {
                $updateData['image'] = $imageName;
            }
        
            $updateResult = DB::table('admission_master')
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

    public function tbl(){
        return view('user.tbl');
    }

    public function tbladd(Request $request){
       
        $rules = [
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,PNG|max:2048',
            'link' => 'required',
            'editorContent' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }
        
        $userId = Auth::user()->id;
        
        $uploadedImagePaths = [];
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('placement'), $imageName);
                $uploadedImagePaths[] = $imageName;
        
                $lastInsertId = DB::table('user_tbl_placement')->insert([
                    'user_id' => $userId,
                    'link_tmp' => $request->link,
                    'image' => $imageName, 
                    'description_tmp' => $request->editorContent,
                    'approved' => "0",
                ]);
        
                if (!$lastInsertId) {

                    return response()->json(['status' => 'error', 'message' => 'Failed to save data']);
                }
            }
        
            return response()->json(['status' => 'success', 'message' => 'Saved Successfully']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'No images were uploaded']);
        
    }

    public function tbllist(Request $request){

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

        $data = DB::table('user_tbl_placement')
        ->where('user_id', $userid);
   
if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('link', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('link', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
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

               if($link == NULL){
                $link = $record->link_tmp;
               }
          
               $action = "";
               if(EditPermission(9)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
               }
               if(DeletePermission(9)){
                if($record->delete_status == 1){
                    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                      }else{
                         $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                      }
            //    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
               }
               

            $data_arr[] = array(
                "id" => ++$start,
                  "link" => $link,
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

    public function tbldelete(Request $request){
        $id = $request->id;

        $delete = DB::table('user_tbl_placement')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'Delete Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }
    }

    public function tbledit(Request $request){
        $id = $request->id;

        $data = DB::table('user_tbl_placement')->where('id' , $id)->get();
        $data_arr = array();
        foreach($data as $key => $val){
                 $id = $val->id;
                 $link = $val->link;
                 $content = $val->content;
                 $image = $val->image;

                 if($val->approved == '0'){
                    $link = $val->link_tmp;
                    $content = $val->description_tmp;
                 }
                 
            $data_arr[] = array(
                  "id" => $id,
                  "link" => $link,
                  "content" => $content,
                  "image" => $image,
            );

        }

        $data = $data_arr;

        return $data;
    }

    public function tableupdate(Request $request){

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

         $updateData = [
            'user_id' => $userid,
                'link_tmp' => $link,
                'description_tmp' => $editorContent,
                'approved' => "0",
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->imageupdate->move(public_path('placement'), $imageName);
            $updateData['image'] = $imageName;
        }

        $update = DB::table('user_tbl_placement')->where('id', $id)->update($updateData);
    
        if($update){
            return response()->json(['status' => 'success', 'message' => 'Record Update successfully']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Update Record failed!']);
        }

    }
    public function acceditations(){
        $id = Auth::user()->id;
        $Recognization = DB::table('accreditations')->where('user_id' , $id)->first();
        return view('user.acceditations' , compact('Recognization'));
    }

    public function acceditationsadd(Request $request){
     
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
     $request->image->move(public_path('accreditations_master'), $imageName);
 
     $lastInsertedId = DB::table('accreditations_master')->insert([
         'user_id' => $userid,
         'title_tmp' => $link,
         'image' => $imageName,
         'description_tmp' => $editorContent,
         'approved' => "0",
     ]);
 
     if($lastInsertedId){

         return response()->json(['status' => 'success', 'message' => 'Saved Successfully ']);
     }else{
         return response()->json(['status' => 'error', 'message' => 'failed!']);
     }
        
    }

    public function acceditationslist(Request $request){
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

        $data = DB::table('accreditations_master')
        ->where('user_id', $userid);
   
if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('title', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'name' && $columnSortOrder === 'asc') {
            $data->orderBy('title', 'asc');
        } elseif ($columnName === 'name' && $columnSortOrder === 'desc') {
            $data->orderBy('title', 'desc');
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $image = $record->image;
               $link = $record->title;

               if($link == NULL){
                $link = $record->title_tmp;
               }
          
               $action = "";
               if(EditPermission(10)){
               $action = '&nbsp;<a class="dropdown-items edit" href="javascript:void(0);"  data-id="'.$id.'" ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
               }

               if(DeletePermission(10)){
                if($record->delete_status == 1){
                    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                      }else{
                         $action .='&nbsp;&nbsp;<i class="fa fa-clock-o" aria-hidden="true" style="color:red;"></i>';
                      }
            //    $action .= '&nbsp;<a class="dropdown-items delete" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
               }
               

            $data_arr[] = array(
                "id" => ++$start,
                  "link" => $link,
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

    public function acceditationsdelete(Request $request){
        $id = $request->id;

        $delete = DB::table('accreditations_master')->where('id' , $id)->update([
            'delete_status' => "0"
        ]);

        if($delete){
            return response()->json(['status' => 'success', 'message' => 'Delete Successfully ']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'failed!']);
        }
    }

    public function acceditationsedit(Request $request){
        $id = $request->id;

        $data = DB::table('accreditations_master')->where('id' , $id)->get();
        $data_arr = array();
        foreach ($data as $key => $val) {
           $id = $val->id;
           $title = $val->title;
           $content = $val->content;
           $image = $val->image;

           if($title == NULL && $content == NULL){
            $title = $val->title_tmp;
            $content = $val->description_tmp;
           }

            $data_arr[] = array(
                  "id" => $id,
                  "title" => $title,
                  "image" => $image,
                 "content" => $content,
            );
        }
        $data = $data_arr;
        return $data;
    }

    public function acceditationsupdate(Request $request){

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
            $request->image->move(public_path('accreditations'), $imageName);
        }
    
        try {
            $updateData = [
                'user_id' => $userid,
                'title_tmp' => $link,
                'description_tmp' => $editorContent,
                'approved' => "0",
            ];
        
            if ($imageName !== null) {
                $updateData['image'] = $imageName;
            }
        
            $updateResult = DB::table('accreditations_master')
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

    public function Recognization(Request $request){
            //    dd($request->all());
        $id = $request->userupdateid;
        $link = $request->link;
        $editorContent = $request->editorContent;
        $image = $request->image;

        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'link' => 'required',
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
            $request->image->move(public_path('accreditations'), $imageName);
        }
    
        try {
            $updateData = [
                'user_id' => $userid,
                'title_tmp' => $link,
                'description_tmp' => $editorContent,
                'approved' => "0",
            ];
        
            if ($imageName !== null) {
                $updateData['image'] = $imageName;
            }
        
            $updateResult = DB::table('accreditations')
                ->insert($updateData);
        
                if($updateResult){  
                    return response()->json(['status' => 'success', 'message' => 'Successfully ']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'failed!']);
                }
        } catch (\Exception $e) {
            
            return response()->json(['status' => 'error' , 'message' => 'ghyjrjtdfdsbhe']);
        }

    }

    public function Recognizationupdate(Request $request){
        // dd($request->all());
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
            $request->image->move(public_path('accreditations_master'), $imageName);
        }
    
        try {
            $updateData = [
                'user_id' => $userid,
                'title_tmp' => $link,
                'description_tmp' => $editorContent,
                'approved' => "0",
            ];
        
            if ($imageName !== null) {
                $updateData['image'] = $imageName;
            }
        
            $updateResult = DB::table('accreditations')
                ->where('id' , $id)
                ->update($updateData);
        
                if($updateResult){  
                    return response()->json(['status' => 'success', 'message' => 'Successfully ']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'failed!']);
                }
        } catch (\Exception $e) {
            
            return response()->json(['status' => 'error' , 'message' => 'Failed']);
        }
    }
}
