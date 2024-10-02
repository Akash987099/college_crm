<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth,DB;
use Illuminate\Support\Facades\Mail;
use App\Models\City; // Make sure this import is correct
use App\Models\HistoryReport;
use App\Models\User;
use App\Models\article;
use App\Models\news;
use App\Models\Program;

class articlecontroller extends Controller
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

    public function addArticles(Request $request){
       $title = $request->title;
       $editorContent = $request->editorContent;
       $image = $request->image;

       $rules = [
           'title' => 'required',
           'editorContent' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
     ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('articles'), $imageName);
    }

    $userid = Auth::user()->id;
    $insert = DB::table('articles')->insert([
        'user_id' => $userid,
        'title' => $title,
        'image' => $imageName,
        'description' => $editorContent,
    ]);

    if($insert){
        return response()->json(['status' => 'success' , 'message' => 'Add Record successfully']);
    }else{
        return response()->json(['status' => 'error' , 'message' => 'Failed!']);
    }

    }

    public function articlesview(Request $request){
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

        $data = DB::table('articles')->where('user_id' , $userid);


if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('title', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'title' && $columnSortOrder === 'asc') {
            $data->orderBy('title', 'asc');
        } elseif ($columnName === 'title' && $columnSortOrder === 'desc') {
            $data->orderBy('title', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $title = $record->title;
          
             
               $action = '&nbsp;<a class="dropdown-items updatedata" href="javascript:void(0);" data-id="'.$id.'" ><i class="fa fa-pencil" aria-hidden="true"></i></a>';
               $action .= '&nbsp;<a class="dropdown-items deletedata" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
              
            $data_arr[] = array(
                "id" => ++$start,
                  "title" => $title,
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

    public function deletearticles(Request $request){
        $id = $request->id;

        $oldstate = article::find($id); 

        $deletedData = $oldstate->toArray();

        $delete = DB::table('articles')->where('id' , $id)->delete();

        if($delete){

            $userId = Auth::user()->id;
            $this->storeDeleteHistory($userId, 'Articles', 'Delete', $deletedData);

            return response()->json(['status' => 'success' , 'message' => 'Delete Record successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed!']);
        }

    }

    public function updatearticles(Request $request){
        $id = $request->id;

        $data = DB::table('articles')->where('id' , $id)->get();
        return $data;
    }

    public function updatearticlesdata(Request $request){
       $updateid = $request->updateid;
       $title = $request->title;
       $description = $request->editorContent;

       $rules = [
        'title' => 'required',
        'editorContent' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
  ];

     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()) {
     return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $updateData = [
        'title' => $title,
     'description' => $description,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move(public_path('articles'), $imageName);
        $updateData['image'] = $imageName;
    }
    $update = DB::table('articles')->where('id', $updateid)->update($updateData);


 if($update){
    
    $oldstate = article::find($updateid); 
          
    $old = [];
    $new = [];

    $fields = ['user_id', 'image' , 'title', 'description', 'title_tmp' , 'description_tmp', 'created_at', 'updated_at'];

    foreach ($fields as $field) {
        $old[$field] = $oldstate->$field;
    }

    foreach ($fields as $field) {
        $new[$field] = $request->$field;
    }            

    $user_id = Auth::user()->id;

    $st = $this->Storehistory($user_id, 'Articles', 'Update', $old , $new);

     return response()->json(['status' => 'success' , 'message' => 'Update Record successfully']);
 }else{
     return response()->json(['status' => 'error' , 'message' => 'Failed!']);
 }

    }

    public function articaltopdata(Request $request){
//  dd($request->all());

       return view('article');
     
        
    }

    public function articlegetdatabyid(Request $request){
        // dd($request->all());
        $articles = DB::table('articles')->where('id' , $request->id)->get();
        $data_arr = array();

foreach ($articles as $key => $val) {
  $id = $val->id;
  $title = $val->title;
  $image = $val->image;
  $description = $val->description;

  $data_arr[] = array(
      "id" => $id,
      "title" => $title,
      "image" => $image,
      "description" => $description
  );
}

        return response()->json([ "article" => $data_arr]);
    }

    public function artcleslistdata(Request $request){
        return view('article-list');
    }

    public function listarticle(){
        $articles = DB::table('articles')->get();
        $data_arr = array();

foreach ($articles as $key => $val) {
  $id = $val->id;
  $title = $val->title;
  $image = $val->image;
  $date = $val->created_at ?? '';

  $data_arr[] = array(
      "id" => $id,
      "title" => $title,
      "image" => $image,
      "date" => $date,
  );
}

        return response()->json([ "article" => $data_arr]);
    }

    public function addnews(Request $request){

        $title = $request->title;
        $editorContent = $request->editorContent;
        $image = $request->image;
 
        $rules = [
            'title' => 'required',
            'editorContent' => 'required',
         'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      ];
 
     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
     }
 
     if ($request->hasFile('image')) {
     $image = $request->file('image');
     $imageName = time() . '.' . $image->getClientOriginalExtension();
     $image->move(public_path('news'), $imageName);
     }
 
     $userid = Auth::user()->id;
     $insert = DB::table('news_master')->insert([
         'user_id' => $userid,
         'title' => $title,
         'image' => $imageName,
         'description' => $editorContent,
     ]);
 
     if($insert){
         return response()->json(['status' => 'success' , 'message' => 'Add Record successfully']);
     }else{
         return response()->json(['status' => 'error' , 'message' => 'Failed!']);
     }
    }

    public function newsview(Request $request){

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

        $data = DB::table('news_master')->where('user_id' , $userid);


if ($searchValue != null) {
    $data->where(function ($query) use ($searchValue) {
        $query->where('title', 'like', '%' . $searchValue . '%');
    });
}


        if ($columnName === 'title' && $columnSortOrder === 'asc') {
            $data->orderBy('title', 'asc');
        } elseif ($columnName === 'title' && $columnSortOrder === 'desc') {
            $data->orderBy('title', 'desc');
        }


        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->get();

        $data = $data->get();
          
        $data_arr = array();
        foreach($list as $sno => $record){
               $id = $record->id;
               $title = $record->title;
          
             
               $action = '&nbsp;<a class="dropdown-items updatedata" href="javascript:void(0);" data-id="'.$id.'" ><i class="fa fa-pencil" aria-hidden="true"></i></a>';
               $action .= '&nbsp;<a class="dropdown-items deletedata" href="javascript:void(0);"  style="color:red;" data-id="'.$id.'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
              
            $data_arr[] = array(
                "id" => ++$start,
                  "title" => $title,
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

    public function deletenews(Request $request){
        $id = $request->id;
        $oldstate = news::find($id);
        $deletedData = $oldstate->toArray();
        $delete = DB::table('news_master')->where('id' , $id)->delete();

        if($delete){
            $userId = Auth::user()->id;
            $this->storeDeleteHistory($userId, 'news', 'Delete', $deletedData);
            return response()->json(['status' => 'success' , 'message' => 'Delete Record successfully']);
        }else{
            return response()->json(['status' => 'error' , 'message' => 'Failed!']);
        }

    }

    public function editnews(Request $request){
        $id = $request->id;
        $data = DB::table('news_master')->where('id' , $id)->get();

        return $data;
    }

    public function updatenews(Request $request){

        $updateid = $request->updateid;
       $title = $request->title;
       $description = $request->editorContent;

       $rules = [
        'title' => 'required',
        'editorContent' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
  ];

     $validator = Validator::make($request->all(), $rules);
     if ($validator->fails()) {
     return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $updateData = [
        'title' => $title,
        'description' => $description,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move(public_path('news'), $imageName);
        $updateData['image'] = $imageName;
    }

    $update = DB::table('news_master')->where('id', $updateid)->update($updateData);

 if($update){

    $oldstate = news::find($request->updateid);
          
    $old = [];
    $new = [];

    $fields = ['id', 'user_id', 'image' , 'title', 'description', 'title_tmp' , 'description_tmp'];

    foreach ($fields as $field) {
        $old[$field] = $oldstate->$field;
    }

    foreach ($fields as $field) {
        $new[$field] = $request->$field;
    }            

    $user_id = Auth::user()->id;

    $st = $this->Storehistory($user_id, 'News', 'Update', $old , $new);

     return response()->json(['status' => 'success' , 'message' => 'Update Record successfully']);
 }else{
     return response()->json(['status' => 'error' , 'message' => 'Failed!']);
 }

    }

    public function getnewsdata(){
        $data = DB::table('news_master')->get();
        $data_arr = array();

        foreach($data as $key => $val){

            $id = $val->id;
            $image = $val->image;
            $title = $val->title;
            $date = $val->created_at;

            $data_arr[] = array(
                "id" => $id,
                "title" => $title,
                "image" => $image,
                "date" => $date,
            );

        }

        return response()->json([ "news" => $data_arr]);

    }

    public function getnewssingle(Request $request){
        return view('news-single');
    }

    public function getnewsgetbyId(Request $request){
        $data = DB::table('news_master')->where('id' , $request->id)->get();
        $data_arr = array();

        foreach($data as $key => $val){

            $id = $val->id;
            $image = $val->image;
            $title = $val->title;
            $description = $val->description;

            $data_arr[] = array(
                "id" => $id,
                "title" => $title,
                "image" => $image,
                "description" => $description,
            );

        }

        return response()->json([ "news" => $data_arr]);
    }

}
