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


class datahistorycontrollet extends Controller
{
    public function history(){
             return view('admin.history');
    }

    public function historyview(Request $request){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $userid = Auth::user()->id;
        
        $data = DB::table('history_reports')
    ->leftJoin('users', 'history_reports.user_id', '=', 'users.id')
    ->select('history_reports.*','history_reports.id', 'users.username as username', 'history_reports.created_at'
            , 'history_reports.updated_at', 'history_reports.mode as mode', 'history_reports.name as name')
    ->orderByDesc('history_reports.id');

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

    $data->whereBetween('history_reports.created_at', [$startDate, $endDate]);
}
        
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        
        $list = $data->skip($start)->take($length)->get();
        
        $data_arr = [];
        foreach ($list as $sno => $record) {
            $id = $record->id;
            $name = $record->username;
            $old = $record->old_value;
            $new = $record->new_value;
            // $login = $record->created_at;
            $login = \Carbon\Carbon::parse($record->created_at)->format('d-m-Y h:i:s A');
            // $date = \Carbon\Carbon::parse($record->created_at)->format('d-m-Y');
            $duration = $record->mode;
            $duration_time = $record->name;
        
                $action = '&nbsp;<a class="dropdown-items view" href="javascript:void(0);"  style="color:green;" data-id="' . $id . '" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
          
            $data_arr[] = array(
                "id" => ++$start,
                "name" => $name,
                "login" => $login,
                "old_value" => $old,
                "new_value" => $new,
                "duration" => $duration,
                "duration_time" => $duration_time,
                "action"   => $action
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

    public function adminhistory(){
        return view('admin.admin-history');
    }

    public function adminhistoryview(Request $request){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        
        $userid = Auth::user()->id;
        
        $data = DB::table('admin_history')
    ->leftJoin('users', 'admin_history.user_id', '=', 'users.id')
    ->select('admin_history.id', 'users.username as username', 'admin_history.created_at'
            , 'admin_history.updated_at', 'admin_history.mode as mode', 'admin_history.name as name')
    ->orderByDesc('admin_history.id');

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

    $data->whereBetween('history_reports.created_at', [$startDate, $endDate]);
}
        
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        
        $list = $data->skip($start)->take($length)->get();
        
        $data_arr = [];
        foreach ($list as $sno => $record) {
            $id = $record->id;
            $name = $record->username;
            // $login = $record->created_at;
            $login = \Carbon\Carbon::parse($record->created_at)->format('d-m-Y h:i:s A');
            // $date = \Carbon\Carbon::parse($record->created_at)->format('d-m-Y');
            $duration = $record->mode;
            $duration_time = $record->name;
        
                $action = '&nbsp;<a class="dropdown-items view" href="javascript:void(0);"  style="color:green;" data-id="' . $id . '" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
       
        
            $data_arr[] = array(
                "id" => ++$start,
                "name" => $name,
                "login" => $login,
                "duration" => $duration,
                "duration_time" => $duration_time,
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

    public function userhistpryview(Request $request){
        $id = $request->id;
       
        $data = DB::table('history_reports')->where('id', $id)->first();
        
        if (isset($data->new_value)) {
            $data->new_value = str_replace(['{', '}'], '', $data->new_value);
        }
        
        if (isset($data->old_value)) {
            $data->old_value = str_replace(['{', '}'], '', $data->old_value);
        }
        
        return response()->json($data);
        
    }

    public function adminhistpryview(Request $request){
        $id = $request->id;
       
        $data = DB::table('admin_history')->where('id', $id)->first();
        
        if (isset($data->new_value)) {
            $data->new_value = str_replace(['{', '}'], '', $data->new_value);
        }
        
        if (isset($data->old_value)) {
            $data->old_value = str_replace(['{', '}'], '', $data->old_value);
        }
        
        return response()->json($data);
    }
}
