<?php

namespace App\Http\Controllers\admin;

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
use App\Models\programs;
use App\Models\Privilege;
use Auth,DB;

class privilegescontroller extends Controller
{
    public function privilege(){
           $data = DB::table('users')->where('users.id', '!=', Auth::user()->id)->where('user_id' , Auth::user()->id)->get();
           return view('admin.privileges' , compact('data'));
    }

    private function getUserPrivilegePermission($user_id, $program_id) {
        
        if($user_id!="" && $user_id!=null){
            return Privilege::where(['user_id' => $user_id, 'program_id' => $program_id])->first();
        }
        
    }

    public function Privilegeview(Request $request){

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $module_id = null;
       // Total records
       $countData = programs::select('count(*) as allcount');

       if($request->user_id == null) {
           $countData->whereNull('programs.id');
       }

       
       $totalRecordswithFilter = $countData->count();
       $records = programs::select('programs.*')->orderBy('id', 'Asc')->skip($start)->take($rowperpage);
         
       if($request->user_id == null) {
           $records->whereNull('programs.id');
       }
      

       $list = $records->get();
       $data_arr = array();
       
       foreach($list as $sno => $record){
           $id = $record->id;
           $UserId = $record->user_id;
           $RoleId = $record->role_id;
           //$action = "<a href='{{ url('department/edit/'.$record->id) }}' target='_blank'><i class='fa fa-edit' style='color:blue' aria-hidden='true'></i></a>";

           $action = '<i class="fa fa-edit update fa-2x" style="color:blue;cursor:pointer" data-id="'.$record->id.'"></i>'; //'<a href="'.$url.'" target="_blank"><i class="fa fa-edit" style="color:blue"></i></a>';
           $action .= ' ';
           $action .= '<i class="fa fa-trash delete fa-2x" style="color:red;cursor:pointer" data-id="'.$record->id.'"></i>';


           $user_id = $request->user_id;
           $role_id = $request->role_id;
           
           $program_id = $record->id;

           $userPrivilegeObj = $this->getUserPrivilegePermission($user_id, $program_id);
           
           $pk = 0;
           $View_Option = $Add_Option = $Modify_Option  = $Delete_Option = '';
           if($userPrivilegeObj) {
               $pk = $userPrivilegeObj->id;
               if($userPrivilegeObj->view_priv == 1) {
                   $View_Option = 'checked';
               }
               if($userPrivilegeObj->add_priv == 1) {
                   $Add_Option = 'checked';
               }
               if($userPrivilegeObj->modify_priv == 1) {
                   $Modify_Option = 'checked';
               }
               if($userPrivilegeObj->del_priv == 1) {
                   $Delete_Option = 'checked';
               }
           }

           $view = '<input type="hidden" name="View_Option['.$id.']" value="0" /><input type="checkbox" class="View_Option" name="View_Option['.$id.']" value="1" '.$View_Option.'  />';
           $add = '<input type="hidden" name="Add_Option['.$id.']" value="0" /><input type="checkbox" class="Add_Option" name="Add_Option['.$id.']" value="1"  '.$Add_Option.'   />';
           $edit = '<input type="hidden" name="Modify_Option['.$id.']" value="0" /><input type="checkbox" class="Modify_Option" name="Modify_Option['.$id.']" value="1"  '.$Modify_Option.'   />';
           $delete = '<input type="hidden" name="Delete_Option['.$id.']" value="0" /><input type="checkbox" class="Delete_Option" name="Delete_Option['.$id.']" value="1"  '.$Delete_Option.'   />';

           $data_arr[] = array(
             "id" => ++$sno,
             "description" => $record->description,
             'view' => $view,
             'add' => $add,
             'edit' => $edit,
             'delete' => $delete,
           );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecordswithFilter,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        echo json_encode($response);
    }

    public function handleprivilege(Request $request){
    //    dd($request->all());
        try
        {
            if ($request->isMethod('post'))
            {

                $userId = $request->user_id;
                $params = array();
                foreach($request->View_Option as $programId => $viewoption) {
                    $addoption = $modifyoption = $deleteoption = 0;

                    if(isset($request->Add_Option[$programId])) {
                        $addoption = $request->Add_Option[$programId];
                    }

                    if(isset($request->Modify_Option[$programId])) {
                        $modifyoption = $request->Modify_Option[$programId];
                    }

                    if(isset($request->Delete_Option[$programId])) {
                        $deleteoption = $request->Delete_Option[$programId];
                    }
                    $params = array('user_id' => $userId, 'program_id' => $programId, 'view_priv' => $viewoption, 'add_priv' => $addoption, 'modify_priv' => $modifyoption,
                    'del_priv' => $deleteoption
                    );
                    $isObj = $this->getUserPrivilegePermission($userId , $programId);
                    

                    if($isObj)
                    {
                        $this->updateUserPrivilegeById($isObj->id, $params);

                    } else {
                        $this->createUserPrivilege($params);
                    }

                }
                return response()->json(array('status'=>'success', 'message' => 'Privileges Saved.'));
                //return response()->json(array('status'=>'success'));
            }
        }
        catch (\Throwable $e)
        {
            $error = $e->getMessage().', File Path = '.$e->getFile().', Line Number = '.$e->getLine();
            return response()->json(array('status'=>'exceptionError'));
        }

    }

    private function createUserPrivilege($data) {

        $status = Privilege::create($data);

        if($status)
        {
            return true;
        }
        return false;
    }

    private function getUserPrivilegeById($id)
    {
        return Privilege::findById($id);
    }

    private function updateUserPrivilegeById($id, $data) {
        $status = Privilege::where('id', $id)->update($data);
        if($status)
        {
            return true;
        }

        return false;
    }

    private function exceptionpPivilegeHandling($error)
    {
        $moduleObj = getModuleById(2);
        if($moduleObj)
        {
            $obj = \App\Components\AuditReportManager::getInstance();
            $data = array('name' => $moduleObj->Description, 'data' => $error, 'user_id' => Auth::user()->id);
            $obj->save($data);
        }
    }

   
}
