$laveldata = course::where('program_id', $course)
    ->leftJoin('users', 'courses.user_id', '=', 'users.id')
    ->select('users.college_code as college_code')->get();




    $collegeCodes = $laveldata->pluck('college_code')->unique()->toArray();

    $query = $request->input('query');
  
  $results = [];

  $results['colleges'] = College::where('name', 'like', '%' . $query . '%')->get();
  $results['universities'] = University::where('name', 'like', '%' . $query . '%')->get();
  // $results['courses'] = Course::where('name', 'like', '%' . $query . '%')->get();
  
  $response = collect($results)->flatten();
  
  if ($response->isNotEmpty()) {
      return response()->json($response);
  } else {
      return response()->json([]);
  }


  $result = $this->coursefilterdatasearchall($request, $collegeCodes, $uniCodes);

  if ($data_arr == NULL) {
            return response()->json([]);
        } else {
            return response()->json([
                "data" => $data_arr,
                "totalRecords" => $totalRecords
         ]); 
        }

        <div class="overlay"></div>
    <main>
        <header>
        <nav>
                <ul class="links">
                    <li id="submenu">Lorem <i class="fa-solid fa-chevron-down"></i></li>
                </ul>

                <div class="close-menu">
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="container-menu-responsive">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
        <div class="container-submenu">
        <div class="menu-submenu">
            <ul>
                <li class="current-submenu" data-submenu="1"><i class="fa-solid fa-truck-fast"></i> Lorem <span><i class="fa-solid fa-arrow-right"></i></span></li>
                <li data-submenu="2"><i class="fa-solid fa-house" ></i> Lorem <span><i class="fa-solid fa-arrow-right"></i></span></li>
                <li data-submenu="3"><i class="fa-solid fa-sailboat"></i> Lorem <span><i class="fa-solid fa-arrow-right"></i></span></li>
                <li data-submenu="4"><i class="fa-solid fa-utensils"></i> Lorem <span><i class="fa-solid fa-arrow-right"></i></span></li>
                <li data-submenu="5"><i class="fa-solid fa-music"></i> Lorem <span><i class="fa-solid fa-arrow-right"></i></span></li>
            </ul>
        </div>
        <div class="block-submenu">
            <div data-submenu="1" class="is-visible submenu">
                <h3>Submenu 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quas tempore repudiandae, rem velit error nisi qui consequatur excepturi nihil natus hic! Ipsa officiis quas exercitationem eum accusamus? Odio, aperiam?</p>

                <div class="lists-submenu">
                    <ul>
                        <h5>Lorem</h5>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                    </ul>

                    <ul>
                        <h5>Lorem</h5>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                        <li><a href="#">Lorem</a></li>
                    </ul>
                </div>
            </div>
            <div data-submenu="2" class="submenu">
                <form action="" id="form-search">
                    <h3>Search</h3>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="search" id="search">
                    <button type="submit">search</button>
                </form>
            </div>
            <div data-submenu="3" class="submenu">
                
                <h3>Submenu 3</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, fugiat velit cumque sit unde eius temporibus delectus labore. Perspiciatis explicabo vel libero! Voluptate ipsum veniam nostrum, voluptates possimus iure libero!</p>
            </div>
            <div data-submenu="4" class="submenu">
                <h3>Submenu 4</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, fugiat velit cumque sit unde eius temporibus delectus labore. Perspiciatis explicabo vel libero! Voluptate ipsum veniam nostrum, voluptates possimus iure libero!</p>
            </div>
            <div data-submenu="5" class="submenu">
                <h3>Submenu 5</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, fugiat velit cumque sit unde eius temporibus delectus labore. Perspiciatis explicabo vel libero! Voluptate ipsum veniam nostrum, voluptates possimus iure libero!</p>
            </div>
        </div>

    </div>
    </header>
    </main>




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


    if($data->isEmpty()){

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

return $data;

 }



 $dataId = ucwords(str_replace('-', ' ', $id));


 $id = $request->id;
        $dataId = ucwords(str_replace('-', ' ', $id));

        $college = college::where('name' , 'like', '%' . $dataId . '%')->first();
         $collegeID = $college->id;
      
        $userId = DB::table('users')->where('college_code' , $collegeID)->first();
       
        $main = $userId->id;


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

            $Established = property_exists($record, 'Established') ? $record->Established : $record->established ?? '';