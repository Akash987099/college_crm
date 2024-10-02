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
                  <button for="firstName" class="form-label nav-link btn btn-primary" data-bs-toggle="modal"
                          data-bs-target="#basicModal" >Add</button>
                
                </h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                  
                    <table class="table" id="datatable">
                    <thead class="">
                      <tr >
                      <th >Sr No</th>
                      <th >Facility</th>
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
 
    <form id="updateaboout" method="POST">
    @csrf
   
      <div class="row" id="description-container">
     @if($facility == NULL)
      <input type="text"  value="" name="aboutid" hidden>
     @else
      <input type="text"  value="{{$facility->id}}" name="aboutid" hidden>
     @endif

        <div class="row mb-3">
        <div class="mb-3 col-md-6">
          <label for="firstName" class="form-label ">Title Name <span style="color: red; font-size:20px;">*</span></label>
       
          @if($facility == NULL)
                            <input
                              class="form-control specialchar"
                              type="text"
                              name="title"
                              id="title"
                              placeholder = "Title Name"
                            />
                            @else
                            @php
        $updateTitleValue = ($facility->title_tmp) ? $facility->title_tmp : $facility->title;
    @endphp
                            <input
                              class="form-control specialchar"
                              type="text"
                              name="update_title"
                              id="update_title"
                              value="{{$updateTitleValue}}"
                              placeholder = "Title Name"
                            />
                            @endif
         
          
        </div>
      </div>
      </div>

      <div class="form-group">
       
      <label for="" class=" font-layout">Content <span class="inputlabelmedetory text-err"></span></label>
      @if($facility == null)
      <textarea class="form-control" name="about"  id="programeditor">
      </textarea>
      @else
      <textarea class="form-control" name="about"  id="programeditor">
      @if($facility->description_tmp)
        {{ $facility->description_tmp }}
    @elseif($facility->content)
        {{ $facility->content }}
    @endif"
      </textarea>
      @endif
      
  </div>

<div class="mt-2">
              @if($facility == NULL)
              <button type="save" id="add" class="btn btn-primary me-2">Submit</button>
                 @else
              <button type="submit" id="updata" class="btn btn-primary me-2">Submit</button>
              @endif
</div>
    </form>
   
  </div>

  <!-- /Account -->
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

            
                <form method="POST"  class="update_country" enctype="multipart/form-data">
                    <div id="errorContainer"></div>
                    @csrf
                    <input type="text" name="id_input" id="user_id_view" value="" hidden>
                     <div class="form-group">
                     <label for="exampleInputEmail1"> Name <span class="required">*</span></label>
                     <input type="text" class="form-control" value="" id="name_view" name="name" placeholder="Name" readonly>
                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1">Image <span class="required">*</span></label>
                     <input type="file" value=""  class="form-control" id="update_image" name="image" placeholder="image">
                     <img src="..." alt="..." style="height:100px;" id="update_image_preview" class="img-thumbnail">
                 </div>


                </form>

            </div>
            <div class="modal-footer">
            <button type="submit" id="updatecountry" class="btn btn-primary" data-bs-dismiss="modal">
                                  update
                                </button>
            <!-- <button type="button" class="btn btn-outline-secondary" id="close" data-bs-dismiss="modal">
                                  Close
                                </button> -->
            </div>
          </div>
        </div>
      </div>

                  <div class="card mb-4">
                    
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form action="{{ route('add-facility-ajax') }}" id="addprogram" method="POST">
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
                                  <div class="col mb-4">
                                    <label for="nameBasic" class="form-label">Search Facility</label>
                                   
                                    <br>
                                 <select id="autoCompletewithSelect2" class="form-control" name="autoCompletewithSelect2" multiple="multiple">
                                       
                                 </select>  <i class="fa fa-plus" aria-hidden="true" id="adddrop" style="color:blue;"></i>
                                 <br>

                                 <div id="dynamicInput">
                                 <label for="nameBasic" class="form-label" >Facilty Name <span class="required">*</span></label>
                                 <input style=" width: 11.75em !important;" type="text"  id="programdata" name="facility" class="form-control" placeholder="Enter Program Name"/>
                                   <span id="selecteddata"></span>

                                   <label for="nameBasic" class="form-label" >Image <span class="required">*</span></label>
                                 <input style=" width: 11.75em !important;" type="file"  id="imagedata" name="image" class="form-control" placeholder="Enter Program Name"/>
                                   <span id="selectimage"></span>

                                   </div>
                                  </div>
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <button type="button" data-action="save" class="btn btn-primary" id="userprogramsave">Save </button>
                              </div>
                            </div>
                           </form>
                          </div>
                        </div>
                        </div>
                        

                    

                       
