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
use Auth,DB;

class aboutcontroller extends Controller
{

    public function getaboutdata(Request $request){
        // $id = $request->id;
    //    dd($id);
         $id = Auth::user()->id;

        $data = DB::table('about_master')
        ->where('user_id', $id)
        ->first();
    
    return $data;
    }

    public function updateabout(Request $request){
        $id = Auth::user()->id;
        // dd($id);
        // dd($request->all());
        $editorContent = $request->editorContent;
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
        
         $update = DB::table('about_master')
             ->where('user_id', $id) 
             ->update([
                 'title_tmp' => $update_title,
                //  'description' => $update_title,
                 'description_tmp' => $editorContent,
                 'approved' => "0",
             ]);
        
        if ($update) {

            // $updateStatus = DB::table('about_master')
            // ->where('user_id', $id)
            // ->update([
            // 'approved' => "0",
            //    ]);

            return response()->json(['status' => 'success', 'message' => 'Update Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed!']);
        }

    }

    public function deleteabout(Request $request){
        $id = $request->id;

        // dd($id);

        $delete = DB::table('about_master')->where('id' , $id)->delete();

        if ($delete) {
            return response()->json(['status' => 'success', 'message' => 'Delete Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed!']);
        }
    }
}
