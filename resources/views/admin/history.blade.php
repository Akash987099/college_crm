@extends('admin.layouts.master')

@section('contant')

<!-- Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<ul class="nav nav-pills flex-column flex-md-row mb-3">
                  <!-- <li class="nav-item">
                      <a class="nav-link " href="{{route('assign-data')}}">
                      <i class="fa fa-info" aria-hidden="true"></i>
                       Assign</a>
                    </li> -->
       
          <li class="nav-item">
          <a class="nav-link active" href="{{ route('history') }}">
            <!-- <i class="fa fa-info" aria-hidden="true"></i> -->
             User History
          </a>
           </li>
       
           <li class="nav-item">
          <a class="nav-link" href="{{ route('admin-history') }}">
            <!-- <i class="fa fa-info" aria-hidden="true"></i>  -->
            Admin History
          </a>
           </li>

                  </ul>

   
                        <div class="card">
                <!-- <h5 class="card-header">College</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th >S No.</th>
                      <th >User Name</th>
                      <th >Date & Time</th>
                      <th >Mode </th>
                      <th > Program </th>
                      <!-- <th > Old Data </th>
                      <th > New Data </th> -->
                      <th > Action </th>
                     
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                     
                    </tbody>
                  </table>
                  </div>

                  <hr>
                  <div class="form-group" id="content">
       <label for="" class=" font-layout">New Record <span class="inputlabelmedetory text-err"></span></label>
              <textarea class="form-control conitentdata" name="about"  id="programeditor1">
       
       </textarea>
       <br>
       <label for="" class=" font-layout">Old Record <span class="inputlabelmedetory text-err"></span></label>
       <textarea class="form-control conitentdata" name="about"  id="programeditor2">
       
       </textarea>
              </div>

                </div>
             

            <script>

$('#add_university').hide();
$('#collegeupdate').hide();
$('#content').hide();

                
   var table = $('#datatable').DataTable({
    dom: 'lBfrtip',
    buttons: ['excel'],
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
        url: "{{ route('history-view') }}",
        type: 'GET',
        data: function (d) {
          
        }
    },
    columns: [
        {
            data: 'id',
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
            data: 'duration',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'duration_time',
            orderable: false,
            className: 'text-center'
        },
        // {
        //     data: 'old_value',
        //     orderable: false,
        //     className: 'text-center'
        // },
        // {
        //     data: 'new_value',
        //     orderable: false,
        //     className: 'text-center'
        // },
        {
            data: 'action',
            orderable: false,
            className: 'text-center'
        },
       
        
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    // scrollY: '800px',
    scrollCollapse: true,
    
});

$(document).ready(function () {
    $('#search').submit(function (e) {
        e.preventDefault(); 

       
        table.search($('#user_search_input').val()).draw();
    });
    });

    $('body').on('click' , '.view' , function(){
      // alert('hello');
      var id = $(this).attr('data-id');
      // alert(id);
      $.ajax({
        url: "{{ route('history-edit-view') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                CKEDITOR.instances.programeditor1.setData(response.new_value);
                CKEDITOR.instances.programeditor2.setData(response.old_value);
                    $('#content').show();
            } else if (response.status == 'error') {
                alert(response.message);
            } else if (response.status == 'exceptionError') {
                CommonManager.forcelogout();
            }
        },
    });
    });

</script>


<script type="text/javascript">
        $(document).ready(function() {
      var editor2=CKEDITOR.replace('programeditor1',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
      });
        });

</script>

<script type="text/javascript">
        $(document).ready(function() {
      var editor2=CKEDITOR.replace('programeditor2',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
      });
        });

</script>

@endsection
