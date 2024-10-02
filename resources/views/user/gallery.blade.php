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
                  
                  <div class="card">

                  <h5 class="card-header"> 
                  @if(AddPermission(3))
                  <button for="firstName" class="form-label nav-link btn btn-primary" id="adddata"
                          >Add</button>
                          @endif
                
                </h5>
                  <div class="card-body">
                    
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >Sr No</th>
                      <th >Image</th>
                      <th >Rank</th>
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

                        <div class="mb-3 col-md-3">
                            <label for="firstName" class="form-label ">Ranke/Grid <span class="required">*</span></label>
                            <!-- <input type="file" name="docs[]" class="form-control" multiple> -->
                            <select class="form-control" name="ranke" id="ranke">
                              <option value="">Select</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label ">Image<span class="required">*</span></label>
                            <input type="file" name="image" id="image" class="form-control">
                          </div>

                          <div id="selectedValue"></div>

                        <div class="mt-2">
                          <button type="submit" id="save" class="btn btn-primary me-2">Save</button>
                        </div>
                         
                      </form>
                      
                    </div>


                  

                    <!-- /Account -->
                  </div>

                  <div class="card-body" id="updatefgallery">

<form id="updatedata" method="POST" enctype="multipart/form-data">
  @csrf
 
    <div class="row" id="description-container">
<input type="text" id="user_id_view" value="" name="updateid" hidden>
    <div class="mb-3 col-md-3">
        <label for="firstName" class="form-label ">Rank/Grid<span class="required">*</span></label>
        <!-- <input type="file" name="docs[]" class="form-control" multiple> -->
        <select class="form-control" name="ranke" id="rankedata">
          <option value="">Select</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
      </div>

      <div class="mb-3 col-md-6">
        <label for="firstName" class="form-label ">Image<span class="required">*</span></label>
        <input type="file" name="image" class="form-control">
        <img src="..." alt="..." id="update_image_preview" class="img-thumbnail" style="height:150px;">
      </div>

    <div class="mt-2">
      <button type="submit" id="update" class="btn btn-primary me-2">Save</button>
    </div>
     
  </form>
  
</div>


                    </div>
                    </div>
                    </div>
                    
                    </div>
                    </div>


<script>

// adddata

$('#addbord').hide();
$('#updatefgallery').hide();

$('#adddata').click(function(){
  $('#addbord').show();
  $('#updatefgallery').hide();
  $('html, body').scrollTop($(document).height());
});

      $(document).ready(function () {
        $('#save').on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addborddata')[0]);
            $('.err').remove();
              // console.log(formData);
            $.ajax({
                type: 'POST',
                url: "{{route('uplaod-image')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == "sussess") {
                           alert(response.message);
                           window.location.reload();
                        } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "ranke") {
                        $('#ranke').after('<span id="university_error" class="err" style="color:red">your selected rank has already been taken</span>');
                    } else if (i == "image") {
                        $('#image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
            }
                },
                error: function (error) {
                    console.log(error);
                    // Handle error response
                }
            });
        });
    });

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('gallery-list') }}",
        columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-center'
               
            },
            {
                data: 'image',
                orderable: true,
                className: 'text-center',
                render: function (data, type, full, meta) {
                    return type === 'display' ?
                        '<img  style="height:100px;" src="' + "{{ asset('icons') }}/" + data + '" alt="Image" class="img-thumbnail">' :
                        data;
                }
            },
            {
                data: 'rank',
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
        pageLength: 25,
        scrollCollapse: false, 
    });

    $('body').on('click', '.edit', function() {
    var id = $(this).attr('data-id');
    $('#addbord').hide();
    $.ajax({
        url: "{{ route('gallery-edit') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                $.each(response, function(index, item){
                //  alert(item.id);
                    $('#user_id_view').val(item.id);
                    $('#rankedata').val(item.ranke);

                    if (item.image) {
                        var imgElement = $('<img style="hieght:200px;">').attr('src', "{{ asset('icons/') }}/" + item.image);
                      //  console.log(imgElement);
                        $('#update_image_preview').attr('src', imgElement.attr('src'));
                    }
                   $('#updatefgallery').show();
                   $('html, body').scrollTop($(document).height());
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


$(document).on('click', '#update', function (e) {
  e.preventDefault();
    var formdata = new FormData($('#updatedata')[0]);
    $('.err').remove();
    $.ajax({
        url: "{{ route('gallery-update') }}",
        dataType: "json",
        type: "POST",
        data: formdata,
        processData: false,  
        contentType: false, 
        success: function (response) {
          if (response.status == "sussess") { // Fix the typo here
                alert('Update Successfully');
                table.ajax.reload();
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

    $('body').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                    $.ajax({
                        url: "{{ route('gallery-delete') }}",
                        dataType: "json",
                        type: "GET",
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            if (response.status === 'sussess') {
                              alert(response.message);
                              table.ajax.reload();
                            } else if (response.status == 'error') {
                                alert(response.message);
                            } else if (response.status == 'exceptionError') {
                                CommonManager.forcelogout();
                            }
                        },
                    });
                  }
                return false;
            });

</script>
        
          @endsection