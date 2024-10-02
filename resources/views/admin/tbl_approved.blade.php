@extends('admin.layouts.master')

@section('contant')


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<!-- <button
                          type="button"
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#basicModal"
                        >
                          Add 
                        </button> -->
                        <ul class="nav nav-pills flex-column flex-md-row mb-3">
       
       <li class="nav-item">
       <a class="nav-link active" href="{{route('tbl-approved')}}">
          Edit Approvel
       </a>
        </li>
    
        <li class="nav-item">
       <a class="nav-link" href="{{route('delete-tbl-approved')}}">
         Delete Approvel
       </a>
        </li>
               </ul>
    <!-- <button  type="button" class="btn btn-primary mb-3 " id="university_search">Search</button> -->
    <form action="" method="POST" id="useraboutdatachange">
        @csrf
                        <div class="card">
                <!-- <h5 class="card-header">College</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th class="fs-6 text-capitalize">S.No.</th>
									<th class="fs-6 text-capitalize"> User Name</th>
									<th class="fs-6 text-capitalize"> Link</th>
									<th>Approved</th>
									<th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                     
                    </tbody>
                  </table>
                  </div>
              
                </div>
              <!-- </div> -->
              </form>
      <!-- <div class="content-wrapper"> -->

    

  <div class="row" id="showsingle">
                <div class="col-md-12">
             
                  <div class="card mb-4">

                  <div class="card">
               
                    <div class="card-body" id="aboutupdate">
                 
                      <form id="updateaboout" method="POST">
                    
                     
                        <div class="row" id="description-container">
                       
                        <input type="text"  value="" id="user_id_view" name="aboutid" hidden>
                       
                 
                          <div class="row mb-3">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Link <span style="color: red; font-size:20px;">*</span></label>
                            
                            <input
                              class="form-control specialchar"
                              type="text"
                              name="title"
                              id="titleupdate"
                              placeholder = "Title Name"
                              readonly
                            />
                          
                          </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <label for="" class=" font-layout">Content <span class="inputlabelmedetory text-err"></span></label>
                       
                        <textarea class="form-control" name="about"  id="programeditor1" readonly>
                        
                        </textarea>
                       
                    </div>

              <div class="mt-2">
                
              <!-- <button type="submit" id="updata" class="btn btn-primary me-2">Approve</button> -->
             
            </div>
                      </form>
                    
                    </div>

                    <!-- /Account -->
                  </div>
                  
                </div>
             
            </div>
            </div>
  </div>

            <script>

                $('#showsingle').hide();
                
   var table = $('#datatable').DataTable({
    
    processing: true,
    serverSide: true,
    searching: true,
    bFilter: false,
    ajax: {
        url: "{{ route('tbl-approved-view') }}",
        // type: 'GET',
        // data: function (d) {
        //    ;
        // }
    },
    columns: [
        {
            data: 'id',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'username',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'title',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'status',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'action',
            orderable: false,
            className: 'text-center'
        },
       
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    
});

$('body').on('click', '.viewall', function(e) {
    e.preventDefault();
    $('html, body').scrollTop($(document).height());
    var id = $(this).attr('data-id');
    $.ajax({
        url : "{{route('get-tbl-data-byid')}}",
        type : "GET",
        data : {id : id},
        success : function(response){
            if (response) {
                $.each(response, function(index, item){
                    // alert(item.id);
                    $('#user_id_view').val(item.id);
                    $('#titleupdate').val(item.link);

                    CKEDITOR.instances.programeditor1.setData(item.content);
                    $('#showsingle').show();
                    $('html, body').scrollTop($(document).height());
                });
            }
        }
    });
 });

 $('body').on('click', '.viewpending', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url : "{{route('get-tbl-data-byid')}}",
        type : "GET",
        data : {id : id},
        success : function(response){
            if (response) {
                $.each(response, function(index, item){
                  
                    $('#user_id_view').val(item.id);
                    $('#titleupdate').val(item.link_tmp);

                    CKEDITOR.instances.programeditor1.setData(item.description_tmp);
                    $('#showsingle').show();
                    $('html, body').scrollTop($(document).height());
                });
            }
        }
    });
 });

 $('body').on('click' , '.tglbtn' , function(){
      var confirmation = confirm("Are you sure you want to Change this Status?");
      if (confirmation) {
      var id = $(this).attr('data-id');
    //   alert(id);
				$.ajax({
					url: "{{ route('change-tbl-status') }}",
					dataType : "json",
					type: "get",
					data : {id:id},
					success : function(response) {
					  table.ajax.reload();
                      window.location.reload();
						if(response.status == 'success') {
						
						} else if(response.status == 'error') {
							alert(response.message);						
						}
					},
				});
        }
        table.ajax.reload();
    });

 $('#updata').on('click', function(e) {
    e.preventDefault();

    var formData = new FormData($('#updateaboout')[0]);
    var editorContent = CKEDITOR.instances.programeditor1.getData();
    formData.append('editorContent', editorContent);

    // Add CSRF token to the headers
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('approved-tbl-update') }}",
        dataType: "json",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            alert('saved successfully')
            window.location.reload();
        }
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

@endsection
