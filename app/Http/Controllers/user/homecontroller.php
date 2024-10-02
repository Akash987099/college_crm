<?php

namespace App\Http\Controllers\user;

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
use App\Models\User;
use App\Models\City;
use App\Models\course;
use App\Models\Program;
use App\Models\college;
use App\Models\admission;
use App\Models\University;
use App\Models\user_facility;
use App\Models\facility;
use App\Models\state;
use App\Models\about;
use Illuminate\Support\Carbon;
use Auth, DB;

class homecontroller extends Controller
{

    public function addcounsilling(Request $request){
       $name = $request->name;
       $email = $request->email;
       $mobile = $request->mobile;
       $city = $request->city;
       $course = $request->course;
       $message = $request->message;

       $rules = [

        'name' => 'required', 
        'email' => 'required', 
        'mobile' => 'required', 
        'city' => 'required', 
        'course' => 'required', 
        'message' => 'required', 
     ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }
    
    //  $data=[];
    //     $data['name']=$request->input('name');
    //     $data['email']=$request->input('email');
    //     $data['title'] = "Welcome To Intileo's University";
    //     $data['password'] = $password;

    $insert = DB::table('contact_master')->insert([
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
        'city' => $city,
        'course' => $course,
        // 'college' => $college,
        'description' => $message,
    ]);

    
    if($insert){
        
        //   Mail::send('send', $data, function($message)use($data) {
        //             $message->to($data["email"], $data["name"])
        //                 ->subject($data["title"]);
        //         });
        
        return response()->json(['status' => 'success', 'message' => 'Successfully Save Record']);
    }else{
        return response()->json(['status' => 'error', 'message' => 'failed Delete Record']);
    }

    }

    public function viewallnews(){
        return view('news-list-view');
    }

