@extends('admin.layouts.master')

@section('contant')


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<!-- <button type="button" class="btn btn-primary mb-3 text-right" id="university_add">
        Add
    </button> -->
    
    <!-- <button  type="button" class="btn btn-primary mb-3 " id="university_search">Search</button> -->
    <form action="" method="POST" id="search">
    @csrf
    <div class="row">
        <div class="mb-2 col-md-3">
            <!-- <select name="search_type" id="search_type" class="form-control">
                <option value="">Select</option>
                <option value="username">Username</option>
                <option value="date">Date</option>
            </select> -->
            <input type="text" class="form-control" name="user_search_input" id="user_search_input" placeholder=" Enter user name">
        </div>

        
        <div class="mb-2 col-md-3">
    <input type="DATE" class="form-control" name="user_search_startdate" id="user_search_startdate" placeholder="Enter Start Date" max="{{ date('Y-m-d') }}">
    <span id="dateValidationError" style="color: red;"></span>
</div>


<div class="mb-2 col-md-3">
             <input type="date" class="form-control" name="user_search_lastdate" id="user_search_lastdate" placeholder="Enter End Date">
</div>

                <div class="mb-2 col-md-2">
            <button type="submit" id="searchuser" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

   
                        <div class="card">
                <!-- <h5 class="card-header">College</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th >S No.</th>
                      <th > Date</th>
                      <th >User Name</th>
                      <th >Login Time</th>
                      <th >Logout Time</th>
                      <th >Duration </th>
                      <th > Total Duration </th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                     
                    </tbody>
                  </table>
                  </div>
                </div>
              <!-- </div> -->

      <!-- <div class="content-wrapper"> -->


<div class="container-xxl flex-grow-1 container-p-y">
             
              <div class="row" id="add_university">
                <div class="col-md-12">
                  <!-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="fa fa-university me-1"></i> University</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('college')}}"
                        ><i class="fa fa-graduation-cap me-1"></i> College</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user')}}"
                        ><i class="bx bx-user me-1"></i> User</a
                      >
                    </li>
                  </ul> -->
               

            <script>

$('#add_university').hide();
$('#collegeupdate').hide();


// $(document).ready(function() {
  
//     $('#user_search_input').hide();

//     $('#search_type').change(function() {
     
//         $('#user_search_input').toggle($(this).val() !== 'date');

    
//         if ($(this).val() === 'date') {
//             $('#user_search_startdate').val('');
//             $('#user_search_lastdate').val('');
//             $('#dateInputs').show();
//         } else {
//             $('#dateInputs').hide();
//         }
//     });
// });

                
   var table = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
        url: "{{ route('loginReport-list') }}",
        type: 'GET',
        data: function (d) {
            // Add the search values to the data sent to the server
            d.search_type = $('select[name="search_type"]').val();
            d.user_search_input = $('#user_search_input').val();
            d.user_search_startdate = $('#user_search_startdate').val();
            d.user_search_lastdate = $('#user_search_lastdate').val();
        }
    },
    columns: [
        {
            data: 'id',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'date',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'name',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'login',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'logout',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'duration',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'duration_time',
            orderable: false,
            className: 'text-center'
        },
       
        
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    scrollY: '800px',
    scrollCollapse: true,
    
});

$(document).ready(function () {
    $('#search').submit(function (e) {
        e.preventDefault(); 

       
        table.search($('#user_search_input').val()).draw();
    });
    });

</script>

@endsection
