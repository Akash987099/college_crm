@extends('user.layouts.master')

@section('user_contant')
        <!-- Layout container -->
      
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

          <!-- {{ Auth::user();}} -->
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
           
              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                  <li class="nav-item">
                      <a class="nav-link active" href="{{route('assign-data')}}">
                      <!-- <i class="fa fa-info" aria-hidden="true"></i> -->
                       Assign</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('user-university')}}">
                      <i class="fa fa-info" aria-hidden="true"></i> About</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user-programs')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Programs</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('bord-of-director')}}"
                        ><i class="fa fa-sitemap" aria-hidden="true"></i> Board Of Director</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user')}}"
                        ><i class="fa fa-picture-o" aria-hidden="true"></i> Photo Gallery</a
                      >
                    </li>
                  </ul>
                 
                  <div class="card">
                <!-- <h5 class="card-header">University</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >#id</th>
                      <th >Assign</th>
                      <th >Type</th>
                      <th >Estb Year</th>
                      <th >Address</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                        <!-- {{$data}} -->
                        @foreach($data as $key => $val)
                        <tr>
                      <td>{{$val->id}}</td>
                      <td>{{$val->name}}</td>
                      <td>{{$val->type}}</td>
                      <td>{{$val->Established}}</td>
                      <td>{{$val->address}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  </div>
                </div>
                </div>

               
          
          @endsection