    public function news_list_daata(Request $request){

        $articles = DB::table('news_master')->get();
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

    public function getallcity(Request $request){
        $state = City::pluck('id','city_name');
        return response()->json([
            "data" => $state
     ]);
    }

    public function index(){
        $data = DB::table('about_master')->get();
        $articles = DB::table('articles')->get();
        $news = DB::table('news_master')->get();

        $topcollege = DB::table('college_master')->where('college_master.status' , "1")
                          ->join('city_master' , 'college_master.city' , 'city_master.id')
                          ->join('university_master' , 'college_master.uni_id' , 'university_master.id')
                          ->leftjoin('users' , 'college_master.id' , 'users.college_code')
                          ->leftjoin('facility_master' , 'users.id' , 'facility_master.user_id')
                          ->select('college_master.*' ,
                           'university_master.name as uni_name',
                            'city_master.city_name as city_name' , 
                            'city_master.state_name as state_name',
                            'facility_master.name as fac_name',
                            'users.id as user_id',
                            'facility_master.image as fac_image' )
                          ->get();

                          $science = ['bca', 'mca' ,  'BArch' , 'Bsc' , 'BPharma' , 'BE' , 'BTech'];
                          $arts = ['BA', 'BFA' ,  'BSC' , 'BA LLB' , 'BHM' , 'BJMC' , 'BJ' , 'BMM' , 'D'];
                          $commerce = ['BCom', 'BBA', 'MCom', 'MBA', 'BCA (Commerce)']; 
                          $education = ['BEd', 'MEd', 'Diploma in Education', 'MPhil Education', 'PhD Education'];
                          $pharmacy = ['DPharma', 'BPharma', 'MPharma', 'PhD Pharmacy'];
                          $law = ['LLB', 'LLM', 'BA LLB', 'BBA LLB', 'BCom LLB', 'LLD'];
                          $fashionDesign = ['BSc Fashion Design', 'B.Design in Fashion', 'MSc Fashion Technology', 'M.Design in Fashion'];
                          $architecture = ['BArch', 'MArch', 'PhD Architecture'];
                          $agriculture = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
                          $management = ['BBA', 'MBA', 'PGDM', 'BMS', 'BHM', 'BBA LLB', 'MHA'];
                          $engineering = ['BE', 'BTech', 'ME', 'MTech', 'PhD Engineering'];
                          $medical = ['MBBS', 'BDS', 'BAMS', 'BHMS', 'BPT', 'B.Sc Nursing', 'MD', 'MS', 'MDS', 'MPT', 'M.Sc Nursing', 'PhD Medical Sciences'];

                          $totalscience = DB::table('program_master')->whereIn('program_master.name', $science)
                                            ->join('courses' , 'program_master.id' , '=' , 'courses.program_id')
                                            ->join('users' , 'courses.user_id' , '=' , 'users.id')
                                            ->join('college_master' , 'users.college_code' , '=' , 'college_master.id')
                                            ->count();

    $totalArts = DB::table('program_master')->whereIn('program_master.name', $arts)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->join('university_master', 'users.university_code', '=', 'university_master.id')
    ->count();

    $totalCommerce = DB::table('program_master')->whereIn('program_master.name', $commerce)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalEducation = DB::table('program_master')->whereIn('program_master.name', $education)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalPharmacy = DB::table('program_master')->whereIn('program_master.name', $pharmacy)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalLaw = DB::table('program_master')->whereIn('program_master.name', $law)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalFashionDesign = DB::table('program_master')->whereIn('program_master.name', $fashionDesign)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalArchitecture = DB::table('program_master')->whereIn('program_master.name', $architecture)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalAgriculture = DB::table('program_master')->whereIn('program_master.name', $agriculture)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalManagement = DB::table('program_master')->whereIn('program_master.name', $management)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalEngineering = DB::table('program_master')->whereIn('program_master.name', $engineering)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalMedical = DB::table('program_master')->whereIn('program_master.name', $medical)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();


        return view('index' , compact('data' , 'articles' , 'news' , 'topcollege'  , 'totalscience' , 'totalArts' , 'totalCommerce',
                       'totalEducation' , 'totalPharmacy' , 'totalLaw' , 'totalFashionDesign' , 'totalArchitecture' , 'totalAgriculture' ,
                    'totalManagement' , 'totalEngineering' , 'totalMedical'));
    }

    public function TopCollegeajax(Request $request){

        $dataIdArray = $request->id;
        
        if($dataIdArray === NULL){
            $topcollege = DB::table('college_master')->where('college_master.status' , "1")
            ->join('city_master' , 'college_master.city' , 'city_master.id')
            ->join('university_master' , 'college_master.uni_id' , 'university_master.id')
            ->join('users' , 'college_master.id' , 'users.college_code')
            ->join('facility_master' , 'users.id' , 'facility_master.user_id')
            ->select('college_master.*' ,
             'university_master.name as uni_name',
              'city_master.city_name as city_name' , 
              'city_master.state_name as state_name',
              'facility_master.name as fac_name',
              'users.id as user_id',
              'facility_master.image as fac_image' )
            ->get();

            if ($topcollege == NULL) {
                return response()->json([]);
            } else {
                return response()->json([
                    "collegedata" => $topcollege,
             ]); 
            }
        }

        $data = DB::table('program_master')
        ->where(function ($query) use ($dataIdArray) {
            foreach ($dataIdArray as $value) {
                $query->orWhere('name', 'like', '%' . $value . '%');
            }
        })
        ->get();
        
    $programIds = $data->pluck('id')->unique()->toArray();
    $program = DB::table('user_program')->whereIn('program_id', $programIds)->get();
    
    $userIds = $program->pluck('user_id')->unique()->toArray();
    $colleges = DB::table('users')->whereIn('id', $userIds)->get();
    $collegeCodes = $colleges->pluck('college_code')->unique()->toArray();
    $uniCodes = $colleges->pluck('university_code')->unique()->toArray();
    
    // ->get();

        $topcollege = DB::table('college_master')->where('college_master.id' , $collegeCodes)
        ->join('city_master' , 'college_master.city' , 'city_master.id')
        ->join('university_master' , 'college_master.uni_id' , 'university_master.id')
        ->join('users' , 'college_master.id' , 'users.college_code')
        ->join('facility_master' , 'users.id' , 'facility_master.user_id')
        ->select('college_master.*' ,
         'university_master.name as uni_name',
          'city_master.city_name as city_name' , 
          'city_master.state_name as state_name',
          'facility_master.name as fac_name',
          'users.id as user_id',
          'facility_master.image as fac_image' )
        ->get();

        if ($topcollege == NULL) {
            return response()->json([]);
        } else {
            return response()->json([
                "collegedata" => $topcollege,
         ]); 
        }

    }

    public function gettopcity(){
       
        try {
          
            $data = City::where('status', 1)
                ->get();

                $cities = array();
                foreach($data as $key => $val){
                    $id = $val->id;
                    $city_name = $val->city_name;
                    $state_name = $val->state_name;
                    $cities[] = array(
                        "id" => $id,
                        "city_name" => $city_name,
                        "state_name" => $state_name,
                    );
                }
                $data = $data_arr;
    
            return response()->json(['status' => 'success', 'cities' => $cities]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve top cities']);
        }

    }

    public function gettopcitybyid(Request $request){
        $totalcity = City::count();
        $state = state::count('state_name');
        return view('view-list' , compact('totalcity' , 'state'));
    }

    public function viewdetailsgetdata(Request $request){
        //  dd($request->all());
        $id = $request->input('id');
        $dataId = ucwords(str_replace('/', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();

        if($college == NULL && $college == ''){
            $college = university::where('name' ,'like', '%' . $dataId . '%' )->first();
        }

        $collegeID = $college->id;

        $user = User::where('college_code' , $collegeID)->first();

        if($user == null && $user == ''){
            $user = User::where('university_code' , $collegeID)->first();
        }

        $userId = $user->id;

        $gallery = DB::table('gallery_master')->where('user_id', $userId)->get();

        $city = city::where('id' , $college->city ?? '')->first();
        $state = state::where('id' , $college->state ?? '')->first();

        return view('view-details', compact('gallery' , 'college' , "city" , "state"));

    }

    public function getallTopcollege(Request $request){
        $data = college::where('status' , '1')->get();
        $data_arr = array();
        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->name;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
            );
        }
        $data = $data_arr;
        return $data;
    }

    public function getallTopcollegeStateWise(Request $request){
        // $data = college::where('college_master.status' , '1')
        //         ->join('state_master' , 'college_master.state' , '=' , 'state_master.id')->get();
    $data = DB::table('city_master')->where('status' , 1)->get();
    
    $data_arr = array();
    foreach($data as $key => $val){
        $id = $val->id;
            $name = $val->city_name;
        $data_arr[] = array(
            "id" => $id,
            "city_name" => $name,
        );
    }
    $data = $data_arr;
        return $data;
    }

    public function getstatesearch(Request $request){
      $state = $request->state;

      $data = college::where('state' , $state)->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
               ->select('college_master.*', 'city_master.city_name', 'city_master.state_name');

$totalRecords = $data->count();
$data = $data->get();

        $data_arr = array();
        foreach($data as $key => $record){
            $id = $record->id;
            $name = $record->name ?? '';
            $city = $record->city_name ?? '';
            $address = $record->address ?? '';
            $state = $record->state_name ?? '';
            $image = $record->image ?? '';
            $logo = $record->logo ?? '';
            $description = Str::limit($record->description ?? ' ', 100);
            $Established = $record->Established ?? '1980';
            
            $facilities = User::where('college_code', $id)->orWhere('university_code', $id)
            ->leftJoin('user_facility', 'users.id', 'user_facility.user_id')
            ->leftJoin('facility_master', 'user_facility.facility_id', 'facility_master.id')
            ->select('users.id as userId', 'facility_master.name as facility_name', 'facility_master.image as facility_image')
            ->get();

            $facilities_arr = [];
            foreach ($facilities as $facility) {
                $facilities_arr[] = [
                    "userId" => $facility->userId ?? '',
                    "facility_name" => $facility->facility_name ?? 'Gym',
                    "facility_image" => $facility->facility_image ?? '1710402627.png'
                ];
            }

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "city" => $city,
                "address" => $address,
                "state" => $state,
                "image" => $image,
                "logo" => $logo,
                "facilities" => $facilities_arr,
                "description" => $description,
                "Established" => $Established,
            );
        }

        if ($data_arr == NULL) {
            return response()->json([]);
        } else {
            return response()->json([
                "data" => $data_arr,
                "totalRecords" => $totalRecords
         ]); 
        }

    } 

    private function coursefilterdatasearchAllcollege(Request $request, $uni_code)
{
    $data_arr = [];
    if (!empty($uni_code)) {
        // $collegeData = DB::table('college_master')
        //     ->whereIn('uni_id', $uni_code)
        //     ->join("city_master", 'college_master.city', '=', 'city_master.id')
        //     ->select('college_master.*', 'city_master.city_name', 'city_master.state_name')
        //     ->get();

        $universityData = DB::table('university_master')->whereIn('id', $uni_code)->get();

        // foreach ($collegeData as $record) {
        //     $data_arr[] = $this->processRecord($record);
        // }

        foreach ($universityData as $record) {
            $data_arr[] = $this->processRecord($record);
        }
    }

    return $data_arr;
}

        private function coursefilterdatasearchallurl(Request $request , $dataId){
     
            $dataIdArray = explode(',', $request->id);
          
        if ($dataId) {
            $data = University::where('university_master.name' , $dataId)
            ->leftJoin("city_master", 'university_master.city', '=', 'city_master.id')
            ->select('university_master.*', 'city_master.city_name', 'city_master.state_name')
            ->get();
            $uni_code = $data->pluck('id')->unique()->toArray();
            
            $data = $this->coursefilterdatasearchAllcollege($request, $uni_code);
            
            if($data != NULL){
                return $data;
            }
        }

        if($dataId){
           
            $data = college::where('college_master.name' , $dataId)->orwhere('college_master.city' , $dataId)
        ->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
        ->select('college_master.*', 'city_master.city_name', 'city_master.state_name')
        ->get();

        $data_arr = array();
        foreach($data as $record){
            $id = $record->id;
            $name = $record->name ?? '';
            $city = $record->city_name ?? '';
            $address = $record->address ?? '';
            $state = $record->state_name ?? '';
            $image = $record->image ?? '';
            $logo = $record->logo ?? '';
            $description = Str::limit($record->description ?? ' ', 100);
    
         $Established = $record->Established ?? '1998';
                        
         $facilities = User::where('college_code', $id)->orWhere('university_code', $id)
         ->leftJoin('user_facility', 'users.id', 'user_facility.user_id')
         ->leftJoin('facility_master', 'user_facility.facility_id', 'facility_master.id')
         ->select('users.id as userId', 'facility_master.name as facility_name', 'facility_master.image as facility_image')
         ->get();

         $facilities_arr = [];
         foreach ($facilities as $facility) {
             $facilities_arr[] = [
                 "userId" => $facility->userId ?? '',
                 "facility_name" => $facility->facility_name ?? 'Gym',
                 "facility_image" => $facility->facility_image ?? '1710402627.png'
             ];
         }
        
         $data_arr[] = array(
            "id" => $id,
            "name" => $name,
            "city" => $city,
            "address" => $address,
            "state" => $state,
            "image" => $image,
            "logo" => $logo,
            "facilities" => $facilities_arr,
            "description" => $description,
            "Established" => $Established,
        );
        }
          if($data_arr != NULL){
            return $data_arr;
            }
        }

        if($dataIdArray){
            $data = DB::table('program_master')
            ->where(function ($query) use ($dataIdArray) {
                foreach ($dataIdArray as $value) {
                    $query->orWhere('program_master.name', 'like', '%' . $value . '%');
                }
            })->join('courses' , 'program_master.id' , '=' , 'courses.program_id')
            ->get();
            
            $userIds = $data->pluck('user_id')->unique()->toArray();
            
            $colleges = DB::table('users')->whereIn('id', $userIds)->get();
            
            $collegeCodes = $colleges->pluck('college_code')->unique()->toArray();
            $uniCodes = $colleges->pluck('university_code')->unique()->toArray();
            
            $data = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);
            
            if($data != NULL){
                return $data;
            }
             }

             }

