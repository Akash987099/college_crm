@extends('user.layouts.master')

@section('user_contant')
        <!-- Layout container -->
      
          <!-- / Navbar -->

          
          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

            
           
              <div class="row">
                <div class="col-md-12">
                @include('user.common_tab')

                    <!-- {{Auth::user()->id;}} -->

                  <div class="card">
                <h5 class="card-header"> 
                @if(AddPermission(2))
                  <button id="adddata" for="firstName" class="form-label nav-link btn btn-primary" data-bs-toggle="modal"
                          data-bs-target="#basicModal" >Add</button>
                          @endif
                
                </h5>

                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead >
                      <tr >
                      <th >Sr No</th>
                      <th >Name</th>
                      <th >Designation</th>
                      <th >Qualification</th>
                      <th >Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 table-bordered">
                    
                        
                    </tbody>
                  </table>
                  </div>
                </div>
                
                 </div>
                 


                 
                  <div class="card mb-4">
                    <hr class="my-0" />

                    <div class="card-body" id="addbord">

                      <form id="addborddata" method="POST" enctype="multipart/form-data">
                      @csrf
                     
                        <div class="row" id="description-container">


                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Name  <span class="required">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Designation<span class="required">*</span></label>
                            <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Qualification <span class="required">*</span></label>
                            <input type="text" name="qualification" id="qualification" class="form-control" placeholder="Qualification">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">image<span class="required">*</span></label>
                            <input type="file" name="image" class="form-control" >
                          </div>

                          <div id="selectedValue"></div>

                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                          
                        </div>
                         
                      </form>
                      
                    </div>

                  </div>


                  <div class="card mb-4">
                    <br>
                    <br>

                    <div class="card-body" id="upadtedata">

                      <form id="updaterecord" method="POST" enctype="multipart/form-data">
                      @csrf
                     
                        <div class="row" id="description-container">
                                  <input type="text" name="dataid" id="dataid" hidden>

                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Name <span class="required">*</span></label>
                            <input type="text" name="update_name" id="update_name" class="form-control" placeholder="Name">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Designation<span class="required">*</span></label>
                            <input type="text" name="update_designation" id="update_designation" class="form-control" placeholder="Designation">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Qualification <span class="required">*</span></label>
                            <input type="text" name="update_qualification" id="update_qualification" class="form-control" placeholder="Qualification">
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">image <span class="required">*</span></label>
                            <input type="file" name="update_image"  class="form-control" >
                            <img id="imagePreview" style="height:100px;" alt="Image Preview">
                          </div>

                          <div id="selectedValue"></div>

                        <div class="mt-2">
                          <button type="submit" id="submit" class="btn btn-primary me-2">Save</button>
                       
                        </div>
                         
                      </form>
                      
                    </div>
                    </div>
                    </div>
                 </div>
               
            <script>

              $('#addbord').hide();
              $('#upadtedata').hide();

              $('#adddata').click(function(){
                $('#upadtedata').hide();
                $('#addbord').show();
                     $('html, body').scrollTop($(document).height());
              });
              // add-bord-data

              $('#save').click(function(e){
                e.preventDefault();
              $('#upadtedata').hide();

                // var formData = $('#addborddata').serialize();
                var formData = new FormData($('#addborddata')[0]);
                
                $('.err').remove();
                 $.ajax({
                  url : "{{route('add-bord-data')}}",
                  type : "POST",
                  contentType: false,
                   processData: false,
                  data : formData,
                  success : function(response){
                    
                    if (response.status == "sussess") {
                           alert(response.message);
                         
                           $('#addborddata')[0].reset();
                           $('html, body').scrollTop($('#addbord').offset().top);
                           table.ajax.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "name"){
                                        $('#name').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if(i == "designation"){
                                        $('#designation').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if(i == "qualification"){
                                        $('#qualification').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }

                  }
                 });
              });

                var table = $('#datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  searching: true,
                  ajax: "{{route('bord-data')}}",
                  columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'name',
                orderable: true,
                className: 'text-center'
            },
            {
                data: 'designation',
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'qualification',
                orderable: false,
                className: 'text-center'
            },
          
            {
                data: 'action',
                orderable: false,
                className: 'text-center'
            }
        ],
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        // scrollY: '800px', 
        scrollCollapse: false, 
                });

              $('body').on('click' , '.update' , function(){
                var id = $(this).attr('data-id');
                // alert('hello');
                $('#addbord').hide();

                  
                  $.ajax({
                    url : "{{route('get-bordid-data')}}",
                    type : "GET",
                    data : {id : id},
                    success : function(response){
                      $.each(response , function(index , item){
                // console.log(item.name);
                var imageUrl = "{{ asset('image/') }}/" + item.image;
                $('#update_name').val(item.name);
                $('#update_designation').val(item.designation);
                $('#update_qualification').val(item.qualification);
                $('#imagePreview').attr('src', imageUrl);
                $('#dataid').val(item.id);
                $('#upadtedata').show();
                $('html, body').scrollTop($(document).height());
              });
                    }
                  });
              });

              $('#submit').click(function(e){
                e.preventDefault();
                $('.err').remove();
                // var formData = $('#updaterecord').serialize();
                var formData = new FormData($('#updaterecord')[0]);
                // alert(formData);
                $.ajax({
                  url : "{{route('update-bord')}}",
                  type : "POST",
                  data : formData,
                  contentType: false,
                   processData: false,
                  success : function(response){
                    
                    if (response.status == "success") {
                           alert(response.message);
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "update_name"){
                                        $('#update_name').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if(i == "update_designation"){
                                        $('#update_designation').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if(i == "update_qualification"){
                                        $('#update_qualification').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }

                  }
                });
              });


              $('body').on('click' , '.delete' , function(){
                var id = $(this).attr('data-id');
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                 $.ajax({
                  url : "{{route('delete-bord')}}",
                  tyep : "GET",
                  data : {id : id},
                  success : function(response){
                    if (response.status == "sussess") {
                           alert(response.message);
                           table.ajax.reload();
                        }else if (response.status == 'error') {
                          alert(response.message);
                        }
                  }
                 });
          }
              });

    
            </script>
        
          @endsection