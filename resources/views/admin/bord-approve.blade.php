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
       <a class="nav-link active" href="{{route('bord-approved')}}">
          Edit Approvel
       </a>
        </li>
    
        <li class="nav-item">
       <a class="nav-link " href="{{route('delete-about-approved')}}">
         Delete Approvel
       </a>
        </li>

               </ul>

    <form action="" method="POST" id="useraboutdatachange">
        @csrf
    <div class="row">
                          <div class="mb-2 col-md-4">
                            
                          </div>
</div>
   
   
                        <div class="card">
                <!-- <h5 class="card-header">College</h5> -->
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table " id="datatable">
                    <thead class="">
                      <tr >
                      <th class="fs-6 text-capitalize">S.No.</th>
									<th class="fs-6 text-capitalize"> User Name</th>
									<th class="fs-6 text-capitalize"> Name</th>
									<th class="fs-6 text-capitalize"> qualification</th>
									<th class="fs-6 text-capitalize"> designation</th>
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
                            <label for="firstName" class="form-label ">Title Name <span style="color: red; font-size:20px;">*</span></label>
                            
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
        url: "{{ route('approved-bord') }}",
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
            data: 'name',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'designation',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'designation',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'status',
            orderable: false,
            className: 'text-center'
        },
       
    ],
    lengthMenu: [10, 25, 50, 100],
    pageLength: 25,
    scrollY: '800px',
    scrollCollapse: true,
    
});


$('body').on('click' , '.tglbtn' , function(){
      var confirmation = confirm("Are you sure you want to Change this Status?");
      if (confirmation) {
      var id = $(this).attr('data-id');
    //   alert(id);
				$.ajax({
					url: "{{ route('change-bord-status') }}",
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
