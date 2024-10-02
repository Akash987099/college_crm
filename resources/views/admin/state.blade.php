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
                <h5 class="card-header">State List</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="datatable">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>State Name</th>
                          <!-- <th>State Code</th> -->
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
                            <form action="" id="addstate" method="POST">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">State</h5>
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
                                    <label for="nameBasic" class="form-label">State Name</label>
                                    <input type="text"  min="0" max="26" name="statename" class="form-control form-range" placeholder="State Name" />
                                  </div>
                                </div>
                                
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" class="btn btn-primary" id="statesave">Save </button>
                              </div>
                            </div>
                           </form>
                          </div>
                        </div>
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
                <form method="POST"  class="update_state">
                    <div id="errorContainer"></div>
                    @csrf
                    <input type="text" name="id_input" id="user_id_view" value="" hidden>
                     <div class="form-group">
                     <label for="exampleInputEmail1">State Name</label>
                     <input type="text" class="form-control" value="" id="name_view" name="name_input" placeholder="Name">
                 </div>
                
                </form>

            </div>
            <div class="modal-footer">
            <button type="submit" id="updatestate" class="btn btn-primary" data-bs-dismiss="modal">
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
                ajax: "{{ route('state_data') }}",
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
                        url: "{{ route('state-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                window.location.reload();
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
                        url: "{{ route('state-edit') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response) {

                                $.each(response, function(index, item){
                                 $('#user_id_view').val(item.id);
                                 $('#name_view').val(item.state_name);
                                 $('#code_view').val(item.state_code);
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
            
            $(document).on('click' , '#updatestate' , function(){
               var formData = $('.update_state').serialize();
                 $.ajax({
                    url: "{{ route('state-update') }}",
                        dataType: "json",
                        type: "GET",
                        data: formData,
                        success : function (response){
                            if(response.status === "success"){
                alert(response.message);
                window.location.reload();
            }
                        }
                 });
            });

    $('#statesave').on('click' , function(){
      var formdata = $('#addstate').serialize();
     $.ajax({
        url : "{{route('addstate')}}",
        type : "POST",
        data : formdata,
        success : function(response){
            if(response.status === "success"){
                alert(response.message);
                window.location.reload();
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