             private function stateData($stateData){

                $statecode = DB::table('state_master')->where('state_name', 'like', '%' . $statecode . '%')->get();
                $collegeCodes = $statecode->pluck('id')->unique()->toArray();
                $data = college::where('state' , $collegeCodes)->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
                ->select('college_master.*', 'city_master.city_name', 'city_master.state_name');
 
 $totalRecords = $data->count();
 $data = $data->get();
 
         $data_arr = array();
         foreach($data as $key => $record){
             $id = $record->id;
             $name = $record->name ?? '';
             $city = $record->city_name ?? '';
             $address = $record->address ?? '';
             $state = $record->state_name ?? '';
             $image = $record->image ?? '';
             $logo = $record->logo ?? '';
             $description = Str::limit($record->description ?? ' ', 100);
             $Established =$record->Established ?? '1995';
             
                if($data){
                       
 
                         $facility = User::where('college_code' , $id)
                                     ->leftjoin('user_facility' , 'users.id' , 'user_facility.user_id')
                                     ->leftjoin('facility_master' , 'user_facility.facility_id' , 'facility_master.id')
                                     ->select('users.id as userId','facility_master.name as facility_name' , 'facility_master.image as facility_image' )
                                     ->first();
                                      $userId = $facility->userId ?? '';
                                    
                                         $facilityname = $facility->facility_name ?? '';
                                         $facilityimage = $facility->facility_image ?? '1709719444.png';
 
                                         if($facilityname === NULL && $facilityimage == NULL){
                                             $facilityname = '1709719444.png';
                                             $facilityimage = '1709719444.png';
                                         }
                                    
                }
 
                $data_arr[] = array(
                 "id" => $id,
                 "userId" => $userId,
                 "name" => $name,
                 "city" => $city,
                 "address" => $address,
                 "state" => $state,
                 "image" => $image,
                 "logo" => $logo,
                 "facility_name" => $facilityname,
                 "facility_image" => $facilityimage,
                 "description" => $description,
                 "Established" => $Established,
             );
         }
 
         if ($data_arr == NULL) {
             return response()->json([]);
         } else {
             return response()->json([
                 "data" => $data_arr,
                 "totalRecords" => $totalRecords
          ]); 
         }

             }

