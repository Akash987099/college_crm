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
use App\Models\City; 
use App\Models\HistoryReport;
use App\Models\User;
use App\Models\about;
use App\Models\user_facility;
use App\Models\course;
use App\Models\event;
use App\Models\admission;
use App\Models\tbl;
use App\Models\user_trans;
use App\Models\bord;
use App\Models\recognitions;
use App\Models\accreditation;
use Illuminate\Support\Carbon;
use Auth, DB;

class approvedcontroller extends Controller
{
    public function Approved(){

        $data = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
        return view('admin.approved' , compact('data'));
    }

    public function Approvedlist(Request $request){

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

        // $userIdToExclude = Auth::user()->id;


           $data = DB::table('about_master')
                       ->join('users' , 'about_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                       ->select('about_master.*', 'about_master.id as id' , 'users.username as username' , 'users.id as user_id')
                       ->orderByDesc('about_master.id');
   
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        // $id = "0";
        foreach($list as $sno => $record){
                $id = $record->id;
                $user_id = $record->user_id;
                $approed = $record->approved;
                $username = $record->username;
          
            if($approed == 1){
               
                $title = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->title).'">' .
                Str::limit($record->title, 500) .
                '</span>';
                
                $description = $record->description;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{

                $title = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->title_tmp).'">' .
                Str::limit($record->title_tmp, 500) .
                '</span>';

                $description = $record->description_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }


            $data_arr[] = array(
                "id" => ++$start,
                "username" => $username,
              "title" => $title,
              "description" => $description,
              "status"   => $status,
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

    public function getaboutbydatabyid(Request $request){
       $id = $request->id;

       $data = DB::table('about_master')->where('id' , $id)->get();

       return $data;
    }

    public function approvedaboutupdate(Request $request){
      $aboutid = $request->aboutid;
      $editorContent = $request->editorContent;
      $title = $request->title;

      $update = DB::table('about_master')->where('id' , $aboutid)->update([

        'title' => $title,
        'description' => $editorContent,
        'title_tmp' => null,
        'description_tmp' => null, 
        'approved' => "1",

      ]);

      if($update){
      
            return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'failed!'));
        }

    }

    public function aboutchangestatus(Request $request)
    {
        $id = $request->id;

        $data = DB::table('about_master')->where('id', $id)->first();
        
        if ($data) {
            $title = $data->title;
            $description = $data->description;

            $title_status = $data->title_tmp;
            $description_status = $data->description_tmp;
        
            $update = DB::table('about_master')->where('id', $id)->update([
                'title' =>   $title_status,
                'description' => $description_status,
                'title_tmp' => NULL,
                'description_tmp' => NULL,
                'approved' => "1",
            ]);
            
            // dd($update);

            if ($update) {
                
                $oldstate = About::find($request->id);
               
                $old  = [
                    'title' => $title,
                    'description' => $description,
                ];

                $new  = [
                    'title' => $title_status,
                    'description' => $description_status,
                ];

                $user_id = $oldstate->user_id;
        
                $st = $this->Storehistory($user_id, 'about Master', 'Update', $old , $new);

                if($st){
                    return response()->json(['status' => 'success', 'message' => 'Approved Successfully']);
                }
        
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update about_master']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Record not Found!']);
        }
        
    }
   
