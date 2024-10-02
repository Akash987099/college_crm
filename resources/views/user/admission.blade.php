@extends('user.layouts.master')

@section('user_contant')

<style>
 .select2-search__field {
    width: 11.75em !important;
}
</style>
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
                @if(AddPermission(8))
                  <button for="firstName" class="form-label nav-link btn btn-primary" id="Addformshow">Add</button>
                  @endif
                </h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >Sr No</th>
                      <th >Link</th>
                      <th >Image</th>
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

<div class="card">

  <div class="card-body" id="aboutupdate">
 
    <form id="updateaboout" method="POST" enctype="multipart/form-data">
    @csrf
   
      <div class="row" id="description-container">

        <div class="row mb-3">
        <div class="mb-3 col-md-6">
          <label for="firstName" class="form-label ">Link <span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              name="link"
                              id="link"
                              placeholder = "Link"
                            />
        </div>

        <div class="mb-3 col-md-6">
          <label for="firstName" class="form-label ">Image<span class="required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="file"
                              name="image"
                              id="image"
                              placeholder = "Link"
                            />
        </div>
      </div>
      </div>

      <div class="form-group">
       
      <label for="" class=" font-layout">Content <span class="inputlabelmedetory text-err required">*</span></label>
      
      <textarea class="form-control" name="about"  id="programeditor">
      </textarea>
     
      
  </div>

<div class="mt-2">
             
              <button type="save" id="add" class="btn btn-primary me-2">Submit</button>
               
</div>
    </form>
   
  </div>

  <!-- /Account -->
</div>

<div class="card-body" id="updateupcoming">
 
    <form id="upcomingupdate" method="POST" enctype="multipart/form-data">
    @csrf
     <input type="text" name="userupdateid" id="user_id_view" hidden>
      <div class="row" id="description-container">

        <div class="row mb-3">
        <div class="mb-3 col-md-6">
          <label for="firstName" class="form-label ">Link<span class="inputlabelmedetory text-err required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="text"
                              name="link"
                              id="update_link"
                              placeholder = "Link"
                            />
        </div>

        <div class="mb-3 col-md-6">
          <label for="firstName" class="form-label ">Image<span class="inputlabelmedetory text-err required">*</span></label>
                            <input
                              class="form-control specialchar"
                              type="file"
                              name="image"
                              id="updateimage"
                              placeholder = "Link"
                            />
                            <img style="height:100px;" src="" id="updateimageview" alt="">
        </div>
      </div>
      </div>

      <div class="form-group">
       
      <label for="" class=" font-layout">Content <span class="inputlabelmedetory text-err required">*</span></label>
      
      <textarea class="form-control conitentdata" name="about"  id="programeditor1">
      </textarea>
        
  </div>

<div class="mt-2">
             
              <button type="save" id="update" class="btn btn-primary me-2">Submit</button>
               
</div>
    </form>
   
  </div>

</div>

</div>


                       
<script>

  $('#dynamicInput').hide();
  $('#updateupcoming').hide();

  $('#aboutupdate').hide();

  $('#Addformshow').click(function(){
    $('#aboutupdate').show();
    $('html, body').scrollTop($(document).height());
  });

  $('#adddrop').click(function(){
    $('#dynamicInput').show();
  });

  $('#close').click(function(){
    $('#viewmodal').hide();
  });


  $(document).ready(function () {
    $('#add').on('click', function (e) {
        e.preventDefault();
        $('#updateupcoming').hide();
        var editor = CKEDITOR.instances.programeditor;
        var editorContent = editor.getData();

        var formData = new FormData($('#updateaboout')[0]);
        formData.append('editorContent', editorContent);

        $('.err').remove();

        // Append the CSRF token to the headers
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        // AJAX request
        $.ajax({
            url: '{{ route('admission-add') }}',
            type: 'POST',
            data: formData,
            headers: headers,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle the response from the server
                if (response.status == "success") {
                    // alert(response.message);
                    alert('Saved successfully. This content is forwarded for approval')
                    window.location.reload();
                } else if (response.status == 'error') {
                    $.each(response.message, function (i, message) {
                        if (i == "editorContent") {
                            $('#programeditor').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                        } else if (i == "link") {
                            $('#link').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                        } else if (i == "image") {
                            $('#image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                        }
                    });
                }
            },
            error: function (error) {
                // Handle errors
                console.error(error);
            }
        });
    });
});


var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('adission-list') }}",
        columns: [
            {
                data: 'id',
                orderable: false,
                className: 'text-center'
               
            },
            {
                data: 'link',
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'image',
                orderable: false,
                className: 'text-center',
                render: function (data, type, full, meta) {
                    return type === 'display' ?
                        '<img  style="height:70px;" src="' + "{{ asset('events') }}/" + data + '" alt="Image" class="img-thumbnail">' :
                        data;
                }
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


    $('body').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var confirmation = confirm("Are you sure you want to Delete this Record?");
          if (confirmation) {
                    $.ajax({
                        url: "{{ route('admission-delete') }}",
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
                  }
                return false;
            });


    $('body').on('click', '.edit', function() {
    var id = $(this).attr('data-id');
    $('#aboutupdate').hide();
    $.ajax({
        url: "{{ route('admission-edit') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                $.each(response, function(index, item){
                  // alert(item.link);
                    $('#user_id_view').val(item.id);
                    $('#update_link').val(item.link);
                    
                    CKEDITOR.instances.programeditor1.setData(item.content);

                    if (item.image) {
                        var imgElement = $('<img>').attr('src', "{{ asset('events/') }}/" + item.image);
                      //  console.log(imgElement);
                        $('#updateimageview').attr('src', imgElement.attr('src'));
                    }
                    $('#updateupcoming').show();
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
    // alert('hello');
    e.preventDefault();
    // var formdata = new FormData($('#upcomingupdate')[0]);
        var editor = CKEDITOR.instances.programeditor1;
        var editorContent = editor.getData();

        var formData = new FormData($('#upcomingupdate')[0]);
        formData.append('editorContent', editorContent);

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };


    $('.err').remove();
    $.ajax({
        url: "{{ route('admission-update') }}",
        type: "POST",
        data: formData,
        headers: headers,
            processData: false,
            contentType: false,
        success: function (response) {
          if (response.status == "success") { 
                // alert('Update Successfully');
                alert('Saved successfully. This content is forwarded for approval');
                table.ajax.reload();
                window.location.reload();
            } else if (response.status == 'error') {
                $.each(response.message, function (i, message) {
                    if (i == "name") {
                        $('#name_view').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    } else if (i == "image") {
                        $('#update_image').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }else if (i == "link") {
                        $('#update_link').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                    }
                });
            }
        }
    });
});


</script>

<script type="text/javascript">
        $(document).ready(function() {
      var editor2=CKEDITOR.replace('programeditor',{
        extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
        height:250,
        allowedContent :true,
        uiColor : '#ffffff' , 
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