             public function getallTopcollegeStateWisehedaer(Request $request){
                $course = $request->course;

                $data = DB::table('College_master')
                    ->where(function ($query) use ($course) {
                        foreach ($course as $value) {
                            $query->orWhere('name', 'like', '%' . $value . '%');
                        }
                    })
                    ->get();
                    $data_arr = array();
                    foreach($data as $key => $val){
                        $name = $val->name;
                        $data_arr[] = array(
                            "name" => $name,
                        );
                    }

                    return response()->json($data);
             }

    public function viewdetailsgeturl(Request $request){
        $urlId = $request->input('id');
        // dd($urlId);
        $dataId = ucwords(str_replace('/', ' ', $urlId));  
        // dd($dataId);

        if($urlId == NULL){
           
            $data = DB::table('college_master')
            ->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
            ->select('college_master.*', 'city_master.city_name', 'city_master.state_name')
            ->get();
        
        $data_arr = array();
        foreach ($data as $key => $record) {
            $id = $record->id;
            $name = $record->name ?? '';
            $city = $record->city_name ?? '';
            $address = $record->address ?? '';
            $state = $record->state_name ?? '';
            $image = $record->image ?? '';
            $logo = $record->logo ?? '';
            $description = Str::limit($record->description ?? ' ', 100);
            $Established = $record->Established ?? '1994';
        
            $facilities = User::where('college_code', $id)->orWhere('university_code', $id)
                ->leftJoin('user_facility', 'users.id', 'user_facility.user_id')
                ->leftJoin('facility_master', 'user_facility.facility_id', 'facility_master.id')
                ->select('users.id as userId', 'facility_master.name as facility_name', 'facility_master.image as facility_image')
                ->get();
        
            $facilities_arr = [];
            foreach ($facilities as $facility) {
                $facilities_arr[] = [
                    "userId" => $facility->userId ?? '',
                    "facility_name" => $facility->facility_name ?? 'Gym',
                    "facility_image" => $facility->facility_image ?? '1710402627.png'
                ];
            }
        
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "city" => $city,
                "address" => $address,
                "state" => $state,
                "image" => $image,
                "logo" => $logo,
                "facilities" => $facilities_arr,
                "description" => $description,
                "Established" => $Established,
            );
        }
        
        return response()->json(["data" => $data_arr]);
        
        }

        if($urlId){
            $program = DB::table('program_master')->where('program_master.name' , $urlId)
            ->join('courses' , 'program_master.id' , '=' , 'courses.program_id')->get();
            
            $programIds = $program->pluck('user_id')->unique()->toArray();
            $colleges = DB::table('users')->whereIn('id', $programIds)->get();
            $collegeCodes = $colleges->pluck('college_code')->unique()->toArray();
            $uniCodes = $colleges->pluck('university_code')->unique()->toArray();
            $result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);
        
