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
                <h5 class="card-header">Facility</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="datatable">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>image</th>

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
                            <form action="" id="addcountry" method="POST" enctype="multipart/form-data">
                                @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Facility</h5>
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
                                    <label for="nameBasic" class="form-label"> Name <span class="required">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control form-range" placeholder="Facility Name" />
                                  </div>
                                </div>
                                <div class="row g-2">
                                 
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Image<span class="required">*</span></label>
                                    <input type="file" id="image" name="image" class="form-control form-range" placeholder="****" />
                                  </div>
                                </div>
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
              <h5 class="modal-title">update Record </h5>
              <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                  id="close"
                                ></button>
            </div>
            <div class="modal-body" >

            
                <form method="POST"  class="update_country" enctype="multipart/form-data">
                    <div id="errorContainer"></div>
                    @csrf
                    <input type="text" name="id_input" id="user_id_view" value="" hidden>
                     <div class="form-group">
                     <label for="exampleInputEmail1"> Name<span class="required">*</span></label>
                     <input type="text" class="form-control" maxlength="26" value="" id="name_view" name="name" placeholder="Name">
                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1">Image<span class="required">*</span></label>
                     <input type="file" value=""  class="form-control" id="update_image" name="image" placeholder="image">
                     <img src="..." alt="..." style="height:100px;" id="update_image_preview" class="img-thumbnail">
                 </div>


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
                ajax: "{{ route('list-facility') }}",
                columns: [
                    {
                        data: 'id' , orderable:false,
                        className: 'text-center'
                    },
                    {
                        data: 'name' , orderable:false,
                        className: 'text-center'
                    },
                    {
            data: 'image',
            orderable: false,
            render: function (data, type, row) {
                return '<img class="img-thumbnail" style="height:50px;" src="' + '{{ asset('icons/') }}' + '/' + data + '" alt="Image">';
            }
        },
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
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                    $.ajax({
                        url: "{{ route('facility-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                              table.ajax.reload();
                            } else if (response.status === 'error') {
                                alert(response.message);
                            } else if (response.status === 'exceptionError') {
                              alert(response.message);
                            }
                        },
                    });
                  }
                return false;
            });

            $('body').on('click', '.edit', function() {
    var id = $(this).attr('data-id');

    $.ajax({
        url: "{{ route('facility-edit') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                $.each(response, function(index, item){
                    $('#user_id_view').val(item.id);
                    $('#name_view').val(item.name);

                    if (item.image) {
                        var imgElement = $('<img>').attr('src', "{{ asset('icons/') }}/" + item.image);
                        $('#update_image_preview').attr('src', imgElement.attr('src'));
                    }

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



            
$(document).on('click', '#updatecountry', function () {
    var formdata = new FormData($('.update_country')[0]);
    $('.err').remove();
    $.ajax({
        url: "{{ route('facility-update') }}",
        dataType: "json",
        type: "POST",
        data: formdata,
        processData: false,  
        contentType: false, 
        success: function (response) {
          if (response.status == "success") { // Fix the typo here
                alert('Update Successfully');
                window.location.reload();
            } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "name") {
                        $('#name_view').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "image") {
                        $('#update_image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
            }
        }
    });
});


            $('#countyrsave').on('click', function () {
    var formdata = new FormData($('#addcountry')[0]); 
    $('.err').remove();

    $.ajax({
        url: "{{ route('add-facility') }}",
        type: "POST",
        data: formdata,
        contentType: false, 
        processData: false, 
        success: function (response) {
            if (response.status == "success") { // Fix the typo here
                alert('Saved Successfully');
                location.reload();
            } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "name") {
                        $('#name').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "image") {
                        $('#image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
            }
        }
    });
});

</script>

@endsection