    private function Storehistory($user_id, $program, $mode, $old , $new)
    {
        $store = DB::table('history_reports')->insert([
            'user_id' => $user_id,
            'name' => $program,
            'old_value' => json_encode($old),
            'new_value' => json_encode($new),
            'mode' => $mode,
        ]);
    
        return true;
    }
    
public function facilityapproved(){
    return view('admin.facilityapproved');
}

public function facilityapprovedview(Request $request){

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


    $data = DB::table('user_facility_trans')
            ->join('users' , 'user_facility_trans.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
              ->orderByDesc('user_facility_trans.id');
    // ->join('users', 'user_facility.user_id', '=', 'users.id');
    // ->where('user_facility.approved', '=', 0);


    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();
    

      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            

            $user = DB::table('users')->where('id' , $record->user_id)->first();
            $username = $user->username;
                     
            if ($approved == 1) {
                $title = $record->title;
                $description = $record->content;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
            }
            else{
            $title = $record->title_tmp;
            $description = $record->description_tmp;
            $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
            $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
            }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "title" => $title,
          "description" => $description,
          "status"   => $status,
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

public function getfacilitydatabyid(Request $request){
    $id = $request->id;

       $data = DB::table('user_facility_trans')->where('id' , $id)->get();
       $data_arr = array();
       foreach($data as $key => $val){
 
        $id = $val->id;
        $title = $val->title;
        $description = $val->content;

        if($title == NULL && $description == NULL){
            $title = $val->title;
            $description = $val->description_tmp;
        }

        $data_arr[] = array(
            "id" => $id,
          "title" => $title,
          "description" => $description,
        );

       }
           $data = $data_arr;
       return $data;
}

public function approvedfacilityupdate(Request $request){
   
    
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    $title = $request->title;
    // dd($aboutid);
    $update = DB::table('user_facility')->where('id' , $aboutid)->update([

      'title' => $title,
      'description' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('user_facility')->where('id', $aboutid)->update([
          'title_tmp' => null,
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('user_facility')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }

}

public function facilitychangestatus(Request $request){
    //  dd($request->all());
    $id = $request->id;

    $data = DB::table('user_facility_trans')->where('id', $id)->first();

    if ($data) {
        $title_status = $data->title_tmp;
        $description_status = $data->description_tmp;

        $title = $data->title;
        $description= $data->content;

        $update = DB::table('user_facility_trans')->where('id', $id)->update([
            'title' => $title_status,
            'content' => $description_status,
            'approved' => "1",
        ]);

        if ($update) {

            $update = DB::table('user_facility_trans')->where('id', $id)->update([
                'title_tmp' => null,
                'description_tmp' => null,
            ]);

            $oldstate = user_trans::find($request->id);
               
            $old  = [
                'title' => $title,
                'description' => $description,
            ];

            $new  = [
                'title' => $title_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'User Facility Trans', 'Update', $old , $new);

            if ($st) {
               
                return response()->json(['status' => 'success', 'message' => 'Approved Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update title_status and description_status']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } 

}

public function courseapproved(){
    return view('admin.course-approved');
}

public function courseapprovedview(Request $request){

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


       $data = DB::table('courses')
                   ->join('users' , 'courses.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('courses.*', 'courses.id as id' , 'users.username as username')
                   ->orderByDesc('courses.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
            // $title = $record->title_tmp;
            $description = $record->description_tmp;
            

            if($approved == 1){
                $description = $record->description;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $description = $record->description_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
        //   "title" => $title,
          "description" => $description,
          "status"   => $status,
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

public function courseapprovedgetbyid(Request $request){
    $id = $request->id;

       $data = DB::table('courses')->where('id' , $id)->get();

       return $data;
}

public function courseschangestatus(Request $request){
    
    $id = $request->id;

    // dd($id);

    $data = DB::table('courses')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $description = $data->description;

        $update = DB::table('courses')->where('id', $id)->update([
            'description' => $description_status,
            'description_tmp' => null,
            'approved' => "1",
        ]);

        if ($update) {

            $oldstate = course::find($request->id);
               
            $old  = [
                'description' => $description,
            ];

            $new  = [
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'Course ', 'Update', $old , $new);
           
                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
       
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function approvedcoursesupdate(Request $request){

    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('courses')->where('id' , $aboutid)->update([

      'description' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('courses')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('courses')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
    
}

public function eventsapproved(){
    return view('admin.events-approved');
}

public function eventsapprovedview(Request $request){
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


       $data = DB::table('events_master')
                   ->join('users' , 'events_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('events_master.*', 'events_master.id as id' , 'users.username as username')
                   ->orderByDesc('events_master.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
            // $title = $record->title_tmp;
            $description = $record->description_tmp;
            

            if($approved == 1){
                $description = $record->content;
                $link = $record->link;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $description = $record->description_tmp;
                $link = $record->link_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "link" => $link,
          "description" => $description,
          "status"   => $status,
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

public function eventsapprovedgetdatabyid(Request $request){
    $id = $request->id;

    $data = DB::table('events_master')->where('id' , $id)->get();

    return $data;
}

public function eventschangestatus(Request $request){
    $id = $request->id;

    // dd($id);

    $data = DB::table('events_master')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $link_status = $data->link_tmp;

        $description = $data->content;
        $link = $data->link;

        $update = DB::table('events_master')->where('id', $id)->update([
            'content' => $description_status,
            'link'   => $link_status  ,
            'approved' => "1",
        ]);

        if ($update) {

            $update = DB::table('events_master')->where('id', $id)->update([
                'description_tmp' => null,
                'link_tmp' => null,
            ]);

            $oldstate = event::find($request->id);
               
            $old  = [
                'link' => $link,
                'description' => $content,
            ];

            $new  = [
                'link' => $link_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'Event Master', 'Update', $old , $new);

        
                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
          
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function approvedevntsupdate(Request $request){
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('events_master')->where('id' , $aboutid)->update([

      'content' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('events_master')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('courses')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
}

public function admissionapproved(){
    return view('admin.admission-approved');
}

public function admissionapprovedview(Request $request){
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


       $data = DB::table('admission_master')
                   ->join('users' , 'admission_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('admission_master.*', 'admission_master.id as id' , 'users.username as username')
                   ->orderByDesc('admission_master.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
            // $title = $record->title_tmp;
            $description = $record->description_tmp;
            

            if($approved == 1){
                // $description = $record->content;
                $link = $record->link;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                // $description = $record->description_tmp;
                $link = $record->link_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "link" => $link,
        //   "description" => $description,
          "status"   => $status,
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

public function admissionapprovedgetdatabyid(Request $request){
    $id = $request->id;

    $data = DB::table('admission_master')->where('id' , $id)->get();

    return $data;
}

public function admissionchangestatus(Request $request){
    $id = $request->id;

    // dd($id);

    $data = DB::table('admission_master')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $link_status = $data->link_tmp;

        $description = $data->content;
        $link = $data->link;

        $update = DB::table('admission_master')->where('id', $id)->update([
            'content' => $description_status,
            'link' => $link_status,
            'description_tmp' => null,
            'link_tmp' => null,
            'approved' => "1",
        ]);

        if ($update) {

            $oldstate = admission::find($request->id);
               
            $old  = [
                'link' => $link,
                'description' => $description,
            ];

            $new  = [
                'link' => $link_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'admission master ', 'Update', $old , $new);
           
            if ($update) {

                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to update title_status and description_status']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function approvedadmissionupdate(Request $request){
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('admission_master')->where('id' , $aboutid)->update([

      'content' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('admission_master')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('admission_master')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
}

public function tblapproved(){
    return view('admin.tbl_approved');
}

public function tblapprovedview(Request $request){
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


       $data = DB::table('user_tbl_placement')
                   ->join('users' , 'user_tbl_placement.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('user_tbl_placement.*', 'user_tbl_placement.id as id' , 'users.username as username')
                   ->orderByDesc('user_tbl_placement.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
           
            if($approved == 1){

                $link = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->link).'">' .
                Str::limit($record->link, 500) .
                '</span>';

                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $link = '<span class="dropdown-items viewaddress" href="javascript:void(0);" ' .
                'style="float:left; color:#000 !important;  white-space: pre-line;" ' .
                'data-id="'.$id.'" title="'.e($record->link_tmp).'">' .
                Str::limit($record->link_tmp, 500) .
                '</span>';
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }
      

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "title" => $link,
        //   "description" => $description,
          "status"   => $status,
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

public function tblapprovedgetdatabyid(Request $request){
    $id = $request->id;

    $data = DB::table('user_tbl_placement')->where('id' , $id)->get();

    return $data;
}

public function tblchangestatus(Request $request){
   
    $id = $request->id;

    // dd($id);

    $data = DB::table('user_tbl_placement')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $link_status = $data->link_tmp;

        $description = $data->content;
        $link = $data->link;

        $update = DB::table('user_tbl_placement')->where('id', $id)->update([
            'content' => $description_status,
            'link' => $link_status,
            'approved' => "1",
            'description_tmp' => null,
            'link_tmp' => null,
        ]);

        if ($update) {
          
            $oldstate = tbl::find($request->id);
               
            $old  = [
                'link' => $link,
                'description' => $description,
            ];

            $new  = [
                'link' => $link_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'training && placement ', 'Update', $old , $new);
        
            return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
          
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function approvedtblupdate(Request $request){
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('user_tbl_placement')->where('id' , $aboutid)->update([

      'content' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('user_tbl_placement')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('user_tbl_placement')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
}

public function accreditationsapproved(Request $request){
    return view('admin.Accreditations');
}

public function accreditationsapprovedview(Request $request){
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


       $data = DB::table('accreditations_master')
                   ->join('users' , 'accreditations_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('accreditations_master.*', 'accreditations_master.id as id' , 'users.username as username')
                   ->orderByDesc('accreditations_master.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
            // $title = $record->title_tmp;
            // $description = $record->description_tmp;
            

            if($approved == 1){
                $description = $record->content;
                $title = $record->title;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $description = $record->description_tmp;
                $title = $record->title_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }
       
        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "title" => $title,
          "description" => $description,
          "status"   => $status,
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

public function accreditationsapproveddetdata(Request $request){
    $id = $request->id;
    // dd($request->all());

    $data = DB::table('accreditations_master')->where('id' , $id)->get();

    return $data;
}

public function accreditationchangestatus(Request $request){

    $id = $request->id;

    // dd($id);

    $data = DB::table('accreditations_master')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $title_status = $data->title_tmp;

        $description = $data->content;
        $title = $data->title;

        $update = DB::table('accreditations_master')->where('id', $id)->update([
            'content' => $description_status,
            'title' => $title_status,
            'approved' => "1",
        ]);

        if ($update) {

            $update = DB::table('accreditations_master')->where('id', $id)->update([
                'description_tmp' => null,
                'title_tmp' => null,
            ]);

            $oldstate = accreditation::find($request->id);
               
            $old  = [
                'title' => $title,
                'description' => $description,
            ];

            $new  = [
                'title' => $title_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'accreditations master ', 'Update', $old , $new);
           
            
                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
          
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }

}

public function approvedaccreditationupdate(Request $request){
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('accreditations_master')->where('id' , $aboutid)->update([

      'content' => $editorContent,

    ]);

    if($update){
     $insert =  DB::table('accreditations_master')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('accreditations_master')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
}

public function recognitionsapproved(){
    return view('admin.recognitions');
}

public function recognitionsapprovedview(Request $request){
    // dd($request-all());
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


       $data = DB::table('accreditations')
                   ->join('users' , 'accreditations.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('accreditations.*', 'accreditations.id as id' , 'users.username as username')
                     ->orderByDesc('accreditations.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
           
            
            if($approved == 1){
                $description = $record->content;
                $title = $record->title;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $description = $record->description_tmp;
                $title = $record->title_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
          "title" => $title,
          "description" => $description,
          "status"   => $status,
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

public function recognitionsapprovedGETDATA(Request $request){
    $id = $request->id;
    // dd($id);

    $data = DB::table('accreditations')->where('id' , $id)->get();
    $data_arr = array();
    foreach($data as $key => $val){
        $id = $val->id;
        $title = $val->title;
        $content = $val->content;

        if($title == NULL && $content == NULL){
            $title = $val->title_tmp;
            $content = $val->description_tmp;
        }

        $data_arr[] = array(
          "id" => $id,
          "title" => $title,
          "description" => $content
        );
    }
    $data = $data_arr;
    return $data;
}

public function recognitionschangestatus(Request $request){
    $id = $request->id;

    // dd($id);

    $data = DB::table('accreditations')->where('id', $id)->first();

    if ($data) {
        $description_status = $data->description_tmp;
        $title_status = $data->title_tmp;

        $description = $data->content;
        $title = $data->title;

        $update = DB::table('accreditations')->where('id', $id)->update([
            'content' => $description_status,
            'approved' => "1", 
            'title' => $title_status, 
        ]);

        if ($update) {

            $update = DB::table('accreditations')->where('id', $id)->update([
                'description_tmp' => null,
                'title_tmp' => null,
            ]);

            $oldstate = recognitions::find($request->id);
               
            $old  = [
                'title' => $title,
                'description' => $description,
            ];

            $new  = [
                'title' => $title_status,
                'description' => $description_status,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'accreditations master for recognitions ', 'Update', $old , $new);
                   
                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
          
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function approvedrecognitionsupdate(Request $request){
    // dd($request->all());
    $aboutid = $request->aboutid;
    $editorContent = $request->editorContent;
    // $title = $request->title;
    // dd($aboutid);
    $update = DB::table('accreditations')->where('id' , $aboutid)->update([
      'content' => $editorContent,
    ]);

    if($update){
     $insert =  DB::table('accreditations')->where('id', $aboutid)->update([
          'description_tmp' => null, 
      ]);

    
      if($insert){
          $updateStatus = DB::table('accreditations')
          ->where('id', $aboutid)
          ->update([
          'approved' => "1",
             ]);

          return response()->json(array('status'=>'success', 'message' => 'SAVED Successfully'));
      }else{
          return response()->json(array('status'=>'error', 'message' => 'failed!'));
      }

    }
}

public function Approvedaboutdelete(){
    return view('admin.about-delete');
}

public function Approvedaboutrecord(Request $request){

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


       $data = DB::table('bord_of_director')
                   ->where('delete_status' , "0")
                   ->join('users' , 'bord_of_director.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('bord_of_director.*', 'bord_of_director.id as id' , 'users.username as username')
                   ->orderByDesc('bord_of_director.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->delete_status;
            $username = $record->username;
            $name = $record->name;
            $designation = $record->designation;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';


        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "name" => $name,
            "designation" => $designation,
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

public function Approvedbord(Request $request){
    return view('admin.bord-approve');
}

public function bordapproved(Request $request){

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


       $data = DB::table('bord_of_director')
                   ->join('users' , 'bord_of_director.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('bord_of_director.*', 'bord_of_director.id as id' , 'users.username as username')
                   ->orderByDesc('bord_of_director.id');

    $totalRecordswithFilter = $data->count();
    $totalRecords = $totalRecordswithFilter;
    $list = $data->skip($start)->take($length)->get();

    $data = $data->get();
      
    $data_arr = array();
    // $id = "0";
    foreach($list as $sno => $record){
            $id = $record->id;
            $approved = $record->approved;
            $username = $record->username;
            // $name = $record->name;
            // $title = $record->title_tmp;
            // $description = $record->description_tmp;
            
            if($approved == 1){
                $name = $record->name;
                $title = $record->qualification;
                $designation = $record->designation;
                $status='<button type="button" class="btn rounded-pill btn-success"">Approved</button>';
                $action = '<a class="dropdown-items viewall" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }else{
                $name = $record->name_tmp;
                $title = $record->qualification_tmp;
                $designation = $record->designation_tmp;
                $status='<button type="button" class="btn rounded-pill btn-danger tglbtn" data-id="' . $id . '">Pending</button>';
                $action = '<a class="dropdown-items viewpending" href="javascript:void(0);" style="float:left; " data-id="'.$id.'" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "name" => $name,
          "title" => $title,
        //   "description" => $description,
          "designation" => $designation,
          "status"   => $status,
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

public function bordapprovedchange(Request $request){
    $id = $request->id;

    // dd($id);

    $data = DB::table('bord_of_director')->where('id', $id)->first();

    if ($data) {
      $name = $data->name;
      $qualification = $data->qualification;
      $designation = $data->designation;
      $image = $data->image;

      $name_tmp = $data->name_tmp;
      $qualification_tmp = $data->qualification_tmp;
      $designation_tmp = $data->designation_tmp;
      $image_tmp = $data->image_tmp;

        $update = DB::table('bord_of_director')->where('id', $id)->update([
             'name' => $name_tmp,
             'qualification' => $qualification_tmp,
             'designation'   => $designation_tmp,
             'image'  => $image_tmp,
            'approved' => "1", 
            
        ]);

        if ($update) {

            $update = DB::table('bord_of_director')->where('id', $id)->update([
                'name_tmp' => null,
                'qualification_tmp' => null,
                'designation_tmp' => null,
                'image_tmp' => null,
               'approved' => "1", 
               
           ]);

            $oldstate = bord::find($request->id);
               
            $old  = [
                'name' => $name,
                'qualification' => $qualification,
                'designation'   => $designation,
                'image'  => $image_tmp,
            ];

            $new  = [
                'name' => $name_tmp,
                'qualification' => $qualification_tmp,
                'designation'   => $designation_tmp,
                'image'  => $image_tmp,
            ];

            $user_id = $oldstate->user_id;
    
            $st = $this->Storehistory($user_id, 'Bord of Director ', 'Update', $old , $new);
                   
                return response()->json(['status' => 'success', 'message' => 'SAVED Successfully']);
          
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update title and description']);
        }
    } else {
        return response()->json(['status' => 'error', 'message' => 'Record not found']);
    }
}

}