<script>

  $('#dynamicInput').hide();

  $('#adddrop').click(function(){
    $('#dynamicInput').show();
  });

  $('#close').click(function(){
    $('#viewmodal').hide();
  });

  $(document).ready(function () {
    // Initiate the search on page load
    initiateSearch();

    function initiateSearch() {
        $.ajax({
            url: '{{ route("search-facility") }}',
            method: 'GET',
            data: {}, 
            success: function (response) {
                displayResults(response);
            }
        });
    }

    function displayResults(results) {
        var $searchResults = $('#autoCompletewithSelect2');
        $searchResults.empty();

        if (results.length > 0) {
            results.forEach(function (item) {
                $searchResults.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        } else {
            $searchResults.append('<option value="">No results found</option>');
        }

        $searchResults.trigger('change');
    }

    $(document).on('click', '#userprogramsave', function (e) {
    e.preventDefault();
    $('.err').remove();

    var selectedValues = $('#autoCompletewithSelect2').val();
    var formData = new FormData($('#addprogram')[0]);

    formData.append('autoCompletewithSelect2', selectedValues);

    $.ajax({
        url: "{{ route('add-facility-ajax') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status == "success") {
              alert('Saved successfully')
                window.location.reload();
            } 

            else if (response.status == 'error') {
    $.each(response.message, function (i, message) {
        if (i == "facility") {
            $('#programdata').after('<div class="alert alert-danger">' + message + '</div>');
        } else if (i == "autoCompletewithSelect2") {
            $('#autoCompletewithSelect2').after('<div class="alert alert-danger">Select data already exists</div>');
        } else if (i == "image") {
            $('#imagedata').after('<div class="alert alert-danger">' + message + '</div>');
        }
    });
}


        }
    });
});

$('#autoCompletewithSelect2').select2({
    multiple: true
});

;
});  


  $('#updata').click(function(e){
                e.preventDefault();
                var editorContent = CKEDITOR.instances.programeditor.getData();
                var formData = $('#updateaboout').serializeArray();
                formData.push({ name: 'editorContent', value: editorContent });
                $('.err').remove();
                $.ajax({
                  url : "{{route('update-facility')}}",
                  type : "POST",
                  data : formData,
                  success : function(response){
                    if (response.status == "success") {
                          //  alert(response.message);
                          alert('Updated successfully. it will publish after approval')
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "editorContent"){
                                        $('#programeditor').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if (i == "update_title"){
                                        $('#update_title').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }
                            });
                        }
                  }
                });
              });


  $(document).ready(function () {
        $('#add').on('click', function (e) {
          // alert('hello');


          e.preventDefault();
          var editorContent = CKEDITOR.instances.programeditor.getData();
                var formData = $('#updateaboout').serializeArray();
                formData.push({ name: 'editorContent', value: editorContent });
            $('.err').remove();
            // AJAX request
            $.ajax({
                url: '{{route('facility-add')}}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                          //  alert(response.message);
                          alert('Saved successfully. it will publish after approval')
                           window.location.reload();
                        }else if (response.status == 'error') {
                            $.each(response.message, function(i, message) {
                               if(i == "editorContent"){
                                        $('#programeditor').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
                               }else if (i == "title"){
                                        $('#title').after('<span id="university_error" class="err" style="color:red">' + message + '</span>');
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

  $('#close').click(function(){
    // alert('hello');
    $('#programupdate').hide();
  });

var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: "{{ route('facility-list') }}",
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
                data: 'image',
                orderable: true,
                className: 'text-center',
                render: function (data, type, full, meta) {
                    return type === 'display' ?
                        '<img  style="height:70px;" src="' + "{{ asset('icons') }}/" + data + '" alt="Image" class="img-thumbnail">' :
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
                        url: "{{ route('facility-delete-ajax') }}",
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

    $.ajax({
        url: "{{ route('facility-edit-ajax') }}",
        dataType: "json",
        type: "GET",
        data: {
            'id': id
        },
        success: function(response) {
            if (response) {
                $.each(response, function(index, item){
                    $('#user_id_view').val(item.id);
                    $('#name_view').val(item.facility_name);

                    if (item.facility_image) {
                        var imgElement = $('<img>').attr('src', "{{ asset('icons/') }}/" + item.facility_image);
                      //  console.log(imgElement);
                        $('#update_image_preview').attr('src', imgElement.attr('src'));
                    }
                    $('#viewmodal').show();
                    // alert('hello');
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
        url: "{{ route('facility-update-ajax') }}",
        dataType: "json",
        type: "POST",
        data: formdata,
        processData: false,  
        contentType: false, 
        success: function (response) {
          if (response.status == "success") { // Fix the typo here
                // alert('Update Successfully');
                alert('Updated successfully')
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
 
          @endsection