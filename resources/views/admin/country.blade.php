@extends('admin.layouts.master')

@section('contant')


<div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">
<!-- <button type="button" class="btn btn-primary" id="addcountry">Add Country</button> -->
<button
                          type="button"
                          class="btn btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#basicModal"
                        >
                          Add 
                        </button>
                        <div class="card">
                <h5 class="card-header">Country List</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="datatable">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Country Name</th>
                          <!-- <th>Country Code</th> -->
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

</div>

<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form action="" id="addcountry" method="POST">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Country</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Country Name</label>
                                    <input type="text"  min="0" max="26" name="contryname" class="form-control form-range" placeholder="Country Name" />
                                  </div>
                                </div>
                                <!-- <div class="row g-2">
                                 
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Country Code</label>
                                    <input type="text" min="0" max="4"  name="countrycode" class="form-control form-range" placeholder="****" />
                                  </div>
                                </div> -->
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" class="btn btn-primary" id="countyrsave">Save </button>
                              </div>
                            </div>
                           </form>
                          </div>
                        </div>

                        <div class="modal"  id="viewmodal" tabindex="-2" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Record </h5>
              <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                  id="close"
                                ></button>
            </div>
            <div class="modal-body" >

            
                <form method="POST"  class="update_country">
                    <div id="errorContainer"></div>
                    @csrf
                    <input type="text" name="id_input" id="user_id_view" value="" hidden>
                     <div class="form-group">
                     <label for="exampleInputEmail1">Country Name</label>
                     <input type="text" class="form-control" maxlength="26" value="" id="name_view" name="name_input" placeholder="Name">
                 </div>
                 <!-- <div class="form-group">
                     <label for="exampleInputPassword1">Country Code</label>
                     <input type="phone" value="" maxlength="6" class="form-control" id="code_view" name="phone_input" placeholder="Phone">
                 </div> -->


                </form>

            </div>
            <div class="modal-footer">
            <button type="submit" id="updatecountry" class="btn btn-primary" data-bs-dismiss="modal">
                                  update
                                </button>
            <button type="button" class="btn btn-outline-secondary" id="close" data-bs-dismiss="modal">
                                  Close
                                </button>
            </div>
          </div>
        </div>
      </div>

    <script>
    
    $(document).on('click' , '#close' , function(){
        $('.modal').hide();
    });

            var _ = $('body');
            var updateRecord = 'Are you sure you want to modify this record?';
            var deleteRecord = 'Are you sure you want to delete this record?';

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,  
                searching: true,
                ajax: "{{ route('country_data') }}",
                columns: [
                    {
                        data: 'id' , orderable:false,
                        className: 'text-center'
                    },
                    {
                        data: 'name' , orderable:false,
                        className: 'text-center'
                    },
                    // {
                    //     data: 'code' , orderable:false
                    // },
                    {
                        data: 'action' , orderable:false,
                        className: 'text-center'
                    }
                ],
                lengthMenu: [10, 25, 50, 100], // Define available options
                pageLength: 25,
                // scrollY: '500px', 
                scrollCollapse: false, 
            });
 

        $('body').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('country-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                table.ajax.reload();
                            } else if (response.status == 'error') {
                                alert(response.message);
                            } else if (response.status == 'exceptionError') {
                                CommonManager.forcelogout();
                            }
                        },
                    });
                return false;
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('country-edit') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response) {

                                $.each(response, function(index, item){
                                 $('#user_id_view').val(item.id);
                                 $('#name_view').val(item.country_name);
                                 $('#code_view').val(item.country_code);
                                 $('#viewmodal').show();
                                  });
                              
                            } else if (response.status == 'error') {

                                alert(response.message);

                            } else if (response.status == 'exceptionError') {
                                CommonManager.forcelogout();
                            }
                        },
                    });
                return false;
            });
            
            $(document).on('click' , '#updatecountry' , function(){
               var formData = $('.update_country').serialize();
                 $.ajax({
                    url: "{{ route('country-update') }}",
                        dataType: "json",
                        type: "GET",
                        data: formData,
                        success : function (response){
                            if(response.status === "success"){
                alert(response.message);
                table.ajax.reload();
            }
                        }
                 });
            });

    $('#countyrsave').on('click' , function(){
      var formdata = $('#addcountry').serialize();
     $.ajax({
        url : "{{route('addcountry')}}",
        type : "POST",
        data : formdata,
        success : function(response){
            if(response.status === "success"){
                alert(response.message);
               table.ajax.reload();
            }else if(response.status === "exit"){
                alert(response.message);
            }
            else if (response.status === 'error') {
                alert(response.errors);
                        }
        }
     });
    });
</script>

@endsection
