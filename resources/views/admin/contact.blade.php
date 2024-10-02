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
     
                        <!-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
       
       <li class="nav-item">
       <a class="nav-link " href="{{route('Approved')}}">
          Edit Approvel
       </a>
        </li>
    
        <li class="nav-item">
       <a class="nav-link active" href="{{route('delete-about-approved')}}">
         Delete Approvel
       </a>
        </li>

               </ul> -->

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
									<th class="fs-6 text-capitalize">Name</th>
									<th class="fs-6 text-capitalize"> Phone</th>
									<th class="fs-6 text-capitalize"> Email</th>
									<th class="fs-6 text-capitalize"> city</th>
									<th class="fs-6 text-capitalize"> course</th>
									<!-- <th class="fs-6 text-capitalize"> college</th> -->
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

      <div class="row" id="update_articles">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    
                    <div class="card-body">

                      <form id="articlesupdate" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="text" id="user_id_view" name="updateid" hidden>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Name </label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              id="namedata"
                              name="title"
                              placeholder = "Title"
                            />  
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">phone</label>
                            <input type="text" class="form-control addressallow" id="phonedata" name="image" placeholder="" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Email</label>
                            <input type="text" class="form-control addressallow" id="emaildata" name="image" placeholder="" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">City</label>
                            <input type="text" class="form-control addressallow" id="citydata" name="image" placeholder="" />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Course</label>
                            <input type="text" class="form-control addressallow" id="coursedata" name="image" placeholder="" />
                          </div>

                          <!-- <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">College</label>
                            <input type="text" class="form-control addressallow" id="collegedata" name="image" placeholder="" />
                          </div> -->


                          <div class="mb-3 col-md-12">
                            <label for="zipCode" class="form-label">Description<span class="required">*</span></label>
                            <textarea class="form-control" name="description" id="programeditor1" rows="5">

                            </textarea>
                              
                          </div>
                         
                        <div class="mt-2">
                          <!-- <button type="submit" id="update" class="btn btn-primary me-2">Save</button>
                          <button type="reset" id="close" class="btn btn-outline-secondary">Cancel</button> -->
                        </div>
                      </form>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
              </div>
    


            <script>

                $('#showsingle').hide();
                $('#update_articles').hide();
                
   var table = $('#datatable').DataTable({
    
    processing: true,
    serverSide: true,
    searching: true,
    bFilter: false,
    ajax: {
        url: "{{ route('contact-get-data') }}",
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
            data: 'name',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'mobile',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'email',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'city',
            orderable: false,
            className: 'text-center'
        },
        {
            data: 'course',
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
    scrollY: '800px',
    scrollCollapse: true,
    
});

$('body').on('click', '.edit', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url : "{{route('contact-getbyid')}}",
        type : "GET",
        data : {id : id},
        success : function(response){
              
            $.each(response, function(index, item){
                CKEDITOR.instances.programeditor1.setData(item.description);
                                 $('#namedata').val(item.name);
                                 $('#phonedata').val(item.mobile);
                                 $('#emaildata').val(item.email);
                                 $('#citydata').val(item.city);
                                 $('#coursedata').val(item.course);
                                //  $('#code_view').val(item.country_code);
                                 $('#update_articles').show();
                                  });

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
