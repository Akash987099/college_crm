<?php

namespace App\Http\Controllers;

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
use App\Models\bord; 
use App\Models\HistoryReport;
use App\Models\User;
use App\Models\about;
use App\Models\user_facility;
use App\Models\course;
use App\Models\event;
use App\Models\admission;
use App\Models\tbl;
use App\Models\gallery;
use App\Models\recognitions;
use App\Models\accreditation;
use Illuminate\Support\Carbon;
use Auth, DB;

class deletecontroller extends Controller
{

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

    private function storeDeleteHistory($userId, $mode, $action, $deletedData)
    {
    
        $store = DB::table('history_reports')->insert([
            'user_id' => $userId,
            'name' => $mode,
            'old_value' => json_encode($deletedData),
            'mode' => $action,
        ]);
    
        return true;
    }

    public function aboutreject(Request $request){
        $id = $request->id;
        
        $reject = DB::table('bord_of_director')->where('id' , $id)->update([
            'delete_status' => "1",
        ]);

        if($reject){
      
            return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
        }else{
            return response()->json(array('status'=>'error', 'message' => 'failed!'));
        }

    }

    public function aboutdeletedata(Request $request){
       
        $id = $request->id;
        $oldstate = bord::find($id);

        if (!$oldstate) {
                    return response()->json(['status' => 'error', 'message' => 'record not found.']);
                }
            
                $deletedData = $oldstate->toArray();
        $delete = DB::table('bord_of_director')->where('id' , $id)->delete();

        if ($delete) {
                    // Log the changes
                    $changes = '';
                    foreach ($deletedData as $key => $value) {
                        $changes .= $key . ' Old Value ' . $value . ' New Value null ';
                    }
            
                    $user_id = Auth::user()->id;
                    $st = $this->Storehistory($user_id, 'bord of director', 'Delete', $changes);

            return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));

                }
    }

    public function gallerydeltedata(){
        return view('admin.gallery-delete');
    }

    public function gallerydeltedataajax(Request $request){
        
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


       $data = DB::table('gallery_master')
                   ->where('delete_status' , "0")
                   ->join('users' , 'gallery_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('gallery_master.*', 'gallery_master.id as id' , 'users.username as username');

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
            $name = $record->image;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "image" => $name,
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

    public function gallerydataajaxdelete(Request $request){
        $id = $request->id;
        $oldstate = gallery::find($id);
        if ($oldstate) {
            $deletedData = $oldstate->toArray();
            $delete = DB::table('gallery_master')->where('id', $id)->delete();
        
            if ($delete) {
                $userId = $oldstate->user_id;
                $this->storeDeleteHistory($userId, 'Gallery', 'Delete', $deletedData);
                return response()->json(array('status' => 'success', 'message' => 'Delete Successfully'));
            } else {
                return response()->json(array('status' => 'error', 'message' => 'failed!'));
            }
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Record not found!'));
        }

         }

         public function gallerydataajaxreject(Request $request){
            $id = $request->id;

            $reject = DB::table('gallery_master')->where('id' , $id)->update([
                'delete_status' => "1"
            ]);

            if($reject){
                return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
            }else{
                return response()->json(array('status'=>'error', 'message' => 'failed!'));
            }

         }

         public function facilitydeleteapprovel(Request $request){
            return view('admin.delete-facility-approved');
         }

         public function facilitydeleteapprovelview(Request $request){
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


       $data = DB::table('user_facility')
                   ->where('delete_status' , "0")
                   ->join('users' , 'user_facility.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->join('facility_master', 'user_facility.facility_id', '=', 'facility_master.id')
                   ->select('user_facility.*', 'user_facility.id as id' , 'facility_master.image as facility_image'  , 'users.username as username');

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
            $image = $record->image;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
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

         public function facilitydeleteapproveldelete(Request $request){
            // user_facility
            $id = $request->id;

            $delete = DB::table('user_facility')->where('id' , $id)->delete();

            if($delete){
                return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
            }else{
                return response()->json(array('status'=>'error', 'message' => 'failed!'));
            }

}

public function facilitydeleteapprovelreject(Request $request){
    $id = $request->id;

    $reject = DB::table('user_facility')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);

    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function coursedeleteapprovel(Request $request){
    return view('admin.delete-course');
}

public function coursedeleteapprovelview(Request $request){
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
                   ->where('delete_status' , "0")
                   ->join('users' , 'courses.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->join('program_master', 'courses.program_id', '=', 'program_master.id')
                   ->select('courses.*', 'courses.id as id', 'program_master.name as program_name'  , 'users.username as username');

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
            $image = $record->program_name;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
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

public function coursedeleteapproveldelete(Request $request){
    $id = $request->id;

    $delete = DB::table('courses')->where('id' , $id)->delete();

    if($delete){
        return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function coursedeleteapprovelreject(Request $request){
    $id = $request->id;

    $reject = DB::table('courses')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);

    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function eventsdeleteapprovel(Request $request){
    return view('admin.events-delete');
}

public function eventsdeleteapprovelview(Request $request){

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
                   ->where('delete_status' , "0")
                   ->join('users' , 'events_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('events_master.*', 'events_master.id as id' , 'users.username as username');

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
            $image = $record->image;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
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

public function eventsdeleteapprovelreject(Request $request){
    $id = $request->id;

    $reject = DB::table('events_master')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);

    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function eventsdeleteapproveldelete(Request $request){
    $id = $request->id;

    $delete = DB::table('events_master')->where('id' , $id)->delete();

    if($delete){
        return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function admissiondeleteapprovel(Request $request){
    return view('admin.delete-admission');
}

public function admissiondeleteapprovelview(Request $request){
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
                   ->where('delete_status' , "0")
                   ->join('users' , 'admission_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('admission_master.*', 'admission_master.id as id' , 'users.username as username');

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
            $image = $record->image;
            $link = $record->link;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "image" => $image,
            "link" => $link,
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

public function admissiondeleteapproveldata(Request $request){
    $id = $request->id;

    $delete = DB::table('admission_master')->where('id' , $id)->delete();
    if($delete){
        return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function admissiondeleteapprovelreject(Request $request){
    $id = $request->id;

    $reject = DB::table('admission_master')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);
    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function tbldeleteapprovel(Request $request){
    return view('admin.delete-tbl');
}

public function tbldeleteapprovelview(Request $request){
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
                   ->where('delete_status' , "0")
                   ->join('users' , 'user_tbl_placement.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('user_tbl_placement.*', 'user_tbl_placement.id as id' , 'users.username as username');

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
            $image = $record->image;
            $link = $record->link;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "image" => $image,
            "link" => $link,
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

public function tbldeleteapproveldata(Request $request){
    $id = $request->id;
    $delete = DB::table('user_tbl_placement')->where('id' , $id)->delete();
    if($delete){
        return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function tbldeleteapprovelreject(Request $request){
    $id = $request->id;
    $reject = DB::table('user_tbl_placement')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);
    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function accreditationsdeleteapprovel(Request $request){
    return view('admin.delete-accreditations');
}

public function accreditationsdeleteapprovelview(Request $request){
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
                   ->where('delete_status' , "0")
                   ->join('users' , 'accreditations_master.user_id' , 'users.id')->where('users.user_id' , Auth::user()->id)
                   ->select('accreditations_master.*', 'users.username as username');

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
            $image = $record->image;
            $link = $record->title;
            
            $action = '<button type="button" class="btn rounded-pill btn-success delete" data-id="' . $id . '">Approve</button>';
            $action .= '&nbsp;<button type="button" class="btn rounded-pill btn-danger reject" data-id="' . $id . '">Reject</button>';

            if($image == NULL){
                $image = $record->facility_image;
               }

        $data_arr[] = array(
            "id" => ++$start,
            "username" => $username,
            "image" => $image,
            "link" => $link,
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

public function accreditationsdeleteapprovelreject(Request $request){
    $id = $request->id;
    // dd($request->all());
    $reject = DB::table('accreditations_master')->where('id' , $id)->update([
        'delete_status' => "1"
    ]);
    if($reject){
        return response()->json(array('status'=>'success', 'message' => 'Reject Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

public function accreditationsdeleteapproveldata(Request $request){
    $id = $request->id;
    // dd($request->all());
    $delete = DB::table('accreditations_master')->where('id' , $id)->delete();
    if($delete){
        return response()->json(array('status'=>'success', 'message' => 'Delete Successfully'));
    }else{
        return response()->json(array('status'=>'error', 'message' => 'failed!'));
    }
}

}