        if ($result != NULL) {
            return response()->json([
                "data" => $result,
         ]); 
        } 
        }

        if ($program->isEmpty()) {
            // return "1111";
            $dataId = is_array($dataId) ? $dataId : [$dataId];
        
            $result = $this->coursefilterdatasearchallurl($request, $dataId);

            if ($result == NULL) {
                return response()->json([]);
            }else {
                return response()->json([
                    "data" => $result,
             ]); 
            }
        }

    }

    public function getfilterload(Request $request){
     $cities = City::pluck('id', 'city_name');
     $data_arr = array();

foreach ($cities as $key => $val) {
    $id = $val;
    $city = $key; 

    $totaldata = college::where('city' , $id)->count();
    
    $data_arr[] = array(
        "id" => $id,
        "city" => $city,
        "totalrecord" => $totaldata
    );
}

return response()->json(["cities" => $data_arr]);

    }

    public function statefilterload(Request $request){

          $state = state::pluck('id','state_name');
       
          $data_arr = array();

foreach ($state as $key => $val) {
    $id = $val;
    $city = $key; 

    $totaldata = college::where('state' , $id)->count();

    $data_arr[] = array(
        "id" => $id,
        "state" => $city,
        "totalrecord" => $totaldata
    );
}

          return response()->json([ "state" => $data_arr]);
    }

    public function coursefilterload(Request $request){
       
        $state = DB::table('program_master')->pluck('id' , 'name');
      
foreach ($state as $key => $val) {
  $id = $val;
  $city = $key; 

  $totaldata = course::where('program_id' , $id)
             ->join('users' , 'courses.user_id' , 'users.id')
             ->join('college_master' , 'users.college_code' , 'college_master.id')
            //  ->join('university_master' , 'users.university_code' , 'university_master.id')
             ->count();

  $data_arr[] = array(
      "id" => $id,
      "name" => $city,
      "totalrecord" => $totaldata
  );
}

        return response()->json([ "program" => $data_arr]);
    }

    
    public function viewdetailsgetbyid(Request $request){
        $id = $request->id;
        $dataId = ucwords(str_replace('/', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
        
        if($college == NULL && $college == ''){
            $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
        }

         $collegeID = $college->id;
      
        $userId = DB::table('users')->where('college_code' , $collegeID)->first();
       
        if($userId == NULL && $userId == ''){
            $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
            // dd($userId);
        }
       
        $main = $userId->id;
    //  dd($main);
        $abouts = About::where(function ($query) use ($main , $id) {
            $query->where('user_id', $main)
                ->orWhere('user_id', $id);
               })->get();

               $id = $abouts->pluck('user_id')->unique()->toArray();

               $admission = admission::where('user_id' , $main)->get();
               $course = course::where('courses.user_id' , $id)
               ->leftjoin('program_master' , 'courses.program_id' , 'program_master.id')->get();
     
        return response()->json(["about" => $abouts , 'admission' => $admission , 'course' => $course]);
    }        

    public function faciltydatagettrans(Request $request){

        $id = $request->id;
        $dataId = ucwords(str_replace('/', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();

        if($college == NULL && $college == ''){
            $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
        }

         $collegeID = $college->id;
      
        $userId = DB::table('users')->where('college_code' , $collegeID)->first();
       if($userId == NULL && $userId == ''){
            $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
        }
        $main = $userId->id;

            $facility = DB::table('user_facility_trans')->where('user_facility_trans.user_id' , $main)->get();
                        $data_arr = array();
                        foreach($facility as $key => $record){
                            $title = $record->title ?? '';
                            $description = $record->content ?? '';
    
                            $data_arr[] = array(
                                "title" => $title,
                                "description" => $description,
                            );
    
                        }
                        
            return response()->json(["facility" => $data_arr]);

    }
    
    public function faciltydataget(Request $request){
       
        $id = $request->id;
        $dataId = ucwords(str_replace('/', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();

        if($college == NULL && $college == ''){
            $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
        }

         $collegeID = $college->id;
      
        $userId = DB::table('users')->where('college_code' , $collegeID)->first();

        if($userId == NULL && $userId == ''){
            $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
        }
       
        $main = $userId->id;

            $facility = DB::table('user_facility')->where('user_facility.user_id' , $main)
                       ->leftjoin('facility_master' , 'user_facility.facility_id' , 'facility_master.id')
                        ->select('user_facility.*' , 'facility_master.name as facility_name' , 'facility_master.image as facility_image')->get();
                        $data_arr = array();
                        foreach($facility as $key => $record){
                            $name = $record->facility_name ?? '';
                            $image = $record->image ?? '';
                            $title = $record->title ?? '';
                            $description = $record->description ?? '';
    
                            if($image == NULL){
                                $image = $record->facility_image;
                            }
    
                            $data_arr[] = array(
                                "facility_image" => $image,
                                "facility_name" => $name,
                                "title" => $title,
                                "description" => $description,
                            );
    
                        }
                        
    
            return response()->json(["facility" => $data_arr]);
        }
    
        public function tbldata(Request $request){
         
            $id = $request->id;
        $dataId = ucwords(str_replace('/', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();

        if($college == NULL && $college == ''){
            $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
        }
         $collegeID = $college->id;
      
        $userId = DB::table('users')->where('college_code' , $collegeID)->first();

        if($userId == NULL && $userId == ''){
            $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
        }
       
        $main = $userId->id;

            $facility = DB::table('user_tbl_placement')->where('user_id' , $main)->get();
    
                        $data_arr = array();
                        foreach($facility as $key => $record){
                            $link = $record->link ?? '';
                            $content = $record->content ?? '';
                            $image = $record->image ?? '';
    
                            $data_arr[] = array(
                                "image" => $image,
                                "link" => $link,
                                "content" => $content,
                            );
    
                        }
                 
            return response()->json(["tbl" => $data_arr]);
        }

        public function geteventdatabycollege(Request $request){

            $id = $request->id;
            $dataId = ucwords(str_replace('/', ' ', $id));
           
            $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
            if($college == NULL && $college == ''){
                $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
            }
             $collegeID = $college->id;
           
            $userId = DB::table('users')->where('college_code' , $collegeID)->first();
            if($userId == NULL && $userId == ''){
                $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
            }
            $main = $userId->id;
           
                       $data = DB::table('events_master')->where('user_id' , $main)->get();
               
                                   $data_arr = array();
                                   foreach($data as $key => $record){
                                       $content = $record->content ?? '';
                                       $image = $record->image ?? '1710667334.jpg';
                                       $link = $record->link ?? '';
               
                                       $data_arr[] = array(
                                           "linnk" => $link,
                                           "image" => $image,
                                           "content" => $content,
                                       );
               
                                   }
                            
                       return response()->json(["event" => $data_arr]);

        }

        public function getbordofdatacollege(Request $request){

            $id = $request->id;
 $dataId = ucwords(str_replace('/', ' ', $id));

 $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
 if($college == NULL && $college == ''){
    $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
}
  $collegeID = $college->id;

 $userId = DB::table('users')->where('college_code' , $collegeID)->first();
 $userId = DB::table('users')->where('college_code' , $collegeID)->first();
 if($userId == NULL && $userId == ''){
    $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
}

 $main = $userId->id;

            $data = DB::table('bord_of_director')->where('user_id' , $main)->get();
    
                        $data_arr = array();
                        foreach($data as $key => $record){
                            $name = $record->name ?? 'Akash kumar';
                            $image = $record->image ?? '1710667334.jpg';
                            $qualification = $record->qualification ?? 'BCA';
                            $designation = $record->designation ?? '....';
    
                            $data_arr[] = array(
                                "name" => $name,
                                "image" => $image,
                                "qualification" => $qualification,
                                "designation" => $designation,
                            );
    
                        }
                 
            return response()->json(["bord" => $data_arr]);

        }
    
        public function accreditationsdata(Request $request){
           
 $id = $request->id;
 $dataId = ucwords(str_replace('/', ' ', $id));

 $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
 if($college == NULL && $college == ''){
    $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
}
  $collegeID = $college->id;

 $userId = DB::table('users')->where('college_code' , $collegeID)->first();
 if($userId == NULL && $userId == ''){
    $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
}
 $main = $userId->id;

            $data = DB::table('accreditations')->where('user_id' , $main)->get();
    
                        $data_arr = array();
                        foreach($data as $key => $record){
                            $title = $record->title ?? '';
                            $image = $record->image ?? '';
                            $content = $record->content ?? '';
    
                            $data_arr[] = array(
                                "title" => $title,
                                "image" => $image,
                                "content" => $content,
                            );
    
                        }
                 
            return response()->json(["accreditations" => $data_arr]);
        }
    
        public function Recognitiondata(Request $request){
            
 $id = $request->id;
 $dataId = ucwords(str_replace('/', ' ', $id));

 $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
 if($college == NULL && $college == ''){
    $college = university::where('name' , 'like', '%' . $dataId . '%')->first();
}
  $collegeID = $college->id;

 $userId = DB::table('users')->where('college_code' , $collegeID)->first();
 if($userId == NULL && $userId == ''){
    $userId = DB::table('users')->where('university_code' , $collegeID)->where('college_code' , NULL)->first();
}
 $main = $userId->id;

            $data = DB::table('accreditations_master')->where('user_id' , $main)->get();
    
                        $data_arr = array();
                        foreach($data as $key => $record){
                            $title = $record->title ?? '';
                            $content = $record->content ?? '';
                            $image = $record->image ?? '';
    
                            $data_arr[] = array(
                                "title" => $title,
                                "content" => $content,
                                "image" => $image,
                            );
    
                        }
                 
            return response()->json(["Recognition" => $data_arr]);
        }

        public function getprogramlavel(Request $request){
 $certificate = course::where('level', 'certificate')->count();
 $Diploma = course::where('level', 'Diploma')->count();
 $UG = course::where('level', 'UG')->count();
 $PG = course::where('level', 'PG')->count();
 
 $data = [
     'certificate' => $certificate,
     'Diploma' => $Diploma,
     'UG' => $UG,
     'PG' => $PG,
 ];
 
 return response()->json($data);
 
         }

         public function coursetypedata(Request $request){

            
 $Distance = course::where('course_type', 'Distance')->count();
 $fulltime = course::where('course_type', 'fulltime')
                    ->join('users' , 'courses.user_id' , '=' , 'users.id')
                    ->join('college_master' , 'users.college_code' , '=' , 'college_master.id')->count();
 $online = course::where('course_type', 'online')->count();
 $parttime = course::where('course_type', 'parttime')->count();
 
 $data = [
     'Distance' => $Distance,
     'fulltime' => $fulltime,
     'online' => $online,
     'parttime' => $parttime,
 ];
 
 return response()->json($data);

         }

         public function getstreamcourse(Request $request){
            $course = $request->course;
            // dd($course);

$data = DB::table('program_master')
    ->where(function ($query) use ($course) {
        foreach ($course as $value) {
            $query->orWhere('program_master.name', 'like', '%' . $value . '%');
        }
    })->join('courses' , 'program_master.id' , '=' , 'courses.program_id')
    ->get();

    if($data->isEmpty()){
        return response()->json([]);
    }

$programIds = $data->pluck('user_id')->unique()->toArray();
// dd($programIds);
// $program = DB::table('user_program')->whereIn('program_id', $programIds)->get();
// dd($program);
// $userIds = explode(',', $program->user_id);
$colleges = DB::table('users')->whereIn('id', $programIds)->get();

$collegeCodes = $colleges->pluck('college_code')->unique()->toArray();
$uniCodes = $colleges->pluck('university_code')->unique()->toArray();

$result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);
    // akash
      if ($result == NULL) {
        return response()->json([]);
    } else {
        return response()->json([
            "data" => $result,
     ]); 
    }
            }

            public function coursefilterdatasearch(Request $request){

        $course = $request->course;
     
        $promgramAll = DB::table('program_master')->where('name' , $course)->get();
        $course = $promgramAll->pluck('id')->unique()->toArray();
       $laveldata = course::where('program_id', $course)
      ->leftJoin('users', 'courses.user_id', '=', 'users.id')
      ->select('users.college_code as college_code', 'users.university_code as university_code')
       ->get();

$college = [];
$university = [];

foreach ($laveldata as $data) {
    if ($data->college_code == null) {
        $university[] = $data->university_code;
    }
    if ($data->university_code !== null && $data->college_code !== null) {
        $college[] = $data->college_code;
    }
}

if (empty($college) && !empty($university)) {
    $college = $laveldata->pluck('university_code')->unique()->toArray();
} elseif (empty($college) && empty($university)) {
}

$collegeCodes = array_unique($college);
$uniCodes = array_unique($university);

    $result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);

    
      if ($result == NULL) {
        return response()->json([]);
    } else {
        return response()->json([
            "data" => $result,
     ]); 
    }

            }

   

    private function coursefilterdatasearchall(Request $request, $collegeCodes, $uniCodes)
{
    $data_arr = [];
    if (!empty($collegeCodes)) {
        $collegeData = college::whereIn('college_master.id', $collegeCodes)
            ->orWhere('city', $collegeCodes)
            ->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
            ->select('college_master.*', 'city_master.city_name', 'city_master.state_name')
            ->get();        

        foreach ($collegeData as $record) {
            $data_arr[] = $this->processRecord($record);
        }
    }

    if (!empty($uniCodes)) {        
        $universityData = University::whereIn('university_master.id', $uniCodes)
            ->leftJoin("city_master", 'university_master.city', '=', 'city_master.id')
            ->select('university_master.*', 'city_master.city_name', 'city_master.state_name')
            ->get();

        foreach ($universityData as $record) {
            $data_arr[] = $this->processRecord($record);
        }
    }

    return $data_arr;
}

private function processRecord($record)
{
    $id = $record->id;
    $name = $record->name ?? '';
    $city = $record->city_name ?? '';
    $address = $record->address ?? '';
    $state = $record->state_name ?? '';
    $image = $record->image ?? '';
    $logo = $record->logo ?? '';
    $description = Str::limit($record->description ?? ' ', 100);
    $Established = $record->Established ?? '1996';

    $facilities = User::where('college_code', $id)->orWhere('university_code', $id)
    ->leftJoin('user_facility', 'users.id', 'user_facility.user_id')
    ->leftJoin('facility_master', 'user_facility.facility_id', 'facility_master.id')
    ->select('users.id as userId', 'facility_master.name as facility_name', 'facility_master.image as facility_image')
    ->get();

    $facilities_arr = [];
    foreach ($facilities as $facility) {
        $facilities_arr[] = [
            "userId" => $facility->userId ?? '',
            "facility_name" => $facility->facility_name ?? 'Gym',
            "facility_image" => $facility->facility_image ?? '1710402627.png'
        ];
    }

    return [
                "id" => $id,
                "name" => $name,
                "city" => $city,
                "address" => $address,
                "state" => $state,
                "image" => $image,
                "logo" => $logo,
                "facilities" => $facilities_arr,
                "description" => $description,
                "Established" => $Established,
    ];
}

         private function view_list_dataNULL($urlId){
            //  dd($urlId);
            $data = DB::table('college_master')
            ->leftJoin("city_master", 'college_master.city', '=', 'city_master.id')
            ->select('college_master.*', 'city_master.city_name', 'city_master.state_name')
            ->get();
        
            $totalRecords = $data->count();
            
            $data_arr = array();
            foreach($data as $key => $record){
                $id = $record->id;
                $name = $record->name ?? '';
                $city = $record->city_name ?? '';
                $address = $record->address ?? '';
                $state = $record->state_name ?? '';
                $image = $record->image ?? '';
                $logo = $record->logo ?? '';
                $description = Str::limit($record->description ?? ' ', 100);
        
             $Established = $record->Established ?? '1985';
                
                   if($data){
            
                            $facility = User::where('college_code' , $id)->orwhere('university_code' , $id)
                                        ->leftjoin('user_facility' , 'users.id' , 'user_facility.user_id')
                                        ->leftjoin('facility_master' , 'user_facility.facility_id' , 'facility_master.id')
                                        ->select('users.id as userId','facility_master.name as facility_name' , 'facility_master.image as facility_image' )
                                        ->get();

                                        $userId = $facility->pluck('user_id')->unique()->toArray();
                                        $facilityname = $facility->pluck('facility_name')->unique()->toArray();
                                        $facilityimage = $facility->pluck('facility_image')->unique()->toArray();
                                        //  $userId = $facility->userId ?? '';
                                       
                                        //     $facilityname = $facility->facility_name ?? '';
                                        //     $facilityimage = $facility->facility_image ?? '';
                                       
                   }
            
                   $data_arr[] = array(
                    "id" => $id,
                    "userId" => $userId,
                    "name" => $name,
                    "city" => $city,
                    "address" => $address,
                    "state" => $state,
                    "image" => $image,
                    "logo" => $logo,
                    "facility_name" => $facilityname,
                    "facility_image" => $facilityimage,
                    "description" => $description,
                    "Established" => $Established,
                );
            }
            
            return $data_arr;
         }

         public function viewcoursetypeajax(Request $request){
                 $type = $request->type;
                //  dd($type);
               
                $laveldata = course::where('course_type', $type)
    ->leftJoin('users', 'courses.user_id', '=', 'users.id')->get();

    $collegeCodes = $laveldata->pluck('college_code')->unique()->toArray();
    $uniCodes = $laveldata->pluck('university_code')->unique()->toArray();
   
    $result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);

  if ($result == NULL) {
            return response()->json([]);
        } else {
            return response()->json([
                "data" => $result,
         ]); 
        }

         }

         public function getlavelsearch(Request $request){
            // dd($request->all());
            $lavel = $request->lavel;
            $laveldata = course::where('level' , $lavel)->get();
            $user_id = $laveldata->pluck('user_id')->unique()->toArray();
            $leveldata1 = User::where('id' , $user_id)->get();
            $levelID = $leveldata1->pluck('user_id')->unique()->toArray();
            if ($levelID) {
                $collegeCodes = $levelID->pluck('college_code')->unique()->toArray();
                $uniCodes = $levelID->pluck('university_code')->unique()->toArray();
                $result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);

                if ($result == NULL) {
                          return response()->json([]);
                      } else {
                          return response()->json([
                              "data" => $result,
                       ]); 
                      }
            }
          
    
        }

        public function getstreamtype(Request $request){

                          $science = ['bca', 'mca' ,  'BArch' , 'Bsc' , 'BPharma' , 'BE' , 'BTech'];
                          $arts = ['BA', 'BFA' ,  'BSC' , 'BA LLB' , 'BHM' , 'BJMC' , 'BJ' , 'BMM' , 'D'];
                          $commerce = ['BCom', 'BBA', 'MCom', 'MBA', 'BCA (Commerce)']; 
                          $education = ['BEd', 'MEd', 'Diploma in Education', 'MPhil Education', 'PhD Education'];
                          $pharmacy = ['DPharma', 'BPharma', 'MPharma', 'PhD Pharmacy'];
                          $law = ['LLB', 'LLM', 'BA LLB', 'BBA LLB', 'BCom LLB', 'LLD'];
                          $fashionDesign = ['BSc Fashion Design', 'B.Design in Fashion', 'MSc Fashion Technology', 'M.Design in Fashion'];
                          $architecture = ['BArch', 'MArch', 'PhD Architecture'];
                          $agriculture = ['BSc Agriculture', 'MSc Agriculture', 'B.Tech Agriculture', 'M.Tech Agriculture'];
                          $management = ['BBA', 'MBA', 'PGDM', 'BMS', 'BHM', 'BBA LLB', 'MHA'];
                          $engineering = ['BE', 'BTech', 'ME', 'MTech', 'B.Tech (Hons)', 'M.Tech (Hons)', 'PhD Engineering'];
                          $medical = ['MBBS', 'BDS', 'BAMS', 'BHMS', 'BPT', 'B.Sc Nursing', 'MD', 'MS', 'MDS', 'MPT', 'M.Sc Nursing', 'PhD Medical Sciences'];

                          $totalscience = Program::whereIn('program_master.name', $science)
                                            ->join('courses' , 'program_master.id' , '=' , 'courses.program_id')
                                            ->join('users' , 'courses.user_id' , '=' , 'users.id')
                                            ->join('college_master' , 'users.college_code' , '=' , 'college_master.id')
                                            ->count();

    $totalArts = Program::whereIn('program_master.name', $arts)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalCommerce = Program::whereIn('program_master.name', $commerce)
    ->leftJoin('courses', 'program_master.id', '=', 'courses.program_id')
    ->leftJoin('users', 'courses.user_id', '=', 'users.id')
    ->leftJoin('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalEducation = Program::whereIn('program_master.name', $education)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalPharmacy = Program::whereIn('program_master.name', $pharmacy)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalLaw = Program::whereIn('program_master.name', $law)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalFashionDesign = Program::whereIn('program_master.name', $fashionDesign)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalArchitecture = Program::whereIn('program_master.name', $architecture)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalAgriculture = Program::whereIn('program_master.name', $agriculture)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalManagement = Program::whereIn('program_master.name', $management)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalEngineering = Program::whereIn('program_master.name', $engineering)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $totalMedical = Program::whereIn('program_master.name', $medical)
    ->join('courses', 'program_master.id', '=', 'courses.program_id')
    ->join('users', 'courses.user_id', '=', 'users.id')
    ->join('college_master', 'users.college_code', '=', 'college_master.id')
    ->count();

    $data = [
        // 'managemnt' => $Distance,
        'totalArts' => $totalArts,
        'totalCommerce' => $totalCommerce,
        'totalEducation' => $totalEducation,
        'totalPharmacy' => $totalPharmacy,
        'totalLaw' => $totalLaw,
        'totalFashionDesign' => $totalFashionDesign,
        'totalArchitecture' => $totalArchitecture,
        'totalAgriculture' => $totalAgriculture,
        'totalManagement' => $totalManagement,
        'totalEngineering' => $totalEngineering,
        'totalMedical' => $totalMedical,
    ];
    
    return response()->json($data);

        }

        public function livesearchrecord(Request $request){
            $query = $request->input('query');
  
            $results = [];

            $results['colleges'] = College::where('name', 'like', '%' . $query . '%')->get();
            $results['courses'] = DB::table('program_master')->where('name', 'like', '%' . $query . '%')->get();
            $data = University::where('university_master.name', 'like', '%' . $query . '%')->get();
            $universityIds = $data->pluck('id')->toArray();
            $usersWithUniversity = User::whereIn('university_code', $universityIds)->get(); 
            
            if ($usersWithUniversity->isNotEmpty()) {
                $universityCodes = $usersWithUniversity->pluck('university_code')->unique()->toArray();
                $results['universities'] = University::whereIn('id', $universityCodes)->get();
            } else {
                $data_arr = [];
                foreach ($data as $key => $val) {
                    $name = $val->name;
                    $data_arr[] = [
                        "name" => $name . ' (coming soon)',
                        "clickable" => false,
                    ];
                }
                $data = $data_arr;
                $results['universities'] = $data;
            }
            
            $flattenedResults = [];
            foreach ($results as $key => $collection) {
                foreach ($collection as $item) {
                    $flattenedResults[] = $item;
                }
            }
            
            $response = collect($flattenedResults);
            
            if ($response->isNotEmpty()) {
                return response()->json($response);
            } else {
                return response()->json([]);
            }
            
          }

          public function allprgmrsbyajax(Request $request){
            $data = DB::table('program_master')->get();
            $data_arr = array();
            foreach($data as $key => $val){
                $name = $val->name;
                $data_arr[] = array(
                    "name" => $name,
                );
            }
            $data = $data_arr;
            return $data;
          }

          public function getfootertopcollege(){
            $data = college::where('college_master.status' , '1')->get();
            $data_arr = array();
            foreach($data as $key => $val){
                $name = $val->name;
                $data_arr[] = array(
                    "name" => $name,
                );
            }
            $data = $data_arr;
                    return $data;
          }

          public function getfooteruniversity(){
            $data = University::where('status' , '1')->get();
            $data_arr = array();
            foreach($data as $key => $val){
                $name = $val->name;
                $data_arr[] = array(
                    "name" => $name,
                );
            }
            $data = $data_arr;
            return $data;
          }

}
